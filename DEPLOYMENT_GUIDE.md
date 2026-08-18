# Panduan Deployment & Hosting Live (Kak Jule Public Speaking)

Dokumen ini berisi panduan praktis untuk meng-online-kan website **Kak Jule Public Speaking** hari ini ke layanan Web Hosting & Pembelian Domain.

---

## Ringkasan Struktur Aplikasi
Aplikasi ini dibangun menggunakan **PHP Native, HTML5, CSS3, & JS ES6** dengan sistem penyimpanan **JSON Data Store (`testimonials.json`)**.
Keunggulan arsitektur ini:
- ⚡ **Tanpa Database MySQL / SQL Server**: Sangat cepat dan tidak membutuhkan konfigurasi database serumit CMS lain.
- 🚀 **Portabel & Ringan**: Bisa di-upload langsung ke hosting murah maupun cPanel/Hostinger manapun.
- 🔄 **Auto-Sync Google Sheet & Webhook Form Ready**.

---

## Pilihan Provider Hosting & Pembelian Domain
Rekomendasi provider hosting lokal & internasional terpopuler:
1. **Hostinger Indonesia** (Hostinger.co.id) -> Paket *Single Web Hosting* / *Premium Hosting* (Sudah gratis domain .com / .id selama 1 tahun).
2. **Niagahoster** (Niagahoster.co.id) -> Paket *Bayar bulanan/tahunan*.
3. **Rumahweb / DomaiNesia / Dewaweb**.

---

## Langkah Deployment ke Hosting (cPanel / Hostinger)

### 1. Persiapan File Web
Semua file di dalam folder `jule-publicspeaking` siap di-upload:
- `index.php` (Halaman utama landing page)
- `db.php` (Modul sinkronisasi & datastore JSON)
- `sync-sheets.php` (Endpoint sync spreadsheet)
- `webhook.php` (Endpoint webhook Google Form)
- `api-get-testimonials.php` (API JSON ulasan)
- `testimonials.json` (Database ulasan)
- `assets/` (Folder CSS style & gambar)

### 2. Langkah Upload via File Manager (cPanel / Hostinger Panel)
1. Login ke cPanel atau hPanel Hostinger Anda.
2. Buka menu **File Manager**.
3. Masuk ke direktori **`public_html`**.
4. Upload seluruh file & folder proyek ini ke dalam `public_html`.
5. Pastikan hak akses (*file permission*) untuk `testimonials.json` diatur ke `0664` atau `0755` agar server PHP dapat menulis ulasan baru.

### 3. Verifikasi Domain
1. Buka domain yang baru Anda beli di browser (contoh: `https://julepublicspeaking.com`).
2. Halaman web akan langsung aktif dan menampilkan 140+ ulasan alumni asli yang tersinkronisasi dari Google Sheet!
3. Uji tombol **"Sync Data Spreadsheet Terbaru"** untuk memastikan koneksi ke Google Sheet berjalan lancar.

---

## Catatan Penting Setelah Website Online
Setelah domain Anda aktif:
1. Buka file [GOOGLE_FORM_SETUP.md](file:///c:/laragon/www/jule-publicspeaking/GOOGLE_FORM_SETUP.md) untuk menyambungkan Google Form yang baru dibuat dengan Apps Script ke `https://domainanda.com/webhook.php`.
2. Jika Anda mengubah spreadsheet publik di kemudian hari, Anda cukup memperbarui URL spreadsheet pada baris ke-6 file `db.php`:
   ```php
   define('GOOGLE_SHEET_CSV_URL', 'https://docs.google.com/spreadsheets/d/ID_SPREADSHEET_BARU/export?format=csv');
   ```
