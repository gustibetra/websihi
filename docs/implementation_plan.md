# Konversi Website DPRD → Website SMK (Fokus Admin Panel)

## Latar Belakang

Project ini adalah website DPRD yang akan dikonversi menjadi website profil SMK. Fokus tahap pertama adalah **admin panel** — membersihkan fitur DPRD yang tidak relevan, menyesuaikan terminologi, dan menambahkan modul baru yang dibutuhkan SMK.

Strategi utama: **gunakan `common` table sebagai master data** untuk hal-hal seperti program jurusan, kategori berita, mitra industri, dll. — sehingga tidak perlu banyak migrasi baru.

---

## User Review Required

> [!IMPORTANT]
> **Role baru yang diusulkan:**
> - `SuperAdmin` → akses penuh (ganti dari `Admin`)
> - `AdminJurusan` → kelola konten jurusan-nya sendiri (ganti dari `Operator`)
> - `Editor` → hanya kelola berita & galeri (baru)
>
> Apakah perubahan nama role ini disetujui, atau ingin tetap menggunakan `Admin` / `Operator`?

> [!WARNING]
> **Tabel yang akan di-repurpose (bukan dihapus):**
> - `members` → diubah menjadi **Guru & Tenaga Kependidikan**
> - `secretariat` → diubah menjadi **Tenaga Kependidikan** (atau digabung ke members)
> - `common` → menampung: Program Jurusan, Kategori Berita, Mitra Industri, Alumni, Prestasi, Download Center
>
> Tabel yang akan **dihapus / dinonaktifkan**:
> - `structure_members` (khusus DPRD — struktur fraksi/komisi)
> - `transparency` (keterbukaan informasi publik DPRD — tidak relevan untuk SMK)

---

## Open Questions

> [!IMPORTANT]
> 1. Apakah fitur **PPDB** perlu dibangun di admin panel sekarang, atau di-skip dulu?
> 2. Apakah **struktur organisasi sekolah** tetap menggunakan mekanisme yang sama (`common` + `structure_members`), atau cukup dengan halaman statis?
> 3. Apakah setiap **Program Jurusan** perlu punya admin sendiri (`AdminJurusan`), atau cukup dikelola oleh SuperAdmin saja untuk saat ini?

---

## Proposed Changes

### 1. Database & Migrations

#### [NEW] Migration: repurpose `members` table for Guru
`database/migrations/2026_06_10_000001_repurpose_members_to_guru_table.php`
- Ubah kolom agar sesuai untuk data guru: `nip`, `bidang_studi`, `status_kepegawaian`
- Hapus kolom DPRD-spesifik: `periode`, `nomor_anggota`, `fraksi`

#### [NEW] Migration: add `common_data` columns untuk jurusan
`database/migrations/2026_06_10_000002_add_jurusan_support_to_common.php`
- Tambah `is_active` ke common table (untuk filter aktif/nonaktif)

> [!NOTE]
> **Penggunaan `common` table untuk SMK:**
> | `table_name` | Digunakan untuk |
> |---|---|
> | `jurusan` | Program Keahlian (data1=nama, data2=kode, data3=kepala_program, text1=deskripsi) |
> | `kategori_berita` | Kategori berita (data1=nama, data2=slug, data3=warna) |
> | `mitra_industri` | Mitra DU/DI (data1=nama, data2=website, data3=logo, text1=deskripsi) |
> | `alumni` | Testimoni alumni (data1=nama, data2=angkatan, data3=tempat_kerja, text1=testimoni) |
> | `prestasi` | Prestasi sekolah/siswa (data1=judul, data2=tingkat, data3=tahun, data4=kategori) |
> | `download` | Download center (data1=judul, data2=kategori, data3=file_path) |
> | `fasilitas` | Fasilitas sekolah (data1=nama, data2=lokasi, data3=foto, text1=deskripsi) |

---

### 2. Models

#### [MODIFY] [User.php](file:///c:/Users/andikaa/Downloads/xds/app/Models/User.php)
- Tambah role `Editor`
- Tambah kolom `jurusan_id` (nullable, FK ke common) untuk AdminJurusan
- Update method `isAdmin()`, tambah `isEditor()`, `isAdminJurusan()`

#### [MODIFY] [Member.php](file:///c:/Users/andikaa/Downloads/xds/app/Models/Member.php)
- Rename konseptual menjadi **Guru**
- Sesuaikan `$fillable` dengan kolom baru (nip, bidang_studi, dll)
- Tambah scope: `scopeGuru()`, `scopeTenagaKependidikan()`

#### [MODIFY] [Common.php](file:///c:/Users/andikaa/Downloads/xds/app/Models/Common.php)
- Hapus relasi `structureMembers()` dan `members()` (DPRD-specific)
- Tambah scope: `scopeJurusan()`, `scopeKategoriBerida()`, `scopeAlumni()`, dll.
- Tambah static helper: `Common::getByTable($tableName)`

#### [NEW] Hapus/cleanup model DPRD
- `StructureMember.php` → hapus atau jadikan unused
- `Secretariat.php` → merge ke Member atau repurpose sebagai TenagaKependidikan
- `Transparency.php` → simpan tapi nonaktifkan dari UI

