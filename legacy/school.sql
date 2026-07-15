-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2026 at 07:53 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school`
--

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'siswa',
  `title` varchar(255) NOT NULL,
  `achiever` varchar(255) NOT NULL,
  `student_ids` text DEFAULT NULL,
  `jurusan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kategori_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tingkat_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL,
  `organizer` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `news_id` bigint(20) UNSIGNED DEFAULT NULL,
  `photo` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`id`, `type`, `title`, `achiever`, `student_ids`, `jurusan_id`, `kategori_id`, `tingkat_id`, `date`, `organizer`, `description`, `news_id`, `photo`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'siswa', 'Juara 1 Lomba Robotik Nasional 2026', 'Aura Nabila, Faisal Rahman', '2,1', 1, 118, 130, '2026-05-15', 'Kementerian Riset dan Teknologi', 'Siswa TJKT berhasil meraih medali emas dalam kompetisi robotika tingkat nasional dengan inovasi robot penyelamat mandiri berbasis AI.', 1, 'achievements/4q9Vlb7VyoQwIAKXCo8PES4K9epeIDJDUFPhYPZ5.png;achievements/1JcXa5kFUjhmvwGnEzwaE4XvGQWfInEgqwPBmEjQ.png', 1, 1, 1, '2026-06-15 13:50:49', '2026-06-15 14:40:25'),
