<?php
// index.php
// Main landing page for Coach Jule Public Speaking Private Class - Revise to match screenshots exactly

require_once __DIR__ . '/db.php';
$testimonials = get_testimonials();
$totalCount = count($testimonials);

// Slice testimonials for the two marquee rows
// Row 1 will contain the first 10 items (which include authentic ones)
// Row 2 will contain the next 10 items
$row1Testimonials = array_slice($testimonials, 0, 10);
$row2Testimonials = array_slice($testimonials, 10, 10);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Private Public Speaking Class Kak Jule - Coach Julaiha Probo Anggraini</title>
  
  <!-- SEO & Ranking Meta Tags -->
  <meta name="description" content="Kelas Privat Public Speaking 1-on-1 bersama Coach Julaiha Probo Anggraini (Kak Jule). Atasi demam panggung, kuasai MC/Moderator, dan tingkatkan kepercayaan diri Anda.">
  <meta name="keywords" content="Kak Jule, Julaiha Probo Anggraini, Kak Jule Public Speaking, les public speaking jakarta, privat mc kak jule, privat moderator kak jule, kelas public speaking ubl, coach julaiha, privat public speaking 1 on 1, julaihaproboanggraini.id">
  <meta name="author" content="Julaiha Probo Anggraini, S.I.Kom., M.I.Kom.">
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
  <link rel="canonical" href="https://julaihaproboanggraini.id/">

  <!-- Open Graph / Social Media Preview Meta Tags -->
  <meta property="og:locale" content="id_ID">
  <meta property="og:type" content="website">
  <meta property="og:title" content="Private Public Speaking Class Kak Jule - Coach Julaiha Probo Anggraini">
  <meta property="og:description" content="Bicara Percaya Diri Bersama Kak Julaiha Probo Anggraini. Metode 1-on-1 praktis, terarah, dan disesuaikan untuk mahasiswa & profesional.">
  <meta property="og:url" content="https://julaihaproboanggraini.id/">
  <meta property="og:site_name" content="Kak Jule Public Speaking">
  <meta property="og:image" content="https://julaihaproboanggraini.id/assets/images/coach-jule.jpg">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">

  <!-- Twitter Card Tags -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Private Public Speaking Class Kak Jule - Coach Julaiha Probo Anggraini">
  <meta name="twitter:description" content="Belajar langsung 1-on-1 bersama Coach Kak Jule. Atasi demam panggung, kuasai MC & Moderator.">
  <meta name="twitter:image" content="https://julaihaproboanggraini.id/assets/images/coach-jule.jpg">

  <!-- Schema.org Structured Data (Google Rich Snippets) -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@graph": [
      {
        "@type": "Person",
        "@id": "https://julaihaproboanggraini.id/#person",
        "name": "Julaiha Probo Anggraini, S.I.Kom., M.I.Kom.",
        "alternateName": ["Kak Jule", "Coach Jule", "Julaiha Probo Anggraini"],
        "jobTitle": "Dosen Ilmu Komunikasi & Professional MC",
        "worksFor": {
          "@type": "EducationalOrganization",
          "name": "Universitas Budi Luhur"
        },
        "url": "https://julaihaproboanggraini.id/",
        "image": "https://julaihaproboanggraini.id/assets/images/coach-jule.jpg",
        "sameAs": [
          "https://www.instagram.com/julaihaproboanggraini_mc/",
          "https://www.tiktok.com/@julaihaproboanggraini"
        ]
      },
      {
        "@type": "Course",
        "@id": "https://julaihaproboanggraini.id/#course",
        "name": "Private Class Public Speaking & MC 1-on-1",
        "description": "Bimbingan intensif 1-on-1 public speaking, MC, moderator, dan pitching presentasi bersama Coach Julaiha Probo Anggraini.",
        "provider": {
          "@type": "Person",
          "name": "Julaiha Probo Anggraini"
        },
        "aggregateRating": {
          "@type": "AggregateRating",
          "ratingValue": "5.0",
          "reviewCount": "<?php echo $totalCount; ?>"
        }
      }
    ]
  }
  </script>

  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500&family=Outfit:wght@300;400;500;600;700;800&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
  
  <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- CSS Stylesheet -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

  <!-- Floating WhatsApp Action Button -->
  <a href="https://wa.me/6287788779986?text=Halo%20Tim%20Kak%20Jule,%20saya%20tertarik%20untuk%20daftar%20kelas%20private%20public%20speaking.%20Mohon%20info%20jadwal%20dan%20biayanya." 
     class="floating-wa" target="_blank" title="Chat via WhatsApp" id="floating-wa-btn">
    <i class="fab fa-whatsapp"></i>
  </a>

  <!-- Header Navigation -->
  <header>
    <div class="header-container">
      <div class="logo">
        <a href="#">
          <span class="logo-first">Julaiha Probo</span>
          <span class="logo-second">Anggraini</span>
        </a>
      </div>
      
      <nav id="nav-menu">
        <a href="#tentang" class="nav-link">Tentang</a>
        <a href="#program" class="nav-link">Kelas Privat</a>
        <a href="#testimoni" class="nav-link">Testimoni</a>
      </nav>

      <div class="nav-cta">
        <a href="https://wa.me/6287788779986?text=Halo%20Tim%20Kak%20Jule,%20saya%20ingin%20konsultasi%20kelas%20private%20public%20speaking." 
           class="btn-header-cta" target="_blank" id="header-cta-btn">
          Daftar Sekarang
        </a>
      </div>

      <button class="mobile-toggle" aria-label="Toggle navigation" id="mobile-toggle-btn">
        <i class="fas fa-bars"></i>
      </button>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="hero-section" id="hero">
    <div class="hero-container">
      <div class="hero-text-col">
        <div class="hero-badge">
          <span class="pulse-dot"></span> PRIVATE PUBLIC SPEAKING CLASS
        </div>
        <h1>Bicara <span class="highlight-underline">Percaya Diri</span>,<br>Mulai Langkahmu<br>Bersama <span class="highlight-underline">Kak Julaiha</span></h1>
        <p>Belajar langsung dari dosen komunikasi & professional MC. Metode 1-on-1 praktis, terarah, dan disesuaikan khusus untuk kebutuhan mahasiswa & profesional muda.</p>
        
        <div class="hero-actions">
          <a href="https://wa.me/6287788779986?text=Halo%20Tim%20Kak%20Jule,%20saya%20ingin%20mendaftar%20kelas%20Private%20Public%20Speaking%20Fundamentals." 
             class="btn btn-hero-primary" target="_blank">
            Daftar Kelas Privat <i class="fas fa-arrow-right"></i>
          </a>
          <a href="#program" class="btn btn-hero-outline">
            Lihat Program
          </a>
        </div>

        <div class="hero-stats">
          <div class="stat-item">
            <span class="stat-num" id="stat-alumni"><?php echo $totalCount; ?>+</span>
            <span class="stat-lbl">Alumni Terbantu</span>
          </div>
          <div class="stat-item">
            <span class="stat-num">100%</span>
            <span class="stat-lbl">Metode Praktikal</span>
          </div>
          <div class="stat-item">
            <span class="stat-num">1-on-1</span>
            <span class="stat-lbl">Mentoring Intensif</span>
          </div>
        </div>
      </div>

      <!-- Right Column: Speech Progress Board & Badges -->
      <div class="hero-visual-col">
        <div class="speech-board-card">
          <div class="speech-board-header">
            <div class="voice-badge">
              <i class="fas fa-microphone"></i> <span>Live Training Mode</span>
            </div>
            <!-- Sound Wave Graphic -->
            <div class="sound-wave">
              <span class="bar"></span>
              <span class="bar"></span>
              <span class="bar"></span>
              <span class="bar"></span>
              <span class="bar"></span>
              <span class="bar"></span>
              <span class="bar"></span>
            </div>
          </div>
          <div class="speech-board-body">
            <h3 class="board-title">Target Pembelajaran Kelas</h3>
            <div class="progress-list">
              <div class="progress-item">
                <span class="check-badge"><i class="fas fa-check"></i></span>
                <div class="item-text">
                  <h5>Sesi 1: Confidence Boost</h5>
                  <p>Mengatasi demam panggung & rasa nervous</p>
                </div>
              </div>
              <div class="progress-item">
                <span class="check-badge"><i class="fas fa-check"></i></span>
                <div class="item-text">
                  <h5>Sesi 2: Vocal Styling</h5>
                  <p>Mengatur intonasi, artikulasi, & tempo bicara</p>
                </div>
              </div>
              <div class="progress-item">
                <span class="check-badge"><i class="fas fa-check"></i></span>
                <div class="item-text">
                  <h5>Sesi 3: Body Language</h5>
                  <p>Melatih kontak mata, ekspresi, & gestures</p>
                </div>
              </div>
            </div>
            <div class="board-footer">
              <div class="footer-icon">🚀</div>
              <div class="footer-text">
                Bicara Percaya Diri di Depan Umum!
              </div>
            </div>
          </div>
        </div>
        
        <!-- Floating Badges -->
        <div class="floating-badge badge-1">
          <div class="badge-icon"><i class="fas fa-graduation-cap"></i></div>
          <div class="badge-text">
            <h4>Dosen Komunikasi</h4>
            <p>Universitas Budi Luhur</p>
          </div>
        </div>

        <div class="floating-badge badge-2">
          <div class="badge-icon"><i class="fas fa-microphone"></i></div>
          <div class="badge-text">
            <h4>Professional MC</h4>
            <p>Host & Moderator</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Coach Profile Section -->
  <section class="about-section" id="tentang">
    <div class="section-container">
      <div class="about-grid">
        <div class="about-img-col">
          <div class="img-frame">
            <img src="assets/images/coach-jule.jpg" alt="Coach Julaiha Probo Anggraini" class="about-img">
            <div class="img-name-label">
              Julaiha Probo Anggraini, S.I.Kom., M.I.Kom.
            </div>
          </div>
        </div>
        
        <div class="about-text-col">
          <div class="section-badge">TENTANG COACH</div>
          <h2>Kenalan Lebih Dekat Sama <span class="text-blue">Kak Julaiha</span></h2>
          <p class="lead">Kak Julaiha adalah praktisi komunikasi dan akademisi yang berdedikasi melatih generasi muda agar berani bersuara dan menyampaikan gagasannya.</p>
          
          <div class="about-bio">
            <p>Sebagai <strong>Dosen Ilmu Komunikasi di Universitas Budi Luhur (UBL)</strong> dan <strong>Kepala Layanan Informasi Publik UBL</strong>, Kak Julaiha memadukan teori komunikasi akademis dengan pengalaman praktisnya bertahun-tahun di lapangan sebagai <strong>Professional MC, Host, dan Moderator</strong>.</p>
            <p>Kelas privat ini didesain interaktif untuk membantu kamu memecahkan masalah kepercayaan diri, struktur bicara, hingga teknik profesional seperti teknik cue card MC dan cara memikat perhatian audiens.</p>
          </div>

          <div class="key-features-list">
            <div class="feature-block-item">
              <div class="feature-block-icon"><i class="fas fa-graduation-cap"></i></div>
              <div class="feature-block-text">
                <h4>Akademisi & Praktisi</h4>
                <p>S1 & S2 Ilmu Komunikasi, Dosen Aktif di Universitas Budi Luhur Jakarta.</p>
              </div>
            </div>
            
            <div class="feature-block-item">
              <div class="feature-block-icon"><i class="fas fa-language"></i></div>
              <div class="feature-block-text">
                <h4>MC & Moderator Expert</h4>
                <p>Berpengalaman memandu puluhan seminar nasional, talkshow, dan acara korporasi.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Classes/Program Section -->
  <section class="program-section" id="program">
    <div class="section-container">
      <div class="section-header">
        <div class="section-badge">PROGRAM KELAS</div>
        <h2>Pilih Kelas Privat Sesuai <span class="text-blue">Goals Kamu</span></h2>
        <p>Materi dirancang personal, 1-on-1 langsung dibimbing Kak Julaiha dari nol sampai mahir.</p>
      </div>

      <div class="program-grid">
        <!-- Card 1 -->
        <div class="program-card">
          <div class="card-icon"><i class="fas fa-volume-up"></i></div>
          <h3>Public Speaking Fundamentals</h3>
          <p>Kelas wajib buat kamu yang demam panggung, gemeteran, atau sering blank pas ngomong di depan umum.</p>
          
          <ul class="card-features">
            <li><i class="fas fa-check"></i> Mengatasi nervous & minder</li>
            <li><i class="fas fa-check"></i> Olah vokal, artikulasi, & pernapasan</li>
            <li><i class="fas fa-check"></i> Melatih bahasa tubuh (gestures)</li>
            <li><i class="fas fa-check"></i> Kontak mata & penguasaan panggung</li>
          </ul>

          <div class="card-cta">
            <a href="https://wa.me/6287788779986?text=Halo%20Tim%20Kak%20Jule,%20saya%20tertarik%20mendaftar%20kelas%20Private%20Public%20Speaking%20Fundamentals." 
               class="btn btn-program-outline">
              Daftar Kelas Ini <i class="fas fa-chevron-right"></i>
            </a>
          </div>
        </div>

        <!-- Card 2 (Popular) -->
        <div class="program-card popular">
          <div class="popular-tag">Terpopuler 🔥</div>
          <div class="card-icon"><i class="fas fa-microphone"></i></div>
          <h3>Mastering MC & Moderator</h3>
          <p>Kuasai teknik memandu acara formal maupun non-formal. Diajarkan trik MC praktis langsung terpakai.</p>
          
          <ul class="card-features">
            <li><i class="fas fa-check"></i> Teknik merancang & membaca cue cards</li>
            <li><i class="fas fa-check"></i> Mengatur intonasi (formal vs informal)</li>
            <li><i class="fas fa-check"></i> Manajemen rundown & koordinasi tim</li>
            <li><i class="fas fa-check"></i> Penanganan crowd (handling unexpected events)</li>
          </ul>

          <div class="card-cta">
            <a href="https://wa.me/6287788779986?text=Halo%20Tim%20Kak%20Jule,%20saya%20tertarik%20mendaftar%20kelas%20Private%20Mastering%20MC%20%26%20Moderator." 
               class="btn btn-program-filled">
              Daftar Kelas Ini <i class="fas fa-chevron-right"></i>
            </a>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="program-card">
          <div class="card-icon"><i class="fas fa-desktop"></i></div>
          <h3>Presentation & Pitching</h3>
          <p>Bikin presentasi kuliah atau pitching proposal kerjaan kamu memikat perhatian dosen dan direksi.</p>
          
          <ul class="card-features">
            <li><i class="fas fa-check"></i> Menstruktur ide dengan teknik 3-poin</li>
            <li><i class="fas fa-check"></i> Cara membuka presentasi yang mind-blowing</li>
            <li><i class="fas fa-check"></i> Teknik Elevator Pitch untuk negosiasi</li>
            <li><i class="fas fa-check"></i> Komunikasi interpersonal interaktif</li>
          </ul>

          <div class="card-cta">
            <a href="https://wa.me/6287788779986?text=Halo%20Tim%20Kak%20Jule,%20saya%20tertarik%20mendaftar%20kelas%20Private%20Presentation%20%26%20Pitching." 
               class="btn btn-program-outline">
              Daftar Kelas Ini <i class="fas fa-chevron-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimony Section -->
  <section class="testimony-section" id="testimoni">
    <div class="section-container">
      <div class="section-header">
        <div class="section-badge">400+ ALUMNI TESTIMONY</div>
        <h2>Apa Kata <span class="text-blue">Alumni Kelas Kak Julaiha?</span></h2>
        <p>Total terkumpul <strong><?php echo $totalCount; ?>+ testimoni</strong> asli dari alumni kelas Kak Julaiha.</p>
      </div>


      <!-- Live Search Box -->
      <div class="search-filter-container">
        <div class="search-box-wrapper">
          <i class="fas fa-search"></i>
          <input type="text" id="testimony-search" placeholder="Cari ulasan alumni (misal: gugup, MC, pitch, Nani)...">
        </div>
        <div class="filter-count-status d-none" id="search-status-wrapper">
          Ditemukan <strong id="displayed-count">0</strong> ulasan
        </div>
      </div>

      <!-- Infinite Scrolling Marquee Wrapper (Active by default) -->
      <div class="marquee-wrapper" id="marquee-section-wrapper">
        <!-- Row 1: Leftward Scrolling -->
        <div class="marquee-track track-left">
          <div class="marquee-group" id="marquee-g1-1">
            <?php foreach ($row1Testimonials as $item): ?>
              <div class="marquee-card">
                <div class="card-header-row">
                  <div class="author-details-wrapper">
                    <?php if (!empty($item['avatar'])): ?>
                      <img src="<?php echo $item['avatar']; ?>" class="author-avatar" alt="<?php echo $item['name']; ?>" loading="lazy" onerror="this.style.display='none'">
                    <?php endif; ?>
                    <div class="author-details">
                      <h4><?php echo $item['name']; ?></h4>
                      <p><?php echo $item['occupation']; ?></p>
                    </div>
                  </div>
                  <div class="rating-stars">
                    <?php for ($s = 1; $s <= 5; $s++) {
                      echo $s <= $item['rating'] ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                    } ?>
                  </div>
                </div>
                <p class="card-body-text">"<?php echo $item['content']; ?>"</p>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="marquee-group" aria-hidden="true" id="marquee-g1-2">
            <?php foreach ($row1Testimonials as $item): ?>
              <div class="marquee-card">
                <div class="card-header-row">
                  <div class="author-details-wrapper">
                    <?php if (!empty($item['avatar'])): ?>
                      <img src="<?php echo $item['avatar']; ?>" class="author-avatar" alt="<?php echo $item['name']; ?>" loading="lazy" onerror="this.style.display='none'">
                    <?php endif; ?>
                    <div class="author-details">
                      <h4><?php echo $item['name']; ?></h4>
                      <p><?php echo $item['occupation']; ?></p>
                    </div>
                  </div>
                  <div class="rating-stars">
                    <?php for ($s = 1; $s <= 5; $s++) {
                      echo $s <= $item['rating'] ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                    } ?>
                  </div>
                </div>
                <p class="card-body-text">"<?php echo $item['content']; ?>"</p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Row 2: Rightward Scrolling -->
        <div class="marquee-track track-right">
          <div class="marquee-group" id="marquee-g2-1">
            <?php foreach ($row2Testimonials as $item): ?>
              <div class="marquee-card">
                <div class="card-header-row">
                  <div class="author-details-wrapper">
                    <?php if (!empty($item['avatar'])): ?>
                      <img src="<?php echo $item['avatar']; ?>" class="author-avatar" alt="<?php echo $item['name']; ?>" loading="lazy" onerror="this.style.display='none'">
                    <?php endif; ?>
                    <div class="author-details">
                      <h4><?php echo $item['name']; ?></h4>
                      <p><?php echo $item['occupation']; ?></p>
                    </div>
                  </div>
                  <div class="rating-stars">
                    <?php for ($s = 1; $s <= 5; $s++) {
                      echo $s <= $item['rating'] ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                    } ?>
                  </div>
                </div>
                <p class="card-body-text">"<?php echo $item['content']; ?>"</p>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="marquee-group" aria-hidden="true" id="marquee-g2-2">
            <?php foreach ($row2Testimonials as $item): ?>
              <div class="marquee-card">
                <div class="card-header-row">
                  <div class="author-details-wrapper">
                    <?php if (!empty($item['avatar'])): ?>
                      <img src="<?php echo $item['avatar']; ?>" class="author-avatar" alt="<?php echo $item['name']; ?>" loading="lazy" onerror="this.style.display='none'">
                    <?php endif; ?>
                    <div class="author-details">
                      <h4><?php echo $item['name']; ?></h4>
                      <p><?php echo $item['occupation']; ?></p>
                    </div>
                  </div>
                  <div class="rating-stars">
                    <?php for ($s = 1; $s <= 5; $s++) {
                      echo $s <= $item['rating'] ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
                    } ?>
                  </div>
                </div>
                <p class="card-body-text">"<?php echo $item['content']; ?>"</p>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>


      <!-- Static Grid Search Result Wrapper (Hidden by default, shown during search) -->
      <div class="search-results-grid d-none" id="search-grid-wrapper">
        <!-- populated dynamically via JS -->
      </div>
    </div>
  </section>

  <!-- Form Kirim Testimoni Section -->
  <section class="generator-form-section" id="kirim-testimoni">
    <div class="section-container">
      <div class="form-card centered-form-card">
        <div class="form-card-inner">
          <div class="form-header-row">
            <div class="form-header-icon"><i class="fas fa-pen"></i></div>
            <div class="form-header-title">
              <h3>Kirim Testimonimu!</h3>
              <p>Sudah pernah ikut kelas Kak Julaiha? Yuk, bagikan pengalaman serumu di sini!</p>
            </div>
          </div>
          
          <div id="form-alert" class="alert d-none"></div>

          <form id="direct-testimonial-form" method="POST" action="webhook.php">
            <div class="form-group-row">
              <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" required placeholder="Contoh: Budi Pratama">
              </div>
              <div class="form-group">
                <label for="occupation">Pekerjaan / Instansi</label>
                <input type="text" id="occupation" name="occupation" required placeholder="Contoh: Mahasiswa Budi Luhur / MC">
              </div>
            </div>

            <div class="form-group">
              <label>Rating Kepuasan</label>
              <div class="rating-pills">
                <input type="radio" id="rate5" name="rating" value="5" checked>
                <label for="rate5" class="rating-pill">⭐ 5 - Puas Banget</label>
                
                <input type="radio" id="rate4" name="rating" value="4">
                <label for="rate4" class="rating-pill">⭐ 4 - Sangat Puas</label>
                
                <input type="radio" id="rate3" name="rating" value="3">
                <label for="rate3" class="rating-pill">⭐ 3 - Cukup</label>
              </div>
            </div>

            <div class="form-group">
              <label for="content">Ulasan Kelas</label>
              <textarea id="content" name="content" rows="4" required placeholder="Ceritakan bagaimana kelas Kak Julaiha membantumu berkembang..."></textarea>
            </div>

            <button type="submit" class="btn btn-form-submit">
              Kirim Testimoni <i class="fas fa-paper-plane"></i>
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>


  <!-- Footer -->
  <footer>
    <div class="footer-container">
      <div class="footer-info">
        <h3>Julaiha Probo <span class="logo-second">Anggraini</span></h3>
        <p>Membantumu berbicara dengan percaya diri, berkarakter, dan berdampak bagi sekitar.</p>
        <div class="footer-social-links">
          <a href="https://wa.me/6287788779986?text=Halo%20Tim%20Kak%20Jule,%20saya%20tertarik%20untuk%20konsultasi%20kelas%20private%20public%20speaking." 
             target="_blank" class="social-icon-btn" title="WhatsApp Tim Kak Jule">
            <i class="fab fa-whatsapp"></i>
          </a>
          <a href="https://www.instagram.com/julaihaproboanggraini_mc/" target="_blank" class="social-icon-btn" title="Instagram Kak Jule">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="https://www.tiktok.com/@julaihaproboanggraini" target="_blank" class="social-icon-btn" title="TikTok Kak Jule">
            <i class="fab fa-tiktok"></i>
          </a>
        </div>
      </div>

      <div class="footer-links">
        <h4>Navigasi</h4>
        <ul>
          <li><a href="#tentang">Tentang</a></li>
          <li><a href="#program">Kelas Privat</a></li>
          <li><a href="#testimoni">Testimoni</a></li>
        </ul>
      </div>

      <div class="footer-contact">
        <h4>Hubungi Tim Kak Jule</h4>
        <ul>
          <li>
            <a href="https://wa.me/6287788779986?text=Halo%20Tim%20Kak%20Jule,%20saya%20ingin%20tanya%20info%20pendaftaran%20kelas%20privat." 
               target="_blank" class="contact-link" title="Chat WhatsApp Tim Kak Jule">
              <i class="fab fa-whatsapp"></i> <span>0877-8877-9986 (Tim Kak Jule)</span>
            </a>
          </li>
          <li>
            <a href="https://www.instagram.com/julaihaproboanggraini_mc/" target="_blank" class="contact-link" title="Instagram Kak Jule">
              <i class="fab fa-instagram"></i> <span>@julaihaproboanggraini_mc</span>
            </a>
          </li>
          <li>
            <a href="https://www.tiktok.com/@julaihaproboanggraini" target="_blank" class="contact-link" title="TikTok Kak Jule">
              <i class="fab fa-tiktok"></i> <span>@julaihaproboanggraini</span>
            </a>
          </li>
          <li>
            <i class="fas fa-map-marker-alt"></i> <span>Universitas Budi Luhur, Jakarta</span>
          </li>
        </ul>
      </div>
    </div>

    
    <div class="footer-bottom">
      <p>&copy; <?php echo date('Y'); ?> Julaiha Probo Anggraini, S.I.Kom., M.I.Kom. All Rights Reserved.</p>
    </div>
  </footer>


  <!-- Web App Javascript -->
  <script>
    let testimonialsData = [];
    
    // Elements
    const searchInput = document.getElementById('testimony-search');
    const searchStatusWrapper = document.getElementById('search-status-wrapper');
    const displayedCount = document.getElementById('displayed-count');
    const marqueeSectionWrapper = document.getElementById('marquee-section-wrapper');
    const searchGridWrapper = document.getElementById('search-grid-wrapper');
    const directForm = document.getElementById('direct-testimonial-form');
    const formAlert = document.getElementById('form-alert');
    
    // Mobile navigation toggle
    const mobileToggle = document.getElementById('mobile-toggle-btn');
    const navMenu = document.getElementById('nav-menu');
    mobileToggle.addEventListener('click', () => {
      navMenu.classList.toggle('active');
      const icon = mobileToggle.querySelector('i');
      if (navMenu.classList.contains('active')) {
        icon.className = 'fas fa-times';
      } else {
        icon.className = 'fas fa-bars';
      }
    });

    // Close menu when clicking link
    document.querySelectorAll('#nav-menu a').forEach(link => {
      link.addEventListener('click', () => {
        navMenu.classList.remove('active');
        mobileToggle.querySelector('i').className = 'fas fa-bars';
      });
    });

    // Fetch Testimonials from API
    async function loadTestimonials() {
      try {
        const res = await fetch('api-get-testimonials.php');
        testimonialsData = await res.json();
      } catch (err) {
        console.error("Failed to load testimonials:", err);
      }
    }

    // Live search listener
    searchInput.addEventListener('input', () => {
      const query = searchInput.value.toLowerCase().trim();
      
      if (query === '') {
        marqueeSectionWrapper.classList.remove('d-none');
        searchGridWrapper.classList.add('d-none');
        searchStatusWrapper.classList.add('d-none');
        return;
      }

      const filtered = testimonialsData.filter(item => {
        return item.name.toLowerCase().includes(query) || 
               item.occupation.toLowerCase().includes(query) || 
               item.content.toLowerCase().includes(query);
      });

      displayedCount.textContent = filtered.length;
      searchStatusWrapper.classList.remove('d-none');

      searchGridWrapper.innerHTML = '';
      if (filtered.length === 0) {
        searchGridWrapper.innerHTML = `<div class="search-empty-state"><i class="fas fa-search-minus"></i> Tidak ada testimoni yang cocok dengan "${query}".</div>`;
      } else {
        filtered.forEach(item => {
          let starsHtml = '';
          for (let s = 1; s <= 5; s++) {
            starsHtml += s <= item.rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
          }

          const avatarHtml = item.avatar ? `<img src="${item.avatar}" class="author-avatar" alt="${item.name}" loading="lazy" onerror="this.style.display='none'">` : '';

          const card = document.createElement('div');
          card.className = 'marquee-card static-card';
          card.innerHTML = `
            <div class="card-header-row">
              <div class="author-details-wrapper">
                ${avatarHtml}
                <div class="author-details">
                  <h4>${item.name}</h4>
                  <p>${item.occupation}</p>
                </div>
              </div>
              <div class="rating-stars">${starsHtml}</div>
            </div>
            <p class="card-body-text">"${item.content}"</p>
          `;
          searchGridWrapper.appendChild(card);
        });
      }

      marqueeSectionWrapper.classList.add('d-none');
      searchGridWrapper.classList.remove('d-none');
    });

    // Direct Form AJAX Submission
    directForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      
      const formData = new FormData(directForm);
      const submitBtn = directForm.querySelector('button[type="submit"]');
      const originalHtml = submitBtn.innerHTML;
      
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
      
      try {
        const response = await fetch('webhook.php', {
          method: 'POST',
          body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
          formAlert.className = 'alert alert-success';
          formAlert.innerHTML = `<i class="fas fa-check-circle"></i> ${result.message}`;
          directForm.reset();
          
          testimonialsData.unshift(result.data);
          addCardToMarqueeDOM(result.data);
        } else {
          formAlert.className = 'alert alert-danger';
          formAlert.innerHTML = `<i class="fas fa-times-circle"></i> ${result.message}`;
        }
      } catch (err) {
        formAlert.className = 'alert alert-danger';
        formAlert.innerHTML = `<i class="fas fa-times-circle"></i> Terjadi kesalahan koneksi server.`;
        console.error(err);
      } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalHtml;
        formAlert.classList.remove('d-none');
        
        setTimeout(() => {
          formAlert.classList.add('d-none');
        }, 8000);
      }
    });

    function addCardToMarqueeDOM(item) {
      let starsHtml = '';
      for (let s = 1; s <= 5; s++) {
        starsHtml += s <= item.rating ? '<i class="fas fa-star"></i>' : '<i class="far fa-star"></i>';
      }
      
      const avatarHtml = item.avatar ? `<img src="${item.avatar}" class="author-avatar" alt="${item.name}" loading="lazy" onerror="this.style.display='none'">` : '';

      const cardHtml = `
        <div class="card-header-row">
          <div class="author-details-wrapper">
            ${avatarHtml}
            <div class="author-details">
              <h4>${item.name}</h4>
              <p>${item.occupation}</p>
            </div>
          </div>
          <div class="rating-stars">${starsHtml}</div>
        </div>
        <p class="card-body-text">"${item.content}"</p>
      `;

      const g1_1 = document.getElementById('marquee-g1-1');
      const g1_2 = document.getElementById('marquee-g1-2');
      
      const newCard1 = document.createElement('div');
      newCard1.className = 'marquee-card animate-pop';
      newCard1.innerHTML = cardHtml;
      if (g1_1) g1_1.insertBefore(newCard1, g1_1.firstChild);

      const newCard2 = document.createElement('div');
      newCard2.className = 'marquee-card';
      newCard2.innerHTML = cardHtml;
      if (g1_2) g1_2.insertBefore(newCard2, g1_2.firstChild);
    }

    // Initial Load
    window.addEventListener('DOMContentLoaded', () => {
      loadTestimonials();
    });


  </script>
</body>
</html>
