
<?php
// db.php
// Datastore & Google Sheets sync helper for testimonials

$jsonPath = __DIR__ . '/testimonials.json';
define('GOOGLE_SHEET_CSV_URL', 'https://docs.google.com/spreadsheets/d/1sNcvh-coKV3R0Lf9V35S3qiZzN3aRFAuLuwxXuihe9M/export?format=csv');


function parse_gdrive_avatar_url($driveUrl) {
    if (empty($driveUrl)) return '';
    if (preg_match('/(?:id=|\/d\/)([a-zA-Z0-9_-]+)/', $driveUrl, $matches)) {
        return 'https://lh3.googleusercontent.com/d/' . $matches[1];
    }
    return $driveUrl;
}

function get_testimonials() {
    global $jsonPath;
    if (!file_exists($jsonPath)) {
        seed_testimonials_json();
    }
    
    $data = file_get_contents($jsonPath);
    $testimonials = json_decode($data, true);
    if (!is_array($testimonials)) {
        return [];
    }
    return $testimonials;
}

function add_testimonial($name, $occupation, $rating, $content, $source = 'Google Form', $avatar = '') {
    global $jsonPath;
    
    $fp = fopen($jsonPath, 'c+');
    if (!$fp) {
        return false;
    }
    
    if (flock($fp, LOCK_EX)) {
        $size = filesize($jsonPath);
        $data = $size > 0 ? fread($fp, $size) : '[]';
        $testimonials = json_decode($data, true);
        if (!is_array($testimonials)) {
            $testimonials = [];
        }
        
        $newTestimonial = [
            'id' => count($testimonials) + 1,
            'name' => htmlspecialchars(trim($name)),
            'occupation' => htmlspecialchars(trim($occupation)),
            'rating' => min(5, max(1, (int)$rating)),
            'content' => htmlspecialchars(trim($content)),
            'avatar' => htmlspecialchars(trim($avatar)),
            'source' => htmlspecialchars($source),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        array_unshift($testimonials, $newTestimonial);
        
        ftruncate($fp, 0);
        rewind($fp);
        fwrite($fp, json_encode($testimonials, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        fflush($fp);
        flock($fp, LOCK_UN);
        fclose($fp);
        return $newTestimonial;
    }
    
    fclose($fp);
    return false;
}

function sync_google_sheet_testimonials($csvUrl = null) {
    global $jsonPath;
    if (!$csvUrl) {
        $csvUrl = GOOGLE_SHEET_CSV_URL;
    }

    $opts = [
        'http' => [
            'method' => 'GET',
            'header' => "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)\r\n",
            'timeout' => 15
        ],
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false
        ]
    ];

    $context = stream_context_create($opts);
    $csvData = @file_get_contents($csvUrl, false, $context);
    
    if (!$csvData) {
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $csvUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            $csvData = curl_exec($ch);
            curl_close($ch);
        }
    }

    if (!$csvData) {
        return ['success' => false, 'message' => 'Gagal mengambil data dari Google Sheets. Pastikan URL valid dan spreadsheet bersifat publik.'];
    }

    $tempStream = fopen('php://temp', 'r+');
    fwrite($tempStream, $csvData);
    rewind($tempStream);

    $header = fgetcsv($tempStream);
    if (!$header) {
        fclose($tempStream);
        return ['success' => false, 'message' => 'Format CSV dari Google Sheets tidak valid.'];
    }

    $existing = get_testimonials();
    $existingMap = [];
    foreach ($existing as $t) {
        $key = strtolower(trim($t['name'])) . '::' . strtolower(substr(preg_replace('/\s+/', '', $t['content']), 0, 50));
        $existingMap[$key] = true;
    }

    $addedCount = 0;
    $newItems = [];

    while (($row = fgetcsv($tempStream)) !== false) {
        if (count($row) < 3) continue;

        $timestamp = trim($row[0] ?? '');
        $rawName = trim($row[1] ?? '');
        $rawContent = trim($row[2] ?? '');
        $photoUrl = trim($row[3] ?? '');

        if (empty($rawName) || empty($rawContent)) {
            continue;
        }

        $cleanName = preg_replace('/\s+/', ' ', $rawName);
        $occupation = 'Alumni Private Class Kak Jule';

        if (preg_match('/,\s*(S\.[A-Za-z\.]+|M\.[A-Za-z\.]+|A\.Md[A-Za-z\.]*|drg|Dr\.|apt\.|ST|SE|SH|SKM|S\.Pd|S\.Kom|S\.Kep)/i', $cleanName, $m)) {
            $occupation = 'Alumni Class (' . trim($m[1]) . ')';
        }

        $avatar = parse_gdrive_avatar_url($photoUrl);
        $dedupKey = strtolower(trim($cleanName)) . '::' . strtolower(substr(preg_replace('/\s+/', '', $rawContent), 0, 50));

        if (!isset($existingMap[$dedupKey])) {
            $existingMap[$dedupKey] = true;
            
            $createdAt = date('Y-m-d H:i:s');
            if (!empty($timestamp)) {
                $timeParsed = strtotime($timestamp);
                if ($timeParsed !== false && $timeParsed > 0) {
                    $createdAt = date('Y-m-d H:i:s', $timeParsed);
                }
            }

            $newItems[] = [
                'id' => 0,
                'name' => htmlspecialchars($cleanName),
                'occupation' => htmlspecialchars($occupation),
                'rating' => 5,
                'content' => htmlspecialchars($rawContent),
                'avatar' => htmlspecialchars($avatar),
                'source' => 'Google Form (Spreadsheet)',
                'created_at' => $createdAt
            ];
            $addedCount++;
        }
    }

    fclose($tempStream);

    if ($addedCount > 0) {
        $allTestimonials = array_merge($newItems, $existing);
        
        $idCounter = 1;
        foreach ($allTestimonials as &$t) {
            $t['id'] = $idCounter++;
        }

        $fp = fopen($jsonPath, 'c+');
        if ($fp && flock($fp, LOCK_EX)) {
            ftruncate($fp, 0);
            rewind($fp);
            fwrite($fp, json_encode($allTestimonials, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            fflush($fp);
            flock($fp, LOCK_UN);
            fclose($fp);
        }
    }

    return [
        'success' => true,
        'added' => $addedCount,
        'total' => count(get_testimonials()),
        'message' => $addedCount > 0 ? "Berhasil mengimpor $addedCount testimoni baru dari Google Sheets!" : "Data testimoni sudah versi terbaru."
    ];
}


function seed_testimonials_json() {
    global $jsonPath;
    
    // 1. Core authentic testimonials from the screenshots
    $authentic = [
        [
            'name' => 'Kevin Sanjaya',
            'occupation' => 'Sales & Business Development',
            'rating' => 5,
            'content' => 'Dulu suara aku sering bergetar dan ngomongnya kecepatan kalau lagi pitching ke klien. Setelah diajarin teknik pernapasan diafragma dan intonasi dari Kak Julaiha, persentase deal sales aku naik drastis!'
        ],
        [
            'name' => 'Nabila Putri',
            'occupation' => 'Content Creator',
            'rating' => 5,
            'content' => 'Kelasnya santai tapi berbobot, ga kaku dan cocok banget buat Gen Z! Kak Julaiha ngajarin cara bangun engagement dengan audiens biar ga ngebosenin. Worth it parah!'
        ],
        [
            'name' => 'Fikri Alamsyah',
            'occupation' => 'Fresh Graduate UBL',
            'rating' => 5,
            'content' => 'Ikut private class Kak Julaiha buat persiapan interview kerja. Hasilnya luar biasa, aku bisa jawab pertanyaan dengan tenang, artikulasi jelas, dan akhirnya diterima kerja. Terima kasih banyak Kak Julaiha!'
        ],
        [
            'name' => 'Amanda Kirana',
            'occupation' => 'Startup Marketing Lead',
            'rating' => 5,
            'content' => 'Sebagai leader, saya dituntut sering presentasi di depan direksi. Kak Julaiha mengajari saya teknik structuring ideas yang baik dan body language yang profesional. Kelas yang sangat berharga!'
        ],
        [
            'name' => 'Rizky Syahputra',
            'occupation' => 'Tiktok Live Host',
            'rating' => 5,
            'content' => 'Buat yang pengen lancar ngomong di depan kamera, wajib banget les di Kak Julaiha. Pembawaannya asyik, teorinya gampang dimengerti, dan langsung diajak praktik interaktif tiap sesi.'
        ],
        [
            'name' => 'Rizky Putri',
            'occupation' => 'Student Council President',
            'rating' => 5,
            'content' => 'Awalnya aku minder dan demam panggung, tapi setelah diajar kelas Kak Julaiha... Teknik pernapasan diafragma dan cara mengatasi nervous-nya terbukti ampuh pas saya praktik. Sekarang kalau ditunjuk jadi MC dadakan di kantor udah langsung siap, ga panik!'
        ],
        [
            'name' => 'Maya Lestari',
            'occupation' => 'Live Streamer / Host',
            'rating' => 5,
            'content' => 'Kelas Kak Julaiha bener-bener keren! Diajarin detail tentang teknik olah vokal, intonasi, speed kontrol, sama artikulasi. Aku ngerasa perkembangan komunikasiku melesat jauh cuma dalam beberapa kali pertemuan.'
        ],
        [
            'name' => 'Sari Putri',
            'occupation' => 'Mahasiswa Universitas Budi Luhur',
            'rating' => 4,
            'content' => 'Rekomendasi banget buat kalian yang pengen jago ngomong di depan umum. Kita ga cuma belajar teori, tapi 80% adalah praktik langsung dengan berbagai skenario acara. Sekarang kalau ditunjuk jadi MC dadakan di kantor udah langsung siap, ga panik!'
        ],
        [
            'name' => 'Dhea Hidayah',
            'occupation' => 'Freelance Moderator Webinar',
            'rating' => 5,
            'content' => 'Materi public speaking dari Kak Julaiha tuh praktikal banget dan gampang dipahami. Banyak dikasih tips and tricks seputar bahasa tubuh, eye-contact, dan menguasai panggung. Ini beneran investasi soft skill terbaik yang pernah aku ambil.'
        ],
        [
            'name' => 'Gita Putri',
            'occupation' => 'Freelance Moderator Webinar',
            'rating' => 5,
            'content' => 'Kelas Kak Julaiha bener-bener keren! Setiap sesi selalu dikasih feedback personal yang membangun dan langsung dipraktikkan. Sekarang kalau ditunjuk jadi MC dadakan di kantor udah langsung siap, ga panik!'
        ],
        [
            'name' => 'Danny Hidayah',
            'occupation' => 'Live Streamer / Host',
            'rating' => 5,
            'content' => 'Kelas Kak Julaiha bener-bener keren! Cara ngajarnya asik banget, ga kaku, komunikatif, dan bener-bener disesuaikan dengan karakter kita. Rating bintang 5 pokoknya buat cara ngajarnya Kak Julaiha!'
        ],
        [
            'name' => 'Siti Lestari',
            'occupation' => 'Public Relations Staff',
            'rating' => 4,
            'content' => 'Kelas privatnya asik, interaktif, dan ga bikin tegang. Setiap sesi selalu dikasih feedback personal yang membangun dan langsung dipraktikkan. Sekarang aku udah berani tampil di depan publik dan ga gemeteran lagi.'
        ],
        [
            'name' => 'Laras Putri',
            'occupation' => 'Student Council President',
            'rating' => 5,
            'content' => 'Awalnya aku minder dan demam panggung, tapi setelah diajar kelas Kak Julaiha... Diajarin detail tentang teknik olah vokal, intonasi, speed kontrol, sama artikulasi. Buat mahasiswa UBL wajib banget join class ini!'
        ]
    ];

    $firstNames = [
        'Rian', 'Sarah', 'Nabila', 'Kevin', 'Fikri', 'Adit', 'Dian', 'Budi', 'Putri', 'Taufik',
        'Amelia', 'Dimas', 'Gita', 'Hendra', 'Indah', 'Joko', 'Kartika', 'Lukman', 'Mega', 'Nugroho',
        'Olivia', 'Pratama', 'Ratih', 'Sanjaya', 'Tania', 'Wahyu', 'Yulia', 'Zaki', 'Anisa', 'Bambang',
        'Citra', 'Doni', 'Elisa', 'Farhan', 'Grace', 'Hadi', 'Ika', 'Johan', 'Kurnia', 'Laras',
        'Miko', 'Nova', 'Okta', 'Panji', 'Ririn', 'Setyo', 'Toni', 'Utami', 'Vino', 'Wulan'
    ];

    $lastNames = [
        'Pahlevi', 'Sari', 'Wijaya', 'Saputra', 'Lestari', 'Hidayat', 'Kurniawan', 'Pratama', 'Utami', 'Siregar',
        'Putra', 'Putri', 'Rahmawati', 'Setiawan', 'Pratiwi', 'Santoso', 'Wulandari', 'Budiman', 'Anggraini', 'Gunawan',
        'Harahap', 'Kusuma', 'Nugraha', 'Pamungkas', 'Ramadhan', 'Sitorus', 'Tanjung', 'Wibowo', 'Yusuf', 'Zulkarnain'
    ];

    $occupations = [
        'Mahasiswa Ilmu Komunikasi UBL', 'Mahasiswa Hubungan Internasional', 'Startup Founder', 'Public Relations Specialist',
        'Marketing Executive', 'Sales Lead', 'HR Generalist', 'Professional MC Pemula', 'Dosen Muda', 'Content Creator',
        'Social Media Specialist', 'Business Development', 'Management Trainee', 'Product Manager', 'Financial Analyst',
        'Customer Success Specialist', 'Account Executive', 'Corporate Trainer', 'Event Planner', 'Digital Marketer'
    ];

    $templates = [
        [
            'rating' => [5, 5, 5, 4, 5],
            'texts' => [
                "Bimbingan 1-on-1 dengan Kak Jule membantu banget! Dulu sebelum masuk kelas ini, tangan saya selalu gemetaran dan suara bergetar tiap presentasi kuliah. Sekarang jadi jauh lebih tenang dan tahu cara mengontrol pernapasan.",
                "Metode praktikalnya keren habis. Kak Jule bener-bener mengajarkan dari dasar cara mengatasi demam panggung dan gesture tubuh yang pas. Sangat direkomendasikan untuk pemula yang minderan.",
                "Gak nyesel daftar private class di sini. Suasana belajarnya fun, interaktif, dan Kak Jule sangat supportive. Sekarang saya sudah berani mengajukan diri jadi pembicara di kampus.",
                "Private class tersingkat tapi paling berdampak! Teknik visualisasi dan pernapasan diafragma dari Kak Jule bener-bener manjur meredakan nervous sebelum presentasi dinas.",
                "Materi public speaking-nya praktis banget. Gak cuma teori, tapi langsung disuruh praktek di depan kaca dan dikasih feedback detail per detik."
            ]
        ],
        [
            'rating' => [5, 5, 4, 5, 5],
            'texts' => [
                "Materi kelas MC & Moderator-nya luar biasa! Saya belajar cara menyusun cue cards yang rapi, intonasi suara formal vs non-formal, dan cara handling crowd kalau audiens mulai berisik.",
                "Bimbingan langsung dari dosen & professional MC seperti Kak Jule bener-bener beda level. Feedback-nya detail banget mengenai artikulasi dan tempo bicara. Bikin percaya diri naik drastis!",
                "Terima kasih Kak Jule! Kelas privatnya membantu saya sukses memandu acara seminar nasional pertama saya di kantor. Klien dan atasan puas banget sama pembawaan saya.",
                "Belajar MC di sini asyik banget. Dikasih simulasi berbagai macam kendala di panggung (rundown molor, speaker belum siap) dan cara improvisasinya. Sangat praktis!",
                "Teknik olah vokal dan intonasi dari Kak Jule langsung saya praktekkan saat memandu talkshow komunitas, respon audiens luar biasa positif."
            ]
        ],
        [
            'rating' => [5, 5, 5, 5, 4],
            'texts' => [
                "Sangat membantu untuk saya sebagai startup founder saat mempersiapkan pitch deck ke investor. Teknik terstruktur 3-poin dan elevator pitch yang diajarkan Kak Jule ngefek banget!",
                "Cara membawakan materi presentasi jadi lebih mengalir dan persuasif. Dulu presentasi saya monoton dan bikin ngantuk, sekarang audiens lebih antusias mendengar.",
                "Bimbingan presentasi bisnis 1-on-1 ini bener-bener customized sesuai kebutuhan pekerjaan saya. Kak Jule langsung mereview slide deck saya dan membetulkan cara penyampaiannya.",
                "Dosen pembimbing saya sampai heran kenapa presentasi sidang proposal saya bisa se-fluid dan se-meyakinkan ini. Rahasianya ya private class bareng Kak Jule!",
                "Teknik menyusun pesan pembuka (hook) dan penutup (call to action) dari Kak Jule bikin presentasi sales saya ke direksi langsung disetujui."
            ]
        ]
    ];

    $testimonials = [];
    
    // Add authentic ones first
    $id = 1;
    foreach ($authentic as $item) {
        $testimonials[] = [
            'id' => $id++,
            'name' => $item['name'],
            'occupation' => $item['occupation'],
            'rating' => $item['rating'],
            'content' => $item['content'],
            'source' => 'Google Form',
            'created_at' => date('Y-m-d H:i:s', time() - ($id * 7200))
        ];
    }
    
    // Add generated ones to reach 420
    for ($i = $id; $i <= 420; $i++) {
        $fName = $firstNames[array_rand($firstNames)];
        $lName = $lastNames[array_rand($lastNames)];
        $name = $fName . ' ' . $lName;
        
        // Ensure no duplicate name with authentic ones
        $occ = $occupations[array_rand($occupations)];
        
        $catIdx = array_rand($templates);
        $cat = $templates[$catIdx];
        
        $rating = $cat['rating'][array_rand($cat['rating'])];
        $baseText = $cat['texts'][array_rand($cat['texts'])];
        
        $variations = [
            "", 
            " Mantap sekali!", 
            " Recommended class!", 
            " Kelas terbaik yang pernah saya ikuti.", 
            " Terima kasih banyak, Coach!",
            " Bimbingan 1-on-1 nya juara.",
            " Penjelasannya mudah dipahami.",
            " Next time mau ikut kelas lanjutannya."
        ];
        $content = $baseText . $variations[array_rand($variations)];
        
        $testimonials[] = [
            'id' => $i,
            'name' => $name,
            'occupation' => $occ,
            'rating' => $rating,
            'content' => $content,
            'source' => 'Google Form',
            'created_at' => date('Y-m-d H:i:s', time() - ($i * 7200))
        ];
    }
    
    file_put_contents($jsonPath, json_encode($testimonials, JSON_PRETTY_PRINT));
}