(2, 'siswa', 'Juara 2 Olimpiade Matematika Terapan', 'Bintang Pratama', '3', 4, 116, 129, '2026-04-18', 'Universitas Indonesia', 'Prestasi membanggakan diraih oleh siswi Akuntansi dalam olimpiade matematika terapan tingkat provinsi Jawa Barat.', NULL, 'achievements/wJoIqqui8Fi7dk38FRucrya5snPWxMDU6rkmrUFk.png', 1, 1, 1, '2026-06-15 13:50:49', '2026-06-15 14:11:48'),
(3, 'siswa', 'Juara 1 Web Design Competition 2026', 'Budi Setiawan', NULL, NULL, 118, 130, '2026-03-22', 'Kementerian Pendidikan dan Kebudayaan', 'Budi Setiawan dari kelas XII RPL meraih Juara 1 nasional dalam kategori desain antarmuka web interaktif bertema edukasi pasca-pandemi.', NULL, NULL, 1, 1, NULL, '2026-06-15 13:50:49', '2026-06-15 13:50:49'),
(4, 'siswa', 'Juara 1 Kejuaraan Pencak Silat Pelajar', 'Deden Kurnia', NULL, NULL, 119, 127, '2026-02-10', 'IPSI Kabupaten Subang', 'Medali emas diraih oleh Deden Kurnia dalam kategori tanding kelas C Putra Kejuaraan Pencak Silat Pelajar se-Kabupaten Subang.', NULL, NULL, 1, 1, NULL, '2026-06-15 13:50:49', '2026-06-15 13:50:49'),
(5, 'siswa', 'Juara 3 Lomba Karya Tulis Ilmiah Populer', 'Siti Nurhaliza', NULL, NULL, 122, 129, '2026-01-15', 'Dinas Pendidikan Jawa Barat', 'Siti Nurhaliza berhasil menyabet juara ketiga melalui karya tulis ilmiah populernya yang membahas pemanfaatan IoT untuk pertanian berkelanjutan.', NULL, NULL, 1, 1, NULL, '2026-06-15 13:50:49', '2026-06-15 13:50:49'),
(6, 'sekolah', 'Penghargaan Sekolah Adiwiyata Mandiri 2026', 'SMK PGRI Subang', NULL, NULL, 117, 130, '2026-06-05', 'Kementerian Lingkungan Hidup dan Kehutanan', 'SMK PGRI Subang dianugerahi penghargaan Adiwiyata Mandiri atas konsistensi sekolah dalam menerapkan budaya peduli lingkungan hidup dan kelestarian alam.', NULL, NULL, 1, 1, NULL, '2026-06-15 13:50:49', '2026-06-15 13:50:49'),
(7, 'sekolah', 'Sekolah Rujukan Pembelajaran Berbasis Industri', 'SMK PGRI Subang', NULL, NULL, 118, 130, '2026-05-20', 'Direktorat PSMK Kemendikbud', 'Terpilih menjadi salah satu sekolah percontohan nasional dalam mengimplementasikan kurikulum link and match kelas industri bersama mitra multinasional.', NULL, NULL, 1, 1, NULL, '2026-06-15 13:50:49', '2026-06-15 13:50:49'),
(8, 'sekolah', 'Juara 1 Perpustakaan Sekolah Terbaik', 'Perpustakaan Widya Pustaka', NULL, NULL, 122, 127, '2026-04-12', 'Dinas Kearsipan dan Perpustakaan Daerah', 'Perpustakaan Widya Pustaka SMK PGRI Subang dinobatkan sebagai perpustakaan sekolah dengan pengelolaan digital dan kenyamanan baca terbaik tingkat kabupaten.', NULL, NULL, 1, 1, NULL, '2026-06-15 13:50:49', '2026-06-15 13:50:49'),
(9, 'sekolah', 'Penghargaan Apresiasi Seni & Budaya Daerah', 'Grup Seni Lingkar Widya', NULL, NULL, 120, 129, '2026-03-10', 'Dinas Pariwisata dan Kebudayaan Jabar', 'Apresiasi tinggi diberikan atas dedikasi sekolah dalam melestarikan seni musik tradisional kecapi suling dan angklung interaktif di kalangan remaja.', NULL, NULL, 1, 1, NULL, '2026-06-15 13:50:49', '2026-06-15 13:50:49'),
(10, 'sekolah', 'Juara Umum Tata Kelola Sanitasi Sekolah Sehat', 'SMK PGRI Subang', NULL, NULL, 117, 127, '2026-02-18', 'Dinas Kesehatan Kabupaten Subang', 'Keberhasilan mewujudkan lingkungan sekolah bersih dengan standar pengelolaan air bersih dan sanitasi kelas satu se-kabupaten Subang.', NULL, NULL, 1, 1, NULL, '2026-06-15 13:50:49', '2026-06-15 13:50:49');

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL DEFAULT 'male',
  `birth_place` varchar(100) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `tahun_lulus` varchar(4) NOT NULL,
  `tempat_kerja` varchar(150) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `status_alumni` varchar(100) DEFAULT NULL,
  `bidang_pekerjaan` varchar(100) DEFAULT NULL,
  `testimoni` text DEFAULT NULL,
  `is_inspiratif` tinyint(1) NOT NULL DEFAULT 0,
  `jurusan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`id`, `name`, `photo`, `gender`, `birth_place`, `birth_date`, `address`, `phone`, `email`, `tahun_lulus`, `tempat_kerja`, `jabatan`, `status_alumni`, `bidang_pekerjaan`, `testimoni`, `is_inspiratif`, `jurusan_id`, `order`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Ahmad Fauzi', 'alumni/alumni-01.png', 'male', 'Bandung', '2004-03-12', 'Jl. Merdeka No. 45, Bandung', '081234567801', 'ahmad.fauzi@gmail.com', '2022', 'Institut Teknologi Bandung (ITB)', 'Mahasiswa Teknik Informatika', 'Kuliah', NULL, 'Bekal materi pemrograman web dan basis data dari SMK sangat menunjang kuliah saya. Di semester awal ITB saya merasa jauh lebih siap dibanding rekan-rekan lulusan SMA.', 1, NULL, 1, 1, 1, 1, '2026-06-16 08:21:05', '2026-06-16 08:21:05'),
(2, 'Luthfi Ramadhan', 'alumni/alumni-02.png', 'male', 'Jakarta', '2005-07-22', 'Jl. Gatot Subroto No. 12, Bandung', '081234567802', 'luthfi.r@gmail.com', '2023', 'Universitas Indonesia (UI)', 'Mahasiswa Ilmu Komputer', 'Kuliah', NULL, 'Kurikulum di sekolah yang adaptif dan fokus pada project base learning sangat melatih logika berpikir saya untuk mata kuliah Algoritma dan Pemrograman di UI.', 1, 1, 2, 1, 1, 1, '2026-06-16 08:21:05', '2026-06-18 23:25:50'),
(3, 'Siti Aminah', 'alumni/alumni-03.png', 'female', 'Cimahi', '2004-11-05', 'Jl. Cihanjuang No. 88, Cimahi', '081234567803', 'siti.aminah@gmail.com', '2022', 'Universitas Gadjah Mada (UGM)', 'Mahasiswa Teknologi Informasi', 'Kuliah', NULL, 'Fasilitas laboratorium komputer dan praktek jaringan selama sekolah membuka wawasan saya tentang arsitektur internet modern, sangat berguna dalam perkuliahan di UGM.', 1, 1, 3, 1, 1, 1, '2026-06-16 08:21:05', '2026-06-18 23:25:56'),
(4, 'Rizky Pratama', 'alumni/alumni-04.png', 'male', 'Soreang', '2003-09-18', 'Perum Indah Regency No. A4, Bandung', '081234567804', 'rizky.p@gmail.com', '2021', 'Universitas Padjadjaran (Unpad)', 'Mahasiswa Akuntansi Keuangan', 'Kuliah', NULL, 'Praktek komputer akuntansi menggunakan Accurate dan MYOB selama di sekolah membuat mata kuliah Akuntansi Praktis di Unpad terasa jauh lebih mudah dipahami.', 0, 4, 4, 1, 1, 1, '2026-06-16 08:21:05', '2026-06-16 08:21:05'),
(5, 'Fatimah Az-Zahra', 'alumni/alumni-05.png', 'female', 'Bandung', '2005-01-30', 'Jl. Antapani No. 102, Bandung', '081234567805', 'fatimah.az@gmail.com', '2023', 'Universitas Pendidikan Indonesia (UPI)', 'Mahasiswa Pendidikan Ilmu Komputer', 'Kuliah', NULL, 'Sekolah melatih mental dan kedisiplinan saya. Para guru tidak hanya memberikan ilmu akademis tetapi juga etika kepemimpinan yang luar biasa.', 0, NULL, 5, 1, 1, 1, '2026-06-16 08:21:05', '2026-06-16 08:21:05'),
(6, 'Budi Santoso', 'alumni/alumni-06.png', 'male', 'Sumedang', '2004-05-14', 'Jl. Jatinangor No. 27, Sumedang', '081234567806', 'budi.s@gmail.com', '2022', 'Telkom University', 'Mahasiswa Teknik Telekomunikasi', 'Kuliah', NULL, 'Pengalaman praktek konfigurasi routing, Cisco, dan Mikrotik di laboratorium sekolah memberikan dasar yang sangat kuat bagi mata kuliah jaringan telekomunikasi saya.', 1, 2, 6, 1, 1, 1, '2026-06-16 08:21:05', '2026-06-16 08:21:05'),
(7, 'Dewi Lestari', 'alumni/alumni-07.png', 'female', 'Bandung', '2004-08-09', 'Jl. Pasir Kaliki No. 15, Bandung', '081234567807', 'dewi.lestari@gmail.com', '2022', 'Universitas Diponegoro (Undip)', 'Mahasiswa Manajemen Keuangan', 'Kuliah', NULL, 'Berkat pembekalan perpajakan dan audit dari sekolah, saya bisa berprestasi dalam kompetisi akuntansi nasional tingkat universitas semester ini.', 0, 4, 7, 1, 1, 1, '2026-06-16 08:21:05', '2026-06-16 08:21:05'),
(8, 'Eko Prasetyo', 'alumni/alumni-08.png', 'male', 'Garut', '2003-12-25', 'Jl. Soekarno Hatta No. 345, Bandung', '081234567808', 'eko.p@gmail.com', '2021', 'Institut Teknologi Sepuluh Nopember (ITS)', 'Mahasiswa Sistem Informasi', 'Kuliah', NULL, 'Pelajaran rekayasa perangkat lunak mengajarkan saya esensi dari Software Development Life Cycle (SDLC) yang sangat ditekankan di perkuliahan ITS.', 0, NULL, 8, 1, 1, 1, '2026-06-16 08:21:05', '2026-06-16 08:21:05'),
(9, 'Indah Cahyani', 'alumni/alumni-09.png', 'female', 'Bandung', '2005-04-12', 'Jl. Buah Batu No. 199, Bandung', '081234567809', 'indah.c@gmail.com', '2023', 'BINUS University', 'Mahasiswa Mobile Application Development', 'Kuliah', NULL, 'Materi Android programming and OOP yang solid selama sekolah membuat saya langsung terpilih menjadi asisten laboratorium di BINUS.', 0, 1, 9, 1, 1, 1, '2026-06-16 08:21:05', '2026-06-18 23:26:02'),
(10, 'Fajar Nugraha', 'alumni/alumni-10.png', 'male', 'Subang', '2004-10-02', 'Jl. Dago Elos No. 3, Bandung', '081234567810', 'fajar.n@gmail.com', '2022', 'Universitas Brawijaya (UB)', 'Mahasiswa Jaringan Komputer', 'Kuliah', NULL, 'Sertifikasi industri CCNA yang difasilitasi sekolah saat kelas XI benar-benar mempercepat pemahaman materi infrastruktur IT saya di UB.', 1, 2, 10, 1, 1, 1, '2026-06-16 08:21:05', '2026-06-16 08:21:05'),
(11, 'Rian Hidayat, S.Kom.', 'alumni/alumni-01.png', 'male', 'Bandung', '2000-05-18', 'Jl. Cibaduyut Lama No. 56, Bandung', '081299998881', 'rian.h@gmail.com', '2019', 'PT Tokopedia (GoTo)', 'Senior Frontend Developer', 'Bekerja', 'Software Engineering', 'Belajar di SMK ini adalah pondasi terbaik karir saya. Kurikulum industri dan guru yang kompeten membuat saya siap kerja langsung setelah lulus.', 1, NULL, 11, 1, 1, 1, '2026-06-16 08:21:05', '2026-06-16 08:21:05'),
(12, 'Dimas Anggara', 'alumni/alumni-02.png', 'male', 'Bandung', '1999-11-04', 'Jl. Sukajadi No. 190, Bandung', '081299998883', 'dimas.a@gmail.com', '2018', 'PT Telkom Indonesia', 'Network Security Specialist', 'Bekerja', 'Cyber Security / IT', 'Kombinasi teori and praktek laboratorium yang lengkap membuat proses sertifikasi keahlian saya berjalan sangat mulus ketika lulus.', 1, 2, 12, 1, 1, 1, '2026-06-16 08:21:05', '2026-06-16 08:21:05'),
(13, 'Andika Wijaya', 'alumni/alumni-03.png', 'male', 'Cimahi', '2001-02-15', 'Jl. Leuwigajah No. 45, Cimahi', '081234567811', 'andika.w@gmail.com', '2020', 'Shopee Indonesia', 'Fullstack Web Engineer', 'Bekerja', 'Software Developer', 'Tugas akhir berbasis project yang menantang selama sekolah sangat membantu portofolio saya untuk menembus seleksi kerja di e-commerce ternama.', 1, NULL, 13, 1, 1, 1, '2026-06-16 08:21:05', '2026-06-16 08:21:05'),
(14, 'Riana Fitriani', 'alumni/alumni-04.png', 'female', 'Bandung', '2002-06-21', 'Jl. Kopo Sayati No. 12, Bandung', '081234567812', 'riana.f@gmail.com', '2020', 'PricewaterhouseCoopers (PwC) Indonesia', 'Junior Auditor', 'Bekerja', 'Akuntansi / Auditor', 'Kemampuan audit dan analisis laporan keuangan yang diajarkan guru sangat relevan dengan standar kerja KAP Big Four tempat saya berkarir.', 1, 4, 14, 1, 1, 1, '2026-06-16 08:21:05', '2026-06-16 08:21:05'),
(15, 'Maulana Malik', 'alumni/alumni-05.png', 'male', 'Bandung', '2000-08-31', 'Jl. Gedebage No. 90, Bandung', '081234567813', 'maulana.m@gmail.com', '2019', 'PT Astra International Tbk', 'Systems Administrator', 'Bekerja', 'IT Operations', 'Sekolah tidak hanya mengajarkan skill teknis, tetapi soft skill seperti kedisiplinan dan komunikasi kerja (attitude) yang sangat dihargai di Astra.', 0, 2, 15, 1, 1, 1, '2026-06-16 08:21:05', '2026-06-16 08:21:05');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `content` text DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jurusan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `period` varchar(50) DEFAULT NULL COMMENT 'Period (contoh: "2024-2029") - optional, jika NULL berarti pengumuman bersifat umum',
  `attachment` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `custom1` varchar(255) DEFAULT NULL,
  `custom2` varchar(255) DEFAULT NULL,
  `custom3` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `title`, `slug`, `content`, `excerpt`, `image`, `banner`, `category_id`, `jurusan_id`, `period`, `attachment`, `start_date`, `end_date`, `is_public`, `is_active`, `custom1`, `custom2`, `custom3`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Pengumuman Pembagian Rapor Semester Genap Tahun Ajaran 2025/2026', 'pengumuman-pembagian-rapor-semester-genap-tahun-ajaran-20252026', '<p>Sehubungan dengan berakhirnya kegiatan belajar mengajar Semester Genap, kami mengumumkan bahwa pembagian Rapor Hasil Belajar Siswa akan dilaksanakan secara langsung di kelas masing-masing.</p><p>Orang tua atau wali murid diwajibkan hadir untuk mengambil rapor dan berdiskusi mengenai perkembangan belajar siswa dengan wali kelas.</p><p>Harap hadir tepat waktu sesuai dengan jadwal yang telah ditentukan dan mematuhi tata tertib sekolah.</p>', 'Informasi pelaksanaan pembagian rapor hasil belajar siswa semester genap kepada orang tua/wali murid.', NULL, NULL, 169, NULL, 'Tahun Ajaran 2025/2026', NULL, '2026-06-16', '2026-06-23', 1, 1, NULL, NULL, NULL, 1, 1, '2026-06-16 06:55:47', '2026-06-16 06:55:47'),
(2, 'Jadwal Pelaksanaan Penilaian Akhir Semester (PAS) Ganjil', 'jadwal-pelaksanaan-penilaian-akhir-semester-pas-ganjil', '<p>Diberitahukan kepada seluruh siswa kelas X, XI, dan XII bahwa Penilaian Akhir Semester (PAS) Ganjil akan diselenggarakan berbasis komputer (CBT). Kartu peserta ujian dapat diambil melalui wali kelas masing-masing setelah menyelesaikan administrasi perpustakaan.</p><p>Harap persiapkan diri dengan belajar giat dan menjaga kesehatan selama masa ujian berlangsung.</p>', 'Pelaksanaan Penilaian Akhir Semester (PAS) Ganjil berbasis Computer Based Test (CBT).', NULL, NULL, 169, NULL, 'Tahun Ajaran 2025/2026', NULL, '2026-06-06', '2026-06-15', 1, 1, NULL, NULL, NULL, 1, 1, '2026-06-16 06:55:47', '2026-06-16 06:55:47'),
(3, 'Pendaftaran Ekstrakurikuler Wajib dan Pilihan Periode 2026', 'pendaftaran-ekstrakurikuler-wajib-dan-pilihan-periode-2026', '<p>Pendaftaran kegiatan ekstrakurikuler untuk tahun ajaran baru telah resmi dibuka. Setiap siswa kelas X diwajibkan mengikuti ekstrakurikuler Pramuka, serta memilih minimal satu ekstrakurikuler pilihan (Paskibra, PMR, Futsal, Basket, Coding Club, atau Seni Musik).</p><p>Pendaftaran dapat dilakukan secara online melalui portal siswa sekolah menggunakan akun masing-masing.</p>', 'Pembukaan pendaftaran ekstrakurikuler pilihan dan wajib bagi seluruh siswa kelas X.', NULL, NULL, 170, NULL, 'Tahun Ajaran 2025/2026', NULL, '2026-06-18', '2026-06-30', 1, 1, NULL, NULL, NULL, 1, 1, '2026-06-16 06:55:47', '2026-06-16 06:55:47'),
(4, 'Pengumuman Kelulusan Siswa Kelas XII Angkatan 2026', 'pengumuman-kelulusan-siswa-kelas-xii-angkatan-2026', '<p>Selamat atas kelulusan siswa-siswi kelas XII SMK Unggulan angkatan tahun 2026! Hasil kelulusan dapat diakses secara resmi melalui portal pengumuman kelulusan sekolah dengan memasukkan nomor ujian nasional atau NISN masing-masing.</p><p>Sekolah mengimbau seluruh siswa untuk bersyukur dengan tertib di rumah masing-masing dan dilarang melakukan konvoi di jalan raya serta aksi coret-coret seragam.</p>', 'Informasi pengumuman kelulusan resmi siswa kelas XII tahun pelajaran 2025/2026.', NULL, NULL, 171, NULL, 'Tahun Ajaran 2025/2026', NULL, '2026-06-11', '2026-06-19', 1, 1, NULL, NULL, NULL, 1, 1, '2026-06-16 06:55:47', '2026-06-16 06:55:47'),
(5, 'Informasi Pendaftaran Peserta Didik Baru (PPDB) Jalur Prestasi', 'informasi-pendaftaran-peserta-didik-baru-ppdb-jalur-prestasi', '<p>Penerimaan Peserta Didik Baru (PPDB) Jalur Prestasi Akademik dan Non-Akademik resmi dibuka untuk lulusan SMP/MTs sederajat. Jalur ini memberikan kesempatan beasiswa bebas biaya pendidikan bagi calon siswa yang memiliki sertifikat kejuaraan tingkat kabupaten, provinsi, maupun nasional.</p><p>Silakan unduh brosur dan syarat lengkap pendaftaran pada lampiran dokumen pengumuman ini.</p>', 'Pembukaan pendaftaran siswa baru (PPDB) jalur prestasi akademik dan non-akademik.', 'announcements/university-blog-02_1781618369.png', NULL, 172, NULL, 'Tahun Ajaran 2025/2026', 'announcements/attachments/Filling Operation.pdf', '2026-06-21', '2026-07-06', 1, 1, NULL, NULL, NULL, 1, 1, '2026-06-16 06:55:47', '2026-06-16 14:01:13'),
(6, 'Pemberitahuan Hari Libur Semester Genap dan Cuti Bersama', 'pemberitahuan-hari-libur-semester-genap-dan-cuti-bersama', '<p>Berdasarkan kalender akademik sekolah dan surat keputusan dinas pendidikan, diumumkan bahwa libur semester genap akan berlangsung. Selama masa libur, kegiatan administrasi sekolah tetap berjalan secara terbatas.</p><p>Siswa diharapkan memanfaatkan waktu libur untuk beristirahat dan berkumpul bersama keluarga di rumah secara aman.</p>', 'Surat pemberitahuan resmi mengenai hari libur semester genap sekolah dan cuti bersama.', NULL, NULL, 173, NULL, 'Tahun Ajaran 2025/2026', NULL, '2026-05-17', '2026-06-01', 1, 1, NULL, NULL, NULL, 1, 1, '2026-06-16 06:55:47', '2026-06-16 06:55:47'),
(7, 'Pendaftaran Program Beasiswa Prestasi dan Bantuan Biaya Pendidikan', 'pendaftaran-program-beasiswa-prestasi-dan-bantuan-biaya-pendidikan', '<p>Dibuka pendaftaran beasiswa internal sekolah bagi siswa kurang mampu berprestasi (BKM) dan beasiswa dari komite sekolah. Program ini mencakup bantuan kuota internet, buku paket, serta keringanan biaya sumbangan pendidikan.</p><p>Persyaratan mencakup surat keterangan tidak mampu (SKTM) dari kelurahan dan fotokopi rapor semester terakhir.</p>', 'Kesempatan beasiswa bantuan biaya sekolah untuk siswa berprestasi dan kurang mampu.', NULL, NULL, 174, NULL, 'Tahun Ajaran 2025/2026', NULL, '2026-06-17', '2026-06-26', 1, 1, NULL, NULL, NULL, 1, 1, '2026-06-16 06:55:47', '2026-06-16 06:55:47'),
(8, 'Pelaksanaan Asesmen Nasional Berbasis Komputer (ANBK) Tingkat SMK', 'pelaksanaan-asesmen-nasional-berbasis-komputer-anbk-tingkat-smk', '<p>Asesmen Nasional Berbasis Komputer (ANBK) untuk mendongkrak mutu pendidikan sekolah akan dilaksanakan. Kegiatan ini diikuti oleh siswa kelas XI yang terpilih secara acak oleh sistem Kemendikbudristek.</p><p>Simulasi dan gladi bersih akan diselenggarakan di laboratorium komputer utama sekolah.</p>', 'Jadwal persiapan simulasi dan pelaksanaan ANBK nasional bagi siswa kelas XI.', NULL, NULL, 169, NULL, 'Tahun Ajaran 2025/2026', NULL, '2026-06-01', '2026-06-17', 1, 1, NULL, NULL, NULL, 1, 1, '2026-06-16 06:55:47', '2026-06-16 06:55:47'),
(9, 'Pengumuman Hasil Seleksi Pengurus OSIS & MPK Masa Bakti 2026/2027', 'pengumuman-hasil-seleksi-pengurus-osis-mpk-masa-bakti-20262027', '<p>Berdasarkan hasil musyawarah perwakilan kelas dan serangkaian tes fit and proper test yang diselenggarakan panitia seleksi, berikut adalah nama-nama siswa yang dinyatakan lolos sebagai Pengurus Harian OSIS dan MPK Sekolah baru.</p><p>Pelantikan resmi akan dilaksanakan pada upacara bendera hari Senin mendatang.</p>', 'Hasil kelulusan seleksi akhir pengurus OSIS dan Majelis Perwakilan Kelas (MPK) periode baru.', NULL, NULL, 170, NULL, 'Tahun Ajaran 2025/2026', NULL, '2026-06-19', '2026-06-24', 1, 1, NULL, NULL, NULL, 1, 1, '2026-06-16 06:55:47', '2026-06-16 06:55:47'),
(10, 'Jadwal Pengambilan Ijazah dan Cap Tiga Jari Kelas XII', 'jadwal-pengambilan-ijazah-dan-cap-tiga-jari-kelas-xii', '<p>Diberitahukan kepada seluruh alumni angkatan 2026 bahwa blangko ijazah asli telah siap. Proses sidik jari (cap tiga jari) dan pengambilan ijazah dilayani pada jam kerja di ruang tata usaha (TU).</p><p>Alumni diwajibkan memakai pakaian rapi (berkerah, bukan kaos) dan bersepatu saat memasuki area sekolah.</p>', 'Agenda jadwal pelayanan cap tiga jari ijazah asli kelulusan bagi alumni kelas XII.', NULL, NULL, 171, NULL, 'Tahun Ajaran 2025/2026', NULL, '2026-06-14', '2026-06-21', 1, 1, NULL, NULL, NULL, 1, 1, '2026-06-16 06:55:47', '2026-06-16 06:55:47');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1781991692),
('356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1781991692;', 1781991692);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `common`
--

CREATE TABLE `common` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `table_name` varchar(50) NOT NULL,
  `key1` varchar(100) DEFAULT NULL,
  `key2` varchar(100) DEFAULT NULL,
  `key3` varchar(100) DEFAULT NULL,
  `data1` varchar(255) DEFAULT NULL,
  `data2` varchar(255) DEFAULT NULL,
  `data3` varchar(255) DEFAULT NULL,
  `data4` varchar(255) DEFAULT NULL,
  `data5` varchar(255) DEFAULT NULL,
  `data6` varchar(255) DEFAULT NULL,
  `data7` varchar(255) DEFAULT NULL,
  `data8` varchar(255) DEFAULT NULL,
  `data9` varchar(255) DEFAULT NULL,
  `data10` varchar(255) DEFAULT NULL,
  `data11` varchar(255) DEFAULT NULL,
  `data12` varchar(255) DEFAULT NULL,
  `data13` varchar(255) DEFAULT NULL,
  `data14` varchar(255) DEFAULT NULL,
  `data15` varchar(255) DEFAULT NULL,
  `date1` date DEFAULT NULL,
  `date2` date DEFAULT NULL,
  `date3` date DEFAULT NULL,
  `date4` date DEFAULT NULL,
  `text1` text DEFAULT NULL,
  `text2` text DEFAULT NULL,
  `text3` text DEFAULT NULL,
  `text4` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Status aktif/nonaktif record',
  `order` smallint(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Urutan tampil',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `common`
--

INSERT INTO `common` (`id`, `table_name`, `key1`, `key2`, `key3`, `data1`, `data2`, `data3`, `data4`, `data5`, `data6`, `data7`, `data8`, `data9`, `data10`, `data11`, `data12`, `data13`, `data14`, `data15`, `date1`, `date2`, `date3`, `date4`, `text1`, `text2`, `text3`, `text4`, `created_by`, `updated_by`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(8, 'tingkat_kelas', 'TK001', NULL, NULL, 'Kelas X', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(9, 'tingkat_kelas', 'TK002', NULL, NULL, 'Kelas XI', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(10, 'tingkat_kelas', 'TK003', NULL, NULL, 'Kelas XII', '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(11, 'kelas', 'KL001', NULL, NULL, 'X RPL 1', '8', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(12, 'kelas', 'KL002', NULL, NULL, 'X RPL 2', '8', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(13, 'kelas', 'KL003', NULL, NULL, 'XI RPL 1', '9', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(14, 'kelas', 'KL004', NULL, NULL, 'XII RPL 1', '10', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(15, 'kelas', 'KL005', NULL, NULL, 'X TJKT 1', '8', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(16, 'kelas', 'KL006', NULL, NULL, 'XI TJKT 1', '9', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(17, 'kelas', 'KL007', NULL, NULL, 'X AKL 1', '8', '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(18, 'kompetensi_keahlian', 'KK001', NULL, NULL, 'Pemrograman Web', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(19, 'kompetensi_keahlian', 'KK002', NULL, NULL, 'Pemrograman Mobile', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(20, 'kompetensi_keahlian', 'KK003', NULL, NULL, 'Basis Data', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(21, 'kompetensi_keahlian', 'KK004', NULL, NULL, 'UI/UX Design', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(22, 'kompetensi_keahlian', 'KK005', NULL, NULL, 'Software Testing', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(23, 'kompetensi_keahlian', 'KK006', NULL, NULL, 'Administrasi Sistem Jaringan', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(24, 'kompetensi_keahlian', 'KK007', NULL, NULL, 'Routing & Switching', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(25, 'kompetensi_keahlian', 'KK008', NULL, NULL, 'Cloud Computing', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(26, 'kompetensi_keahlian', 'KK009', NULL, NULL, 'Fiber Optik', '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(27, 'kompetensi_keahlian', 'KK010', NULL, NULL, 'Akuntansi Keuangan', '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(28, 'kompetensi_keahlian', 'KK011', NULL, NULL, 'Perpajakan', '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(29, 'kurikulum', 'KU001', NULL, NULL, 'Kurikulum Merdeka', NULL, NULL, '2022', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(30, 'kurikulum', 'KU002', NULL, NULL, 'Kurikulum 2013 (Revisi)', NULL, NULL, '2013', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(31, 'kurikulum', 'KU003', NULL, NULL, 'Kurikulum Industri', NULL, NULL, '2023', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(32, 'kurikulum', 'KU004', NULL, NULL, 'Teaching Factory', NULL, NULL, '2023', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(33, 'structure', 'SK001', 'sekolah', NULL, 'Manajemen Sekolah', '202', NULL, NULL, 'sekolah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>asdasd</p>', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-06-19 06:44:11'),
(34, 'structure', 'SK002', 'sekolah', NULL, 'Komite Sekolah', '6', NULL, NULL, 'sekolah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(35, 'structure', 'OR001', 'organisasi', NULL, 'OSIS 2026/2027', '202', NULL, '1', 'organisasi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>ada desc</p>', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-06-19 06:47:13'),
(36, 'structure', 'OR002', 'organisasi', NULL, 'MPK 2024/2025', '6', NULL, NULL, 'organisasi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(37, 'structure', 'EK001', 'ekskul', NULL, 'Pramuka', '6', NULL, NULL, 'ekskul', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(38, 'structure', 'EK002', 'ekskul', NULL, 'PMR', '6', NULL, NULL, 'ekskul', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(39, 'structure', 'EK003', 'ekskul', NULL, 'Paskibra', '6', NULL, NULL, 'ekskul', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(40, 'structure', 'EK004', 'ekskul', NULL, 'IT Club', '6', '1', NULL, 'ekskul', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(41, 'structure', 'KP001', 'kepanitiaan', NULL, 'Panitia MPLS 2025', '6', NULL, NULL, 'kepanitiaan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(42, 'structure', 'KP002', 'kepanitiaan', NULL, 'Panitia Wisuda 2025', '6', NULL, NULL, 'kepanitiaan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(43, 'jabatan_organisasi', 'JB001', NULL, NULL, 'Kepala Sekolah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(44, 'jabatan_organisasi', 'JB002', NULL, NULL, 'Wakasek Kurikulum', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(45, 'jabatan_organisasi', 'JB003', NULL, NULL, 'Wakasek Kesiswaan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(46, 'jabatan_organisasi', 'JB004', NULL, NULL, 'Kaprog / Kaprodi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(47, 'jabatan_organisasi', 'JB005', NULL, NULL, 'Pembina', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(48, 'jabatan_organisasi', 'JB006', NULL, NULL, 'Pelatih', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(49, 'jabatan_organisasi', 'JB007', NULL, NULL, 'Ketua', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(50, 'jabatan_organisasi', 'JB008', NULL, NULL, 'Wakil Ketua', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(51, 'jabatan_organisasi', 'JB009', NULL, NULL, 'Sekretaris', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(52, 'jabatan_organisasi', 'JB010', NULL, NULL, 'Bendahara', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(53, 'jabatan_organisasi', 'JB011', NULL, NULL, 'Koordinator', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(54, 'jabatan_organisasi', 'JB012', NULL, NULL, 'Anggota', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(55, 'divisi', 'DV001', NULL, NULL, 'Humas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(56, 'divisi', 'DV002', NULL, NULL, 'Kesiswaan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(57, 'divisi', 'DV003', NULL, NULL, 'Kurikulum', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(58, 'divisi', 'DV004', NULL, NULL, 'Sarpras', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(59, 'divisi', 'DV005', NULL, NULL, 'Hubin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(60, 'divisi', 'DV006', NULL, NULL, 'BKK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(61, 'divisi', 'DV007', NULL, NULL, 'BK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(62, 'divisi', 'DV008', NULL, NULL, 'Sekbid Ketakwaan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(63, 'divisi', 'DV009', NULL, NULL, 'Sekbid Olahraga', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(64, 'divisi', 'DV010', NULL, NULL, 'Sekbid Kesenian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(65, 'divisi', 'DV011', NULL, NULL, 'Divisi Acara', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(66, 'divisi', 'DV012', NULL, NULL, 'Divisi Konsumsi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(67, 'divisi', 'DV013', NULL, NULL, 'Divisi Perlengkapan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(68, 'divisi', 'DV014', NULL, NULL, 'Divisi Dokumentasi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(69, 'jenis_kerjasama', 'JK001', NULL, NULL, 'PKL (Praktik Kerja Lapangan)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(70, 'jenis_kerjasama', 'JK002', NULL, NULL, 'Teaching Factory', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(71, 'jenis_kerjasama', 'JK003', NULL, NULL, 'Kelas Industri', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(72, 'jenis_kerjasama', 'JK004', NULL, NULL, 'Rekrutmen Alumni', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(73, 'jenis_kerjasama', 'JK005', NULL, NULL, 'Guru Tamu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(74, 'jenis_kerjasama', 'JK006', NULL, NULL, 'Sinkronisasi Kurikulum', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(75, 'jenis_kerjasama', 'JK007', NULL, NULL, 'Sertifikasi Kompetensi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(76, 'jenis_kerjasama', 'JK008', NULL, NULL, 'Kunjungan Industri', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(77, 'jenis_kerjasama', 'JK009', NULL, NULL, 'Magang Guru', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(83, 'bidang_industri', 'BI001', NULL, NULL, 'Teknologi Informasi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(84, 'bidang_industri', 'BI002', NULL, NULL, 'Software House', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(85, 'bidang_industri', 'BI003', NULL, NULL, 'Telekomunikasi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(86, 'bidang_industri', 'BI004', NULL, NULL, 'Manufaktur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(87, 'bidang_industri', 'BI005', NULL, NULL, 'Otomotif', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(88, 'bidang_industri', 'BI006', NULL, NULL, 'Perbankan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(89, 'bidang_industri', 'BI007', NULL, NULL, 'Retail', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(90, 'bidang_industri', 'BI008', NULL, NULL, 'Digital Marketing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(91, 'bidang_industri', 'BI009', NULL, NULL, 'Kuliner & F&B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(92, 'bidang_industri', 'BI010', NULL, NULL, 'Hospitality & Pariwisata', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(93, 'bidang_industri', 'BI011', NULL, NULL, 'Konstruksi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(94, 'bidang_industri', 'BI012', NULL, NULL, 'Kesehatan & Farmasi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(95, 'bidang_industri', 'BI013', NULL, NULL, 'Pendidikan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(96, 'fasilitas', 'FS001', NULL, NULL, 'Laboratorium Komputer RPL', 'Gedung B Lt 2', NULL, '36 Siswa', NULL, 'fasilitas/MdiKed4VANSMIl2EZvRZu7naV4uq47zky1CCUxPM.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>Laboratorium Komputer RPL</p>', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-06-12 06:05:24'),
(97, 'fasilitas', 'FS002', NULL, NULL, 'Laboratorium Jaringan TJKT', 'Gedung B Lt 1', NULL, '30 Siswa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(98, 'fasilitas', 'FS003', NULL, NULL, 'Perpustakaan', 'Gedung A Lt 1', NULL, '100 Orang', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(99, 'fasilitas', 'FS004', NULL, NULL, 'Masjid Sekolah', 'Area Tengah', NULL, '500 Jamaah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(100, 'fasilitas', 'FS005', NULL, NULL, 'Lapangan Olahraga', 'Belakang Gedung', NULL, '-', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>aaassd</p>', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(101, 'fasilitas', 'FS006', NULL, NULL, 'Aula Serbaguna', 'Gedung C', NULL, '300 Orang', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(102, 'sertifikasi', 'SR001', NULL, NULL, 'BNSP - Teknik Jaringan Komputer', NULL, NULL, 'BNSP', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(103, 'sertifikasi', 'SR002', NULL, NULL, 'Mikrotik MTCNA', NULL, NULL, 'Mikrotik', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(104, 'sertifikasi', 'SR003', NULL, NULL, 'Cisco IT Essentials', NULL, NULL, 'Cisco Networking Academy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(105, 'sertifikasi', 'SR004', NULL, NULL, 'Cisco CCNA', NULL, NULL, 'Cisco Networking Academy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(106, 'sertifikasi', 'SR005', NULL, NULL, 'MOS (Microsoft Office Specialist)', NULL, NULL, 'Microsoft', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(107, 'sertifikasi', 'SR006', NULL, NULL, 'AWS Academy Cloud Foundations', NULL, NULL, 'Amazon Web Services', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(108, 'sertifikasi', 'SR007', NULL, NULL, 'Adobe Certified Professional', NULL, NULL, 'Adobe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(109, 'sertifikasi', 'SR008', NULL, NULL, 'TOEIC', NULL, NULL, 'ETS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(110, 'program_unggulan', 'PU001', NULL, NULL, 'Teaching Factory', NULL, NULL, 'Akademik', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'program  yang menghubungkan pembelajaran dengan dunia industri, memberi siswa pengalaman produksi nyata dan  melatih keterampilan profesional', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-06-15 20:07:56'),
(111, 'program_unggulan', 'PU002', NULL, NULL, 'Kelas Industri', NULL, NULL, 'Kerjasama Industri', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Program yang menghadirkan suasana belajar layaknya di perusahaan, membekali siswa dengan pengalaman kerja nyata, standar industri, serta meningkatkan peluang kerja dan wirausaha setelah lulus.', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-06-15 20:07:08'),
(112, 'program_unggulan', 'PU003', NULL, NULL, 'Smart School', NULL, NULL, 'Teknologi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'yang memanfaatkan teknologi digital untuk menciptakan sistem pembelajaran modern, interaktif, efisien, dan terintegrasi, sehingga siswa dan guru lebih siap menghadapi tantangan era industri 4.0.', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-06-15 20:09:03'),
(113, 'program_unggulan', 'PU004', NULL, NULL, 'Kelas Coding', NULL, NULL, 'Teknologi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Program yang membekali siswa dengan keterampilan pemrograman, logika komputasi, dan pengembangan aplikasi berbasis digital, sehingga mereka siap menghadapi tantangan teknologi serta peluang karier di era industri 4.0.', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-06-15 20:09:25'),
(114, 'program_unggulan', 'PU005', NULL, NULL, 'Inkubator Bisnis', NULL, NULL, 'Kewirausahaan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'program unggulan SMK yang mendukung siswa mengembangkan ide usaha, melatih keterampilan wirausaha, serta membimbing mereka membangun bisnis nyata melalui pendampingan, pelatihan, dan kerja sama dengan mitra industri.', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-06-15 20:09:52'),
(116, 'kategori_prestasi', 'GP001', NULL, NULL, 'Akademik', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(117, 'kategori_prestasi', 'GP002', NULL, NULL, 'Non Akademik', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(118, 'kategori_prestasi', 'GP003', NULL, NULL, 'Kejuruan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(119, 'kategori_prestasi', 'GP004', NULL, NULL, 'Olahraga', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(120, 'kategori_prestasi', 'GP005', NULL, NULL, 'Seni dan Budaya', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(121, 'kategori_prestasi', 'GP006', NULL, NULL, 'Organisasi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(122, 'kategori_prestasi', 'GP007', NULL, NULL, 'Literasi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(123, 'tingkatan_prestasi', 'TP001', NULL, NULL, 'Internal Sekolah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(124, 'tingkatan_prestasi', 'TP002', NULL, NULL, 'Antar Kelas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(125, 'tingkatan_prestasi', 'TP003', NULL, NULL, 'Antar Sekolah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(126, 'tingkatan_prestasi', 'TP004', NULL, NULL, 'Kecamatan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(127, 'tingkatan_prestasi', 'TP005', NULL, NULL, 'Kabupaten / Kota', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(128, 'tingkatan_prestasi', 'TP006', NULL, NULL, 'Wilayah / Regional', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(129, 'tingkatan_prestasi', 'TP007', NULL, NULL, 'Provinsi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(130, 'tingkatan_prestasi', 'TP008', NULL, NULL, 'Nasional', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(131, 'tingkatan_prestasi', 'TP009', NULL, NULL, 'Asia Tenggara', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(132, 'tingkatan_prestasi', 'TP010', NULL, NULL, 'Asia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(133, 'tingkatan_prestasi', 'TP011', NULL, NULL, 'Internasional', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(134, 'status_alumni', 'SA001', NULL, NULL, 'Bekerja', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(135, 'status_alumni', 'SA002', NULL, NULL, 'Kuliah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(136, 'status_alumni', 'SA003', NULL, NULL, 'Wirausaha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(137, 'status_alumni', 'SA004', NULL, NULL, 'Bekerja dan Kuliah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(138, 'status_alumni', 'SA005', NULL, NULL, 'Mengikuti Pelatihan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(139, 'status_alumni', 'SA006', NULL, NULL, 'Mencari Kerja', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(140, 'status_alumni', 'SA007', NULL, NULL, 'Belum Terdata', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(141, 'bidang_pekerjaan', 'BP001', NULL, NULL, 'Software Developer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(142, 'bidang_pekerjaan', 'BP002', NULL, NULL, 'Web Developer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(143, 'bidang_pekerjaan', 'BP003', NULL, NULL, 'Mobile Developer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(144, 'bidang_pekerjaan', 'BP004', NULL, NULL, 'Network Engineer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(145, 'bidang_pekerjaan', 'BP005', NULL, NULL, 'IT Support', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(146, 'bidang_pekerjaan', 'BP006', NULL, NULL, 'UI/UX Designer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(147, 'bidang_pekerjaan', 'BP007', NULL, NULL, 'Graphic Designer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(148, 'bidang_pekerjaan', 'BP008', NULL, NULL, 'Digital Marketing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(149, 'bidang_pekerjaan', 'BP009', NULL, NULL, 'Akuntan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(150, 'bidang_pekerjaan', 'BP010', NULL, NULL, 'Staff Administrasi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(151, 'bidang_pekerjaan', 'BP011', NULL, NULL, 'Operator Produksi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(152, 'bidang_pekerjaan', 'BP012', NULL, NULL, 'Quality Control', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(153, 'bidang_pekerjaan', 'BP013', NULL, NULL, 'Teknisi Otomotif', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(154, 'bidang_pekerjaan', 'BP014', NULL, NULL, 'Guru / Pendidik', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(155, 'bidang_pekerjaan', 'BP015', NULL, NULL, 'Wirausaha / Entrepreneur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(156, 'bidang_pekerjaan', 'BP016', NULL, NULL, 'Freelancer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(157, 'kategori_berita', 'KB001', NULL, NULL, 'Berita Sekolah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(158, 'kategori_berita', 'KB002', NULL, NULL, 'Prestasi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(159, 'kategori_berita', 'KB003', NULL, NULL, 'Akademik', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(160, 'kategori_berita', 'KB004', NULL, NULL, 'Kegiatan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(161, 'kategori_berita', 'KB005', NULL, NULL, 'Pengumuman', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(162, 'kategori_berita', 'KB006', NULL, NULL, 'Hubungan Industri', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(163, 'kategori_event', 'KE001', NULL, NULL, 'Seminar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(164, 'kategori_event', 'KE002', NULL, NULL, 'Workshop', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(165, 'kategori_event', 'KE003', NULL, NULL, 'Lomba / Kompetisi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(166, 'kategori_event', 'KE004', NULL, NULL, 'Pelatihan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(167, 'kategori_event', 'KE005', NULL, NULL, 'Kunjungan Industri', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(168, 'kategori_event', 'KE006', NULL, NULL, 'Pameran', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(169, 'kategori_pengumuman', 'PN001', NULL, NULL, 'Akademik', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(170, 'kategori_pengumuman', 'PN002', NULL, NULL, 'Kesiswaan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(171, 'kategori_pengumuman', 'PN003', NULL, NULL, 'Kelulusan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(172, 'kategori_pengumuman', 'PN004', NULL, NULL, 'PPDB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(173, 'kategori_pengumuman', 'PN005', NULL, NULL, 'Libur Sekolah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(174, 'kategori_pengumuman', 'PN006', NULL, NULL, 'Beasiswa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(175, 'kategori_galeri', 'KG001', NULL, NULL, 'Kegiatan Sekolah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(176, 'kategori_galeri', 'KG002', NULL, NULL, 'Prestasi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(177, 'kategori_galeri', 'KG003', NULL, NULL, 'PKL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(178, 'kategori_galeri', 'KG004', NULL, NULL, 'Workshop', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(179, 'kategori_galeri', 'KG005', NULL, NULL, 'Lomba', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(180, 'kategori_galeri', 'KG006', NULL, NULL, 'Wisuda', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(181, 'kategori_galeri', 'KG007', NULL, NULL, 'MPLS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(182, 'kategori_download', 'KD001', NULL, NULL, 'Formulir', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(183, 'kategori_download', 'KD002', NULL, NULL, 'Brosur & Leaflet', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(184, 'kategori_download', 'KD003', NULL, NULL, 'Kalender Akademik', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(185, 'kategori_download', 'KD004', NULL, NULL, 'Panduan & SOP', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(186, 'kategori_download', 'KD005', NULL, NULL, 'Dokumen Resmi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(187, 'kategori_download', 'KD006', NULL, NULL, 'Materi Pembelajaran', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(188, 'tag_konten', 'TG001', NULL, NULL, 'AI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(189, 'tag_konten', 'TG002', NULL, NULL, 'Coding', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(190, 'tag_konten', 'TG003', NULL, NULL, 'Robotika', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(191, 'tag_konten', 'TG004', NULL, NULL, 'PKL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(192, 'tag_konten', 'TG005', NULL, NULL, 'LKS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(193, 'tag_konten', 'TG006', NULL, NULL, 'Seminar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(194, 'tag_konten', 'TG007', NULL, NULL, 'Workshop', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(195, 'tag_konten', 'TG008', NULL, NULL, 'Prestasi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(196, 'tag_konten', 'TG009', NULL, NULL, 'PPDB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(197, 'tag_konten', 'TG010', NULL, NULL, 'Alumni', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(198, 'tag_konten', 'TG011', NULL, NULL, 'Beasiswa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(199, 'tag_konten', 'TG012', NULL, NULL, 'Wisuda', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(201, 'sertifikasi', 'SR009', NULL, NULL, 'Oracle Database Admin', NULL, 'sertifikasi/P13V2clr8Jj2OHU2ABK6CLgLb1CLnpagSljApLVN.jpg', 'Oracle', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Oracle Database', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-13 00:34:46', '2026-06-13 00:35:10'),
(202, 'period', 'PD001', NULL, NULL, 'Tahun Ajaran 2026/2027', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-07-01', '2027-07-01', NULL, NULL, 'Tahun Ajaran 2026/2027 Semester Ganjil', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-13 00:43:33', '2026-06-13 00:45:14'),
(203, 'tingkat_kelas', 'TK004', NULL, NULL, 'Kelas XIII', '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kelas Tambahan', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-13 00:45:45', '2026-06-13 00:45:58'),
(204, 'kelas', 'KL008', NULL, NULL, 'XII AKL III', '10', '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-13 00:47:02', '2026-06-13 00:47:02');
INSERT INTO `common` (`id`, `table_name`, `key1`, `key2`, `key3`, `data1`, `data2`, `data3`, `data4`, `data5`, `data6`, `data7`, `data8`, `data9`, `data10`, `data11`, `data12`, `data13`, `data14`, `data15`, `date1`, `date2`, `date3`, `date4`, `text1`, `text2`, `text3`, `text4`, `created_by`, `updated_by`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(206, 'home_section', 'hero_banner', NULL, NULL, 'Hero Banner', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2026-06-13 06:40:26', '2026-06-13 06:40:26'),
(207, 'home_section', 'sambutan', NULL, NULL, 'Sambutan Kepala Sekolah', 'home/media_1781359987.jpg', 'Dr. H. Ahmad Fauzi, M.Pd.', 'Kepala Sekolah', 'Sambutan Kepala Sekolah', 'Kurikulum Merdeka berorientasi industri', 'Lulusan siap kerja, siap kuliah, siap wirausaha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Assalamualaikum Wr. Wb. Selamat datang di website resmi sekolah kami. Kami berkomitmen untuk menyelenggarakan pendidikan berkualitas tinggi yang relevan dengan kebutuhan industri masa kini. Didukung dengan fasilitas modern serta pengajar yang berkompeten, kami mendidik siswa menjadi insan profesional dan berakhlak mulia.', NULL, NULL, NULL, 1, 1, 1, 2, '2026-06-13 06:40:26', '2026-06-13 07:13:07'),
(208, 'home_section', 'statistik', NULL, NULL, 'Statistik Sekolah', 'Siswa Aktif', '1,200+', 'Pendidik & Staf', '85', 'Program Keahlian', '3', 'Mitra Industri', '50+', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 5, '2026-06-13 06:40:26', '2026-06-19 00:07:20'),
(209, 'home_section', 'program_keahlian', NULL, NULL, 'Program Keahlian', 'Program Keahlian Terbaik', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pilihan program keahlian yang relevan dengan perkembangan industri global.', NULL, NULL, NULL, 1, 1, 0, 3, '2026-06-13 06:40:26', '2026-06-19 00:07:24'),
(210, 'home_section', 'program_unggulan', NULL, NULL, 'Program Unggulan', 'Program Unggulan Sekolah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Program unggulan untuk mengasah hard skill and soft skill siswa secara optimal.', NULL, NULL, NULL, 1, 1, 1, 6, '2026-06-13 06:40:26', '2026-06-19 00:07:18'),
(211, 'home_section', 'mitra_industri', NULL, NULL, 'Mitra Industri', 'Kerjasama Industri (DU/DI)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Didukung oleh perusahaan nasional dan internasional terpercaya dalam penyaluran kerja dan magang.', NULL, NULL, NULL, 1, 1, 1, 16, '2026-06-13 06:40:26', '2026-06-20 12:53:02'),
(212, 'home_section', 'prestasi_siswa', NULL, NULL, 'Prestasi Siswa', 'Prestasi Terbaru Siswa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Prestasi membanggakan dari siswa-siswi terbaik kami di berbagai bidang perlombaan.', NULL, NULL, NULL, 1, 1, 1, 8, '2026-06-13 06:40:26', '2026-06-20 12:53:14'),
(213, 'home_section', 'prestasi_sekolah', NULL, NULL, 'Prestasi & Penghargaan Sekolah', 'Penghargaan & Prestasi Sekolah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Penghargaan resmi atas kualitas tata kelola, inovasi, dan prestasi institusi kami.', NULL, NULL, NULL, 1, 1, 0, 9, '2026-06-13 06:40:26', '2026-06-20 12:53:12'),
(214, 'home_section', 'karya_siswa', NULL, NULL, 'Karya & Projek Siswa', 'Karya Kreatif & Projek Siswa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inovasi, produk kreatif, dan portofolio orisinal buatan siswa-siswi kami.', NULL, NULL, NULL, 1, 1, 1, 10, '2026-06-13 06:40:26', '2026-06-20 12:53:10'),
(215, 'home_section', 'berita_terbaru', NULL, NULL, 'Berita Terbaru', 'Kabar & Informasi Terkini', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ikuti berita terkini mengenai berbagai kegiatan, pengumuman, dan agenda di sekolah kami.', NULL, NULL, NULL, 1, 1, 1, 11, '2026-06-13 06:40:26', '2026-06-20 12:53:08'),
(216, 'home_section', 'agenda_event', NULL, NULL, 'Agenda & Event', 'Agenda & Kegiatan Sekolah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pantau jadwal acara, ujian, pertemuan wali murid, dan kegiatan mendatang.', NULL, NULL, NULL, 1, 1, 1, 12, '2026-06-13 06:40:26', '2026-06-20 12:53:07'),
(217, 'home_section', 'galeri', NULL, NULL, 'Galeri Kegiatan', 'Galeri Dokumentasi Kegiatan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Dokumentasi visual dari berbagai aktivitas edukasi, sosial, dan prestasi di sekolah.', NULL, NULL, NULL, 1, 1, 1, 13, '2026-06-13 06:40:26', '2026-06-20 12:53:06'),
(218, 'home_section', 'alumni_berprestasi', NULL, NULL, 'Alumni Berprestasi', 'Testimoni & Kisah Sukses Alumni', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inspirasi dan kisah sukses para lulusan kami yang telah berkiprah di dunia industri dan perguruan tinggi.', NULL, NULL, NULL, 1, 1, 1, 14, '2026-06-13 06:40:26', '2026-06-20 12:53:04'),
(219, 'home_section', 'testimoni', NULL, NULL, 'Testimoni', 'Apa Kata Mereka?', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pendapat para orang tua siswa, tokoh industri, dan masyarakat tentang kualitas pendidikan kami.', NULL, NULL, NULL, 1, 1, 1, 15, '2026-06-13 06:40:26', '2026-06-20 12:53:03'),
(221, 'home_section', 'ppdb', NULL, NULL, 'PPDB', 'Penerimaan Peserta Didik Baru', 'Daftar Sekarang', '/ppdb', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ayo bergabung bersama keluarga besar sekolah kami! Pendaftaran online PPDB tahun ajaran baru telah resmi dibuka.', NULL, NULL, NULL, 1, 1, 0, 17, '2026-06-13 06:40:26', '2026-06-20 12:52:58'),
(223, 'hero_banner_slide', 'HB01', NULL, NULL, 'Mewujudkan Generasi Unggul dan Berkarakter', 'hero_banner/bg-image-25_1781361679.jpg', 'Lihat Selengkapnya', '#', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Selamat Datang di Portal Resmi Sekolah Kami. Kami siap membimbing dan mengantarkan putra-putri Anda menuju masa depan cemerlang.', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-13 06:40:26', '2026-06-13 07:41:21'),
(224, 'hero_banner_slide', 'HB02', NULL, NULL, 'Pendidikan Kreatif & Berbasis Teknologi', 'hero_banner/chatgpt-image-jun-21-2026-04-26-02-am_1781990794.png', 'Program Unggulan', '#', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Mempersiapkan siswa didik dengan kompetensi digital yang siap bersaing secara global di era modern.', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-13 06:40:26', '2026-06-20 14:26:36'),
(225, 'karya_siswa', 'KR178136013063', NULL, NULL, 'Tong Sampah Berbasi IoT', 'karya_siswa/screenshot-2026-05-25-104640_1781360130.png', '1', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Tong Sampah Berbasi IoT', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-13 07:15:30', '2026-06-13 07:15:30'),
(226, 'tag_konten', 'TG013', NULL, NULL, 'juara', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-14 15:15:14', '2026-06-14 15:15:14'),
(227, 'jurusan', 'JR001', NULL, NULL, 'Rekayasa Perangkat Lunak', 'RPL', 'Budi Santoso, S.Kom', 'A', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Deskripsi jurusan Rekayasa Perangkat Lunak', NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 14:54:16', '2026-06-15 14:54:16'),
(228, 'jurusan', 'JR002', NULL, NULL, 'Teknik Jaringan Komputer dan Telekomunikasi', 'TJKT', 'Ahmad Rizal, S.T', 'A', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Deskripsi jurusan Teknik Jaringan Komputer dan Telekomunikasi', NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 14:54:16', '2026-06-15 14:54:16'),
(229, 'jurusan', 'JR003', NULL, NULL, 'Akuntansi dan Keuangan Lembaga', 'AKL', 'Siti Aminah, S.E', 'B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Deskripsi jurusan Akuntansi dan Keuangan Lembaga', NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 14:54:16', '2026-06-15 14:54:16'),
(230, 'period', 'PD002', NULL, NULL, 'Tahun Ajaran 2023/2024', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2023-07-15', '2024-06-15', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 14:54:16', '2026-06-15 14:54:16'),
(231, 'period', 'PD003', NULL, NULL, 'Tahun Ajaran 2024/2025', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-15', '2025-06-15', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 14:54:16', '2026-06-15 14:54:16'),
(232, 'period', 'PD004', NULL, NULL, 'Tahun Ajaran 2025/2026', NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-07-15', '2026-06-15', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 14:54:16', '2026-06-15 14:54:16'),
(233, 'period', 'PD005', NULL, NULL, 'Periode OSIS 2024/2025', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-01', '2025-06-30', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 14:54:16', '2026-06-15 14:54:16'),
(235, 'karya_siswa', 'CM001', NULL, NULL, 'Aplikasi IoT Monitoring Pertanian Pintar', NULL, '227', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Sistem monitoring kelembapan tanah, suhu, dan penyiraman otomatis berbasis IoT yang terintegrasi dengan aplikasi mobile.', NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 14:54:16', '2026-06-15 14:54:16'),
(236, 'karya_siswa', 'CM002', NULL, NULL, 'Rancang Bangun Jaringan Server Cloud Lokal', NULL, '228', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Solusi infrastruktur cloud lokal menggunakan Kubernetes untuk menunjang virtualisasi laboratorium komputer sekolah.', NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 14:54:16', '2026-06-15 14:54:16'),
(237, 'karya_siswa', 'CM003', NULL, NULL, 'Sistem Informasi Kasir & Inventory Toko Retail', NULL, '227', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Aplikasi POS (Point of Sales) berbasis web yang dilengkapi dengan modul laporan keuangan otomatis dan inventory tracking.', NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 14:54:16', '2026-06-15 14:54:16'),
(238, 'karya_siswa', 'CM004', NULL, NULL, 'Sistem Keamanan Pintar Menggunakan Pengenalan Wajah', NULL, '228', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Prototipe sistem keamanan pintu gerbang sekolah dengan face recognition menggunakan kamera pintar Raspberry Pi.', NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 14:54:16', '2026-06-15 14:54:16'),
(239, 'karya_siswa', 'CM005', NULL, NULL, 'Audit Laporan Keuangan Digital UMKM', NULL, '229', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Penyusunan dan digitalisasi laporan keuangan menggunakan aplikasi pencatatan akuntansi modern untuk UMKM binaan sekolah.', NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 14:54:16', '2026-06-15 14:54:16'),
(240, 'tag_konten', 'TG014', NULL, NULL, 'keselamatan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 15:34:23', '2026-06-15 15:34:23'),
(241, 'tag_konten', 'TG015', NULL, NULL, 'siswa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 15:34:23', '2026-06-15 15:34:23'),
(242, 'tag_konten', 'TG016', NULL, NULL, 'tefa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 15:34:35', '2026-06-15 15:34:35'),
(243, 'tag_konten', 'TG017', NULL, NULL, 'industri', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 15:34:35', '2026-06-15 15:34:35'),
(244, 'tag_konten', 'TG018', NULL, NULL, 'akademik', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 15:35:25', '2026-06-15 15:35:25'),
(245, 'tag_konten', 'TG019', NULL, NULL, 'ujian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 15:35:25', '2026-06-15 15:35:25'),
(246, 'tag_konten', 'TG020', NULL, NULL, 'bkk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 15:35:49', '2026-06-15 15:35:49'),
(247, 'tag_konten', 'TG021', NULL, NULL, 'karir', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 15:35:50', '2026-06-15 15:35:50'),
(248, 'mitra_industri', 'MT001', NULL, NULL, 'PT. Telkom Indonesia Tbk', 'https://telkom.co.id', 'mitra_industri/partner-1.webp', 'Telekomunikasi & Jaringan', '021-5001111', 'JK006;JK008', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kemitraan strategis dalam penyelarasan kurikulum sekolah, penyediaan tempat praktek kerja lapangan (PKL) / magang industri bagi siswa, guru tamu, serta program rekrutmen alumni secara langsung.', NULL, NULL, NULL, 1, NULL, 1, 1, '2026-06-16 08:38:21', '2026-06-16 08:38:21'),
(249, 'mitra_industri', 'MT002', NULL, NULL, 'PT. Astra International Tbk', 'https://astra.co.id', 'mitra_industri/partner-2.webp', 'Otomotif & Manufaktur', '021-6522555', 'JK005;JK007', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kemitraan strategis dalam penyelarasan kurikulum sekolah, penyediaan tempat praktek kerja lapangan (PKL) / magang industri bagi siswa, guru tamu, serta program rekrutmen alumni secara langsung.', NULL, NULL, NULL, 1, NULL, 1, 2, '2026-06-16 08:38:21', '2026-06-16 08:38:21'),
(250, 'mitra_industri', 'MT003', NULL, NULL, 'PT. Toyota Motor Manufacturing Indonesia', 'https://toyota.co.id', 'mitra_industri/partner-3.webp', 'Manufaktur Otomotif', '021-8836000', 'JK005;JK007', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kemitraan strategis dalam penyelarasan kurikulum sekolah, penyediaan tempat praktek kerja lapangan (PKL) / magang industri bagi siswa, guru tamu, serta program rekrutmen alumni secara langsung.', NULL, NULL, NULL, 1, NULL, 1, 3, '2026-06-16 08:38:21', '2026-06-16 08:38:21'),
(251, 'mitra_industri', 'MT004', NULL, NULL, 'PT. Bank Central Asia Tbk (BCA)', 'https://bca.co.id', 'mitra_industri/partner-4.webp', 'Perbankan & Layanan Keuangan', '021-23588000', 'JK004;JK006', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kemitraan strategis dalam penyelarasan kurikulum sekolah, penyediaan tempat praktek kerja lapangan (PKL) / magang industri bagi siswa, guru tamu, serta program rekrutmen alumni secara langsung.', NULL, NULL, NULL, 1, NULL, 1, 4, '2026-06-16 08:38:21', '2026-06-16 08:38:21'),
(252, 'mitra_industri', 'MT005', NULL, NULL, 'Shopee Indonesia', 'https://shopee.co.id', 'mitra_industri/partner-5.webp', 'E-Commerce & Teknologi', '021-80600900', 'JK003;JK008', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kemitraan strategis dalam penyelarasan kurikulum sekolah, penyediaan tempat praktek kerja lapangan (PKL) / magang industri bagi siswa, guru tamu, serta program rekrutmen alumni secara langsung.', NULL, NULL, NULL, 1, NULL, 1, 5, '2026-06-16 08:38:21', '2026-06-16 08:38:21'),
(253, 'mitra_industri', 'MT006', NULL, NULL, 'PT. GoTo Gojek Tokopedia Tbk', 'https://gotocompany.com', 'mitra_industri/partner-6.webp', 'Teknologi & Layanan Digital', '021-50849000', 'JK003;JK007', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kemitraan strategis dalam penyelarasan kurikulum sekolah, penyediaan tempat praktek kerja lapangan (PKL) / magang industri bagi siswa, guru tamu, serta program rekrutmen alumni secara langsung.', NULL, NULL, NULL, 1, NULL, 1, 6, '2026-06-16 08:38:21', '2026-06-16 08:38:21'),
(254, 'mitra_industri', 'MT007', NULL, NULL, 'PT. Indomarco Prismatama (Indomaret)', 'https://indomaret.co.id', 'mitra_industri/partner-7.webp', 'Retail & Logistik', '021-7590999', 'JK006;JK008', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kemitraan strategis dalam penyelarasan kurikulum sekolah, penyediaan tempat praktek kerja lapangan (PKL) / magang industri bagi siswa, guru tamu, serta program rekrutmen alumni secara langsung.', NULL, NULL, NULL, 1, NULL, 1, 7, '2026-06-16 08:38:21', '2026-06-16 08:38:21'),
(255, 'mitra_industri', 'MT008', NULL, NULL, 'CV. Sinergi Solusi Informatika', 'https://example.com/sinergi', NULL, 'Software House & Konsultan IT', '022-1234567', 'JK004;JK007', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kemitraan strategis dalam penyelarasan kurikulum sekolah, penyediaan tempat praktek kerja lapangan (PKL) / magang industri bagi siswa, guru tamu, serta program rekrutmen alumni secara langsung.', NULL, NULL, NULL, 1, NULL, 1, 8, '2026-06-16 08:38:21', '2026-06-16 08:38:21'),
(256, 'mitra_industri', 'MT009', NULL, NULL, 'PT. Kereta Api Indonesia (Persero)', 'https://kai.id', NULL, 'Transportasi & Logistik BUMN', '121', 'JK002;JK007', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kemitraan strategis dalam penyelarasan kurikulum sekolah, penyediaan tempat praktek kerja lapangan (PKL) / magang industri bagi siswa, guru tamu, serta program rekrutmen alumni secara langsung.', NULL, NULL, NULL, 1, NULL, 1, 9, '2026-06-16 08:38:21', '2026-06-16 08:38:21'),
(257, 'mitra_industri', 'MT010', NULL, NULL, 'CV. Media Kreatif Nusantara', 'https://example.com/mediakreatif', NULL, 'Desain & Multimedia', '022-7654321', 'JK006;JK009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kemitraan strategis dalam penyelarasan kurikulum sekolah, penyediaan tempat praktek kerja lapangan (PKL) / magang industri bagi siswa, guru tamu, serta program rekrutmen alumni secara langsung.', NULL, NULL, NULL, 1, NULL, 1, 10, '2026-06-16 08:38:21', '2026-06-16 08:38:21'),
(258, 'structure', 'ST001', 'yayasan', NULL, 'Struktur Yayasan', NULL, NULL, NULL, 'yayasan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Yayasan Pendidikan yang menaungi dan menyelenggarakan kegiatan pendidikan di sekolah ini.', NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-16 09:29:46', '2026-06-16 09:29:46'),
(259, 'structure', 'SK003', 'sekolah', NULL, 'Guru PPPK', NULL, NULL, NULL, 'sekolah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Daftar Guru Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) yang bertugas di sekolah ini.', NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-17 09:53:03', '2026-06-17 09:53:03'),
(260, 'tag_konten', 'TG022', NULL, NULL, 'kompetisi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-18 23:21:13', '2026-06-18 23:21:13'),
(261, 'home_section', 'school_life', NULL, NULL, 'School Life', NULL, 'https://www.youtube.com/watch?v=nA1Aqp0sPQo', 'SMK Al-Wutsqo', 'Kehidupan Sekolah', '99%', 'Puas', 'Pembelajaran Fleksibel', 'feather-heart', 'Belajar di Mana Saja', 'feather-book', 'Berbasis Praktik', 'feather-award', NULL, NULL, NULL, NULL, NULL, NULL, 'Fakta yang terbukti bahwa siswa dapat belajar dengan nyaman menggunakan kurikulum fleksibel kami.', 'Akses materi pembelajaran secara online kapan saja dan di mana saja tanpa hambatan.', 'Kurikulum dirancang untuk meningkatkan keterampilan nyata yang siap digunakan di dunia kerja.', NULL, 2, 1, 1, 4, '2026-06-19 00:06:20', '2026-06-19 00:09:52'),
(262, 'seo_setting', 'seo_config', NULL, NULL, 'SMK PGRI Subang', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Sekolah Menengah Kejuruan PGRI Subang adalah sekolah menengah tingkat atas berbasis kejuruan. SMK PGRI Subang sekolah yang menyelenggarakan pendidikan kejuruan kelompok teknologi, informasi dan industri', 'smk, sekolah, favorit, modern', NULL, NULL, 1, 1, 1, 1, '2026-06-20 12:26:33', '2026-06-20 12:26:33'),
(263, 'home_section', 'fasilitas', NULL, NULL, 'Fasilitas Sekolah', NULL, NULL, NULL, 'SARANA & PRASARANA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Dukung proses belajar mengajar dengan fasilitas pendidikan modern dan lingkungan belajar yang nyaman.', NULL, NULL, NULL, NULL, NULL, 1, 7, '2026-06-20 12:35:53', '2026-06-20 12:53:14'),
(264, 'home_section', 'faq', NULL, NULL, 'Frequently Asked Questions', NULL, NULL, NULL, 'FAQ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Temukan jawaban atas pertanyaan-pertanyaan yang sering diajukan mengenai sekolah kami.', NULL, NULL, NULL, NULL, 1, 1, 18, '2026-06-20 12:35:53', '2026-06-26 05:43:09'),
(265, 'faq', 'CM001', NULL, NULL, 'Berapa biaya pendaftaran?', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Untuk setiap calon peserta didik yg ingin mendaftar dikenakan biaya sebesar Rp. 200.000', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-20 19:48:10', '2026-06-20 19:48:10'),
(266, 'home_section', 'social_media', NULL, NULL, 'Media Sosial', 'Koneksi Sosial', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ikuti kanal media sosial resmi kami untuk mendapatkan informasi terbaru secara real-time.', NULL, NULL, NULL, 2, 1, 1, 18, '2026-06-26 05:33:09', '2026-06-26 05:43:10'),
(267, 'social_media_setting', 'social_media_config', NULL, NULL, 'https://www.instagram.com/smeriofficial/', '1', 'https://www.youtube.com/@broadcastsmkpgrisubang/videos', '1', 'https://facebook.com', '0', 'https://tiktok.com', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, 1, 0, '2026-06-26 05:33:09', '2026-06-26 05:41:27');

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jurusan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_size` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `downloads`
--

