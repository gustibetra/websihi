# Portal Website & CMS Sekolah

Aplikasi web modern berbasis Laravel untuk portal informasi, profil sekolah, dan manajemen konten (CMS) internal sekolah.

## Fitur Utama

### 1. Manajemen Informasi & Konten (CMS)
- **Berita & Kegiatan**: Publikasi berita sekolah dengan kategori, kalkulasi waktu baca, statistik pengunjung, dan tag cloud.
- **Agenda & Event**: Publikasi jadwal agenda sekolah terintegrasi dengan program keahlian tertentu.
- **Pengumuman**: Manajemen pengumuman aktif dan berakhir dengan lampiran dokumen pendukung.
- **Galeri Foto**: Galeri dokumentasi kegiatan sekolah yang premium dan responsif.
- **Pusat Unduhan (Documents)**: Upload dan unduh berkas, formulir, panduan, serta dokumen penting sekolah.

### 2. Fitur Akademik & Organisasi
- **Program Keahlian (Jurusan)**: Halaman khusus (Program Space) untuk setiap jurusan (seperti RPL, TJKT, AKL) yang dinamis menampilkan agenda khusus jurusan tersebut.
- **Struktur Organisasi**: Manajemen data pengurus komite, kepala sekolah, guru, staf, dan anggota struktural lainnya.
- **Direktori Guru, Siswa, & Alumni**: Pencarian data guru/staf aktif, siswa, serta pelacakan alumni.

### 3. Modul Interaktif & Pengaturan
- **Fasilitas Sekolah**: Daftar fasilitas sekolah pada beranda utama yang lengkap dengan foto, judul, kapasitas, dan deskripsi singkat.
- **FAQ (Tanya Jawab)**: Modul pengelolaan FAQ dinamis dari panel admin untuk ditampilkan di beranda.
- **Pengaturan Portal**: Manajemen logo, kontak, link PPDB, banner hero, menu navigasi dinamis, dan integrasi link eksternal.
- **Sistem Keamanan**: Logging aktivitas sistem, manajemen user, dan perlindungan akses menu admin.

## Tech Stack

- **Framework**: Laravel 10+ (PHP 8.2+)
- **Frontend Interactivity**: Livewire & JavaScript Vanilla
- **Styling & Assets**: Vanilla CSS (RBT Theme), Feather Icons, SCSS compilation
- **Database**: MySQL / MariaDB

## Prasyarat

Pastikan environment lokal Anda sudah terpasang:
- PHP 8.2 atau lebih baru
- Composer
- Node.js & NPM
- Database MySQL/MariaDB

## Panduan Instalasi

1. **Clone repository**:
   ```bash
   git clone https://github.com/gustibetra/websihi.git
   cd web-sihi
   ```

2. **Install dependency backend**:
   ```bash
   composer install
   ```

3. **Install dependency frontend**:
   ```bash
   npm install
   ```

4. **Konfigurasi Environment**:
   Salin file `.env.example` menjadi `.env` dan generates APP_KEY:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Pengaturan Database**:
   Sesuaikan konfigurasi database (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) di file `.env`, kemudian jalankan migrasi database beserta seeder datanya:
   ```bash
   php artisan migrate --seed
   ```

6. **Symbolic Link Storage**:
   Buat link folder storage ke folder publik untuk kebutuhan upload gambar dan file:
   ```bash
   php artisan storage:link
   ```

## Menjalankan Aplikasi Secara Lokal

Jalankan server Laravel:
```bash
php artisan serve
```

Jalankan asset compiler Vite untuk frontend:
```bash
npm run dev
```

Build production assets:
```bash
npm run build
```

## Struktur Direktori Utama

- `app/` - Logika utama aplikasi (Models, Services, Livewire components, Controllers, Repository pattern).
- `database/` - Migrasi tabel database, seeder data awal, dan model factory.
- `resources/` - File view Laravel (Blade template), asset JavaScript, dan stylesheet CSS/SCSS.
- `routes/` - Definisi route (Web site publik, admin control panel, dan common modules).
- `public/` - Asset statis hasil compile, library eksternal, dan file upload publik.