---

### 3. Controllers (Admin)

#### [MODIFY] [DashboardController.php](file:///c:/Users/andikaa/Downloads/xds/app/Http/Controllers/Admin/DashboardController.php)
Ubah statistik dashboard:
- ~~Total Anggota~~ → **Total Guru**
- ~~Total Agenda~~ → **Total Galeri**
- Tambah: **Total Program Jurusan**, **Total Berita**

#### [MODIFY] [MemberController.php](file:///c:/Users/andikaa/Downloads/xds/app/Http/Controllers/Admin/MemberController.php)
- Rename secara konseptual menjadi **GuruController** (tapi file tetap `MemberController.php` untuk backward compat)
- Ubah logic: filter `jenis` (Guru / Tenaga Kependidikan)
- Update validasi form

#### [DELETE] Nonaktifkan dari routes:
- `StructureController` (DPRD-specific)
- `SecretariatController` → gabung ke MemberController atau hapus
- `TransparencyController` → sembunyikan dari sidebar

#### [NEW] `JurusanController.php`
- CRUD untuk data program jurusan (menggunakan `common` table dengan `table_name = 'jurusan'`)
- Fitur: nama jurusan, kode, kepala program, deskripsi, foto

---

### 4. Livewire Components

#### [MODIFY] [MemberManager.php](file:///c:/Users/andikaa/Downloads/xds/app/Livewire/Admin/MemberManager.php)
- Ubah label & kolom ke terminologi guru/sekolah
- Tambah filter: Guru vs Tenaga Kependidikan
- Tambah kolom: `nip`, `bidang_studi`, `status_kepegawaian`

#### [NEW] `JurusanManager.php`
- Livewire component untuk CRUD Program Jurusan via common table
- Reuse pattern dari `CommonDataManager.php`

#### [MODIFY] [CommonDataManager.php](file:///c:/Users/andikaa/Downloads/xds/app/Livewire/Admin/CommonDataManager.php)
- Tambah awareness terhadap `table_name` baru (jurusan, alumni, prestasi, download, fasilitas)
- Tambah mapping label kolom per table_name

#### [MODIFY] [SettingsManager.php](file:///c:/Users/andikaa/Downloads/xds/app/Livewire/Admin/SettingsManager.php)
- Ubah label setting dari DPRD ke SMK (nama sekolah, NPSN, alamat, dll)

---

### 5. Views (Admin)

#### [MODIFY] [layouts/admin.blade.php](file:///c:/Users/andikaa/Downloads/xds/resources/views/layouts/admin.blade.php)
- Ubah footer: "DPRD Subang" → nama sekolah dari settings

#### [MODIFY] [partials/admin/sidebar.blade.php](file:///c:/Users/andikaa/Downloads/xds/resources/views/partials/admin/sidebar.blade.php)
Ubah struktur menu sidebar:
```
📊 Dashboard

📢 Konten
  - Berita
  - Pengumuman  
  - Agenda/Kegiatan
  - Halaman
  - Galeri

🏫 Data Sekolah [SuperAdmin]
  - Program Jurusan
  - Guru & Tenaga Kependidikan
  - Prestasi
  - Alumni
  - Mitra DU/DI
  - Fasilitas
  - Download Center

⚙️ Pengaturan [SuperAdmin]
  - Pengaturan Website
  - Manajemen Menu
  - Common Data
  - Manajemen User
```

#### [MODIFY] [admin/dashboard.blade.php](file:///c:/Users/andikaa/Downloads/xds/resources/views/admin/dashboard.blade.php)
- Ubah kartu statistik sesuai konteks SMK

#### [NEW] `admin/jurusan/` folder
- `index.blade.php` — daftar program jurusan
- `form.blade.php` — form tambah/edit jurusan

#### [MODIFY] `admin/members/` → views guru
- Sesuaikan label, tambah filter jenis (Guru/TU)

---

### 6. Routes

#### [MODIFY] [routes/web.php](file:///c:/Users/andikaa/Downloads/xds/routes/web.php)
- Hapus/comment: `structure`, `secretariat`, `transparency` routes dari admin group
- Tambah: `jurusan` routes
- Update use statements (hapus `StructureController`, `SecretariatController`)

---

### 7. Seeder

#### [MODIFY] [UserSeeder.php](file:///c:/Users/andikaa/Downloads/xds/database/seeders/UserSeeder.php)
- Ganti email dari `dika@dprd.com` → email sekolah
- Update role menjadi `SuperAdmin` (jika role diubah)

#### [NEW] `CommonDataSeeder.php`
- Seed data awal `jurusan` di common table (contoh: RPL, TKJ, Multimedia)
- Seed kategori berita, dll.

---

## Verification Plan

### Automated
```bash
php artisan migrate:fresh --seed
php artisan route:list | grep admin
```

### Manual Verification
1. Login ke admin panel — pastikan sidebar sudah berubah ke konteks SMK
2. Buka menu **Program Jurusan** — pastikan CRUD berjalan
3. Buka menu **Guru** — pastikan data guru bisa dikelola
4. Dashboard menampilkan statistik yang relevan
5. Setting bisa diubah dengan nama sekolah SMK
6. Tidak ada error/broken link di sidebar