INSERT INTO `downloads` (`id`, `title`, `category_id`, `jurusan_id`, `file_path`, `file_size`, `description`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Formulir PPDB 2026/2027', 182, NULL, 'downloads/5qRIk0tnelZJxRRUtOmwVoLkrhHkS4Gq0XuQpwYX.xlsx', '210.92 KB', 'Formulir PPDB 2026/2027', 1, 1, 1, '2026-06-12 06:06:24', '2026-06-12 06:10:15'),
(2, 'Kalender Akademik 2026/2027', 184, NULL, 'downloads/DY08AmH8Y5n8co535u1ama3HdAJVfvC1QwkVavmE.xlsx', '20.95 KB', 'Kalender Akademik Tahun Ajaran 2026/2027', 1, 1, 1, '2026-06-12 06:07:46', '2026-06-12 06:09:00'),
(3, 'Formulir Pendaftaran Siswa Baru (PPDB) Tahun Ajaran 2026/2027', 182, NULL, 'documents/formulir_ppdb_2026.pdf', '450 KB', 'Formulir resmi untuk pendaftaran calon peserta didik baru SMK Unggulan angkatan tahun ajaran 2026/2027.', 1, 1, 1, '2026-06-06 07:29:59', '2026-06-16 07:29:59'),
(4, 'Brosur Sekolah & Program Keahlian Unggulan 2026', 183, NULL, 'documents/brosur_sekolah_2026.pdf', '3.2 MB', 'Brosur profil lengkap sekolah, fasilitas, daftar ekstrakurikuler, dan keunggulan tiap kompetensi keahlian.', 1, 1, 1, '2026-06-07 07:29:59', '2026-06-16 07:29:59'),
(5, 'Kalender Akademik Tahun Pelajaran 2026/2027', 184, NULL, 'documents/kalender_akademik_2026.pdf', '1.1 MB', 'Kalender jadwal kegiatan belajar mengajar, penilaian tengah/akhir semester, dan hari libur nasional.', 1, 1, 1, '2026-06-08 07:29:59', '2026-06-16 07:29:59'),
(6, 'Buku Panduan Tata Tertib & Kode Etik Siswa', 185, NULL, 'documents/tata_tertib_siswa.pdf', '850 KB', 'Dokumen regulasi tata tertib siswa, poin pelanggaran, hak dan kewajiban siswa di lingkungan sekolah.', 1, 1, 1, '2026-06-09 07:29:59', '2026-06-16 07:29:59'),
(7, 'SOP Pelaksanaan Praktik Kerja Lapangan (PKL) Siswa', 185, NULL, 'documents/sop_pkl_siswa.pdf', '1.4 MB', 'Standar operasional prosedur pengajuan, pelaksanaan, dan pelaporan kegiatan Praktik Kerja Lapangan (PKL).', 1, 1, 1, '2026-06-10 07:29:59', '2026-06-16 07:29:59'),
(8, 'Dokumen Kurikulum Operasional Satuan Pendidikan (KOSP)', 186, NULL, 'documents/kurikulum_kosp_smk.pdf', '2.8 MB', 'Kurikulum operasional sekolah yang memuat profil lulusan, struktur kurikulum, dan beban belajar siswa.', 1, 1, 1, '2026-06-11 07:29:59', '2026-06-16 07:29:59'),
(9, 'Modul Ajar Dasar-Dasar Pemrograman (HTML/CSS/JS)', 187, NULL, 'documents/modul_rpl_pemrograman.pdf', '4.5 MB', 'Buku panduan praktikum pemrograman web dasar untuk siswa kelas X jurusan Rekayasa Perangkat Lunak.', 1, 1, 1, '2026-06-11 07:29:59', '2026-06-16 07:29:59'),
(10, 'Panduan Keselamatan Kerja & Penggunaan Lab Komputer Jaringan', 185, 2, 'documents/panduan_lab_tjkt.pdf', '1.9 MB', 'SOP keselamatan kerja, tata cara penggunaan perangkat router, switch, dan cabling di laboratorium TJKT.', 1, 1, 1, '2026-06-12 07:29:59', '2026-06-16 07:29:59'),
(11, 'Modul Praktikum Administrasi & Infrastruktur Jaringan Kelas XI', 187, 2, 'documents/modul_jaringan_tjkt.pdf', '5.2 MB', 'Materi praktikum konfigurasi routing dinamis, VLAN, dan firewall menggunakan simulator jaringan Cisco Packet Tracer.', 1, 1, 1, '2026-06-12 07:29:59', '2026-06-16 07:29:59'),
(12, 'Modul Pembelajaran Akuntansi Keuangan Dasar Kelas X', 187, 4, 'documents/modul_akuntansi_dasar.pdf', '3.8 MB', 'Modul ajar mencakup pengenalan persamaan dasar akuntansi, jurnal umum, buku besar, dan siklus akuntansi jasa.', 1, 1, 1, '2026-06-13 07:29:59', '2026-06-16 07:29:59'),
(13, 'Formulir Pengajuan Beasiswa Komite Kurang Mampu (BKM)', 182, NULL, 'documents/formulir_beasiswa_bkm.pdf', '280 KB', 'Formulir permohonan keringanan biaya sekolah dan pengajuan beasiswa BKM dari Komite Sekolah.', 1, 1, 1, '2026-06-13 07:29:59', '2026-06-16 07:29:59'),
(14, 'Formulir Pendaftaran Ekstrakurikuler Sekolah', 182, NULL, 'documents/formulir_ekstrakurikuler.pdf', '150 KB', 'Form pendaftaran anggota baru ekstrakurikuler wajib Pramuka maupun pilihan (PMR, Futsal, Coding Club).', 1, 1, 1, '2026-06-14 07:29:59', '2026-06-16 07:29:59'),
(15, 'Leaflet Profil Kompetensi Keahlian Rekayasa Perangkat Lunak', 183, NULL, 'documents/leaflet_rpl.pdf', '1.5 MB', 'Pamflet promosi jurusan RPL yang berisi prospek kerja, materi utama keahlian, dan prestasi siswa.', 1, 1, 1, '2026-06-14 07:29:59', '2026-06-16 07:29:59'),
(16, 'Leaflet Profil Kompetensi Keahlian Teknik Jaringan Komputer & Telekomunikasi', 183, 2, 'documents/leaflet_tjkt.pdf', '1.7 MB', 'Leaflet informasi kurikulum TJKT, sertifikasi kompetensi Mikrotik/Cisco, dan prospek karir alumni.', 1, 1, 1, '2026-06-15 07:29:59', '2026-06-16 07:29:59'),
(17, 'Leaflet Profil Kompetensi Keahlian Akuntansi & Keuangan Lembaga', 183, 4, 'documents/leaflet_akl.pdf', '1.3 MB', 'Brosur ringkas program keahlian AKL mengenai lab manual/komputer akuntansi Accurate dan MYOB.', 1, 1, 1, '2026-06-15 07:29:59', '2026-06-16 07:29:59'),
(18, 'Jadwal Pelajaran & Kalender Kegiatan Kelas X Semester Ganjil', 184, NULL, 'documents/jadwal_kegiatan_kelas10.pdf', '920 KB', 'Pembagian jadwal pelajaran mingguan dan jadwal bimbingan akademik kelas X.', 1, 1, 1, '2026-06-16 07:29:59', '2026-06-16 07:29:59'),
(19, 'Jadwal Pelajaran & Kalender Kegiatan Kelas XI Semester Ganjil', 184, NULL, 'documents/jadwal_kegiatan_kelas11.pdf', '940 KB', 'Pembagian jadwal pelajaran mingguan dan jadwal persiapan pelaksanaan PKL kelas XI.', 1, 1, 1, '2026-06-16 07:29:59', '2026-06-16 07:29:59'),
(20, 'Jadwal Pelajaran & Kalender Kegiatan Kelas XII Semester Ganjil', 184, NULL, 'documents/jadwal_kegiatan_kelas12.pdf', '950 KB', 'Pembagian jadwal pelajaran mingguan, jadwal persiapan Ujian Sekolah dan UKK kelas XII.', 1, 1, 1, '2026-06-16 07:29:59', '2026-06-16 07:29:59'),
(21, 'Rencana Pelaksanaan Pembelajaran (RPP) Pemrograman Berorientasi Objek', 187, NULL, 'documents/rpp_rpl_oop.pdf', '2.1 MB', 'RPP mata pelajaran Pemrograman Berorientasi Objek (OOP) kelas XI RPL sebagai pedoman KBM.', 1, 1, 1, '2026-06-16 07:29:59', '2026-06-16 07:29:59'),
(22, 'SOP Penilaian & Ujian Kompetensi Keahlian (UKK) Akuntansi', 185, 4, 'documents/sop_ukk_akl.pdf', '1.1 MB', 'Prosedur penilaian, kriteria kelulusan, dan jadwal pengujian eksternal UKK bagi siswa kelas XII AKL.', 1, 1, 1, '2026-06-16 07:29:59', '2026-06-16 07:29:59');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jurusan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` text DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `start_datetime` datetime DEFAULT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `speaker` varchar(255) DEFAULT NULL,
  `organizer` varchar(255) DEFAULT NULL,
  `period` varchar(50) DEFAULT NULL COMMENT 'Period (contoh: "2024-2029") - optional, jika NULL berarti event bersifat umum',
  `attachment` varchar(255) DEFAULT NULL,
  `custom1` varchar(255) DEFAULT NULL,
  `custom2` varchar(255) DEFAULT NULL,
  `custom3` text DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `slug`, `category_id`, `jurusan_id`, `description`, `excerpt`, `image`, `banner`, `location`, `start_datetime`, `end_datetime`, `speaker`, `organizer`, `period`, `attachment`, `custom1`, `custom2`, `custom3`, `is_public`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Seminar Tren Teknologi Industri Kreatif dan Artificial Intelligence', 'seminar-tren-teknologi-industri-kreatif-dan-artificial-intelligence', 163, NULL, '<p>Perkembangan teknologi AI yang sangat pesat memberikan dampak besar bagi industri kreatif dan teknologi informasi. Seminar ini akan membahas tren terbaru kecerdasan buatan dan bagaimana siswa dapat mempersiapkan diri menghadapi era otomatisasi.</p><p>Acara ini wajib diikuti oleh seluruh siswa program keahlian teknologi informasi, namun terbuka juga untuk umum.</p>', 'Seminar nasional tentang perkembangan teknologi kecerdasan buatan (AI) di dunia industri kreatif modern.', NULL, NULL, 'Aula Utama Lantai 3 Gedung Rektorat', '2026-06-15 09:00:00', '2026-06-15 12:30:00', 'Dr. Eko Prasetyo, M.T. (AI Research Lead)', 'Program Studi RPL & OSIS SMK', 'Tahun Ajaran 2025/2026', NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2026-06-15 15:51:02', '2026-06-15 15:51:02'),
(2, 'Workshop Web Development Modern dengan Laravel 11', 'workshop-web-development-modern-dengan-laravel-11', 164, NULL, '<p>Pelajari cara membangun aplikasi web modern menggunakan Laravel 11 dari awal hingga deployment. Workshop ini fokus pada hands-on coding, best practices, dan optimasi arsitektur web modern.</p><p>Siswa diharapkan membawa laptop masing-masing dengan PHP >= 8.2 dan Composer sudah terinstall.</p>', 'Workshop coding praktis membangun aplikasi web interaktif menggunakan framework terpopuler Laravel 11.', NULL, NULL, 'Laboratorium Komputer RPL 1', '2026-06-17 08:00:00', '2026-06-17 16:00:00', 'Indra Permana (Senior Backend Developer)', 'Himpunan Jurusan RPL', 'Tahun Ajaran 2025/2026', NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2026-06-15 15:51:02', '2026-06-15 15:51:02'),
(3, 'Lomba Coding Antar Kelas: Web Design Competition 2026', 'lomba-coding-antar-kelas-web-design-competition-2026', 165, NULL, '<p>Tunjukkan kreativitas dan kemampuan coding kamu dalam mendesain halaman web interaktif dengan tema \"Green School Portal\". Kompetisi ini ditujukan untuk memupuk semangat inovasi dan kerja sama tim.</p><p>Pemenang akan mendapatkan sertifikat penghargaan dan hadiah menarik dari sponsor industri.</p>', 'Kompetisi desain web interaktif antar kelas dengan tema portal sekolah ramah lingkungan.', NULL, NULL, 'Laboratorium Komputer RPL 2', '2026-06-20 08:30:00', '2026-06-20 15:00:00', 'Team Juri Industri & Guru Produktif', 'Panitia Lomba Kominfo OSIS', 'Tahun Ajaran 2025/2026', NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2026-06-15 15:51:02', '2026-06-15 15:51:02'),
(4, 'Pelatihan Dasar Jaringan Komputer dan Fiber Optic', 'pelatihan-dasar-jaringan-komputer-dan-fiber-optic', 166, 2, '<p>Pelatihan teknis mengenai konfigurasi jaringan lokal (LAN), manajemen bandwidth, serta teknik instalasi dan splicing kabel fiber optic.</p><p>Sangat cocok untuk siswa yang ingin berkarir sebagai network engineer.</p>', 'Pelatihan hands-on instalasi fiber optic and konfigurasi routing mikrotik untuk siswa TJKT.', NULL, NULL, 'Laboratorium Jaringan Komputer & FO', '2026-06-25 09:00:00', '2026-06-25 14:00:00', 'Irwan Setiawan, CCNA (Network Engineer)', 'Program Keahlian TJKT', 'Tahun Ajaran 2025/2026', NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2026-06-15 15:51:02', '2026-06-15 15:51:02'),
(5, 'Kunjungan Industri ke Kantor Google Indonesia & Tokopedia', 'kunjungan-industri-ke-kantor-google-indonesia-tokopedia', 167, NULL, '<p>Kunjungan tahunan dalam rangka memperkenalkan budaya kerja perusahaan teknologi papan atas dunia (Tech Giant) kepada para siswa tingkat akhir.</p><p>Siswa akan diajak berkeliling kantor dan berdiskusi langsung dengan software engineer profesional.</p>', 'Studi banding lapangan ke Google Indonesia dan Tokopedia Tower Jakarta untuk pengenalan budaya kerja startup.', NULL, NULL, 'Tech Offices Jakarta (Google & Tokopedia)', '2026-06-29 06:00:00', '2026-06-29 18:00:00', 'Developer Relations Team', 'Hubungan Industri & Humas Sekolah', 'Tahun Ajaran 2025/2026', NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2026-06-15 15:51:02', '2026-06-15 15:51:02'),
(6, 'Pameran Karya Kreatif Siswa SMK Unggulan 2026', 'pameran-karya-kreatif-siswa-smk-unggulan-2026', 168, NULL, '<p>Pameran tahunan yang memamerkan produk-produk inovatif, sistem IoT, aplikasi mobile, hingga karya seni buatan siswa-siswi berprestasi dari seluruh program keahlian.</p><p>Terbuka untuk orang tua siswa, alumni, dan perwakilan dari industri mitra.</p>', 'Expo tahunan pameran produk inovasi, aplikasi mobile, dan teknologi tepat guna ciptaan siswa.', NULL, NULL, 'Lapangan Utama & Gedung Olahraga Sekolah', '2026-06-10 08:00:00', '2026-06-10 16:00:00', 'Kepala Dinas Pendidikan & Perwakilan DUDI', 'Panitia Expo SMK', 'Tahun Ajaran 2025/2026', NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2026-06-15 15:51:02', '2026-06-15 15:51:02'),
(7, 'Seminar Karier: Sukses Masuk Dunia Kerja & Lolos Interview', 'seminar-karier-sukses-masuk-dunia-kerja-lolos-interview', 163, NULL, '<p>Dunia kerja membutuhkan kesiapan mental dan soft skills yang matang. Seminar ini dipandu oleh praktisi HR berpengalaman untuk memberikan tips menulis CV ATS-friendly dan teknik wawancara kerja.</p>', 'Seminar persiapan karir, cara membuat CV profesional, dan strategi menghadapi wawancara HRD.', NULL, NULL, 'Ruang Aula Mini Gedung B', '2026-05-31 09:30:00', '2026-05-31 12:00:00', 'Rina Kartika, M.Psi. (HR Manager)', 'Bursa Kerja Khusus (BKK) Sekolah', 'Tahun Ajaran 2025/2026', NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2026-06-15 15:51:02', '2026-06-15 15:51:02'),
(8, 'Workshop Cyber Security & Ethical Hacking Essentials', 'workshop-cyber-security-ethical-hacking-essentials', 164, 1, '<p>Membahas dasar-dasar pertahanan keamanan siber, identifikasi kerentanan web (OWASP Top 10), serta cara melindungi infrastruktur sistem informasi dari serangan hacker jahat.</p>', 'Workshop keamanan siber dan pemahaman dasar etika peretasan (ethical hacking) untuk proteksi data.', NULL, NULL, 'Laboratorium Komputer TJKT 2', '2026-07-10 09:00:00', '2026-07-10 15:00:00', 'Yusuf Maulana, CEH (Cyber Security Specialist)', 'Program Studi TJKT', 'Tahun Ajaran 2025/2026', NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2026-06-15 15:51:02', '2026-06-18 23:22:30'),
(9, 'Lomba Inovasi Teknologi Tepat Guna Tingkat Provinsi', 'lomba-inovasi-teknologi-tepat-guna-tingkat-provinsi', 165, NULL, '<p>Ajang kompetisi regional untuk memamerkan inovasi teknologi yang bermanfaat bagi masyarakat umum dan ramah lingkungan.</p>', 'Kompetisi karya teknologi terapan tingkat provinsi Jawa Barat tahun 2026.', 'agendas/images/mIoRYTc6TW2KJcMvuUb575yUod99YCUK8zE633fV.png', 'agendas/banners/9xZfknwUSaeWkwSt9BCCa0RnqiDJQKkyrbzX7PRA.png', 'Pusat Edukasi & Rekreasi Regional', '2026-07-20 08:00:00', '2026-07-20 17:00:00', 'Dewan Juri Asosiasi Ilmuwan Indonesia', 'Dinas Pemberdayaan Masyarakat', 'Tahun Ajaran 2025/2026', NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2026-06-15 15:51:02', '2026-06-16 07:41:40'),
(10, 'Kunjungan Industri Jurusan Akuntansi ke Kantor KPP Pratama', 'kunjungan-industri-jurusan-akuntansi-ke-kantor-kpp-pratama', 167, 4, '<p>Kunjungan ini bertujuan memberikan pemahaman mendalam tentang tata cara perpajakan, pengelolaan pelaporan keuangan negara, serta prospek karir di bidang administrasi pajak.</p>', 'Studi lapangan pengenalan sistem administrasi perpajakan dan pelaporan SPT tahunan di KPP.', NULL, NULL, 'Kantor Pelayanan Pajak (KPP) Pratama', '2026-05-12 08:30:00', '2026-05-12 13:00:00', 'Fungsional Penyuluh Pajak KPP', 'Program Keahlian AKL', 'Tahun Ajaran 2025/2026', NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2026-06-15 15:51:02', '2026-06-15 15:51:02');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(150) NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jurusan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `upload_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `slug`, `category_id`, `jurusan_id`, `title`, `description`, `upload_by`, `created_at`, `updated_at`) VALUES
(1, 'kegiatan-belajar-mengajar-praktikum-iot-rpl', 175, NULL, 'Kegiatan Belajar Mengajar Praktikum IoT RPL', 'Dokumentasi kegiatan praktikum pemrograman Internet of Things (IoT) siswa kelas XI program keahlian Rekayasa Perangkat Lunak di laboratorium komputer.', 1, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(2, 'pelepasan-siswa-pkl-jurusan-teknik-jaringan-komputer', 177, 2, 'Pelepasan Siswa PKL Jurusan Teknik Jaringan Komputer', 'Acara pembekalan dan pelepasan resmi siswa kelas XI Teknik Jaringan Komputer dan Telekomunikasi (TJKT) yang akan melaksanakan Praktik Kerja Lapangan (PKL) di industri mitra.', 1, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(3, 'pemenang-juara-1-lomba-web-design-tingkat-nasional', 176, NULL, 'Pemenang Juara 1 Lomba Web Design Tingkat Nasional', 'Momen kebanggaan penyerahan piala dan penghargaan bagi siswa perwakilan sekolah yang berhasil meraih Juara 1 dalam ajang Lomba Desain Web Nasional.', 1, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(4, 'workshop-cloud-computing-modern-bersama-aws-academy', 178, 2, 'Workshop Cloud Computing Modern bersama AWS Academy', 'Pelaksanaan workshop intensif teknologi komputasi awan (Cloud Computing) bagi siswa tingkat akhir TJKT yang bekerja sama dengan instruktur bersertifikasi AWS.', 1, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(5, 'kemeriahan-kegiatan-mpls-siswa-baru-angkatan-2026', 181, NULL, 'Kemeriahan Kegiatan MPLS Siswa Baru Angkatan 2026', 'Dokumentasi berbagai keseruan dan materi orientasi lingkungan sekolah (MPLS) bagi siswa-siswi baru di lapangan utama dan aula sekolah.', 1, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(6, 'wisuda-dan-pelepasan-siswa-kelas-xii-tahun-2026', 180, NULL, 'Wisuda dan Pelepasan Siswa Kelas XII Tahun 2026', 'Rangkaian prosesi wisuda kelulusan dan upacara pelepasan siswa kelas XII tahun pelajaran 2025/2026 yang berlangsung khidmat.', 1, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(7, 'kunjungan-industri-jurusan-akuntansi-ke-bank-indonesia', 175, 1, 'Kunjungan Industri Jurusan Akuntansi ke Bank Indonesia', 'Studi lapangan dan pengenalan operasional sistem moneter serta tata kelola keuangan negara bagi siswa Akuntansi (AKL) di kantor Bank Indonesia.', 1, '2026-06-16 07:14:12', '2026-06-19 06:24:32'),
(8, 'aksi-sosial-dan-bakti-masyarakat-osis-smk-unggulan', 175, NULL, 'Aksi Sosial dan Bakti Masyarakat OSIS SMK Unggulan', 'Dokumentasi kegiatan bakti sosial pembagian sembako dan bersih-bersih lingkungan sekitar sekolah oleh pengurus OSIS.', 1, '2026-06-16 07:14:12', '2026-06-16 07:14:12'),
(9, 'lomba-futsal-dan-olahraga-antar-kelas-classmeeting', 179, 1, 'Lomba Futsal dan Olahraga Antar Kelas Classmeeting', 'Momen keseruan pertandingan futsal, voli, dan tarik tambang antar kelas pasca ujian semester ganjil.', 1, '2026-06-16 07:14:12', '2026-06-19 06:24:46'),
(10, 'ujian-kompetensi-keahlian-ukk-program-keahlian-rpl', 175, NULL, 'Ujian Kompetensi Keahlian (UKK) Program Keahlian RPL', 'Dokumentasi pelaksanaan ujian praktik keahlian siswa tingkat akhir program Rekayasa Perangkat Lunak yang dinilai langsung oleh asesor industri.', 1, '2026-06-16 07:14:12', '2026-06-16 07:14:12');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gallery_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `gallery_id`, `image_path`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'gallery-01.jpg', 1, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(2, 1, 'gallery-02.jpg', 2, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(3, 1, 'gallery-03.jpg', 3, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(4, 2, 'gallery-01.jpg', 1, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(5, 2, 'gallery-02.jpg', 2, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(6, 2, 'gallery-03.jpg', 3, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(7, 3, 'gallery-01.jpg', 1, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(8, 3, 'gallery-02.jpg', 2, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(9, 3, 'gallery-03.jpg', 3, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(10, 4, 'gallery-01.jpg', 1, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(11, 4, 'gallery-02.jpg', 2, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(12, 4, 'gallery-03.jpg', 3, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(13, 5, 'gallery-01.jpg', 1, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(14, 5, 'gallery-02.jpg', 2, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(15, 5, 'gallery-03.jpg', 3, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(16, 6, 'gallery-01.jpg', 1, '2026-06-16 07:14:11', '2026-06-16 07:14:11'),
(17, 6, 'gallery-02.jpg', 2, '2026-06-16 07:14:12', '2026-06-16 07:14:12'),
(18, 6, 'gallery-03.jpg', 3, '2026-06-16 07:14:12', '2026-06-16 07:14:12'),
(19, 7, 'gallery-01.jpg', 1, '2026-06-16 07:14:12', '2026-06-16 07:14:12'),
(20, 7, 'gallery-02.jpg', 2, '2026-06-16 07:14:12', '2026-06-16 07:14:12'),
(21, 7, 'gallery-03.jpg', 3, '2026-06-16 07:14:12', '2026-06-16 07:14:12'),
(22, 8, 'gallery-01.jpg', 1, '2026-06-16 07:14:12', '2026-06-16 07:14:12'),
(23, 8, 'gallery-02.jpg', 2, '2026-06-16 07:14:12', '2026-06-16 07:14:12'),
(24, 8, 'gallery-03.jpg', 3, '2026-06-16 07:14:12', '2026-06-16 07:14:12'),
(25, 9, 'gallery-01.jpg', 1, '2026-06-16 07:14:12', '2026-06-16 07:14:12'),
(26, 9, 'gallery-02.jpg', 2, '2026-06-16 07:14:12', '2026-06-16 07:14:12'),
(27, 9, 'gallery-03.jpg', 3, '2026-06-16 07:14:12', '2026-06-16 07:14:12'),
(28, 10, 'gallery-01.jpg', 1, '2026-06-16 07:14:12', '2026-06-16 07:14:12'),
(29, 10, 'gallery-02.jpg', 2, '2026-06-16 07:14:12', '2026-06-16 07:14:12'),
(30, 10, 'gallery-03.jpg', 3, '2026-06-16 07:14:12', '2026-06-16 07:14:12');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `location` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `slug` varchar(150) DEFAULT NULL,
  `link_type` enum('page','structure','route','url','group') DEFAULT 'url',
  `page_id` bigint(20) UNSIGNED DEFAULT NULL,
  `structure_id` bigint(20) UNSIGNED DEFAULT NULL,
  `custom_url` varchar(255) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `css_class` varchar(100) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `open_new_tab` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `parent_id`, `location`, `title`, `slug`, `link_type`, `page_id`, `structure_id`, `custom_url`, `icon`, `css_class`, `order`, `is_active`, `open_new_tab`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, NULL, 'header', 'Beranda', NULL, 'route', NULL, NULL, '/site', NULL, NULL, 1, 1, 0, NULL, 1, 1, '2026-06-13 06:50:28', '2026-06-14 13:09:03'),
(2, NULL, 'header', 'Profil', NULL, 'group', NULL, NULL, NULL, NULL, NULL, 2, 1, 0, NULL, 1, NULL, '2026-06-14 13:09:56', '2026-06-14 13:09:56'),
(3, 2, 'header', 'Sambutan Kepala Sekolah', NULL, 'page', 1, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, 1, 1, '2026-06-14 13:10:25', '2026-06-14 14:37:43'),
(4, 2, 'header', 'Sejarah Sekolah', NULL, 'page', NULL, NULL, NULL, NULL, NULL, 2, 1, 0, NULL, 1, NULL, '2026-06-14 13:10:51', '2026-06-14 13:10:51'),
(5, 2, 'header', 'Visi & Misi', NULL, 'page', NULL, NULL, NULL, NULL, NULL, 3, 1, 0, NULL, 1, NULL, '2026-06-14 13:11:12', '2026-06-14 13:11:12'),
(6, 2, 'header', 'Struktur Organisasi', NULL, 'structure', 2, NULL, NULL, NULL, NULL, 4, 1, 0, NULL, 1, 1, '2026-06-14 13:11:28', '2026-06-17 10:03:19'),
(7, 2, 'header', 'Identitas Sekolah', NULL, 'page', NULL, NULL, NULL, NULL, NULL, 5, 1, 0, NULL, 1, NULL, '2026-06-14 13:11:50', '2026-06-14 13:11:50'),
(8, 2, 'header', 'Akreditasi', NULL, 'page', NULL, NULL, NULL, NULL, NULL, 6, 1, 0, NULL, 1, NULL, '2026-06-14 13:12:06', '2026-06-14 13:12:06'),
(9, 2, 'header', 'Fasilitas', NULL, 'page', NULL, NULL, NULL, NULL, NULL, 7, 1, 0, NULL, 1, NULL, '2026-06-14 13:12:22', '2026-06-14 13:12:22'),
(10, 2, 'header', 'Program Unggulan', NULL, 'page', NULL, NULL, NULL, NULL, NULL, 8, 1, 0, NULL, 1, NULL, '2026-06-14 13:12:51', '2026-06-14 13:12:51'),
(11, NULL, 'header', 'Guru & Tendik', NULL, 'page', NULL, NULL, NULL, NULL, NULL, 3, 1, 0, NULL, 1, NULL, '2026-06-14 13:14:55', '2026-06-14 13:14:55'),
(12, 11, 'header', 'Manajemen Sekolah', NULL, 'structure', NULL, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, 1, NULL, '2026-06-14 13:15:26', '2026-06-14 13:15:26'),
(13, 11, 'header', 'Guru Produktif', NULL, 'structure', NULL, NULL, NULL, NULL, NULL, 2, 1, 0, NULL, 1, NULL, '2026-06-14 13:15:50', '2026-06-14 13:15:50'),
(14, 11, 'header', 'Guru Adaptif', NULL, 'structure', NULL, NULL, NULL, NULL, NULL, 3, 1, 0, NULL, 1, NULL, '2026-06-14 13:16:11', '2026-06-14 13:16:11'),
(15, 11, 'header', 'Guru Normatif', NULL, 'structure', NULL, NULL, NULL, NULL, NULL, 4, 1, 0, NULL, 1, NULL, '2026-06-14 13:16:28', '2026-06-14 13:16:28'),
(16, 11, 'header', 'Tenaga Kependidikan', NULL, 'structure', NULL, NULL, NULL, NULL, NULL, 5, 1, 0, NULL, 1, NULL, '2026-06-14 13:17:04', '2026-06-14 13:17:04'),
(17, NULL, 'header', 'Program Keahlian', NULL, 'group', NULL, NULL, NULL, NULL, NULL, 4, 1, 0, NULL, 1, NULL, '2026-06-14 13:17:39', '2026-06-14 13:17:39'),
(18, 17, 'header', 'Pengembangan Perangkat Lunak dan Gim', NULL, 'route', NULL, NULL, '/jurusan/pplg', NULL, NULL, 1, 1, 0, NULL, 1, 1, '2026-06-14 13:20:44', '2026-06-17 19:52:22'),
(19, 17, 'header', 'Teknik Jaringan Komputer dan Telekomunikasi', NULL, 'route', NULL, NULL, '/prodi/TJKT', NULL, NULL, 2, 1, 0, NULL, 1, NULL, '2026-06-14 13:21:33', '2026-06-14 13:21:33'),
(20, 17, 'header', 'Teknik dan Bisnis Sepeda Motor', NULL, 'route', NULL, NULL, '/prodi/tbsm', NULL, NULL, 3, 1, 0, NULL, 1, NULL, '2026-06-14 13:26:26', '2026-06-14 13:26:26'),
(21, 17, 'header', 'Akuntasni dan Keuangan Lembaga', NULL, 'route', NULL, NULL, '/prodi/akl', NULL, NULL, 4, 1, 0, NULL, 1, NULL, '2026-06-14 13:28:38', '2026-06-14 13:28:38'),
(22, 17, 'header', 'Manajemen Perkantoran dan Layanan Bisnis', NULL, 'route', NULL, NULL, '/prodi/MPLB', NULL, NULL, 5, 1, 0, NULL, 1, NULL, '2026-06-14 13:29:15', '2026-06-14 13:29:15'),
(23, 17, 'header', 'Pemasaran', NULL, 'route', NULL, NULL, '/prodi/pm', NULL, NULL, 6, 1, 0, NULL, 1, NULL, '2026-06-14 13:29:41', '2026-06-14 13:29:41'),
(24, 17, 'header', 'Perhotelan', NULL, 'route', NULL, NULL, '/prodi/ph', NULL, NULL, 7, 1, 0, NULL, 1, NULL, '2026-06-14 13:30:12', '2026-06-14 13:30:12'),
(25, NULL, 'header', 'Kesiswaan', NULL, 'group', NULL, NULL, NULL, NULL, NULL, 5, 1, 0, NULL, 1, NULL, '2026-06-14 13:47:01', '2026-06-14 13:47:01'),
(26, 25, 'header', 'Organisasi Siswa', NULL, 'route', NULL, NULL, '/organisasi', NULL, NULL, 1, 1, 0, NULL, 1, 1, '2026-06-14 13:47:31', '2026-06-16 09:15:11'),
(27, 25, 'header', 'Ekstrakurikuler', NULL, 'route', NULL, NULL, '/ekstrakurikuler', NULL, NULL, 2, 1, 0, NULL, 1, NULL, '2026-06-14 13:48:02', '2026-06-14 13:48:02'),
(29, 25, 'header', 'Tata Tertib', NULL, 'page', NULL, NULL, NULL, NULL, NULL, 4, 1, 0, NULL, 1, NULL, '2026-06-14 13:49:40', '2026-06-14 13:49:40'),
(30, 2, 'header', 'Hubungan Industri', NULL, 'route', NULL, NULL, '/hubin', NULL, NULL, 9, 1, 0, NULL, 1, NULL, '2026-06-14 13:53:16', '2026-06-14 13:53:16'),
(31, NULL, 'header', 'Alumni', NULL, 'group', NULL, NULL, NULL, NULL, NULL, 6, 1, 0, NULL, 1, NULL, '2026-06-14 13:53:54', '2026-06-14 13:53:54'),
(32, 31, 'header', 'Alumni Inspiratif', NULL, 'route', NULL, NULL, '/alumni', NULL, NULL, 1, 1, 0, NULL, 1, 1, '2026-06-14 13:54:33', '2026-06-16 09:06:21'),
(33, 31, 'header', 'Tracer Study', NULL, 'route', NULL, NULL, '/tracer', NULL, NULL, 2, 1, 0, NULL, 1, 1, '2026-06-14 13:55:07', '2026-06-14 13:57:13'),
(34, 31, 'header', 'Testimoni Alumni', NULL, 'route', NULL, NULL, '/testimoni_alumni', NULL, NULL, 3, 1, 0, NULL, 1, NULL, '2026-06-14 13:55:53', '2026-06-14 13:57:13'),
(35, 31, 'header', 'Karir Alumni', NULL, 'page', NULL, NULL, NULL, NULL, NULL, 4, 1, 0, NULL, 1, NULL, '2026-06-14 13:56:55', '2026-06-14 13:57:13'),
(36, NULL, 'header', 'Publikasi', NULL, 'group', NULL, NULL, NULL, NULL, NULL, 7, 1, 0, NULL, 1, NULL, '2026-06-14 14:01:36', '2026-06-14 14:01:36'),
(37, 36, 'header', 'Berita', NULL, 'route', NULL, NULL, '/berita', NULL, NULL, 1, 1, 0, NULL, 1, NULL, '2026-06-14 14:01:55', '2026-06-14 14:01:55'),
(38, 36, 'header', 'Pengumuman', NULL, 'route', NULL, NULL, '/pengumuman', NULL, NULL, 2, 1, 0, NULL, 1, NULL, '2026-06-14 14:02:25', '2026-06-14 14:02:25'),
(39, 36, 'header', 'Agenda & Event', NULL, 'route', NULL, NULL, '/agenda', NULL, NULL, 3, 1, 0, NULL, 1, NULL, '2026-06-14 14:02:47', '2026-06-14 14:02:47'),
(40, 36, 'header', 'Prestasi', NULL, 'route', NULL, NULL, '/prestasi', NULL, NULL, 4, 1, 0, NULL, 1, NULL, '2026-06-14 14:03:24', '2026-06-14 14:03:24'),
(41, 36, 'header', 'Gallery', NULL, 'route', NULL, NULL, '/gallery', NULL, NULL, 5, 1, 0, NULL, 1, 1, '2026-06-14 14:03:50', '2026-06-16 07:21:32'),
(42, 36, 'header', 'Download', NULL, 'route', NULL, NULL, '/download', NULL, NULL, 6, 1, 0, NULL, 1, NULL, '2026-06-14 14:04:49', '2026-06-14 14:04:49'),
(43, NULL, 'jurusan_pplg', 'Kurikulum', NULL, 'page', 1, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, 1, NULL, '2026-06-17 20:09:48', '2026-06-17 20:09:48'),
(44, NULL, 'header', 'Kontak', NULL, 'route', NULL, NULL, '/kontak', NULL, NULL, 8, 1, 0, NULL, 1, NULL, '2026-06-20 12:02:39', '2026-06-20 12:02:39');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_05_025843_create_personal_access_tokens_table', 1),
(5, '2025_11_05_100949_create_common_table', 1),
(6, '2025_11_05_101029_create_announcement_table', 1),
(7, '2025_11_05_101043_create_events_table', 1),
(8, '2025_11_05_101110_create_members_table', 1),
(9, '2025_11_05_101124_create_news_table', 1),
(10, '2025_11_05_101143_create_pages_table', 1),
(11, '2025_11_05_101157_create_secretariat_table', 1),
(12, '2025_11_05_101210_create_settings_table', 1),
(13, '2025_11_05_101223_create_transparency_table', 1),
(14, '2025_11_05_101235_create_security_logs_table', 1),
(15, '2025_11_05_101248_create_security_settings_table', 1),
(16, '2025_11_09_141528_add_unique_constraint_to_common_table', 1),
(17, '2025_11_09_141551_add_active_period_to_settings_table', 1),
(18, '2025_11_09_142901_add_additional_columns_to_common_table', 1),
(19, '2025_11_09_143252_create_structure_members_table', 1),
(20, '2025_11_09_143329_add_structure_columns_to_pages_table', 1),
(21, '2025_11_09_143349_add_period_to_news_table', 1),
(22, '2025_11_09_143403_add_period_to_events_table', 1),
(23, '2025_11_09_143443_add_period_to_announcement_table', 1),
(24, '2025_11_18_223023_add_updated_by_to_news_table', 1),
(25, '2025_11_18_223739_update_news_timestamps_to_use_database_time', 1),
(26, '2025_11_29_211614_create_menus_table', 1),
(27, '2025_11_29_233149_add_route_to_menus_link_type', 1),
(28, '2025_11_29_update_pages_type_column', 1),
(29, '2025_11_30_add_fields_to_settings_table', 1),
(30, '2026_06_07_000001_create_galleries_table', 1),
(31, '2026_06_07_000002_create_gallery_images_table', 1),
(32, '2026_06_07_000003_add_slug_to_galleries_table', 1),
(33, '2026_06_10_000001_update_users_roles_add_jurusan', 1),
(34, '2026_06_10_000002_repurpose_members_to_guru_table', 1),
(35, '2026_06_10_000003_add_is_active_order_to_common_table', 1),
(36, '2026_06_10_000004_rename_editor_to_operator_role', 1),
(37, '2026_06_11_155619_create_sdm_and_testimonials_tables', 1),
(38, '2026_06_11_171000_add_rating_to_testimonials_table', 1),
(39, '2026_06_12_000000_create_achievements_table', 2),
(40, '2026_06_12_000001_update_achievements_table', 3),
(41, '2026_06_12_112120_add_jurusan_id_to_achievements_table', 4),
(42, '2026_06_12_184500_create_programs_table_and_migrate_data', 5),
(44, '2026_06_12_125758_create_downloads_table', 6),
(45, '2026_06_13_000000_add_jurusan_and_categories_to_content_tables', 7),
(46, '2026_06_13_084500_create_structure_sections_and_update_members', 8),
(47, '2026_06_16_163057_drop_member_id_fk_on_structure_members', 9),
(48, '2026_06_19_055810_add_extended_fields_to_programs_table', 10),
(49, '2026_06_19_064009_add_ppdb_link_to_settings_table', 11),
(50, '2026_06_19_070500_insert_school_life_section', 12),
(51, '2026_06_26_000001_create_social_media_settings_and_home_section', 13);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `excerpt` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jurusan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `period` varchar(50) DEFAULT NULL COMMENT 'Period (contoh: "2024-2029") - optional, jika NULL berarti berita bersifat umum',
  `published_at` datetime DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `tags` varchar(255) DEFAULT NULL,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `share_count` int(11) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `source` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `is_have_file` tinyint(1) NOT NULL DEFAULT 0,
  `file` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `content`, `excerpt`, `image`, `author`, `created_by`, `updated_by`, `category_id`, `jurusan_id`, `period`, `published_at`, `status`, `tags`, `view_count`, `share_count`, `is_featured`, `source`, `meta_title`, `meta_description`, `is_have_file`, `file`, `created_at`, `updated_at`) VALUES
(1, 'Andika Raih Juara 1 Lomba Robot Line by Diskominfo', 'andika-raih-juara-1-lomba-robot-line-by-diskominfo', '<p>asdasdasd</p>', 'asdasd', 'news/dcr-result-andika_1781245614.png', 'Andika', 1, 1, 158, NULL, NULL, '2026-06-12 13:26:54', 'published', 'juara', 3, 0, 1, 'ass', 'Andika Raih Juara 1 Lomba Robot Line by Diskominfo', 'asd', 0, NULL, '2026-06-12 06:26:54', '2026-06-15 15:08:34'),
(2, 'Pembukaan Masa Pengenalan Lingkungan Sekolah Tahun Ajaran 2026/2027', 'pembukaan-mpls-tahun-ajaran-2026-2027', '<p>SMK PGRI Subang secara resmi membuka kegiatan MPLS bagi peserta didik baru tahun ajaran 2026/2027.</p>', 'Pembukaan kegiatan MPLS peserta didik baru.', 'news/dummy-news.jpg', 'Admin SMK PGRI Subang', 1, 1, 158, NULL, NULL, '2026-06-15 05:49:12', 'published', 'mpls,sekolah', 0, 0, 0, NULL, 'Pembukaan Masa Pengenalan Lingkungan Sekolah Tahun Ajaran 2026/2027', 'Pembukaan kegiatan MPLS peserta didik baru.', 0, NULL, '2026-06-14 22:49:12', '2026-06-14 22:49:12'),
(3, 'Tim Futsal SMK PGRI Subang Raih Juara Tingkat Kabupaten', 'tim-futsal-smk-pgri-subang-raih-juara-tingkat-kabupaten', '<p>Tim futsal berhasil meraih prestasi membanggakan dalam kompetisi tingkat kabupaten.</p>', 'Prestasi tim futsal tingkat kabupaten.', 'news/dummy-news.jpg', 'Admin SMK PGRI Subang', 1, 1, 158, NULL, NULL, '2026-06-15 05:49:12', 'published', 'futsal,prestasi', 2, 0, 0, NULL, 'Tim Futsal SMK PGRI Subang Raih Juara Tingkat Kabupaten', 'Prestasi tim futsal tingkat kabupaten.', 0, NULL, '2026-06-14 22:49:12', '2026-06-15 15:11:02'),
(4, 'Workshop Digital Marketing Bersama Praktisi Industri', 'workshop-digital-marketing-bersama-praktisi-industri', '<p>Siswa mendapatkan wawasan langsung dari praktisi industri digital marketing.</p>', 'Workshop digital marketing untuk siswa.', 'news/dummy-news.jpg', 'Admin SMK PGRI Subang', 1, 1, 158, NULL, NULL, '2026-06-15 05:49:12', 'published', 'workshop,pemasaran', 0, 0, 0, NULL, 'Workshop Digital Marketing Bersama Praktisi Industri', 'Workshop digital marketing untuk siswa.', 0, NULL, '2026-06-14 22:49:12', '2026-06-14 22:49:12'),
(5, 'Kunjungan Industri Siswa TJKT ke Data Center Nasional', 'kunjungan-industri-siswa-tjkt-ke-data-center-nasional', '<p>Siswa TJKT melakukan kunjungan industri untuk mempelajari infrastruktur jaringan modern.</p>', 'Kunjungan industri siswa TJKT.', 'news/dummy-news.jpg', 'Admin SMK PGRI Subang', 1, 1, 158, NULL, NULL, '2026-06-15 05:49:12', 'published', 'tjkt,industri', 0, 0, 0, NULL, 'Kunjungan Industri Siswa TJKT ke Data Center Nasional', 'Kunjungan industri siswa TJKT.', 0, NULL, '2026-06-14 22:49:12', '2026-06-14 22:49:12'),
(6, 'PPLG Gelar Pelatihan Pembuatan Aplikasi Berbasis Web', 'pplg-gelar-pelatihan-pembuatan-aplikasi-berbasis-web', '<p>Peserta didik PPLG mengikuti pelatihan pengembangan aplikasi web modern.</p>', 'Pelatihan aplikasi web bagi siswa PPLG.', 'news/dummy-news.jpg', 'Admin SMK PGRI Subang', 1, 1, 158, NULL, NULL, '2026-06-15 05:49:12', 'published', 'pplg,web', 1, 0, 0, NULL, 'PPLG Gelar Pelatihan Pembuatan Aplikasi Berbasis Web', 'Pelatihan aplikasi web bagi siswa PPLG.', 0, NULL, '2026-06-14 22:49:12', '2026-06-20 13:22:40'),
(7, 'TBSM Adakan Servis Gratis untuk Masyarakat', 'tbsm-adakan-servis-gratis-untuk-masyarakat', '<p>Kegiatan servis gratis menjadi bagian dari pembelajaran dan pengabdian kepada masyarakat.</p>', 'Servis gratis oleh jurusan TBSM.', 'news/dummy-news.jpg', 'Admin SMK PGRI Subang', 1, 1, 158, NULL, NULL, '2026-06-15 05:49:12', 'published', 'tbsm,bakti-sosial', 1, 0, 0, NULL, 'TBSM Adakan Servis Gratis untuk Masyarakat', 'Servis gratis oleh jurusan TBSM.', 0, NULL, '2026-06-14 22:49:12', '2026-06-15 12:58:09'),
(8, 'AKL Mengadakan Seminar Literasi Keuangan', 'akl-mengadakan-seminar-literasi-keuangan', '<p>Siswa AKL mendapatkan pemahaman mengenai pengelolaan keuangan sejak dini.</p>', 'Seminar literasi keuangan bagi siswa.', 'news/dummy-news.jpg', 'Admin SMK PGRI Subang', 1, 1, 158, NULL, NULL, '2026-06-15 05:49:12', 'published', 'akl,keuangan', 0, 0, 0, NULL, 'AKL Mengadakan Seminar Literasi Keuangan', 'Seminar literasi keuangan bagi siswa.', 0, NULL, '2026-06-14 22:49:12', '2026-06-14 22:49:12'),
(9, 'MPLB Tingkatkan Kompetensi Administrasi Digital', 'mplb-tingkatkan-kompetensi-administrasi-digital', '<p>Siswa MPLB mengikuti pelatihan administrasi berbasis teknologi digital.</p>', 'Pelatihan administrasi digital MPLB.', 'news/dummy-news.jpg', 'Admin SMK PGRI Subang', 1, 1, 158, NULL, NULL, '2026-06-15 05:49:12', 'published', 'mplb,administrasi', 0, 0, 0, NULL, 'MPLB Tingkatkan Kompetensi Administrasi Digital', 'Pelatihan administrasi digital MPLB.', 0, NULL, '2026-06-14 22:49:12', '2026-06-14 22:49:12'),
(10, 'Perhotelan Praktik Front Office di Hotel Mitra', 'perhotelan-praktik-front-office-di-hotel-mitra', '<p>Siswa perhotelan melaksanakan praktik kerja lapangan di hotel mitra sekolah.</p>', 'Praktik front office siswa perhotelan.', 'news/dummy-news.jpg', 'Admin SMK PGRI Subang', 1, 1, 158, NULL, NULL, '2026-06-15 05:49:12', 'published', 'perhotelan,pkl', 0, 0, 0, NULL, 'Perhotelan Praktik Front Office di Hotel Mitra', 'Praktik front office siswa perhotelan.', 0, NULL, '2026-06-14 22:49:12', '2026-06-14 22:49:12'),
(11, 'SMK PGRI Subang Gelar Job Fair Bersama Mitra Industri', 'smk-pgri-subang-gelar-job-fair-bersama-mitra-industri', '<p>Kegiatan job fair menghadirkan berbagai perusahaan mitra untuk rekrutmen lulusan.</p>', 'Job fair bersama perusahaan mitra.', 'news/dummy-news.jpg', 'Admin SMK PGRI Subang', 1, 1, 158, NULL, NULL, '2026-06-15 05:49:12', 'published', 'jobfair,bkk', 0, 0, 0, NULL, 'SMK PGRI Subang Gelar Job Fair Bersama Mitra Industri', 'Job fair bersama perusahaan mitra.', 0, NULL, '2026-06-14 22:49:12', '2026-06-14 22:49:12'),
(12, 'Pelaksanaan Asesmen Sumatif Akhir Semester', 'pelaksanaan-asesmen-sumatif-akhir-semester', '<p>Asesmen sumatif akhir semester dilaksanakan sesuai jadwal akademik sekolah.</p>', 'Pelaksanaan asesmen akhir semester.', 'news/dummy-news.jpg', 'Admin SMK PGRI Subang', 1, 1, 159, NULL, NULL, '2026-06-15 05:49:12', 'published', 'akademik,ujian', 0, 0, 0, NULL, 'Pelaksanaan Asesmen Sumatif Akhir Semester', 'Pelaksanaan asesmen akhir semester.', 0, NULL, '2026-06-14 22:49:12', '2026-06-15 22:35:25'),
(13, 'Ekstrakurikuler Paskibra Raih Prestasi Gemilang', 'ekstrakurikuler-paskibra-raih-prestasi-gemilang', '<p>Tim paskibra berhasil mengharumkan nama sekolah pada ajang kompetisi.</p>', 'Prestasi ekstrakurikuler paskibra.', 'news/dummy-news.jpg', 'Admin SMK PGRI Subang', 1, 1, 158, NULL, NULL, '2026-06-15 05:49:12', 'published', 'paskibra,prestasi', 0, 0, 0, NULL, 'Ekstrakurikuler Paskibra Raih Prestasi Gemilang', 'Prestasi ekstrakurikuler paskibra.', 0, NULL, '2026-06-14 22:49:12', '2026-06-14 22:49:12'),
(14, 'Program Teaching Factory Terus Dikembangkan', 'program-teaching-factory-terus-dikembangkan', '<p>Sekolah berkomitmen meningkatkan kualitas pembelajaran berbasis industri.</p>', 'Pengembangan teaching factory sekolah.', 'news/dummy-news.jpg', 'Admin SMK PGRI Subang', 1, 1, 159, NULL, NULL, '2026-06-15 05:49:12', 'published', 'tefa,industri', 0, 0, 0, NULL, 'Program Teaching Factory Terus Dikembangkan', 'Pengembangan teaching factory sekolah.', 0, NULL, '2026-06-14 22:49:12', '2026-06-15 22:34:35'),
(15, 'Sosialisasi Keselamatan Berkendara untuk Siswa', 'sosialisasi-keselamatan-berkendara-untuk-siswa', '<p>Kegiatan edukasi keselamatan berkendara dilakukan bersama kepolisian.</p>', 'Sosialisasi keselamatan berkendara.', 'news/dummy-news.jpg', 'Admin SMK PGRI Subang', 1, 1, 159, NULL, NULL, '2026-06-15 05:49:12', 'published', 'keselamatan,siswa', 1, 0, 0, NULL, 'Sosialisasi Keselamatan Berkendara untuk Siswa', 'Sosialisasi keselamatan berkendara.', 0, NULL, '2026-06-14 22:49:12', '2026-06-15 22:34:23'),
(16, 'Peringatan Hari Pendidikan Nasional 2026', 'peringatan-hari-pendidikan-nasional-2026', '<p>Seluruh warga sekolah mengikuti upacara dan kegiatan peringatan Hardiknas.</p>', 'Peringatan Hari Pendidikan Nasional.', 'news/dummy-news.jpg', 'Admin SMK PGRI Subang', 1, 1, 158, NULL, NULL, '2026-06-15 05:49:12', 'published', 'hardiknas,sekolah', 1, 0, 1, NULL, 'Peringatan Hari Pendidikan Nasional 2026', 'Peringatan Hari Pendidikan Nasional.', 0, NULL, '2026-06-14 22:49:12', '2026-06-15 15:49:37'),
(17, 'BKK Laksanakan Rekrutmen Bersama Perusahaan Nasional', 'bkk-laksanakan-rekrutmen-bersama-perusahaan-nasional', '<p>BKK memfasilitasi proses rekrutmen lulusan bersama perusahaan nasional.</p>', 'Rekrutmen lulusan melalui BKK.', 'news/dummy-news.jpg', 'Admin SMK PGRI Subang', 1, 1, 159, NULL, NULL, '2026-06-15 05:49:12', 'published', 'bkk,karir', 1, 0, 1, NULL, 'BKK Laksanakan Rekrutmen Bersama Perusahaan Nasional', 'Rekrutmen lulusan melalui BKK.', 0, NULL, '2026-06-14 22:49:12', '2026-06-16 06:38:45'),
(18, 'Penguatan Karakter Melalui Kegiatan Keagamaan', 'penguatan-karakter-melalui-kegiatan-keagamaan', '<p>Kegiatan keagamaan rutin dilaksanakan untuk membentuk karakter peserta didik.</p>', 'Pembinaan karakter melalui kegiatan keagamaan.', 'news/dummy-news.jpg', 'Admin SMK PGRI Subang', 1, 1, 158, NULL, NULL, '2026-06-15 05:49:12', 'published', 'karakter,keagamaan', 0, 0, 1, NULL, 'Penguatan Karakter Melalui Kegiatan Keagamaan', 'Pembinaan karakter melalui kegiatan keagamaan.', 0, NULL, '2026-06-14 22:49:12', '2026-06-15 15:33:56'),
(19, 'SMK PGRI Subang Terima Kunjungan Sekolah Mitra', 'smk-pgri-subang-terima-kunjungan-sekolah-mitra', '<p>Kunjungan dilakukan untuk berbagi praktik baik dalam pengelolaan pendidikan.</p>', 'Kunjungan sekolah mitra.', 'news/dummy-news.jpg', 'Admin SMK PGRI Subang', 1, 1, 158, NULL, NULL, '2026-06-15 05:49:12', 'published', 'kunjungan,kerjasama', 0, 0, 1, NULL, 'SMK PGRI Subang Terima Kunjungan Sekolah Mitra', 'Kunjungan sekolah mitra.', 0, NULL, '2026-06-14 22:49:12', '2026-06-15 15:33:55'),
(20, 'Persiapan Kompetensi Keahlian Tingkat Nasional', 'persiapan-kompetensi-keahlian-tingkat-nasional', '<p>Siswa terbaik dipersiapkan untuk mengikuti kompetisi tingkat nasional.</p>', 'Persiapan kompetisi tingkat nasional.', 'news/dummy-news.jpg', 'Admin SMK PGRI Subang', 1, 1, 158, 1, NULL, '2026-06-15 05:49:12', 'published', 'lks,kompetisi', 0, 0, 0, NULL, 'Persiapan Kompetensi Keahlian Tingkat Nasional', 'Persiapan kompetisi tingkat nasional.', 0, NULL, '2026-06-14 22:49:12', '2026-06-19 06:21:13'),
(21, 'Rapat Evaluasi Program Kerja Semester Genap', 'rapat-evaluasi-program-kerja-semester-genap', '<p>Evaluasi dilakukan untuk meningkatkan kualitas layanan pendidikan sekolah.</p>', 'Evaluasi program kerja semester genap.', 'news/dummy-news.jpg', 'Admin SMK PGRI Subang', 1, 1, 158, NULL, NULL, '2026-06-15 05:49:12', 'published', 'rapat,evaluasi', 0, 0, 0, NULL, 'Rapat Evaluasi Program Kerja Semester Genap', 'Evaluasi program kerja semester genap.', 0, NULL, '2026-06-14 22:49:12', '2026-06-14 22:49:12');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(150) NOT NULL,
  `page_type` varchar(50) NOT NULL DEFAULT 'page',
  `structure_common_id` bigint(20) UNSIGNED DEFAULT NULL,
  `structure_type` varchar(100) DEFAULT NULL,
  `period` varchar(50) DEFAULT NULL,
  `jurusan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `custom1` varchar(255) DEFAULT NULL,
  `custom2` varchar(255) DEFAULT NULL,
  `custom3` varchar(255) DEFAULT NULL,
  `custom4` text DEFAULT NULL,
  `custom5` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `slug`, `page_type`, `structure_common_id`, `structure_type`, `period`, `jurusan_id`, `title`, `subtitle`, `content`, `excerpt`, `image`, `banner`, `attachment`, `custom1`, `custom2`, `custom3`, `custom4`, `custom5`, `is_active`, `is_public`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'sambutan-kepala-sekolah', 'page', NULL, NULL, NULL, NULL, 'Sambutan Kepala Sekolah', NULL, '<h2>Assalamu\'alaikum Warahmatullahi Wabarakatuh<br>&nbsp;</h2><p style=\"text-align:justify;\">Puji syukur kita panjatkan ke hadirat Allah SWT atas segala rahmat dan karunia-Nya sehingga SMK PGRI Subang terus dapat berkontribusi dalam mencetak generasi yang unggul, berkarakter, dan siap menghadapi tantangan dunia kerja maupun pendidikan di masa depan.</p><p style=\"text-align:justify;\">Selamat datang di website resmi SMK PGRI Subang. Website ini hadir sebagai sarana informasi dan komunikasi bagi peserta didik, orang tua, alumni, dunia usaha dan dunia industri, serta masyarakat luas untuk mengenal lebih dekat profil, program, prestasi, dan berbagai kegiatan yang ada di sekolah kami.</p><p style=\"text-align:justify;\">Sebagai sekolah kejuruan yang berkomitmen pada peningkatan kualitas pendidikan, SMK PGRI Subang senantiasa berupaya menghadirkan pembelajaran yang relevan dengan perkembangan teknologi dan kebutuhan industri. Melalui berbagai program unggulan, kerja sama dengan dunia usaha dan dunia industri, serta dukungan tenaga pendidik yang profesional, kami bertekad menciptakan lulusan yang kompeten, berakhlak mulia, kreatif, inovatif, dan siap bersaing di era global.</p><p style=\"text-align:justify;\">Kami percaya bahwa pendidikan yang berkualitas tidak hanya membentuk kemampuan akademik dan keterampilan, tetapi juga karakter, kedisiplinan, dan tanggung jawab sebagai bekal kehidupan bermasyarakat.</p><p style=\"text-align:justify;\">Akhir kata, kami mengucapkan terima kasih atas kepercayaan dan dukungan semua pihak terhadap SMK PGRI Subang. Semoga website ini dapat memberikan manfaat dan menjadi media informasi yang efektif bagi seluruh pengunjung.</p><p style=\"text-align:justify;\">Wassalamu\'alaikum Warahmatullahi Wabarakatuh.</p><p>&nbsp;</p><p>&nbsp;</p><p><strong>Kepala SMK PGRI Subang</strong></p><p><strong>Andika Aulia</strong></p>', NULL, 'pages/screenshot-2026-05-29-215617_1781473032.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, '2026-06-14 21:37:12', '2026-06-14 21:37:12'),
(2, 'osis-periode-20262027', 'structure', 35, 'organisasi', 'Tahun Ajaran 2026/2027', NULL, 'OSIS Periode 2026/2027', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, '2026-06-17 17:01:59', '2026-06-17 17:01:59');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(20) NOT NULL,
  `singkatan` varchar(50) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `ka_prodi` varchar(150) DEFAULT NULL,
  `akreditasi` varchar(10) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `video_url` varchar(500) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `tahun_berdiri` int(10) UNSIGNED DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `deskripsi_singkat` varchar(500) DEFAULT NULL,
  `visi` text DEFAULT NULL,
  `misi` text DEFAULT NULL,
  `tujuan` text DEFAULT NULL,
  `profil_lulusan` text DEFAULT NULL,
  `kurikulum` varchar(100) DEFAULT NULL,
  `order` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `kode`, `singkatan`, `nama`, `ka_prodi`, `akreditasi`, `logo`, `banner`, `video_url`, `email`, `phone`, `tahun_berdiri`, `deskripsi`, `deskripsi_singkat`, `visi`, `misi`, `tujuan`, `profil_lulusan`, `kurikulum`, `order`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'PPLG', 'PPLG', 'Pengembangan Perangkat Lunak dan Gim', '1', 'A', 'programs/0Dj8g9vv1jjIb60328Pc8FoxhrvPdN8NaYdMeZgY.png', NULL, '', '', '', NULL, '<p><strong>Pengembangan Perangkat Lunak dan Gim (PPLG)</strong> adalah salah satu program keahlian pada bidang Teknologi Informasi di SMK yang berfokus pada pengembangan perangkat lunak (software), aplikasi, website, aplikasi mobile, basis data, hingga pembuatan gim. Program ini merupakan pengembangan dari jurusan Rekayasa Perangkat Lunak (RPL) yang mulai berganti nama menjadi PPLG sesuai kebijakan Kemendikbud.</p><h3>Tujuan Program Keahlian</h3><p>PPLG bertujuan menghasilkan lulusan yang:</p><ul><li>Menguasai logika dan algoritma pemrograman.</li><li>Mampu merancang, membuat, menguji, dan memelihara perangkat lunak.</li><li>Memiliki kemampuan pengembangan aplikasi web, desktop, mobile, dan gim.</li><li>Memahami kebutuhan pengguna serta konsep User Experience (UX).</li><li>Memiliki keterampilan kerja, komunikasi, kolaborasi, dan pemecahan masalah yang dibutuhkan industri digital.&nbsp;</li></ul><h2>Kompetensi yang Dipelajari</h2><h3>1. Dasar Pemrograman</h3><p>Siswa mempelajari:</p><ul><li>Logika algoritma</li><li>Flowchart</li><li>Struktur data</li><li>Pemrograman prosedural</li><li>Pemrograman berorientasi objek (OOP)</li><li>Debugging dan testing program</li></ul><p>Bahasa pemrograman yang umum digunakan antara lain:</p><ul><li>JavaScript</li><li>PHP</li><li>Python</li><li>Java</li><li>Kotlin</li><li>C++ (tergantung sekolah)&nbsp;</li></ul><h3>2. Pengembangan Website</h3><p>Materi meliputi:</p><ul><li>HTML</li><li>CSS</li><li>JavaScript</li><li>Framework Frontend</li><li>PHP / Node.js</li><li>Framework Backend</li><li>REST API</li><li>Deployment Website</li></ul><p>Siswa mampu membuat website dinamis dan sistem informasi berbasis web.</p><h3>3. Pengembangan Aplikasi Mobile</h3><p>Siswa belajar:</p><ul><li>Android Development</li><li>Kotlin / Java</li><li>UI Mobile</li><li>Konsumsi API</li><li>Database Mobile</li></ul><p>Sehingga mampu membuat aplikasi Android secara mandiri.</p><h3>4. Basis Data (Database)</h3><p>Materi meliputi:</p><ul><li>Perancangan database</li><li>ERD (Entity Relationship Diagram)</li><li>SQL</li><li>MySQL</li><li>PostgreSQL</li><li>Manajemen data</li></ul><p>Siswa belajar membangun sistem penyimpanan data yang efisien dan aman.</p><h3>5. Pengembangan Gim</h3><p>Materi yang dipelajari:</p><ul><li>Dasar game development</li><li>Game design</li><li>Animasi dan multimedia</li><li>Engine pengembangan gim</li><li>Pembuatan gim edukasi dan hiburan</li></ul><p>Siswa dapat membuat gim sederhana hingga menengah sesuai tingkat kompetensi.</p><h3>6. Rekayasa Perangkat Lunak</h3><p>Mempelajari:</p><ul><li>Software Development Life Cycle (SDLC)</li><li>Analisis kebutuhan sistem</li><li>Perancangan sistem</li><li>Dokumentasi</li><li>Quality Assurance (QA)</li><li>Pengujian perangkat lunak</li></ul><p>Siswa memahami proses pengembangan software yang digunakan di industri.</p><h2>Fasilitas Praktik</h2><p>Umumnya jurusan PPLG didukung oleh:</p><ul><li>Laboratorium komputer</li><li>Server lokal</li><li>Jaringan internet</li><li>Software development tools</li><li>Version control (Git)</li><li>Platform cloud dan hosting</li></ul><p>Sehingga pembelajaran lebih menekankan praktik dibanding teori.</p><h2>Peluang Karier Lulusan</h2><p>Lulusan PPLG dapat bekerja sebagai:</p><ul><li>Web Developer</li><li>Frontend Developer</li><li>Backend Developer</li><li>Fullstack Developer</li><li>Mobile Developer</li><li>Game Developer</li><li>Software Engineer</li><li>Programmer</li><li>Database Administrator</li><li>Quality Assurance (QA)</li><li>UI/UX Designer</li><li>IT Support</li><li>Freelancer Digital</li><li>Technopreneur (wirausaha bidang teknologi)&nbsp;</li></ul><h2>Peluang Melanjutkan Pendidikan</h2><p>Lulusan PPLG dapat melanjutkan ke perguruan tinggi pada bidang:</p><ul><li>Teknik Informatika</li><li>Ilmu Komputer</li><li>Sistem Informasi</li><li>Teknologi Informasi</li><li>Rekayasa Perangkat Lunak</li><li>Data Science</li><li>Cybersecurity</li><li>Artificial Intelligence</li></ul><h2>Profil Lulusan PPLG</h2><p>Lulusan PPLG diharapkan menjadi tenaga profesional yang mampu:</p><p>✓ Membuat website dan aplikasi modern<br>✓ Mengembangkan sistem informasi perusahaan<br>✓ Mengelola database skala kecil hingga besar<br>✓ Mengembangkan aplikasi mobile Android<br>✓ Membuat dan mengembangkan gim digital<br>✓ Beradaptasi dengan teknologi baru secara cepat<br>✓ Bekerja dalam tim pengembangan perangkat lunak profesional</p>', 'Mempelajari pengembangan aplikasi, website, basis data, dan teknologi perangkat lunak.', 'Menjadi program keahlian unggulan yang menghasilkan lulusan di bidang Pengembangan Perangkat Lunak dan Gim yang kompeten, kreatif, inovatif, berkarakter, serta mampu bersaing di dunia kerja, dunia usaha, dan dunia industri berbasis teknologi digital.', 'Menyelenggarakan pembelajaran berbasis kompetensi sesuai kebutuhan industri teknologi informasi.\nMeningkatkan kemampuan peserta didik dalam bidang pemrograman, pengembangan aplikasi, dan teknologi digital.\nMenumbuhkan kreativitas, inovasi, dan jiwa kewirausahaan di bidang teknologi informasi.\nMembekali peserta didik dengan keterampilan kerja, komunikasi, dan kolaborasi profesional.\nMenerapkan budaya kerja industri, disiplin, dan tanggung jawab dalam setiap kegiatan pembelajaran.\nMenjalin kerja sama dengan dunia usaha, dunia industri, dan perguruan tinggi untuk meningkatkan kualitas lulusan.\nMendorong peserta didik untuk menghasilkan karya perangkat lunak dan gim yang bermanfaat bagi masyarakat.', 'Menghasilkan lulusan yang memiliki kompetensi di bidang pemrograman dan pengembangan perangkat lunak.\nMembekali peserta didik dengan kemampuan membuat aplikasi berbasis web, desktop, dan mobile.\nMembentuk peserta didik yang mampu merancang, mengembangkan, menguji, dan memelihara perangkat lunak.\nMengembangkan kemampuan peserta didik dalam pengelolaan basis data dan integrasi sistem informasi.\nMembekali peserta didik dengan keterampilan pengembangan gim dan teknologi multimedia interaktif.\nMenyiapkan lulusan yang siap bekerja, berwirausaha, atau melanjutkan pendidikan ke jenjang yang lebih tinggi.\nMembentuk lulusan yang berkarakter, disiplin, adaptif, dan mampu mengikuti perkembangan teknologi.', 'Lulusan Program Keahlian Pengembangan Perangkat Lunak dan Gim (PPLG) memiliki kompetensi dalam analisis kebutuhan sistem, perancangan, pengembangan, pengujian, dan pemeliharaan perangkat lunak. Lulusan mampu mengembangkan aplikasi berbasis web, desktop, mobile, serta gim sederhana hingga menengah dengan memanfaatkan teknologi dan bahasa pemrograman terkini. Selain itu, lulusan memiliki kemampuan bekerja secara individu maupun tim, berkomunikasi secara profesional, serta siap bekerja di dunia industri, berwirausaha, maupun melanjutkan pendidikan ke perguruan tinggi.', 'Kurikulum Merdeka', 1, 1, NULL, 1, '2026-06-14 20:07:00', '2026-06-18 23:34:47'),
(2, 'TJKT', 'TJKT', 'Teknik Jaringan Komputer dan Telekomunikasi', '2', 'A', 'programs/AVBILRuAWrjdY3ym4RmrvCqBBeE3YthFpgT8C9Cb.png', NULL, NULL, NULL, NULL, NULL, 'Mempelajari jaringan komputer, server, keamanan jaringan, dan telekomunikasi.', NULL, NULL, NULL, NULL, NULL, 'Kurikulum Merdeka', 2, 1, NULL, 1, '2026-06-14 20:07:00', '2026-06-16 09:00:52'),
(3, 'TBSM', 'TBSM', 'Teknik dan Bisnis Sepeda Motor', NULL, 'A', 'programs/1FdnBrWJoFZK0tyrZ43NuFbKeVI8XjbsQU6ZEmpn.png', NULL, NULL, NULL, NULL, NULL, 'Mempelajari perawatan, perbaikan, dan manajemen bisnis sepeda motor modern.', NULL, NULL, NULL, NULL, NULL, 'Merdeka', 3, 1, NULL, 1, '2026-06-14 20:07:00', '2026-06-16 09:00:51'),
(4, 'AKL', 'AKL', 'Akuntansi dan Keuangan Lembaga', NULL, 'A', 'programs/0H9Y171V4L3qTcqUVix9dK04RTGHlAid1vFa8lTe.png', NULL, NULL, NULL, NULL, NULL, 'Mempelajari akuntansi, perpajakan, laporan keuangan, dan administrasi keuangan.', NULL, NULL, NULL, NULL, NULL, 'Kurikulum Merdeka', 4, 1, NULL, 1, '2026-06-14 20:07:00', '2026-06-16 09:00:12'),
(5, 'MPLB', 'MPLB', 'Manajemen Perkantoran dan Layanan Bisnis', NULL, 'A', 'programs/niHPXIRZuwVJKkliZM7I33PX17trmfB09VMuxz5K.png', NULL, NULL, NULL, NULL, NULL, 'Mempelajari administrasi perkantoran, layanan bisnis, dan komunikasi profesional.', NULL, NULL, NULL, NULL, NULL, 'Kurikulum Merdeka', 5, 1, NULL, 1, '2026-06-14 20:07:00', '2026-06-16 08:58:17'),
(6, 'PM', 'PM', 'Pemasaran', NULL, 'A', 'programs/CldUaapLCPpTRJNgRDbo39ddeZEqQsSmW1qBNcfg.png', NULL, NULL, NULL, NULL, NULL, 'Mempelajari strategi pemasaran, penjualan, bisnis digital, dan kewirausahaan.', NULL, NULL, NULL, NULL, NULL, 'Kurikulum Merdeka', 6, 1, NULL, 1, '2026-06-14 20:07:00', '2026-06-14 13:34:16'),
(7, 'PH', 'PH', 'Perhotelan', NULL, 'A', 'programs/gvXmpDZzcPhwanbDR3rXfab1KOb0QJ3S3gvUuhAi.png', NULL, NULL, NULL, NULL, NULL, 'Mempelajari pelayanan hotel, housekeeping, front office, dan industri pariwisata.', NULL, NULL, NULL, NULL, NULL, 'Kurikulum Merdeka', 7, 1, NULL, 1, '2026-06-14 20:07:00', '2026-06-14 13:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `secretariat`
--

CREATE TABLE `secretariat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `nip` varchar(30) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `division` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `security_logs`
--

CREATE TABLE `security_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `status` enum('allowed','blocked','suspicious') NOT NULL DEFAULT 'allowed',
  `details` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `security_settings`
--

CREATE TABLE `security_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(100) NOT NULL,
  `value` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `security_settings`
--

INSERT INTO `security_settings` (`id`, `key`, `value`, `description`, `created_at`, `updated_at`) VALUES
(1, 'ip_filtering_enabled', '1', 'Enable/disable IP filtering based on geolocation', '2026-06-19 01:18:32', '2026-06-19 01:18:32'),
(2, 'user_agent_filtering_enabled', '1', 'Enable/disable user agent filtering', '2026-06-19 01:18:32', '2026-06-19 01:18:32'),
(3, 'rate_limiting_enabled', '1', 'Enable/disable rate limiting', '2026-06-19 01:18:32', '2026-06-19 01:18:32'),
(4, 'rate_limit_per_hour', '100', 'Maximum requests per hour per IP', '2026-06-19 01:18:32', '2026-06-19 01:18:32'),
(5, 'security_logging_enabled', '1', 'Enable/disable security event logging', '2026-06-19 01:18:32', '2026-06-19 01:18:32'),
(6, 'disable_devtools', '0', 'Enable/disable blocking developer tools on public pages', '2026-06-19 01:18:32', '2026-06-20 12:08:01');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5KmyxQGyPD7idavJqHTzBPgXk3l45JTTcCixiJeW', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36 Edg/149.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiemNLTEZLSlh3VGRQRFFzMXlHbzJ0V3hERnJiMGx1TUNuV2VXQmdmZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1782476193),
('IB1dNUoU4vtikUfpJvdyQVbTNWFRCRDkOmbYzjPY', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNHJVS1ZGUURjRk9lY1BiU1h3bXJqY0dZeWNGUFF3bUtSa3VzZVNTbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1782477796),
('MCbN5aOdCtNabmOHtqUmcMn9BLTuRyJCpsCG0fNN', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibjNJOUNHR3AwVEJxVFA1SlZieUJNa0s4OEdIQzRFOU5UODA2RjVLRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1784137451);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `institution_name` varchar(255) DEFAULT NULL,
  `managed_by` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `office_hours` varchar(100) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `google_map` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `logo_square` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(50) DEFAULT NULL,
  `ppdb_link` varchar(255) DEFAULT NULL,
  `vision` text DEFAULT NULL,
  `mission` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `active_period` varchar(50) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `institution_name`, `managed_by`, `address`, `email`, `phone`, `office_hours`, `fax`, `website`, `google_map`, `logo`, `logo_square`, `favicon`, `facebook`, `instagram`, `twitter`, `linkedin`, `youtube`, `whatsapp`, `ppdb_link`, `vision`, `mission`, `description`, `active_period`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'SMK PGRI Subang', NULL, 'Jl. Marsinu No. 7, Cigadung, Kecamatan Subang, Dangdeur, Kec. Subang, Kabupaten Subang, Jawa Barat 41211', 'info@smkpgrisubang.sch.id', '(0260) 411420', NULL, '-', 'https://smkpgrisubang.sch.id', '<iframe src=\"https://embed.waze.com/iframe?zoom=16&lat=-6.549760&lon=107.761489&ct=livemap\" width=\"600\" height=\"450\" allowfullscreen></iframe>', 'settings/download_1781246303.jpg', NULL, NULL, 'https://facebook.com/smkpgrisubang', 'https://instagram.com/smkpgrisubang', 'https://twitter.com/smkpgrisubbang', NULL, 'https://youtube.com/smkpgrisubang', '-', 'https://smkal-wutsqo.sch.id/ppdb.html', 'Menjadi Sekolah Unggulan Wirausaha sesuai kompetensi keahlian', 'Senantiasa selalu meningkatkan keimanan dan ketaqwaan kepada Allah SWT.\nMemberdayakan semua potensi yang ada dalam membentuk jiwa wirausaha.\nPeningkatan mutu pendidikan melalui proses kegiatan pembelajaran yang sesuai dengan kebutuhan masyarakat dan pasar kerja.', 'Sekolah Menengah Kejuruan PGRI Subang adalah sekolah menengah tingkat atas berbasis kejuruan. SMK PGRI Subang sekolah yang menyelenggarakan pendidikan kejuruan kelompok teknologi, informasi dan industri', '2026-2027', 1, 1, '2026-06-11 21:12:52', '2026-06-18 23:57:02');

-- --------------------------------------------------------

--
-- Table structure for table `structural_members`
--

CREATE TABLE `structural_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL DEFAULT 'male',
  `birth_place` varchar(100) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `jabatan` varchar(100) NOT NULL,
  `order` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `description` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `structural_members`
--

INSERT INTO `structural_members` (`id`, `name`, `photo`, `gender`, `birth_place`, `birth_date`, `address`, `phone`, `email`, `jabatan`, `order`, `is_active`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Drs. H. Mulyana, M.Pd.', 'structural/structural_6a2ba9cee5ad27.69841199.jpg', 'male', 'Bandung', '1965-03-24', 'Jl. Dago Asri No. 10, Bandung', '08112233445', 'mulyana@yayasan.org', 'Ketua Yayasan Pendidikan', 1, 1, 'Pendiri sekaligus pembina utama Yayasan Pendidikan yang menaungi sekolah.', 1, 1, '2026-06-11 21:12:53', '2026-06-11 23:40:14'),
(2, 'Hj. Ratna Sari, S.E.', 'structural/dummy.jpg', 'female', 'Jakarta', '1972-07-12', 'Jl. Surya Sumantri No. 34, Bandung', '08112233446', 'ratna.sari@yayasan.org', 'Sekretaris Yayasan', 2, 1, 'Mengawasi jalannya administrasi umum dan tata kelola organisasi yayasan.', 1, 1, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(4, 'Drs. H. Ahmad Fauzi, M.Pd.', 'structural/dummy.jpg', 'male', 'Bandung', '1958-06-15', 'Jl. Raya Dago No. 55, Bandung', '08112233441', 'ahmad.fauzi@yayasan.org', 'Ketua Yayasan', 1, 1, 'Pendiri dan pemimpin utama Yayasan Pendidikan. Berpengalaman lebih dari 30 tahun di bidang pendidikan nasional.', 1, 1, '2026-06-16 09:29:46', '2026-06-16 09:29:46'),
(5, 'Hj. Dewi Rahayu, S.H.', 'structural/dummy.jpg', 'female', 'Jakarta', '1965-11-22', 'Jl. Diponegoro No. 88, Bandung', '08112233442', 'dewi.rahayu@yayasan.org', 'Wakil Ketua Yayasan', 2, 1, 'Mengelola aspek hukum dan kelembagaan yayasan, serta mengawasi kepatuhan regulasi pendidikan.', 1, 1, '2026-06-16 09:29:46', '2026-06-16 09:29:46'),
(6, 'Prof. Dr. H. Mulyana, M.Pd.', 'structural/dummy.jpg', 'male', 'Bandung', '1955-03-24', 'Jl. Dago Asri No. 10, Bandung', '08112233443', 'mulyana@yayasan.org', 'Ketua Dewan Pembina', 3, 1, 'Pembina utama yang memberikan arahan strategis pengembangan pendidikan dan kebijakan yayasan.', 1, 1, '2026-06-16 09:29:46', '2026-06-16 09:29:46'),
(7, 'Dra. Hj. Sri Wulandari, M.M.', 'structural/dummy.jpg', 'female', 'Surabaya', '1963-08-17', 'Jl. Pasteur No. 45, Bandung', '08112233444', 'sri.wulandari@yayasan.org', 'Sekretaris Yayasan', 4, 1, 'Mengatur administrasi umum yayasan dan memastikan kelancaran tata kelola organisasi sehari-hari.', 1, 1, '2026-06-16 09:29:46', '2026-06-16 09:29:46'),
(8, 'Ir. Bambang Suharto, M.T.', 'structural/dummy.jpg', 'male', 'Yogyakarta', '1961-04-30', 'Jl. Setia Budi No. 78, Bandung', '08112233446', 'bambang.s@yayasan.org', 'Anggota Dewan Pengawas', 6, 1, 'Mengawasi pelaksanaan program dan anggaran yayasan, serta memberikan rekomendasi pengembangan infrastruktur.', 1, 1, '2026-06-16 09:29:46', '2026-06-16 09:29:46'),
(9, 'Prof. Dr. H. Mulyana Yusuf, M.Pd.', 'structural/dummy.jpg', 'male', 'Bandung', '1955-03-24', 'Jl. Dago Asri No. 10, Bandung', '08112233443', 'mulyana.yusuf@yayasan.org', 'Ketua Dewan Pembina', 3, 1, 'Pembina utama yang memberikan arahan strategis pengembangan pendidikan dan kebijakan yayasan.', 1, 1, '2026-06-17 09:53:03', '2026-06-17 09:53:03'),
(10, 'H. Dedi Kurniawan, M.M.', 'structural/dummy.jpg', 'male', 'Sumedang', '1968-10-09', 'Jl. Kiara Condong No. 112, Bandung', '08112233445', 'dedi.kurniawan@yayasan.org', 'Bendahara Yayasan', 5, 1, 'Mengelola keuangan dan investasi yayasan serta memastikan transparansi laporan keuangan lembaga.', 1, 1, '2026-06-17 09:53:03', '2026-06-17 09:53:03'),
(11, 'Ir. Bambang Hermawan, M.T.', 'structural/dummy.jpg', 'male', 'Yogyakarta', '1961-04-30', 'Jl. Setia Budi No. 78, Bandung', '08112233446', 'bambang.h@yayasan.org', 'Ketua Dewan Pengawas', 6, 1, 'Mengawasi pelaksanaan program dan anggaran yayasan, serta memberikan rekomendasi pengembangan.', 1, 1, '2026-06-17 09:53:03', '2026-06-17 09:53:03'),
(12, 'Hj. Lina Marlina, S.E.', 'structural/dummy.jpg', 'female', 'Jakarta', '1972-07-12', 'Jl. Surya Sumantri No. 34, Bandung', '08112233447', 'lina.marlina@yayasan.org', 'Anggota Dewan Pengawas', 7, 1, 'Bertanggung jawab mengawasi administrasi dan tata kelola keuangan yayasan secara berkala.', 1, 1, '2026-06-17 09:53:03', '2026-06-17 09:53:03');

-- --------------------------------------------------------

--
-- Table structure for table `structure_members`
--

CREATE TABLE `structure_members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `common_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Reference ke common (structure: Dapil 1, Komisi A, dll)',
  `section_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'FK to structure_sections',
  `member_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Reference ke members',
  `member_type` varchar(100) NOT NULL DEFAULT 'AppModelsTeacher' COMMENT 'Polymorphic relation class name',
  `period` varchar(50) DEFAULT NULL COMMENT 'Period (contoh: "2019-2024") - reference ke common atau string',
  `position` varchar(100) DEFAULT NULL COMMENT 'Posisi di struktur (contoh: "Ketua", "Anggota", "Wakil Ketua")',
  `order` int(11) NOT NULL DEFAULT 0 COMMENT 'Urutan tampil',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `structure_members`
--

INSERT INTO `structure_members` (`id`, `common_id`, `section_id`, `member_id`, `member_type`, `period`, `position`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(3, 33, 1, 1, 'App\\Models\\Teacher', '', 'Ketua', 1, 1, '2026-06-12 18:58:45', '2026-06-12 18:58:45'),
(4, 35, 4, 1, 'App\\Models\\Teacher', 'PD004', 'Pembina OSIS Utama', 1, 1, '2026-06-16 09:07:24', '2026-06-16 09:07:24'),
(5, 35, 5, 1, 'App\\Models\\Student', 'PD004', 'Ketua OSIS', 1, 1, '2026-06-16 09:07:24', '2026-06-16 09:07:24'),
(6, 35, 5, 2, 'App\\Models\\Student', 'PD004', 'Wakil Ketua OSIS', 2, 1, '2026-06-16 09:07:24', '2026-06-16 09:07:24'),
(7, 35, 5, 3, 'App\\Models\\Student', 'PD004', 'Bendahara Umum', 3, 1, '2026-06-16 09:07:24', '2026-06-16 09:07:24'),
(8, 35, 6, 2, 'App\\Models\\Student', 'PD004', 'Ketua Sekbid Keagamaan', 1, 1, '2026-06-16 09:07:24', '2026-06-16 09:07:24'),
(9, 35, 7, 3, 'App\\Models\\Student', 'PD004', 'Ketua Sekbid IT & Publikasi', 1, 1, '2026-06-16 09:07:24', '2026-06-16 09:07:24'),
(10, 37, 8, 2, 'App\\Models\\Teacher', 'PD004', 'Pembina Pramuka / Kamabigus', 1, 1, '2026-06-16 09:07:24', '2026-06-16 09:07:24'),
(11, 37, 9, 3, 'App\\Models\\Student', 'PD004', 'Pradana (Ketua Dewan Ambalan)', 1, 1, '2026-06-16 09:07:24', '2026-06-16 09:07:24'),
(12, 37, 9, 1, 'App\\Models\\Student', 'PD004', 'Kerani (Sekretaris)', 2, 1, '2026-06-16 09:07:24', '2026-06-16 09:07:24'),
(13, 38, 10, 3, 'App\\Models\\Teacher', 'PD004', 'Pembina Unit PMR Wira', 1, 1, '2026-06-16 09:07:24', '2026-06-16 09:07:24'),
(14, 38, 11, 2, 'App\\Models\\Student', 'PD004', 'Komandan Unit PMR', 1, 1, '2026-06-16 09:07:24', '2026-06-16 09:07:24'),
(16, 35, 7, 1, 'App\\Models\\Student', '', 'Anggota', 1, 1, '2026-06-16 09:32:39', '2026-06-16 09:32:39'),
(17, 259, 15, 5, 'App\\Models\\Teacher', 'Tahun Ajaran 2025/2026', 'Guru Matematika (PPPK)', 1, 1, '2026-06-17 09:53:03', '2026-06-17 09:53:03'),
(18, 259, 15, 7, 'App\\Models\\Teacher', 'Tahun Ajaran 2025/2026', 'Guru Bahasa Indonesia (PPPK)', 2, 1, '2026-06-17 09:53:03', '2026-06-17 09:53:03'),
(19, 259, 16, 2, 'App\\Models\\Teacher', 'Tahun Ajaran 2025/2026', 'Guru Produktif Basis Data (PPPK)', 1, 1, '2026-06-17 09:53:03', '2026-06-17 09:53:03'),
(20, 259, 16, 6, 'App\\Models\\Teacher', 'Tahun Ajaran 2025/2026', 'Guru Produktif RPL (PPPK)', 2, 1, '2026-06-17 09:53:03', '2026-06-17 09:53:03'),
(21, 35, 4, 3, 'App\\Models\\Teacher', 'Tahun Ajaran 2026/2027', 'Pembina', 1, 1, '2026-06-17 10:05:45', '2026-06-17 10:05:45'),
(22, 35, 5, 1, 'App\\Models\\Student', 'Tahun Ajaran 2026/2027', 'Ketua', 2, 1, '2026-06-17 10:06:06', '2026-06-17 10:06:06'),
(23, 35, 6, 2, 'App\\Models\\Student', 'Tahun Ajaran 2026/2027', 'Anggota', 3, 1, '2026-06-17 10:06:33', '2026-06-17 10:06:33'),
(24, 35, 7, 3, 'App\\Models\\Student', 'Tahun Ajaran 2026/2027', 'Anggota', 4, 1, '2026-06-17 10:06:47', '2026-06-17 10:06:47');

-- --------------------------------------------------------

--
-- Table structure for table `structure_sections`
--

CREATE TABLE `structure_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `common_id` bigint(20) UNSIGNED NOT NULL COMMENT 'FK to common (structure)',
  `name` varchar(100) NOT NULL,
  `order` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `structure_sections`
--

INSERT INTO `structure_sections` (`id`, `common_id`, `name`, `order`, `created_at`, `updated_at`) VALUES
(1, 33, 'Struktur Inti', 1, '2026-06-12 18:51:22', '2026-06-12 18:51:22'),
(4, 35, 'Majelis Pembimbing (Pembina)', 1, '2026-06-16 09:07:24', '2026-06-16 09:07:24'),
(5, 35, 'Pengurus Harian OSIS', 2, '2026-06-16 09:07:24', '2026-06-16 09:07:24'),
(6, 35, 'Seksi Bidang Keimanan & Ketaqwaan', 3, '2026-06-16 09:07:24', '2026-06-16 09:07:24'),
(7, 35, 'Seksi Bidang Teknologi & Informasi', 4, '2026-06-16 09:07:24', '2026-06-16 09:07:24'),
(8, 37, 'Majelis Pembimbing Gugus Depan (Kamabigus)', 1, '2026-06-16 09:07:24', '2026-06-16 09:07:24'),
(9, 37, 'Dewan Ambalan (Penegak)', 2, '2026-06-16 09:07:24', '2026-06-16 09:07:24'),
(10, 38, 'Pembina PMR', 1, '2026-06-16 09:07:24', '2026-06-16 09:07:24'),
(11, 38, 'Pengurus Harian PMR', 2, '2026-06-16 09:07:24', '2026-06-16 09:07:24'),
(12, 258, 'Dewan Pembina', 1, '2026-06-16 09:29:46', '2026-06-16 09:29:46'),
(13, 258, 'Dewan Pengawas', 2, '2026-06-16 09:29:46', '2026-06-16 09:29:46'),
(14, 258, 'Pengurus Harian', 3, '2026-06-16 09:29:46', '2026-06-16 09:29:46'),
(15, 259, 'Guru Mata Pelajaran Umum', 1, '2026-06-17 09:53:03', '2026-06-17 09:53:03'),
(16, 259, 'Guru Produktif', 2, '2026-06-17 09:53:03', '2026-06-17 09:53:03');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `photo` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL DEFAULT 'male',
  `birth_place` varchar(100) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `kelas_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jurusan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `description` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `nis`, `nisn`, `photo`, `gender`, `birth_place`, `birth_date`, `address`, `phone`, `email`, `kelas_id`, `jurusan_id`, `order`, `is_active`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Faisal Rahman', '12021001', '0061234561', 'students/student_6a307166707242.28297100.jpg', 'male', 'Bandung', '2008-04-12', 'Jl. Kebon Waru No. 12, Bandung', '08987654321', 'faisal.r@gmail.com', 13, 1, 1, 1, 'Ketua OSIS Periode 2024/2025\nJuara 1 Lomba Web Design Tingkat Kota Bandung 2024', 1, 1, '2026-06-11 21:12:53', '2026-06-15 14:40:54'),
(2, 'Aura Nabila', '12021002', '0061234562', 'students/dummy.jpg', 'female', 'Cimahi', '2007-09-21', 'Perum Permata Indah Blok C4, Cimahi', '08987654322', 'aura.n@gmail.com', 14, 1, 2, 1, 'Anggota Ekstrakurikuler Paskibra\nJuara Harapan 1 Lomba Pidato Bahasa Inggris 2024', 1, 1, '2026-06-11 21:12:53', '2026-06-11 21:12:53'),
(3, 'Bintang Pratama', '12021003', '0061234563', 'students/dummy.jpg', 'male', 'Bandung', '2009-01-15', 'Jl. Gatot Subroto No. 90, Bandung', '08987654323', 'bintang.p@gmail.com', 11, 2, 3, 1, 'Anggota Pramuka Penegak Bantara\nJuara 3 Lomba Jaringan Mikrotik Tingkat Provinsi 2025', 1, 1, '2026-06-11 21:12:53', '2026-06-11 21:12:53');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `nip` varchar(30) DEFAULT NULL COMMENT 'Nomor Induk Pegawai',
  `photo` varchar(255) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `birth_place` varchar(100) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `jenis` enum('guru','tendik') NOT NULL DEFAULT 'guru' COMMENT 'guru = Guru, tendik = Tenaga Kependidikan',
  `bidang_studi` varchar(150) DEFAULT NULL COMMENT 'Mata pelajaran atau bidang keahlian',
  `pendidikan` varchar(100) DEFAULT NULL COMMENT 'Pendidikan terakhir: S1, S2, dll',
  `status_kepegawaian` enum('PNS','PPPK','Honorer','GTT') DEFAULT NULL,
  `jurusan_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'FK ke common.id (table_name=jurusan), untuk guru yang terikat jurusan',
  `order` smallint(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Urutan tampil',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `description` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `nip`, `photo`, `gender`, `birth_place`, `birth_date`, `address`, `phone`, `email`, `jabatan`, `jenis`, `bidang_studi`, `pendidikan`, `status_kepegawaian`, `jurusan_id`, `order`, `is_active`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Budi Santoso, S.Pd., M.Kom.', '198005152005011001', 'teachers/teacher_6a336a632bab50.68730765.jpg', 'male', 'Bandung', '1980-05-15', 'Jl. Merdeka No. 123, Bandung', '081234567890', 'budi.santoso@smk.sch.id', 'Kepala Kompetensi Keahlian RPL', 'guru', 'Pemrograman Web dan Perangkat Bergerak', 'S2 Ilmu Komputer', 'PNS', NULL, 0, 1, 'Guru Produktif RPL', 1, 1, '2026-06-11 21:12:53', '2026-06-17 20:47:47'),
(2, 'Siti Aminah, S.Kom.', '198508202010012002', NULL, 'female', 'Jakarta', '1985-08-20', 'Jl. Gatot Subroto No. 45, Bandung', '081234567891', 'siti.aminah@smk.sch.id', 'Guru Produktif', 'guru', 'Basis Data', 'S1 Teknik Informatika', 'PPPK', NULL, 0, 1, 'Wali Kelas X RPL 1', 1, 1, '2026-06-11 21:12:53', '2026-06-11 21:29:50'),
(3, 'Deni Ramdhani', '', NULL, 'male', 'Cimahi', '1978-03-10', 'Jl. Ahmad Yani No. 67, Cimahi', '081234567892', 'deni.ramdhani@smk.sch.id', 'Kepala Tata Usaha', 'tendik', '', 'D3 Administrasi Bisnis', 'Honorer', NULL, 0, 1, 'Staf Tata Usaha Bidang Kepegawaian', 1, 1, '2026-06-11 21:12:53', '2026-06-11 21:29:50'),
(5, 'Rini Susanti, S.Pd.', '198706122019032001', 'teachers/dummy.jpg', 'female', 'Bandung', '1987-06-12', 'Jl. Kopo Permai No. 34, Bandung', '081334567890', 'rini.susanti@smk.sch.id', 'Guru Mapel Matematika', 'guru', 'Matematika', 'S1 Pendidikan Matematika', 'PPPK', NULL, 0, 1, 'Guru PPPK bidang Matematika', 1, 1, '2026-06-17 09:53:03', '2026-06-17 09:53:03'),
(6, 'Eko Prasetyo, S.Kom.', '199003182019031002', 'teachers/dummy.jpg', 'male', 'Surabaya', '1990-03-18', 'Jl. Antapani No. 56, Bandung', '081334567891', 'eko.prasetyo@smk.sch.id', 'Guru Produktif RPL', 'guru', 'Rekayasa Perangkat Lunak', 'S1 Teknik Informatika', 'PPPK', NULL, 0, 1, 'Guru PPPK Produktif RPL', 1, 1, '2026-06-17 09:53:03', '2026-06-17 09:53:03'),
(7, 'Nur Hidayah, S.Pd.', '199201052020012001', 'teachers/dummy.jpg', 'female', 'Bogor', '1992-01-05', 'Jl. Pasteur Permai Blok A2, Bandung', '081334567892', 'nur.hidayah@smk.sch.id', 'Guru Bahasa Indonesia', 'guru', 'Bahasa Indonesia', 'S1 Pendidikan Bahasa Indonesia', 'PPPK', NULL, 0, 1, 'Guru PPPK bidang Bahasa Indonesia', 1, 1, '2026-06-17 09:53:03', '2026-06-17 09:53:03');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL DEFAULT 5,
  `content` text NOT NULL,
  `order` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `role`, `photo`, `rating`, `content`, `order`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Prof. Dr. Ir. H. Herman Subarjah, M.Si.', 'Guru Besar Universitas Pendidikan Indonesia', 'testimonials/testimonial_6a37009ba918f3.66046648.jpg', 5, 'Kerjasama riset dan pengabdian masyarakat kami dengan sekolah ini menunjukkan bahwa kompetensi teknis dan karakter siswa sangat unggul dan berstandar nasional.', 1, 1, 1, 1, '2026-06-16 08:31:16', '2026-06-20 14:05:31'),
(2, 'Ir. Budi Rahardjo, M.Sc., Ph.D.', 'Praktisi IT & Dosen Sekolah Teknik Elektro dan Informatika ITB', 'testimonials/testimonial-02.png', 5, 'Lulusan dari program Rekayasa Perangkat Lunak sekolah ini memiliki logika pemrograman yang matang dan sangat siap menghadapi dinamika perkuliahan IT.', 2, 1, 1, 1, '2026-06-16 08:31:16', '2026-06-16 08:31:16'),
(3, 'H. Rahmat Hidayat, M.B.A.', 'Orang Tua Siswa (Kelas XII RPL 1)', 'testimonials/testimonial-03.png', 5, 'Fasilitas belajar yang sangat modern dan lingkungan sekolah yang religius membuat saya sangat yakin menyekolahkan anak saya di sini. Terbukti anak saya sudah bisa magang di startup ternama.', 3, 1, 1, 1, '2026-06-16 08:31:16', '2026-06-16 08:31:16'),
(4, 'Sofia Lestari, S.E.', 'Manager HRD PT GoTo Gojek Tokopedia Tbk', 'testimonials/testimonial-04.png', 5, 'Kami telah merekrut beberapa alumni dari jurusan Akuntansi dan RPL. Mereka memiliki etos kerja yang tinggi, cepat beradaptasi, dan skill teknis yang mumpuni.', 4, 1, 1, 1, '2026-06-16 08:31:16', '2026-06-16 08:31:16'),
(5, 'Drs. H. Wahyudin, M.Pd.', 'Pengawas SMK Dinas Pendidikan Provinsi Jawa Barat', 'testimonials/testimonial-05.png', 5, 'Sekolah ini konsisten menjadi role model bagi sekolah kejuruan lainnya di Jawa Barat dalam penerapan kurikulum merdeka dan link and match dengan dunia industri.', 5, 1, 1, 1, '2026-06-16 08:31:16', '2026-06-16 08:31:16'),
(6, 'Anita Wulandari, S.Psi.', 'Orang Tua Siswa (Kelas XI TJKT)', 'testimonials/testimonial-06.png', 5, 'Sistem pendidikan karakter dan kedisiplinan di sekolah ini sangat luar biasa. Anak saya menunjukkan perubahan sikap yang lebih mandiri, sopan, dan bertanggung jawab sejak masuk ke sini.', 6, 1, 1, 1, '2026-06-16 08:31:16', '2026-06-16 08:31:16'),
(7, 'Hendra Wijaya, S.T.', 'Chief Technology Officer PT Telkom Sigma', 'testimonials/testimonial-07.png', 5, 'Siswa prakerin dari kompetensi keahlian Teknik Jaringan Komputer dan Telekomunikasi di sini memiliki pemahaman infrastruktur jaringan yang sangat baik dan bersertifikasi industri.', 7, 1, 1, 1, '2026-06-16 08:31:16', '2026-06-16 08:31:16'),
(8, 'Dr. Kartika Sari, M.Si.', 'Ketua Komite Sekolah', 'testimonials/testimonial-08.png', 5, 'Transparansi tata kelola sekolah dan sinergi yang harmonis antara sekolah, komite, dan orang tua menjadi pilar penting keberhasilan berbagai program unggulan.', 8, 1, 1, 1, '2026-06-16 08:31:16', '2026-06-16 08:31:16'),
(9, 'M. Yusuf Firmansyah', 'Alumni Angkatan 2017 / Owner Start-Up \"Creative Studio\"', 'testimonials/testimonial-09.png', 5, 'Pendidikan kewirausahaan di SMK ini memberikan saya keberanian dan bekal operasional untuk merintis bisnis kreatif sendiri langsung setelah lulus sekolah.', 9, 1, 1, 1, '2026-06-16 08:31:16', '2026-06-16 08:31:16'),
(10, 'Farida Nuraini, Ak.', 'Senior Auditor Kantor Akuntan Publik (KAP) Tanubrata', 'testimonials/testimonial-10.png', 5, 'Kemampuan praktis siswa jurusan Akuntansi dalam mengoperasikan software akuntansi Accurate dan MYOB sangat rapi dan sesuai dengan standar kebutuhan industri keuangan saat ini.', 10, 1, 1, 1, '2026-06-16 08:31:16', '2026-06-16 08:31:16'),
(11, 'Rian Hidayat, M.Kom.', 'Alumni Angkatan 2019 / Senior Engineer Shopee', 'testimonials/testimonial-11.png', 5, 'Saya mendapatkan bekal pondasi coding yang sangat kokoh dari guru-guru hebat di sekolah ini. Pengalaman praktek kerjanya membuka wawasan industri sejak dini.', 11, 1, 1, 1, '2026-06-16 08:31:16', '2026-06-16 08:31:16'),
(12, 'Dr. H. Ahmad Dahlan, M.Ag.', 'Tokoh Masyarakat & Komite Bidang Keagamaan', 'testimonials/testimonial-12.png', 5, 'Program pembiasaan keagamaan seperti shalat dhuha berjamaah dan tahfidz Quran di sekolah ini berhasil mencetak lulusan yang cerdas secara intelektual dan berakhlak mulia.', 12, 1, 1, 1, '2026-06-16 08:31:16', '2026-06-16 08:31:16'),
(13, 'Diana Putri, S.E.', 'Orang Tua Siswa (Kelas X AKL 2)', 'testimonials/testimonial-01.png', 4, 'Sangat puas dengan pelayanan administrasi sekolah dan cara guru berkomunikasi memantau perkembangan belajar anak lewat buku penghubung online.', 13, 1, 1, 1, '2026-06-16 08:31:16', '2026-06-16 08:31:16'),
(14, 'Taufik Hidayat, S.Kom.', 'IT Infrastructure Specialist PT Indosat Ooredoo Hutchison', 'testimonials/testimonial-02.png', 5, 'Kurikulum jaringan Cisco dan Mikrotik yang diintegrasikan dengan materi sekolah benar-benar memberikan percepatan karir bagi siswa lulusan TJKT.', 14, 1, 1, 1, '2026-06-16 08:31:16', '2026-06-16 08:31:16'),
(15, 'Sri Wahyuni, M.Pd.', 'Kepala Balai Penjaminan Mutu Pendidikan (BPMP) Jabar', 'testimonials/testimonial-03.png', 5, 'Sekolah ini secara konsisten menunjukkan rapor pendidikan dengan predikat sangat baik dan meraih berbagai penghargaan inovasi pembelajaran di tingkat regional.', 15, 1, 1, 1, '2026-06-16 08:31:16', '2026-06-16 08:31:16');

-- --------------------------------------------------------

--
-- Table structure for table `transparency`
--

CREATE TABLE `transparency` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('anggaran','kinerja') NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `file` varchar(255) NOT NULL,
  `year` int(11) DEFAULT NULL,
  `period` varchar(50) DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `custom1` varchar(255) DEFAULT NULL,
  `custom2` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `role` enum('SuperAdmin','Admin','Operator') NOT NULL DEFAULT 'Operator',
  `jurusan_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'FK ke common.id (table_name=jurusan) — diisi jika role = Admin',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `email`, `phone`, `photo`, `role`, `jurusan_id`, `is_active`, `last_login`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Andhika', '$2y$12$z5gPTJ9HbWLmaKMeZsUkmuSYej.lhf49y4wjxO7vwGUSuCj.pQiqW', 'Andhika Aulia', 'admin@smk.sch.id', '6281312901432', 'users/avatar_6a2b8899a86636.03657490.jpg', 'SuperAdmin', NULL, 1, '2026-06-26 12:19:53', 'NOdsIX4avAEUfCI5U3xX5wBqNhq0lVMy4GyCOr2ZpPsHzJmOODl22iACOJBn', '2026-06-11 21:12:52', '2026-06-26 05:19:53'),
(2, 'Agus', '$2y$12$EalvZ1nJPZjmTP9aWZyAJ.FQ08LO/LQtis8BRL2dEzoiY.XBWYGre', 'Agus Sudrajat', 'agus@smkpgrisubang.sch.id', '0817676546532', 'users/avatar_6a2bfeee748e98.20017469.jpg', 'Admin', 1, 1, '2026-06-13 12:25:15', 'vKNKy3nPYr3GPIKIWwhYxLXQFgq7MJz9474yruiRM5bklflgvSTDHGNs9Pdh', '2026-06-12 05:43:26', '2026-06-13 05:25:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `achievements_kategori_id_foreign` (`kategori_id`),
  ADD KEY `achievements_tingkat_id_foreign` (`tingkat_id`),
  ADD KEY `achievements_news_id_foreign` (`news_id`),
  ADD KEY `achievements_created_by_foreign` (`created_by`),
  ADD KEY `achievements_updated_by_foreign` (`updated_by`),
  ADD KEY `achievements_jurusan_id_foreign` (`jurusan_id`);

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `announcement_slug_unique` (`slug`),
  ADD KEY `announcement_created_by_foreign` (`created_by`),
  ADD KEY `announcement_updated_by_foreign` (`updated_by`),
  ADD KEY `announcement_period_index` (`period`),
  ADD KEY `announcement_jurusan_id_foreign` (`jurusan_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `common`
--
ALTER TABLE `common`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `common_table_name_key1_unique` (`table_name`,`key1`),
  ADD KEY `common_created_by_foreign` (`created_by`),
  ADD KEY `common_updated_by_foreign` (`updated_by`),
  ADD KEY `common_table_name_key1_index` (`table_name`,`key1`),
  ADD KEY `common_table_active_idx` (`table_name`,`is_active`),
  ADD KEY `common_table_order_idx` (`table_name`,`order`);

--
-- Indexes for table `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `downloads_category_id_foreign` (`category_id`),
  ADD KEY `downloads_jurusan_id_foreign` (`jurusan_id`),
  ADD KEY `downloads_created_by_foreign` (`created_by`),
  ADD KEY `downloads_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `events_slug_unique` (`slug`),
  ADD KEY `events_created_by_foreign` (`created_by`),
  ADD KEY `events_updated_by_foreign` (`updated_by`),
  ADD KEY `events_period_index` (`period`),
  ADD KEY `events_category_id_foreign` (`category_id`),
  ADD KEY `events_jurusan_id_foreign` (`jurusan_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `galleries_slug_unique` (`slug`),
  ADD KEY `galleries_upload_by_foreign` (`upload_by`),
  ADD KEY `galleries_category_id_foreign` (`category_id`),
  ADD KEY `galleries_jurusan_id_foreign` (`jurusan_id`);

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_images_gallery_id_foreign` (`gallery_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_page_id_foreign` (`page_id`),
  ADD KEY `menus_structure_id_foreign` (`structure_id`),
  ADD KEY `menus_created_by_foreign` (`created_by`),
  ADD KEY `menus_updated_by_foreign` (`updated_by`),
  ADD KEY `menus_parent_id_index` (`parent_id`),
  ADD KEY `menus_location_index` (`location`),
  ADD KEY `menus_order_index` (`order`),
  ADD KEY `menus_is_active_index` (`is_active`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`),
  ADD KEY `news_created_by_foreign` (`created_by`),
  ADD KEY `news_period_index` (`period`),
  ADD KEY `news_updated_by_foreign` (`updated_by`),
  ADD KEY `news_jurusan_id_foreign` (`jurusan_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`),
  ADD KEY `pages_created_by_foreign` (`created_by`),
  ADD KEY `pages_updated_by_foreign` (`updated_by`),
  ADD KEY `pages_structure_common_id_foreign` (`structure_common_id`),
  ADD KEY `pages_jurusan_id_foreign` (`jurusan_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `programs_kode_unique` (`kode`);

--
-- Indexes for table `secretariat`
--
ALTER TABLE `secretariat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `secretariat_created_by_foreign` (`created_by`),
  ADD KEY `secretariat_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `security_logs`
--
ALTER TABLE `security_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `security_logs_user_id_foreign` (`user_id`),
  ADD KEY `security_logs_ip_address_index` (`ip_address`),
  ADD KEY `security_logs_created_at_index` (`created_at`);

--
-- Indexes for table `security_settings`
--
ALTER TABLE `security_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `security_settings_key_unique` (`key`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_created_by_foreign` (`created_by`),
  ADD KEY `settings_updated_by_foreign` (`updated_by`),
  ADD KEY `settings_active_period_index` (`active_period`);

--
-- Indexes for table `structural_members`
--
ALTER TABLE `structural_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `structure_members`
--
ALTER TABLE `structure_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `structure_members_common_id_index` (`common_id`),
  ADD KEY `structure_members_member_id_index` (`member_id`),
  ADD KEY `structure_members_period_index` (`period`),
  ADD KEY `structure_members_is_active_index` (`is_active`),
  ADD KEY `structure_members_section_id_foreign` (`section_id`),
  ADD KEY `idx_structure_member_poly_sec` (`common_id`,`section_id`,`member_id`,`member_type`,`period`);

--
-- Indexes for table `structure_sections`
--
ALTER TABLE `structure_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `structure_sections_common_id_foreign` (`common_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `members_created_by_foreign` (`created_by`),
  ADD KEY `members_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transparency`
--
ALTER TABLE `transparency`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transparency_created_by_foreign` (`created_by`),
  ADD KEY `transparency_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `common`
--
ALTER TABLE `common`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;

--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `secretariat`
--
ALTER TABLE `secretariat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `security_logs`
--
ALTER TABLE `security_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `security_settings`
--
ALTER TABLE `security_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `structural_members`
--
ALTER TABLE `structural_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `structure_members`
--
ALTER TABLE `structure_members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `structure_sections`
--
ALTER TABLE `structure_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `transparency`
--
ALTER TABLE `transparency`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `achievements`
--
ALTER TABLE `achievements`
  ADD CONSTRAINT `achievements_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `achievements_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `programs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `achievements_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `common` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `achievements_news_id_foreign` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `achievements_tingkat_id_foreign` FOREIGN KEY (`tingkat_id`) REFERENCES `common` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `achievements_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `announcement`
--
ALTER TABLE `announcement`
  ADD CONSTRAINT `announcement_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `announcement_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `programs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `announcement_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `common`
--
ALTER TABLE `common`
  ADD CONSTRAINT `common_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `common_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `downloads`
--
ALTER TABLE `downloads`
  ADD CONSTRAINT `downloads_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `common` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `downloads_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `downloads_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `programs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `downloads_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `common` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `events_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `events_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `programs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `events_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `galleries`
--
ALTER TABLE `galleries`
  ADD CONSTRAINT `galleries_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `common` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `galleries_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `programs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `galleries_upload_by_foreign` FOREIGN KEY (`upload_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD CONSTRAINT `gallery_images_gallery_id_foreign` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menus`
--
ALTER TABLE `menus`
  ADD CONSTRAINT `menus_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `menus_page_id_foreign` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `menus_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menus_structure_id_foreign` FOREIGN KEY (`structure_id`) REFERENCES `common` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `menus_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `news_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `programs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `news_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pages_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `programs` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pages_structure_common_id_foreign` FOREIGN KEY (`structure_common_id`) REFERENCES `common` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pages_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `secretariat`
--
ALTER TABLE `secretariat`
  ADD CONSTRAINT `secretariat_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `secretariat_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `security_logs`
--
ALTER TABLE `security_logs`
  ADD CONSTRAINT `security_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `settings_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `structure_members`
--
ALTER TABLE `structure_members`
  ADD CONSTRAINT `structure_members_common_id_foreign` FOREIGN KEY (`common_id`) REFERENCES `common` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `structure_members_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `structure_members_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `structure_sections` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `structure_sections`
--
ALTER TABLE `structure_sections`
  ADD CONSTRAINT `structure_sections_common_id_foreign` FOREIGN KEY (`common_id`) REFERENCES `common` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `members_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `members_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `transparency`
--
ALTER TABLE `transparency`
  ADD CONSTRAINT `transparency_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transparency_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
