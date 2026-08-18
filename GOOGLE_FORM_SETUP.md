# Panduan Menghubungkan Google Form ke Website (Real-Time Testimonial Sync)

Dokumen ini berisi panduan untuk menyambungkan **Google Form** yang diisi alumni ke website **Kak Jule Public Speaking** secara *real-time*.

---

## Langkah 1: Buat Google Form & Hubungkan ke Google Spreadsheet

1. Buat Google Form baru dengan pertanyaan wajib berikut:
   - **Pertanyaan 1 (Short Answer / Jawaban Singkat)**: Nama Lengkap (beserta gelar, jika ada)
   - **Pertanyaan 2 (Short Answer / Jawaban Singkat)**: Pekerjaan / Instansi
   - **Pertanyaan 3 (Linear Scale / Skala Linier 1-5)**: Rating Kepuasan Kelas
   - **Pertanyaan 4 (Paragraph / Paragraf)**: Ulasan / Testimoni Anda
   - *(Opsional) Pertanyaan 5 (File Upload)*: Upload foto terbaik Anda
2. Klik tab **Tanggapan (Responses)** di bagian atas Google Form.
3. Klik ikon hijau **Hubungkan ke Spreadsheet (Link to Sheets)** untuk membuat Google Spreadsheet penampung hasil ulasan.

---

## Langkah 2: Pasang Google Apps Script Webhook

1. Buka file Google Spreadsheet yang sudah terhubung dengan Google Form tersebut.
2. Di menu bagian atas, klik **Ekstensi (Extensions)** > **Apps Script**.
3. Hapus seluruh kode bawaan yang ada di editor `Code.gs`.
4. Salin (copy) dan tempel (paste) kode berikut:

```javascript
function onSubmit(e) {
  var sheet = SpreadsheetApp.getActiveSpreadsheet().getActiveSheet();
  var row = sheet.getLastRow();
  
  // Mengambil data dari kolom baris terakhir
  // Kolom 2: Nama, Kolom 3: Pekerjaan, Kolom 4: Rating, Kolom 5: Ulasan
  var name = sheet.getRange(row, 2).getValue();
  var occupation = sheet.getRange(row, 3).getValue();
  var rating = sheet.getRange(row, 4).getValue();
  var content = sheet.getRange(row, 5).getValue();
  
  // Ganti URL berikut dengan domain hosting live Anda saat online
  var webhookUrl = "https://DOMAIN_ANDA_DISINI.com/webhook.php";
  
  var payload = {
    "name": name,
    "occupation": occupation,
    "rating": rating,
    "content": content
  };
  
  var options = {
    "method": "post",
    "contentType": "application/json",
    "payload": JSON.stringify(payload),
    "muteHttpExceptions": true
  };
  
  try {
    UrlFetchApp.fetch(webhookUrl, options);
  } catch (err) {
    Logger.log("Error sending webhook: " + err.toString());
  }
}
```

5. Ganti `https://DOMAIN_ANDA_DISINI.com/webhook.php` dengan URL domain Anda saat website sudah di-hosting live.
6. Klik ikon disket **Simpan (Save project)**.

---

## Langkah 3: Aktifkan Trigger `onSubmit`

1. Di sebelah kiri layar Apps Script, klik ikon jam **Pemicu (Triggers)**.
2. Klik tombol biru **+ Tambahkan Pemicu (+ Add Trigger)** di kanan bawah.
3. Atur konfigurasi sebagai berikut:
   - **Pilih fungsi yang akan dijalankan**: `onSubmit`
   - **Pilih peluncuran yang harus dijalankan**: `Head`
   - **Pilih sumber acara**: `Dari spreadsheet`
   - **Pilih jenis acara**: `Saat mengirim form` *(On form submit)*
4. Klik **Simpan**. Apabila muncul jendela otorisasi akun Google, klik **Lanjutkan / Izinkan (Allow)**.

---

## Selesai! 🎉
Setiap kali alumni mengisi Google Form Anda, testimoni akan otomatis terkirim dan langsung muncul di halaman depan website Kak Jule secara *real-time*!
