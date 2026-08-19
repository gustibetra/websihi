-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 14, 2026 at 02:20 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.26

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
  `id` bigint UNSIGNED NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'siswa',
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `achiever` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `student_ids` text COLLATE utf8mb4_general_ci,
  `jurusan_id` bigint UNSIGNED DEFAULT NULL,
  `kategori_id` bigint UNSIGNED DEFAULT NULL,
  `tingkat_id` bigint UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL,
  `organizer` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `news_id` bigint UNSIGNED DEFAULT NULL,
  `photo` text COLLATE utf8mb4_general_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`id`, `type`, `title`, `achiever`, `student_ids`, `jurusan_id`, `kategori_id`, `tingkat_id`, `date`, `organizer`, `description`, `news_id`, `photo`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(6, 'sekolah', 'Piagam Penghargaan Keteladanan', 'Subang International Hotel Institute', NULL, NULL, 117, 129, '2018-04-02', 'Wakil Bupati Subang', 'SIHI mendapatkan piagam prestasi penghargaan dari wakil bupati subang dengan kategori Juara III Apresiasi Keteladanan Lembaga Tingkat Jawa Barat ', NULL, 'achievements/IG8CaBClPWDOoWyQvhXZFiWMKFmJYanI6uDCFEAz.jpg', 1, 1, 1, '2026-06-15 13:50:49', '2026-08-03 04:22:35'),
(11, 'sekolah', 'Juara 1 Kategori Perhotelan', 'Subang International Hotel Institute', NULL, NULL, 116, 127, '2017-04-10', 'Kepala Dinas Pendidikan Dan Kebudayaan Kabupaten Subang', 'SIHI mendapatkan Piagam Prestasi Penghargaan dari Kepala Dinas Pendidikan Dan Kebudayaan Kabupaten Subang dengan kategori lomba : Perhotelan, Dalam rangka kegiatan apresiasi \"Lembaga PAUD dan Kursus Dan Pelatihan\" Berprestasi tingkat kabupaten Subang', NULL, 'achievements/9Mws48CTnIvx1OrzeY8qfwA5CJEt3ZmSXuROdbql.jpg', 1, 1, 1, '2026-08-03 04:50:23', '2026-08-03 05:03:32'),
(12, 'sekolah', 'Juara III Kategori Pariwisata', 'Subang International Hotel Institute', NULL, NULL, 119, 129, '2017-05-22', 'Kepala Dinas Pendidikan Provinsi Jawa Barat', 'Sihi Mendapatkan Piagam Prestasi penghargaan dari Kepala Dinas Pendidikan Provinsi Jawa Barat, dengan kategori Pariwisata, Pada Apresiasi Lembaga Kursus dan Pelatihan Berprestasi Tingkat Provinsi Jawa Barat Tahun 2017 Bekerjasama dengan DPD HIPKI Jawa Barat Yang Dilaksanakan Pada Tanggal 15 s.d 20 Mei 2017.', NULL, 'achievements/0Wv12SIC1UBkSacY9pNV0tRBXooKuSn2ejhjsS2M.jpg', 1, 1, 1, '2026-08-03 05:00:21', '2026-08-03 05:01:42'),
(13, 'sekolah', 'Juara I Kategori Pariwisata', 'Subang International Hotel Institute', NULL, NULL, 119, 129, '2017-04-29', 'Kepala Dinas Pendidikan Provinsi Jawa Barat', 'Sihi Mendapatkan Piagam Prestasi penghargaan dari Kepala Dinas Pendidikan Provinsi Jawa Barat, dengan kategori Pariwisata, Pada Apresiasi Lembaga Kursus dan Pelatihan Berprestasi Tingkat Provinsi Jawa Barat Tahun 2017 Bekerjasama dengan DPD HIPKI Jawa Barat Yang Dilaksanakan Pada Tanggal 17 s.d 27 April 2017.', NULL, 'achievements/NcNMExudvVT0yEuPJn2PM0SRSUO6wu2an9x3QftZ.jpg', 1, 1, NULL, '2026-08-03 05:07:50', '2026-08-03 05:07:50'),
(14, 'sekolah', 'Stand Terinovatif dan Terfavorit', 'Subang International Hotel Institute', NULL, NULL, NULL, 130, '2013-12-01', 'Kementerian Pendidikan dan Kebudayaan Direktorat Jenderal Pendidikan Anak Usia Dini, Nonformal dan Informal Direktorat Pembinaan Kursus dan Pelatihan', 'SIHI mendapatkan piagam prestasi penghargaan di makasar dengan kategori Stand Terinovatif dan Terfavorit, yang di selenggarakan oleh Kementerian Pendidikan dan Kebudayaan Direktorat Jenderal Pendidikan Anak Usia Dini, Nonformal dan Informal Direktorat Pembinaan Kursus dan Pelatihan, Pada Pameran Kursus dan Pelatihan Tahun 2013 yang bbertempat di Mall Ratu Indah Makassar, 29 November s.d. 1 Desember 2013', NULL, 'achievements/dUtecL759pw3wHJKZEy0BrWuhixB138EImu64A0S.jpg;achievements/tXvizIYjYOM7YwBSfEWGAJMfHJ2jHbiHnmqKG1fA.jpg', 1, 1, NULL, '2026-08-03 05:17:00', '2026-08-03 05:17:00'),
(15, 'sekolah', 'Juara III Pariwisata', 'Subang International Hotel Institute', NULL, NULL, 119, 129, '2016-08-12', 'Gubernur Jawa Barat', 'SIHI mendapatkan piagam prestasi Penghargaan dalam lomba lembaga Kursus Berprestasi Kategori Pariwisata Jenis Keterampilan Perhotelan Tahun 2016 yang diselenggarakan oleh Gubernur Jawa Barat.', NULL, 'achievements/HHmUSwl2NSCgfBtbnkkU1rFyAlsalNqx0FLZ6CVg.jpg', 1, 1, NULL, '2026-08-03 05:24:16', '2026-08-03 05:24:16');

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'male',
  `birth_place` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahun_lulus` varchar(4) COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_kerja` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jabatan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status_alumni` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bidang_pekerjaan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `testimoni` text COLLATE utf8mb4_general_ci,
  `is_inspiratif` tinyint(1) NOT NULL DEFAULT '0',
  `jurusan_id` bigint UNSIGNED DEFAULT NULL,
  `order` smallint UNSIGNED NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`id`, `name`, `photo`, `gender`, `birth_place`, `birth_date`, `address`, `phone`, `email`, `tahun_lulus`, `tempat_kerja`, `jabatan`, `status_alumni`, `bidang_pekerjaan`, `testimoni`, `is_inspiratif`, `jurusan_id`, `order`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(17, 'DANDI ARIPUDIN', 'alumni/alumni_6a7973c32a8b23.26871332.jpg', 'male', '', NULL, '', '', '', '2020', 'Taaktana a Luxury Collection Resort and Spa Labuan Bajo', 'Room Attendant', 'Bekerja', 'Room Attendant ', 'OJT pada saat COVID 19 magang dari Aston Marina Ancol sehingga sempat terhenti. Tapi SIHI terus mendampingi saya hingga akhirnya saya melanjutkan ke GH Universal dan mendapatkan pekerjaan di le Meridien Fairways Dubai dan saat ini di Labuan Bajo', 1, NULL, 0, 1, 1, 1, '2026-08-10 06:46:27', '2026-08-10 06:51:40'),
(18, 'HERMAWAN', 'alumni/alumni_6a79755e4f1714.31363922.jpg', 'male', '', NULL, '', '', '', '2020', 'Le Meridien Hotel Dubai', 'Room Attendant', 'Bekerja', 'Room Attendant ', 'Terima kasih SIHI! ini tahun ketiga saya di Le Meridien Hotel Dubai sebelum tahun depan lanjut ke Kapal Pesiar :)', 1, NULL, 0, 1, 1, 1, '2026-08-10 06:53:18', '2026-08-10 06:54:28'),
(19, 'SEPTIANA PRATAMA', 'alumni/alumni_6a79759c584604.97970830.jpg', 'male', '', NULL, '', '', '', '2018', 'Movenpick Hotel Jakarta', 'Reservation Supervisor', 'Bekerja', 'Reservation Supervisor', 'Setelah 5 tahun lulus dari SIHI saya diamanahi untuk menjadi seorang supervisor di hotel bintang 5. Terima kasih yang sebesar-besarnya kepada SIHI yang sudah membimbing saya.', 1, NULL, 0, 1, 1, NULL, '2026-08-10 06:54:20', '2026-08-10 06:54:20'),
(20, 'WIDANINGSIH', 'alumni/alumni_6a7975ed5c76b9.95949477.jpg', 'female', '', NULL, '', '', '', '2021', 'Pullman Ciawi Vimala Hills Hotel and Resort Bogor', 'Waiter', 'Bekerja', 'Waiter', 'Belajar di SIHI itu menyenangkan banget ~ Saat saya magang, saya ditempatkan di Holiday Inn Jababeka Cikarang dan tidak lama ditarik kerja dan mendapatkan Best Employee. Saya saat ini fokus bimbingan karir untuk ke Kapal Pesiar dan Hotel Luar Negeri. Sambil menunggu, saya melanjutkan karir di Pullman Ciawi Vimala Hills Hotel and Resort di Bogor', 1, NULL, 0, 1, 1, 1, '2026-08-10 06:55:41', '2026-08-10 06:56:00'),
(21, 'M. AZIS RIJALDI', 'alumni/alumni_6a7976a4717b08.40054875.jpg', 'male', '', NULL, '', '', '', '2021', 'Carnival Cruise', 'Room Attendant', 'Bekerja', 'Room Attendant ', 'Saya belajar dari 0 yang gak bisa apa - apa dan gak tahu apa - apa, dan akhirnya bisa sampai di titik ini. Terima kasih SIHI atas bimbingannya. ', 1, NULL, 0, 1, 1, NULL, '2026-08-10 06:58:44', '2026-08-10 06:58:44'),
(22, 'ALIP MAULANA', 'alumni/alumni_6a7976ee689f71.06998363.jpg', 'male', '', NULL, '', '', '', '2021', 'P&O Cruise Line', 'Chef De Partie', 'Bekerja', 'Chef De Partie', 'Lulus SMA saya ingin melanjutkan ke kapal pesiar dan saya mulai menemukan passion saya, yaitu Cook. Tidak mudah untuk bisa di titik ini dan SIHI selalu mendampingi di saat ada kesulitan.', 1, NULL, 0, 1, 1, NULL, '2026-08-10 06:59:58', '2026-08-10 06:59:58'),
(23, 'MUHAMAD KHAIRUL FIKRI', 'alumni/alumni_6a79775ea26868.22866108.jpg', 'male', '', NULL, '', '', '', '2020', ' Virgin Voyages Cruise Line', 'Room Attendant', 'Bekerja', 'Room Attendant ', 'Bangga menjadi alumni SIHI. Pembelajarannya lebih banyak praktek jadi ketika bekerja di perhotelan atau kapal pesiar sudah siap secara fisik dan mental.', 1, NULL, 0, 1, 1, 1, '2026-08-10 07:01:50', '2026-08-10 07:03:05'),
(24, 'ANGGI GOPIKI', 'alumni/alumni_6a7977a1234088.17470628.jpg', 'male', '', NULL, '', '', '', '2020', 'Celebrity Cruiship', 'Room Attendant', 'Bekerja', 'Room Attendant ', 'Begitu dipermudahnya perjalanan saya sebagai pelaut. Terima kasih SIHI atas ilmu-ilmu yang sudah diberikan, sangat bermanfaat ilmunya', 1, NULL, 0, 1, 1, NULL, '2026-08-10 07:02:57', '2026-08-10 07:02:57');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci,
  `excerpt` text COLLATE utf8mb4_general_ci,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `jurusan_id` bigint UNSIGNED DEFAULT NULL,
  `period` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Period (contoh: "2024-2029") - optional, jika NULL berarti pengumuman bersifat umum',
  `attachment` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `custom1` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `custom2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `custom3` text COLLATE utf8mb4_general_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
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
  `key` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_general_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1781991692),
('356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1781991692;', 1781991692),
('portal_sekolah_cache_356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1786348791),
('portal_sekolah_cache_356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1786348791;', 1786348791);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `common`
--

CREATE TABLE `common` (
  `id` bigint UNSIGNED NOT NULL,
  `table_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `key1` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `key2` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `key3` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data1` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data3` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data4` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data5` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data6` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data7` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data8` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data9` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data10` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data11` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data12` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data13` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data14` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `data15` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date1` date DEFAULT NULL,
  `date2` date DEFAULT NULL,
  `date3` date DEFAULT NULL,
  `date4` date DEFAULT NULL,
  `text1` text COLLATE utf8mb4_general_ci,
  `text2` text COLLATE utf8mb4_general_ci,
  `text3` text COLLATE utf8mb4_general_ci,
  `text4` text COLLATE utf8mb4_general_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Status aktif/nonaktif record',
  `order` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Urutan tampil',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `common`
--

INSERT INTO `common` (`id`, `table_name`, `key1`, `key2`, `key3`, `data1`, `data2`, `data3`, `data4`, `data5`, `data6`, `data7`, `data8`, `data9`, `data10`, `data11`, `data12`, `data13`, `data14`, `data15`, `date1`, `date2`, `date3`, `date4`, `text1`, `text2`, `text3`, `text4`, `created_by`, `updated_by`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(18, 'kompetensi_keahlian', 'KK001', NULL, NULL, 'Perhotelan', '7', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-08-03 03:50:11'),
(29, 'kurikulum', 'KU001', NULL, NULL, 'Kurikulum Merdeka', NULL, NULL, '2022', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(33, 'structure', 'SK001', 'sekolah', NULL, 'Manajemen Sekolah', '202', NULL, NULL, 'sekolah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>asdasd</p>', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-06-19 06:44:11'),
(34, 'structure', 'SK002', 'sekolah', NULL, 'Komite Sekolah', '6', NULL, NULL, 'sekolah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(35, 'structure', 'OR001', 'organisasi', NULL, 'OSIS 2026/2027', '202', NULL, '1', 'organisasi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>ada desc</p>', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-07-30 04:25:54'),
(36, 'structure', 'OR002', 'organisasi', NULL, 'MPK 2024/2025', '6', NULL, NULL, 'organisasi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(37, 'structure', 'EK001', 'ekskul', NULL, 'Pramuka', '6', NULL, NULL, 'ekskul', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(38, 'structure', 'EK002', 'ekskul', NULL, 'PMR', '6', NULL, NULL, 'ekskul', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(39, 'structure', 'EK003', 'ekskul', NULL, 'Paskibra', '6', NULL, NULL, 'ekskul', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(40, 'structure', 'EK004', 'ekskul', NULL, 'IT Club', '6', '1', NULL, 'ekskul', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(41, 'structure', 'KP001', 'kepanitiaan', NULL, 'Panitia MPLS 2025', '6', NULL, NULL, 'kepanitiaan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(42, 'structure', 'KP002', 'kepanitiaan', NULL, 'Panitia Wisuda 2025', '6', NULL, NULL, 'kepanitiaan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(43, 'jabatan_organisasi', 'JB001', NULL, NULL, 'Direktur Lembaga', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-07-30 09:12:22'),
(44, 'jabatan_organisasi', 'JB002', NULL, NULL, 'Penasehat', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-07-30 09:12:35'),
(45, 'jabatan_organisasi', 'JB003', NULL, NULL, 'Pembina', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-07-30 09:12:43'),
(46, 'jabatan_organisasi', 'JB004', NULL, NULL, 'Sekertaris Direktur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-07-30 09:13:07'),
(47, 'jabatan_organisasi', 'JB005', NULL, NULL, 'Wakil Direktur Bidang keuangan Dan Kesekretariatan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-07-30 09:14:02'),
(48, 'jabatan_organisasi', 'JB006', NULL, NULL, 'Wakil Direktur Bidang Akademik', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-07-30 09:14:35'),
(49, 'jabatan_organisasi', 'JB007', NULL, NULL, 'Wakil Direktur Bidang Marketing Dan Instruktur Bar', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-08-10 02:57:27'),
(50, 'jabatan_organisasi', 'JB008', NULL, NULL, 'Wakil Direktur Bidang Kemahasiswaan Dan Alumni', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-07-30 09:15:42'),
(51, 'jabatan_organisasi', 'JB009', NULL, NULL, 'Asisten Wakil DIrektur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-07-30 09:16:06'),
(52, 'jabatan_organisasi', 'JB010', NULL, NULL, 'Bidang Bahasa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-07-30 09:16:28'),
(53, 'jabatan_organisasi', 'JB011', NULL, NULL, 'Bidang Marketing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-07-30 09:16:39'),
(54, 'jabatan_organisasi', 'JB012', NULL, NULL, 'Bidang Bimbingan Karir', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-07-30 09:16:56'),
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
(69, 'jenis_kerjasama', 'JK001', NULL, NULL, 'On the Job Training', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-07-30 07:18:32'),
(70, 'jenis_kerjasama', 'JK002', NULL, NULL, 'Pengembangan SDM, Pendidikan, Pelatihan, dan Sertifikasi Berbasis SKKNI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-07-30 07:18:55'),
(71, 'jenis_kerjasama', 'JK003', NULL, NULL, 'On the Job Training dan Penyerapan Tenaga  Kerja', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-07-30 07:19:15'),
(72, 'jenis_kerjasama', 'JK004', NULL, NULL, 'Training/PKL dan Informasi penyerapan kerja.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-07-30 07:25:36'),
(73, 'jenis_kerjasama', 'JK005', NULL, NULL, 'Guru Tamu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2026-06-11 21:12:52', '2026-07-30 07:25:40'),
(74, 'jenis_kerjasama', 'JK006', NULL, NULL, 'Sinkronisasi Kurikulum', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2026-06-11 21:12:52', '2026-07-30 07:25:41'),
(75, 'jenis_kerjasama', 'JK007', NULL, NULL, 'Sertifikasi Kompetensi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2026-06-11 21:12:52', '2026-07-30 07:25:44'),
(76, 'jenis_kerjasama', 'JK008', NULL, NULL, 'Kunjungan Industri', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2026-06-11 21:12:52', '2026-07-30 07:25:45'),
(77, 'jenis_kerjasama', 'JK009', NULL, NULL, 'Magang Guru', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2026-06-11 21:12:52', '2026-07-30 07:25:51'),
(83, 'bidang_industri', 'BI001', NULL, NULL, 'Perhotelan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-07-30 07:12:31'),
(84, 'bidang_industri', 'BI002', NULL, NULL, 'Pariwisata', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-07-30 07:16:02'),
(85, 'bidang_industri', 'BI003', NULL, NULL, 'Telekomunikasi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2026-06-11 21:12:52', '2026-07-30 07:16:09'),
(86, 'bidang_industri', 'BI004', NULL, NULL, 'Manufaktur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2026-06-11 21:12:52', '2026-07-30 07:16:16'),
(87, 'bidang_industri', 'BI005', NULL, NULL, 'Otomotif', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2026-06-11 21:12:52', '2026-07-30 07:16:18'),
(88, 'bidang_industri', 'BI006', NULL, NULL, 'Perbankan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2026-06-11 21:12:52', '2026-07-30 07:16:20'),
(89, 'bidang_industri', 'BI007', NULL, NULL, 'Retail', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2026-06-11 21:12:52', '2026-07-30 07:16:23'),
(90, 'bidang_industri', 'BI008', NULL, NULL, 'Digital Marketing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2026-06-11 21:12:52', '2026-07-30 07:16:24'),
(91, 'bidang_industri', 'BI009', NULL, NULL, 'Kuliner & F&B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2026-06-11 21:12:52', '2026-07-30 07:26:01'),
(92, 'bidang_industri', 'BI010', NULL, NULL, 'Hospitality & Pariwisata', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2026-06-11 21:12:52', '2026-07-30 07:26:03'),
(93, 'bidang_industri', 'BI011', NULL, NULL, 'Konstruksi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2026-06-11 21:12:52', '2026-07-30 07:26:05'),
(94, 'bidang_industri', 'BI012', NULL, NULL, 'Kesehatan & Farmasi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2026-06-11 21:12:52', '2026-07-30 07:26:09'),
(95, 'bidang_industri', 'BI013', NULL, NULL, 'Pendidikan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 0, '2026-06-11 21:12:52', '2026-07-30 07:26:11'),
(100, 'fasilitas', 'FS005', NULL, NULL, 'Ruangan Administrasi', 'Lantai 1', NULL, '10', NULL, 'fasilitas/lWgzVsHiKf3V6Brh60Z9Pezi2ZY0oXgEODhqy5c1.jpg;fasilitas/ZHgeOBNEFA9Nh0Ixvp5VISxVlSZH6V4GmdebL3pR.jpg;fasilitas/ciXZpAL4d16YwgQNVfRtLBA6atnD2DV64MJbLfkx.jpg;fasilitas/G2oegHdVGN0hTfMcByufSbGbjsc6jNgAXDJx9Mm5.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>ruangan ini digunakan untuk mengurus pedaftaran, melakukan pembayaran seperti spp dan lain lain.</p>', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(101, 'fasilitas', 'FS006', NULL, NULL, 'Ruangan kelas', 'Lantai 2', NULL, '50', NULL, 'fasilitas/TMXVOHeQN10FWRP8GckeSMjhIn5Y12Q9NdFHPNFj.jpg;fasilitas/CfCcvfz6SEEO8t7kgGDRQjRkSx2ZvlDgdrN8prhk.jpg;fasilitas/nSM2hWoOzK2HMQzX7WaI1NWEhPFL4w5pmhRGP3M5.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>Ruangan kelas yang nyaman dipakai untuk pembelajaran, berbagai fasilitas tersedia yang ada di dalam kelas seperti wifi, ac, serta smart tv led yang dipakai untuk media pembelajaran.</p><p>&nbsp;</p>', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(102, 'sertifikasi', 'SR001', NULL, NULL, 'BNSP - Teknik Jaringan Komputer', NULL, NULL, 'BNSP', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(103, 'sertifikasi', 'SR002', NULL, NULL, 'Mikrotik MTCNA', NULL, NULL, 'Mikrotik', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(104, 'sertifikasi', 'SR003', NULL, NULL, 'Cisco IT Essentials', NULL, NULL, 'Cisco Networking Academy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(105, 'sertifikasi', 'SR004', NULL, NULL, 'Cisco CCNA', NULL, NULL, 'Cisco Networking Academy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(106, 'sertifikasi', 'SR005', NULL, NULL, 'MOS (Microsoft Office Specialist)', NULL, NULL, 'Microsoft', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(107, 'sertifikasi', 'SR006', NULL, NULL, 'AWS Academy Cloud Foundations', NULL, NULL, 'Amazon Web Services', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(108, 'sertifikasi', 'SR007', NULL, NULL, 'Adobe Certified Professional', NULL, NULL, 'Adobe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(109, 'sertifikasi', 'SR008', NULL, NULL, 'TOEIC', NULL, NULL, 'ETS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(110, 'program_unggulan', 'PU001', NULL, NULL, 'IN HOUSE TRAINING', NULL, 'program_unggulan/BqiQx8IchgjkmWMFVhJHVxmistBQFkAYeu0h5klP.jpg', 'Pelatihan Kerja', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Program In House Training ini ditujukan untuk industri yang memerlukan upgrading keahlian Hospitality  dan kompetensi yang dibutukan selama bekerja. Adapun keahlian dan kompetensi yang diberikan adalah \n\n1. Bahasa Inggris\n2. Table Manner\n3. Skill Cleaning Service\n4. Skill Customer Service\n5. Pengolahan makanan dan minuman\n6. Grooming / Beauty Class', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-08-10 01:55:10'),
(111, 'program_unggulan', 'PU002', NULL, NULL, 'Short Course', NULL, 'program_unggulan/3IoKIstqze0wHcS8qTeATpzP7qffFVPfdsgk1X86.jpg', 'Pelatihan Kerja', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Program Short Course ini merupakan program singkat bagi yang ingin bekerja di perhotelan atau kapal pesiar namun sudah memiliki fokus di bidang tertentu. Program ini dilaksanakan selama 8 bulan, yaitu 3 (tiga) bulan pembelajaran di kelas dan 6 (enam) bulan Praktik Kerja Industri /On the Job Training. Adapun bidang yang tersedia adalah : \n1. Housekeeping\n2. Food and Beverage Service\n3. Basic Cooking', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-08-10 01:56:51'),
(116, 'kategori_prestasi', 'GP001', NULL, NULL, 'Akademik', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(117, 'kategori_prestasi', 'GP002', NULL, NULL, 'Non Akademik', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(118, 'kategori_prestasi', 'GP003', NULL, NULL, 'Kejuruan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-11 21:12:52', '2026-06-11 21:12:52'),
(119, 'kategori_prestasi', 'GP004', NULL, NULL, 'Pariwisata', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-08-03 05:00:59'),
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
(175, 'kategori_galeri', 'KG001', NULL, NULL, 'English Camp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-08-10 07:20:24'),
(176, 'kategori_galeri', 'KG002', NULL, NULL, 'KLBI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-08-10 07:20:39'),
(177, 'kategori_galeri', 'KG003', NULL, NULL, 'Praktek', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-07-29 09:45:42'),
(178, 'kategori_galeri', 'KG004', NULL, NULL, 'Table Manner', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:52', '2026-07-29 09:46:36'),
(180, 'kategori_galeri', 'KG006', NULL, NULL, 'Akreditasi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-11 21:12:53', '2026-08-03 09:16:13'),
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
(206, 'home_section', 'hero_banner', NULL, NULL, 'Hero Banner', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2026-07-29 05:32:05', '2026-07-29 05:32:05'),
(207, 'home_section', 'sambutan', NULL, NULL, 'Sambutan Kepala Sekolah', 'home/direktur-lembaga_1785379872.jpeg', 'Yushini Muliawanti, S.Pd.', 'Direktur Lembaga', 'Sambutan Direktur Lembaga', 'Pendidikan Perhotelan & Kapal Pesiar', 'Lulusan satu tahun siap kerja', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Salam hangat dari Subang International Hotel Institute (SIHI).\nSebagai Direktur, saya dengan bangga mempersembahkan SIHI sebagai pusat pendidikan hospitality yang berdedikasi menggali potensi terbaik putra-putri daerah. Sejalan dengan visi mulia Yayasan Utomo Bhakti, kami berkomitmen penuh mencetak tenaga profesional yang tidak hanya terampil, namun juga siap bersaing dan terserap di industri global.\nDidukung oleh fasilitas modern dan kurikulum berbasis industri, kami terus berinovasi untuk memastikan setiap peserta didik meraih standar kompetensi tertinggi. Kesuksesan ratusan alumni kami adalah bukti nyata dari dedikasi ini.\nTerima kasih atas kepercayaan dan dukungan Anda. Mari bersinergi bersama SIHI mewujudkan generasi hospitality yang unggul, berkarakter, dan berdaya saing internasional.\nHormat kami,\n\n[Yushini Muliawanti, S.Pd.]\nDirektur Lembaga LP3 SIHI', NULL, NULL, NULL, 1, 1, 1, 2, '2026-07-29 05:32:05', '2026-08-04 03:10:49'),
(208, 'home_section', 'statistik', NULL, NULL, 'Statistik Sekolah', 'Siswa Aktif', '1,500+', 'Pendidik & Staf', '90', 'Program Diploma', '4', 'Mitra Industri', '100+', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, 3, '2026-07-29 05:32:05', '2026-07-30 09:47:27'),
(209, 'home_section', 'program_keahlian', NULL, NULL, 'Program Keahlian', 'Program Keahlian Terbaik', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pilihan program keahlian yang relevan dengan perkembangan industri global.', NULL, NULL, NULL, 1, 1, 1, 4, '2026-07-29 05:32:05', '2026-07-29 05:32:05'),
(210, 'home_section', 'program_unggulan', NULL, NULL, 'Program Unggulan', 'Program Unggulan Sekolah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Program unggulan untuk mengasah hard skill and soft skill siswa secara optimal.', NULL, NULL, NULL, 1, 1, 0, 5, '2026-07-29 05:32:05', '2026-07-30 06:46:52'),
(211, 'home_section', 'mitra_industri', NULL, NULL, 'Mitra Industri', 'DAFTAR MOU SIHI', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Didukung oleh perusahaan nasional dan internasional terpercaya dalam penyaluran kerja dan magang.', NULL, NULL, NULL, 1, 1, 1, 6, '2026-07-29 05:32:05', '2026-07-29 05:32:05'),
(212, 'home_section', 'prestasi_siswa', NULL, NULL, 'Prestasi Siswa', 'Prestasi Terbaru Siswa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Prestasi membanggakan dari siswa-siswi terbaik kami di berbagai bidang perlombaan.', NULL, NULL, NULL, 1, 1, 1, 7, '2026-07-29 05:32:05', '2026-08-04 03:31:03'),
(213, 'home_section', 'prestasi_sekolah', NULL, NULL, 'Prestasi & Penghargaan Sekolah', 'Penghargaan & Prestasi Sekolah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Penghargaan resmi atas kualitas tata kelola, inovasi, dan prestasi institusi kami.', NULL, NULL, NULL, 1, 1, 1, 8, '2026-07-29 05:32:05', '2026-08-04 03:32:01'),
(214, 'home_section', 'karya_siswa', NULL, NULL, 'Karya & Projek Siswa', 'Skill Dan Keahlian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SKill Dan Keahlian yang akan didapat', NULL, NULL, NULL, 1, 1, 1, 9, '2026-07-29 05:32:05', '2026-07-31 08:16:14'),
(215, 'home_section', 'berita_terbaru', NULL, NULL, 'Berita Terbaru', 'Kabar & Informasi Terkini', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ikuti berita terkini mengenai berbagai kegiatan, pengumuman, dan agenda di sekolah kami.', NULL, NULL, NULL, 1, 1, 1, 10, '2026-07-29 05:32:05', '2026-07-29 05:32:05'),
(216, 'home_section', 'agenda_event', NULL, NULL, 'Agenda & Event', 'Agenda & Kegiatan Sekolah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pantau jadwal acara, ujian, pertemuan wali murid, dan kegiatan mendatang.', NULL, NULL, NULL, 1, 1, 1, 11, '2026-07-29 05:32:05', '2026-07-29 05:32:05'),
(217, 'home_section', 'galeri', NULL, NULL, 'Galeri Kegiatan', 'Galeri Dokumentasi Kegiatan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Dokumentasi visual dari berbagai aktivitas edukasi, sosial, dan prestasi di sekolah.', NULL, NULL, NULL, 1, 1, 1, 12, '2026-07-29 05:32:05', '2026-07-29 05:32:05'),
(218, 'home_section', 'alumni_berprestasi', NULL, NULL, 'Alumni Berprestasi', 'Testimoni & Kisah Sukses Alumni', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Inspirasi dan kisah sukses para lulusan kami yang telah berkiprah di dunia industri dan perguruan tinggi.', NULL, NULL, NULL, 1, 1, 1, 13, '2026-07-29 05:32:05', '2026-07-29 05:32:05'),
(219, 'home_section', 'testimoni', NULL, NULL, 'Testimoni', 'Apa Kata Mereka?', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pendapat para orang tua siswa, tokoh industri, dan masyarakat tentang kualitas pendidikan kami.', NULL, NULL, NULL, 1, 1, 0, 14, '2026-07-29 05:32:05', '2026-08-10 06:47:34'),
(221, 'home_section', 'ppdb', NULL, NULL, 'PPDB', 'Penerimaan Peserta Didik Baru', 'Daftar Sekarang', '/ppdb', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ayo bergabung bersama keluarga besar sekolah kami! Pendaftaran online PPDB tahun ajaran baru telah resmi dibuka.', NULL, NULL, NULL, 1, 1, 0, 15, '2026-07-29 05:32:05', '2026-08-04 05:46:28'),
(224, 'hero_banner_slide', 'HB02', NULL, NULL, 'Cepat Kerja, Cepat Sukses Go International', 'hero_banner/background_1785390404.jpg', 'DAFTAR SEKARANG', '/pendaftaran', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pendidikan Perhotelan & Kapal Pesiar, Pendidikan Satu Tahun Siap Kerja Dan Lulus Siap Bersaing Di Dunia Kerja', NULL, NULL, NULL, 1, 1, 1, 0, '2026-07-29 05:32:05', '2026-08-04 04:13:29'),
(225, 'karya_siswa', 'KR178136013063', NULL, NULL, 'Cook Helper', 'karya_siswa/foto-1_1786348735.jpeg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-13 07:15:30', '2026-08-12 07:20:58'),
(226, 'tag_konten', 'TG013', NULL, NULL, 'juara', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-14 15:15:14', '2026-06-14 15:15:14'),
(227, 'jurusan', 'JR001', NULL, NULL, 'Rekayasa Perangkat Lunak', 'RPL', 'Budi Santoso, S.Kom', 'A', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Deskripsi jurusan Rekayasa Perangkat Lunak', NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 14:54:16', '2026-06-15 14:54:16'),
(228, 'jurusan', 'JR002', NULL, NULL, 'Teknik Jaringan Komputer dan Telekomunikasi', 'TJKT', 'Ahmad Rizal, S.T', 'A', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Deskripsi jurusan Teknik Jaringan Komputer dan Telekomunikasi', NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 14:54:16', '2026-06-15 14:54:16'),
(229, 'jurusan', 'JR003', NULL, NULL, 'Akuntansi dan Keuangan Lembaga', 'AKL', 'Siti Aminah, S.E', 'B', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Deskripsi jurusan Akuntansi dan Keuangan Lembaga', NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 14:54:16', '2026-06-15 14:54:16'),
(236, 'karya_siswa', 'CM002', NULL, NULL, 'Barista And Bartending', 'karya_siswa/bartending_1785394522.jpeg', '228', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-15 14:54:16', '2026-08-12 07:20:53'),
(237, 'karya_siswa', 'CM003', NULL, NULL, 'Housekeeper', 'karya_siswa/d2_1785394380.jpeg', '227', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-15 14:54:16', '2026-08-12 07:20:46'),
(238, 'karya_siswa', 'CM004', NULL, NULL, 'Waiter', 'karya_siswa/d3_1785394337.jpeg', '228', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-15 14:54:16', '2026-08-12 07:20:40'),
(239, 'karya_siswa', 'CM005', NULL, NULL, 'Front Liner', 'karya_siswa/d1ph_1785394279.jpeg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-15 14:54:16', '2026-08-12 07:20:28'),
(240, 'tag_konten', 'TG014', NULL, NULL, 'keselamatan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 15:34:23', '2026-06-15 15:34:23'),
(241, 'tag_konten', 'TG015', NULL, NULL, 'siswa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 15:34:23', '2026-06-15 15:34:23'),
(242, 'tag_konten', 'TG016', NULL, NULL, 'tefa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 15:34:35', '2026-06-15 15:34:35'),
(243, 'tag_konten', 'TG017', NULL, NULL, 'industri', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 15:34:35', '2026-06-15 15:34:35'),
(244, 'tag_konten', 'TG018', NULL, NULL, 'akademik', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 15:35:25', '2026-06-15 15:35:25'),
(245, 'tag_konten', 'TG019', NULL, NULL, 'ujian', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 15:35:25', '2026-06-15 15:35:25'),
(246, 'tag_konten', 'TG020', NULL, NULL, 'bkk', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 15:35:49', '2026-06-15 15:35:49'),
(247, 'tag_konten', 'TG021', NULL, NULL, 'karir', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-15 15:35:50', '2026-06-15 15:35:50'),
(257, 'mitra_industri', 'MT010', NULL, NULL, 'GH Universal', 'https://ghuniversal.com/', 'mitra_industri/Vea6urueQb6poC15fmEvhAo4rogrwpYtj3y7qEdU.png', 'Perhotelan', '081802020023', '72;69', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kemitraan strategis dalam penyelarasan kurikulum sekolah, penyediaan tempat praktek kerja lapangan (PKL) / magang industri bagi siswa, guru tamu, serta program rekrutmen alumni secara langsung.', 'Jl. Dr. Setiabudi No.376, Ledeng, Kec. Cidadap, Kota Bandung, Jawa Barat', '(+) Hotel ini berlokasi strategis di daerah Setiabudi, Bandung. Link dari HOD untuk keluar negerinya banyak. Lingkungan kerja nyaman.\n(-) Hotel ini tidak memberikan uang saku kepada trainee. Hotel ini terdampak efisiensi, jadi sangat kecil kesempatan untuk ditarik bekerja', NULL, 1, 1, 1, 10, '2026-06-16 08:38:21', '2026-06-16 08:38:21');
INSERT INTO `common` (`id`, `table_name`, `key1`, `key2`, `key3`, `data1`, `data2`, `data3`, `data4`, `data5`, `data6`, `data7`, `data8`, `data9`, `data10`, `data11`, `data12`, `data13`, `data14`, `data15`, `date1`, `date2`, `date3`, `date4`, `text1`, `text2`, `text3`, `text4`, `created_by`, `updated_by`, `is_active`, `order`, `created_at`, `updated_at`) VALUES
(258, 'structure', 'ST001', 'yayasan', NULL, 'TIM MANAJEMEN DAN INSTRUKTUR', '202', NULL, '1', 'yayasan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-16 09:29:46', '2026-08-10 02:42:09'),
(259, 'structure', 'SK003', 'sekolah', NULL, 'Guru PPPK', NULL, NULL, NULL, 'sekolah', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Daftar Guru Pegawai Pemerintah dengan Perjanjian Kerja (PPPK) yang bertugas di sekolah ini.', NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-17 09:53:03', '2026-06-17 09:53:03'),
(260, 'tag_konten', 'TG022', NULL, NULL, 'kompetisi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 1, 0, '2026-06-18 23:21:13', '2026-06-18 23:21:13'),
(261, 'home_section', 'school_life', NULL, NULL, 'School Life', 'home/class_1786345836.jpeg', '', 'Kegiatan Akademik', 'Kegiatan Akademik', '99%', 'Puas', 'ENGLISH CAMP', 'feather-heart', 'KBM (Kegiatan Belajar Mengajar)', 'feather-book', 'Upgrading', 'feather-award', NULL, NULL, NULL, NULL, NULL, NULL, 'nglish Camp merupakan kegiatan masa orientasi/adaptasi dengan lingkungan kampus, program kampus, serta bertujuan untuk mengenalkan Bahasa Inggris dimana pembelajarannya akan dimulai dari Basic atau dasar. Selama English Camp ini dilakukan juga pembentukan character building dan pendalaman keagamaan. Kegiatan ini dilaksanakan selama 1 (satu) bulan sebelum pembelajaran dimulai. \n\nKegiatan English Camp meliputi\n1. Masa Orientasi lingkungan dan program kampus\n2. Pengenalan Bahasa Inggris Dasar\n3. Pengenalan Etika Perhotelan\n4. Pembentukan Karakter\n5. Keagamaan\n6. Kelas Motivasi\n7. Outbond', 'Kegiatan Belajar Mengajar dilaksanakan setiap hari Senin - Jumat pukul 08.00 - 16.00 WIB. Kegiatan pembelajaran SIHI 30% teori dan 70% praktik.', '\nDilaksanakan Senin - Jumat pukul 19.30 - 21.00 WIB. Materi yang diajarkan selama Extra Class adalah pendalaman bahasa Inggris dan Public Speaking, Pendalaman ilmu keagamaan, Character Building, dan kelas motivasi, serta memberi pembelajaran selama KBM yang belum dipahami.', NULL, 1, 1, 0, 16, '2026-07-29 05:32:05', '2026-08-10 07:11:28'),
(262, 'seo_setting', 'seo_config', NULL, NULL, 'Subang International Hotel Institute', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Sekolah Menengah Kejuruan PGRI Subang adalah sekolah menengah tingkat atas berbasis kejuruan. SMK PGRI Subang sekolah yang menyelenggarakan pendidikan kejuruan kelompok teknologi, informasi dan industri', 'smk, sekolah, favorit, modern', NULL, NULL, 1, 1, 1, 1, '2026-06-20 12:26:33', '2026-07-29 08:27:35'),
(263, 'home_section', 'fasilitas', NULL, NULL, 'Fasilitas Sekolah', NULL, NULL, NULL, 'SARANA & PRASARANA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Fasilitas dan sarana prasarana yang lengkap dan modern untuk menunjang kegiatan pembelajaran.', NULL, NULL, NULL, 1, 1, 1, 17, '2026-07-29 05:32:05', '2026-07-29 05:32:05'),
(264, 'home_section', 'faq', NULL, NULL, 'Frequently Asked Questions', NULL, NULL, NULL, 'FAQ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pertanyaan yang sering diajukan mengenai Kampus kami.', NULL, NULL, NULL, 1, 1, 1, 18, '2026-07-29 05:32:05', '2026-07-29 05:32:05'),
(265, 'faq', 'CM001', NULL, NULL, 'Berapa biaya pendaftaran?', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Untuk setiap calon peserta didik yg ingin mendaftar dikenakan biaya sebesar Rp. 200.000', NULL, NULL, NULL, 1, 1, 1, 0, '2026-06-20 19:48:10', '2026-06-20 19:48:10'),
(266, 'home_section', 'social_media', NULL, NULL, 'Media Sosial', 'Koneksi Sosial', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ikuti kanal media sosial resmi kami untuk mendapatkan informasi terbaru secara real-time.', NULL, NULL, NULL, NULL, 1, 1, 18, '2026-06-26 05:33:09', '2026-08-04 05:46:58'),
(267, 'social_media_setting', 'social_media_config', NULL, NULL, 'https://www.instagram.com/sihi.subang', '1', 'https://www.youtube.com/@sihi.subang6609', '1', 'https://facebook.com', '0', 'https://www.tiktok.com/@sihi.subang', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, '2026-06-26 05:33:09', '2026-07-29 09:11:35'),
(270, 'mitra_industri', NULL, NULL, NULL, 'Novotel Karawang', 'https://www.instagram.com/novotelkarawang', 'mitra_industri/QHhBmTxvYfunufsWIH9QWW0D6uRj5eGF5mDrwhGk.jpg', 'Perhotelan', '082146862198', '72', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Jl. Interchange Karawang Barat, Margakaya, Telukjambe Barat, Karawang, Jawa Barat', '(+) Hotel ini adalah hotel chain internasional dari grup Accor. Dapat uang saku untuk trainee. Ada kesempatan untuk ditarik kerja, tergantung performa. \n(-) Lingkungan kerja cenderung kurang nyaman. Banyak overtime kerja.', NULL, 1, 1, 1, 0, NULL, NULL),
(271, 'mitra_industri', NULL, NULL, NULL, 'Holiday Inn Jababeka', 'https://cikarangjababeka.holidayinn.com/', 'mitra_industri/KfTgsPp7bWjPayW4ZYHGLmT59Jz1NCyPBo2RMH7h.jpg', 'Perhotelan', '08563282006', '72', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', ' Jl. Jababeka Raya Kav. A-2, Jababeka 1, Cikarang Utara, Bekasi, Jawa Barat', '(+) Hotel chain international dari grup IHG. Dapat uang saku untuk trainee. Lokasi strategis. Ada kesempatan untuk ditarik kerja berdasarkan performa. \n(-) Ulasan dari alumni, lingkungan kerja kurang nyaman untuk F&B Service. Biaya hidup relatif lebih mahal karena di kawasan industri. ', NULL, 1, 1, 1, 0, NULL, NULL),
(272, 'mitra_industri', NULL, NULL, NULL, 'Resinda', 'https://resindahotel.com/', 'mitra_industri/YffeF2JDlqevdxN2bkJ6pK4mlSKe1KDHQNLZKLfd.jpg', 'Perhotelan', '081310747379', '72', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Jl. Resinda Raya No.1, Purwadana, Telukjambe Timur, Karawang, Jawa Barat', '(+) Hotel chain lokal skala internasional, sudah diakui beberapa negara. Dapat uang saku untuk trainee. Penarikan kerja berdasarkan performa. Biaya hidup cenderung lebih murah.\n(-) Tidak menerima pekerja dari luar, jadi sulit untuk melamar kerja apabila bukan ex. trainee dari hotel tersebut.  ', NULL, 1, 1, 1, 0, NULL, NULL),
(273, 'mitra_industri', NULL, NULL, NULL, 'Swisbel - Resort Dago Heritage', 'https://www.swiss-belhotel.com/hotels/swiss-belresort-dago-heritage', 'mitra_industri/v4bEQaOhBkE9YL4YOL60ICy5D3oNRLMAWN2moKIC.jpg', 'Perhotelan', '081573867962', '72', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Komplek Dago Heritage 1917, Jl. Lapangan Golf Dago Atas No. 78, Bandung.', '(+) Hotel chain internasional. Banyak trainee yang diangkat kerja. Dapat uang saku untuk trainee. \n(-) Penilaian performa cukup ketat.', NULL, 1, 1, 1, 0, NULL, NULL),
(274, 'mitra_industri', NULL, NULL, NULL, 'Indigo', 'https://hotelindigobandung.com/id/', 'mitra_industri/BGMRpE638nMx4pRwFQRJM24v8veM8ioNj69DzF3L.jpg', 'Perhotelan', '(022) 86028888', '72', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Jl. Dago Pakar Raya No.3, Resor Dago Pakar, Bandung, Jawa Barat', '(+) Pengangkatan trainee berdasarkan perfoma. Dapat uang saku \n(-) Lingkungan kerja kurang nyaman', NULL, 1, 1, 1, 0, NULL, NULL),
(275, 'mitra_industri', NULL, NULL, NULL, 'Grand Mercure', 'https://grandmercurebandung.com/', 'mitra_industri/oWsNwVcQTAo6yskhnFmKttC4zpPrAv7R71ty9ZTB.jpg', 'Perhotelan', '082216308166', '72', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Jalan Dr. Setiabudi no. 269-275 Bandung', '(+) Lokasi strategis.Dapat uang saku untuk trainee, lingkungan kerja nyaman. \n(-) Tidak ada perkembangan untuk trainee', NULL, 1, 1, 1, 0, NULL, NULL),
(276, 'mitra_industri', NULL, NULL, NULL, 'Pullman Ciawi', 'https://www.instagram.com/pullmanciawivimalahills', 'mitra_industri/D6LS6HS7VUbT1dpYH4AWM31Nx2FUV2bBW6rO7FoT.jpg', 'Perhotelan', '089620230020', '72', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Jl. Raya Puncak, Gadog, Megamendung, 16770 Bogor', '(+) Dapat uang saku untuk trainee. Ada kesempatan untuk trainee diangkat kerja \n(-) Lokasi jauh', NULL, 1, 1, 1, 0, NULL, NULL),
(277, 'mitra_industri', NULL, NULL, NULL, 'Santika Linggarjati', 'https://www.mysantika.com/indonesia/kuningan/hotel-santika-premiere-linggarjati-kuningan', 'mitra_industri/xbcaNXxUaQH1LD3FE7zG2zhtB9GEaY7d4zBCUggu.jpg', 'Perhotelan', '087777255744', '72', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Jalan Raya Linggarjati, Kecamatan Cilimus, Kabupaten Kuningan, Jawa Barat ', '(+) Hotel chain lokal skala internasional. Kesempatan besar untuk diangkat kerja\n(-) Tidak dapat uang saku untuk trainee. Gaji yang relatif kecil bagi casual', NULL, 1, 1, 1, 0, NULL, NULL),
(278, 'mitra_industri', NULL, NULL, NULL, 'Harper', 'https://www.harperhotels.com/id/', 'mitra_industri/PaD3kBdU3kHVBYotdMYBtau3gl8wwTRjfKF8R3AW.jpg', 'Perhotelan', '(0264) 8642888', '72', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Jl. Raya Bungursari No.122, Bungursari, Kec. Bungursari, Kabupaten Purwakarta, Jawa Barat', '(+) Hotel chain internasional. Banyak trainee yang diangkat kerja. Dapat uang saku untuk trainee. \n(-) Penilaian performa cukup ketat.', NULL, 1, 1, 1, 0, NULL, NULL),
(279, 'mitra_industri', NULL, NULL, NULL, 'Grand Tjokro', 'https://grandtjokro.com/bandung', 'mitra_industri/tL4jhHvInE43jgp5YKEbkofFRfc9xy3mWlmVOucM.jpg', 'Perhotelan', '082130300374', '72', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Jl. Cihampelas No.211-217, Cipaganti, Kecamatan Coblong, Kota Bandung, Jawa Barat', '(+) Hotel chain lokal skala internasional. Program SHA. Dapat uang saku untuk trainee \n(-) Penilaian performa yang cukup ketat', NULL, 1, 1, 1, 0, NULL, NULL),
(280, 'mitra_industri', NULL, NULL, NULL, 'Delonix', 'https://www.delonixhotel.com/id/', 'mitra_industri/tGE5WM7S3HNQbHae02iOwTIHIuAyuBKETgREhIpH.jpg', 'Perhotelan', '(0267) 644370', '72', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Jl. Marsma R. Iswahyudi, Karawang Barat, Karawang, Jawa Barat', '(+) Hotel chain lokal skala internasional. Program SHA. Dapat uang saku untuk trainee \n(-) Penilaian performa yang cukup ketat', NULL, 1, 1, 1, 0, NULL, NULL),
(281, 'mitra_industri', NULL, NULL, NULL, 'Mercure Karawang', 'https://mercure.hotelkarawang.com/id/', 'mitra_industri/14QdvaDG1FFb1dku0STlGjEkKiIqsG624m7G16IO.jpg', 'Perhotelan', '08111773324', '69', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Jl. Galuh Mas Raya, Sukaharja, Telukjambe Barat, Karawang, Jawa Barat', '', NULL, 1, 1, 1, 0, NULL, NULL),
(282, 'mitra_industri', NULL, NULL, NULL, 'Hotel Lotus Subang', 'https://lotus.hotelsubang.com/id/', 'mitra_industri/3AkYsrzEPskBHRV4XwZaqcNGQG3Cv3LLZxHYiugM.jpg', 'Perhotelan', '085793802229', '69', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Jl. Letjen Suprapto No.31, Karanganyar, Subang, Jawa Barat.', '', NULL, 1, 1, 1, 0, NULL, NULL),
(283, 'mitra_industri', NULL, NULL, NULL, 'Gumilang Hotel Regency Bandung', 'https://gumilangregency.com/', 'mitra_industri/mLAWMfo1lNUlyJkbeMzjmdxcgyhVJaaUQs1DuCY2.png', 'Perhotelan', '(022) 2012618', '69', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Jl. Dr. Setiabudhi 323 -325 Bandung 40154 West Java', '', NULL, 1, 1, 1, 0, NULL, NULL),
(284, 'mitra_industri', NULL, NULL, NULL, 'LSP Pariwisata Maestro Indonesia', 'https://sidia.kemenperin.go.id/competency/lsp/view/2244/pariwisata-maestro-indonesia', 'mitra_industri/yKKHfeW3Pzkbhux1uumb5XwCWdTjxl9Qcf7MeSTG.jpg', 'Pariwisata', '081283185859', '70', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Jl. Letjen Suprapto Ruko Grosir, Cempaka Emas Blok M No. 6, Jakarta Pusat, DKI Jakarta', '', NULL, 1, 1, 1, 0, NULL, NULL),
(285, 'mitra_industri', NULL, NULL, NULL, 'Prime Plaza Purwakarta', 'https://kbi.pphotels.com/', 'mitra_industri/75wZNrqYCnbRR5ztl2fagpMvkwjA7L4T250o6j83.jpg', 'Perhotelan', '081510220003', '71', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Blok L, Kota Bukit Indah, Cinangka, Bungursari, Kabupaten Purwakarta, Jawa Barat', '', NULL, 1, 1, 1, 0, NULL, NULL),
(286, 'mitra_industri', NULL, NULL, NULL, 'Royal Tulip Gunung Geulis Bogor', 'https://royal-tulip-gunung-geulis.goldentulip.com/id/?sr=SEO_GOOGLE', 'mitra_industri/dRLyF88MZYkR0MomgB9ZSkVehiLBrFLLPvEFx4x9.jpg', 'Perhotelan', '081314977484', '71', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Jl. Pasir Angin, Gadog, Ciawi, Bogor, Jawa Barat.', '', NULL, 1, 1, 1, 0, NULL, NULL),
(287, 'mitra_industri', NULL, NULL, NULL, 'Aston Cirebon', 'https://www.astonhotelsinternational.com/id/hotel/view/10/aston-cirebon-hotel---convention-center', 'mitra_industri/ega8N3rhPkBo5YTHdrqDMF4dVEzQnt9snhS9eDJh.jpg', 'Perhotelan', '081287676380', '69', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Jl. Brigjend Dharsono No. 12C (By Pass), Cirebon, Jawa Barat 45132.', '', NULL, 1, 1, 1, 0, NULL, NULL),
(288, 'mitra_industri', NULL, NULL, NULL, 'Hotel Horison Bandung', 'https://www.horisonultimabandung.com/en/', 'mitra_industri/DVClpNNe5ea0FAIfeY0g5bkk1zx3JjiceE1C8Vq6.jpg', 'Perhotelan', '087779885588', '71', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 'Jl. Pelajar Pejuang 45 No. 121, Turangga, Lengkong, Bandung.', '', NULL, 1, 1, 1, 0, NULL, NULL),
(289, 'jabatan_organisasi', 'JB013', NULL, NULL, 'Pembantu Umum', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-07-30 09:17:26', '2026-07-30 09:17:26'),
(290, 'jabatan_organisasi', 'JB014', NULL, NULL, 'Bidang Kemitraan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-07-30 09:17:53', '2026-08-10 03:20:28'),
(291, 'jabatan_organisasi', 'JB015', NULL, NULL, 'Bidang Digital Marketing', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-07-30 09:18:11', '2026-07-30 09:18:11'),
(292, 'jabatan_organisasi', 'JB016', NULL, NULL, 'Ketua Yayasan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-07-31 02:57:36', '2026-08-05 08:33:37'),
(293, 'fasilitas', NULL, NULL, NULL, 'Toilet', '-', NULL, 'bergantian', NULL, 'fasilitas/MKrmfblQEJoWMHeAIWBLH56ggmLVEdn30StF2uWS.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>Fasilitas toilet yang di sediakan sangat nyaman</p>', NULL, NULL, NULL, 1, 1, 1, 0, NULL, NULL),
(294, 'jabatan_organisasi', 'JB017', NULL, NULL, 'Instruktur Mata Ajar Etiket', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-08-05 08:33:29', '2026-08-06 06:42:15'),
(295, 'jabatan_organisasi', 'JB018', NULL, NULL, 'Instruktur Mata Ajar English Conversation', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-08-06 06:44:47', '2026-08-06 06:44:47'),
(296, 'jabatan_organisasi', 'JB019', NULL, NULL, 'Instruktur General English', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-08-06 06:45:11', '2026-08-06 06:45:11'),
(297, 'jabatan_organisasi', 'JB020', NULL, NULL, 'Instruktur Mata Ajar Office', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-08-06 06:45:21', '2026-08-06 06:45:21'),
(298, 'jabatan_organisasi', 'JB021', NULL, NULL, 'Instruktur FB Knowledge, FB Service, dan ESP FB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-08-06 06:45:34', '2026-08-06 06:45:34'),
(299, 'jabatan_organisasi', 'JB022', NULL, NULL, 'Instruktur Housekeeping', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-08-06 06:45:45', '2026-08-06 06:45:45'),
(300, 'jabatan_organisasi', 'JB023', NULL, NULL, 'Instruktur Housekeeping, ESP For Hotel', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-08-06 06:46:08', '2026-08-06 06:46:08'),
(301, 'jabatan_organisasi', 'JB024', NULL, NULL, 'Instruktur Food And Beverage Service', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-08-06 06:46:42', '2026-08-06 06:46:42'),
(302, 'jabatan_organisasi', 'JB025', NULL, NULL, 'INSTRUKTUR FRONT OFFICE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-08-10 02:57:00', '2026-08-10 02:57:00'),
(303, 'jabatan_organisasi', 'JB026', NULL, NULL, 'Staff Administrasi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-08-10 03:05:56', '2026-08-10 03:05:56'),
(305, 'fasilitas', NULL, NULL, NULL, 'Kampus 2 LP3 SIHi', '', NULL, '', NULL, 'fasilitas/VLpRAM4naA363nwfSb9ixLdec94qBvVLPkziXopS.jpg;fasilitas/JQJhNJzmTKdGYOoNIZwMAzBEhy3LIUGTFzHlsTam.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 1, 1, 1, 0, NULL, NULL),
(306, 'fasilitas', NULL, NULL, NULL, 'Ruang Praktik Housekeeping', '', NULL, '', NULL, 'fasilitas/UAAhpNtyTq9TWqZpQ2YLCygtmTF2SipdaRUNTB56.jpg;fasilitas/hKCrZyWprrgBvNG22o6Hgcull8tapeBVkbXEsrEf.jpg;fasilitas/wIhFo4xmWD72h7087q9NBFewP8T50HmBLIIsmS69.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>Ruang Praktik yang digunakan untuk pembelajaran housekeeping</p>', NULL, NULL, NULL, 1, 1, 1, 0, NULL, NULL),
(307, 'fasilitas', NULL, NULL, NULL, 'ruang praktik food and beverage service', '', NULL, '', NULL, 'fasilitas/9QcDKUzzMjb9hxpw8ZUw8Lv6e8LFBqleuQpP2iu0.jpg;fasilitas/MwL3RPDMULTzqK4kCjxXNMl3l7yCaHHHto0EvWBa.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>Ruangan Praktik yang digunakan mahasiswa untuk praktik food and beverage service</p>', NULL, NULL, NULL, 1, 1, 1, 0, NULL, NULL),
(308, 'fasilitas', NULL, NULL, NULL, 'ruang praktik FRONT OFFICE', '', NULL, '', NULL, 'fasilitas/v3MLLSBJOrVoL5f5r6qGsEKoDajRyyeuiYykJlWc.jpg;fasilitas/BhlwxMfuYw95w6P6naiFhWMJFbRNvN3QwKDRmGH2.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 1, 1, 1, 0, NULL, NULL),
(309, 'fasilitas', NULL, NULL, NULL, 'Ruang PRAKTIK BAR DAN COOKING', '', NULL, '', NULL, 'fasilitas/pB8VRuEsMCOwSDX3qrSMYo8iP2Z0WtzS4HvchR19.jpg;fasilitas/NBqjYrZV9hlla6SZxn97z1F2CaE4fhUDFcLwoIh8.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 1, 1, 1, 0, NULL, NULL),
(310, 'fasilitas', NULL, NULL, NULL, 'Asrama Putra & Putri', '', NULL, '', NULL, 'fasilitas/iXoYJeajHScjaFxOOhvPZTtfvGfnGwy0oBo09Aqr.jpg;fasilitas/GWQhbMgexNulWzHorbJu5tq91XjILan3M7u5j4q1.jpg;fasilitas/0MAVI7FBslLJZIthNyEZV5vtsZTEPL4xu7QjdLxp.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '<p>Asrama putra dan putri yang telah disediakan oleh kampus yang digunakan untuk istirahat serta menyimpan barang mahasiswa/i</p>', NULL, NULL, NULL, 1, 1, 1, 0, NULL, NULL),
(311, 'fasilitas', NULL, NULL, NULL, 'Ruangan Bimbingan Karir', '', NULL, '', NULL, 'fasilitas/pGJgLxvFnrYoP4sMTAFD98p3ZnCF5LToh23u2Ls7.jpg;fasilitas/elGtsPPkhcHRY8jxw5ANQkrwVasvdPcBgHg351Ez.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 1, 1, 1, 0, NULL, NULL),
(312, 'bidang_pekerjaan', 'BP001', NULL, NULL, 'Room Attendant ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-08-10 06:49:25', '2026-08-10 06:49:25'),
(313, 'bidang_pekerjaan', 'BP002', NULL, NULL, 'Reservation Supervisor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-08-10 06:49:53', '2026-08-10 06:49:53'),
(314, 'bidang_pekerjaan', 'BP003', NULL, NULL, 'Waiter', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-08-10 06:50:20', '2026-08-10 06:50:20'),
(315, 'bidang_pekerjaan', 'BP004', NULL, NULL, 'Chef De Partie', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-08-10 06:56:51', '2026-08-10 06:56:51'),
(316, 'jabatan_organisasi', 'JB027', NULL, NULL, 'WAKIL DIREKTUR BIDANG KEUANGAN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-08-10 08:15:27', '2026-08-10 08:15:27'),
(317, 'jabatan_organisasi', 'JB028', NULL, NULL, 'Instruktur Kitchen', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, '2026-08-10 08:33:14', '2026-08-10 08:33:14'),
(318, 'elearning_settings', 'absen_mahasiswa', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2026-08-11 06:51:12', '2026-08-11 07:04:54');

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `jurusan_id` bigint UNSIGNED DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `file_size` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
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
(10, 'Panduan Keselamatan Kerja & Penggunaan Lab Komputer Jaringan', 185, NULL, 'documents/panduan_lab_tjkt.pdf', '1.9 MB', 'SOP keselamatan kerja, tata cara penggunaan perangkat router, switch, dan cabling di laboratorium TJKT.', 1, 1, 1, '2026-06-12 07:29:59', '2026-06-16 07:29:59'),
(11, 'Modul Praktikum Administrasi & Infrastruktur Jaringan Kelas XI', 187, NULL, 'documents/modul_jaringan_tjkt.pdf', '5.2 MB', 'Materi praktikum konfigurasi routing dinamis, VLAN, dan firewall menggunakan simulator jaringan Cisco Packet Tracer.', 1, 1, 1, '2026-06-12 07:29:59', '2026-06-16 07:29:59'),
(12, 'Modul Pembelajaran Akuntansi Keuangan Dasar Kelas X', 187, 4, 'documents/modul_akuntansi_dasar.pdf', '3.8 MB', 'Modul ajar mencakup pengenalan persamaan dasar akuntansi, jurnal umum, buku besar, dan siklus akuntansi jasa.', 1, 1, 1, '2026-06-13 07:29:59', '2026-06-16 07:29:59'),
(13, 'Formulir Pengajuan Beasiswa Komite Kurang Mampu (BKM)', 182, NULL, 'documents/formulir_beasiswa_bkm.pdf', '280 KB', 'Formulir permohonan keringanan biaya sekolah dan pengajuan beasiswa BKM dari Komite Sekolah.', 1, 1, 1, '2026-06-13 07:29:59', '2026-06-16 07:29:59'),
(14, 'Formulir Pendaftaran Ekstrakurikuler Sekolah', 182, NULL, 'documents/formulir_ekstrakurikuler.pdf', '150 KB', 'Form pendaftaran anggota baru ekstrakurikuler wajib Pramuka maupun pilihan (PMR, Futsal, Coding Club).', 1, 1, 1, '2026-06-14 07:29:59', '2026-06-16 07:29:59'),
(15, 'Leaflet Profil Kompetensi Keahlian Rekayasa Perangkat Lunak', 183, NULL, 'documents/leaflet_rpl.pdf', '1.5 MB', 'Pamflet promosi jurusan RPL yang berisi prospek kerja, materi utama keahlian, dan prestasi siswa.', 1, 1, 1, '2026-06-14 07:29:59', '2026-06-16 07:29:59'),
(16, 'Leaflet Profil Kompetensi Keahlian Teknik Jaringan Komputer & Telekomunikasi', 183, NULL, 'documents/leaflet_tjkt.pdf', '1.7 MB', 'Leaflet informasi kurikulum TJKT, sertifikasi kompetensi Mikrotik/Cisco, dan prospek karir alumni.', 1, 1, 1, '2026-06-15 07:29:59', '2026-06-16 07:29:59'),
(17, 'Leaflet Profil Kompetensi Keahlian Akuntansi & Keuangan Lembaga', 183, 4, 'documents/leaflet_akl.pdf', '1.3 MB', 'Brosur ringkas program keahlian AKL mengenai lab manual/komputer akuntansi Accurate dan MYOB.', 1, 1, 1, '2026-06-15 07:29:59', '2026-06-16 07:29:59'),
(18, 'Jadwal Pelajaran & Kalender Kegiatan Kelas X Semester Ganjil', 184, NULL, 'documents/jadwal_kegiatan_kelas10.pdf', '920 KB', 'Pembagian jadwal pelajaran mingguan dan jadwal bimbingan akademik kelas X.', 1, 1, 1, '2026-06-16 07:29:59', '2026-06-16 07:29:59'),
(19, 'Jadwal Pelajaran & Kalender Kegiatan Kelas XI Semester Ganjil', 184, NULL, 'documents/jadwal_kegiatan_kelas11.pdf', '940 KB', 'Pembagian jadwal pelajaran mingguan dan jadwal persiapan pelaksanaan PKL kelas XI.', 1, 1, 1, '2026-06-16 07:29:59', '2026-06-16 07:29:59'),
(20, 'Jadwal Pelajaran & Kalender Kegiatan Kelas XII Semester Ganjil', 184, NULL, 'documents/jadwal_kegiatan_kelas12.pdf', '950 KB', 'Pembagian jadwal pelajaran mingguan, jadwal persiapan Ujian Sekolah dan UKK kelas XII.', 1, 1, 1, '2026-06-16 07:29:59', '2026-06-16 07:29:59'),
(21, 'Rencana Pelaksanaan Pembelajaran (RPP) Pemrograman Berorientasi Objek', 187, NULL, 'documents/rpp_rpl_oop.pdf', '2.1 MB', 'RPP mata pelajaran Pemrograman Berorientasi Objek (OOP) kelas XI RPL sebagai pedoman KBM.', 1, 1, 1, '2026-06-16 07:29:59', '2026-06-16 07:29:59'),
(22, 'SOP Penilaian & Ujian Kompetensi Keahlian (UKK) Akuntansi', 185, 4, 'documents/sop_ukk_akl.pdf', '1.1 MB', 'Prosedur penilaian, kriteria kelulusan, dan jadwal pengujian eksternal UKK bagi siswa kelas XII AKL.', 1, 1, 1, '2026-06-16 07:29:59', '2026-06-16 07:29:59');

-- --------------------------------------------------------

--
-- Table structure for table `elearning_attendances`
--

CREATE TABLE `elearning_attendances` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `check_in` time DEFAULT NULL,
  `check_out` time DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Hadir',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `elearning_attendances`
--

INSERT INTO `elearning_attendances` (`id`, `user_id`, `date`, `check_in`, `check_out`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-08-05', '10:45:00', '10:46:00', 'Terlambat', '2026-08-05 03:45:57', '2026-08-05 03:46:03');

-- --------------------------------------------------------

--
-- Table structure for table `elearning_courses`
--

CREATE TABLE `elearning_courses` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `program` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `owner_id` bigint UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `elearning_courses`
--

INSERT INTO `elearning_courses` (`id`, `title`, `program`, `description`, `owner_id`, `is_active`, `created_at`, `updated_at`) VALUES
(6, 'apa', 'perhotelan', 'apa', 14, 1, '2026-08-12 08:44:28', '2026-08-12 08:44:28');

-- --------------------------------------------------------

--
-- Table structure for table `elearning_documents`
--

CREATE TABLE `elearning_documents` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `drive_link` varchar(500) NOT NULL,
  `notes` text,
  `status` varchar(20) NOT NULL DEFAULT 'Menunggu',
  `feedback` text,
  `reviewed_by` bigint UNSIGNED DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `elearning_exams`
--

CREATE TABLE `elearning_exams` (
  `id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `instructions` text COLLATE utf8mb4_general_ci,
  `soal_path` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `start_at` datetime NOT NULL,
  `end_at` datetime NOT NULL,
  `is_open` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `elearning_exam_submissions`
--

CREATE TABLE `elearning_exam_submissions` (
  `id` bigint UNSIGNED NOT NULL,
  `exam_id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED NOT NULL,
  `answer` text COLLATE utf8mb4_general_ci,
  `drive_link` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `score` int DEFAULT NULL,
  `feedback` text COLLATE utf8mb4_general_ci,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `elearning_job_applications`
--

CREATE TABLE `elearning_job_applications` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `whatsapp` varchar(50) NOT NULL,
  `position` varchar(255) NOT NULL,
  `job_posting_id` bigint UNSIGNED DEFAULT NULL,
  `cv_path` varchar(500) DEFAULT NULL,
  `drive_link` varchar(500) DEFAULT NULL,
  `intro` text,
  `status` varchar(20) NOT NULL DEFAULT 'Baru',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `elearning_job_applications`
--

INSERT INTO `elearning_job_applications` (`id`, `name`, `email`, `whatsapp`, `position`, `job_posting_id`, `cv_path`, `drive_link`, `intro`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Gusti Ardana Betra', 'apa@gmail.com', '093482088429', 'front office — grand mercure', 1, NULL, 'https://drive.google.com/drive/folders/173oAHjzMxNWi48svta6UG12swWWZ9OyD?usp=drive_link', 'apaweh', 'Diproses', '2026-08-11 10:07:23', '2026-08-11 10:08:05');

-- --------------------------------------------------------

--
-- Table structure for table `elearning_job_postings`
--

CREATE TABLE `elearning_job_postings` (
  `id` bigint UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `company_website` varchar(255) DEFAULT NULL,
  `company_photo` varchar(500) DEFAULT NULL,
  `position` varchar(255) NOT NULL,
  `employment_type` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text,
  `status` varchar(20) NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `elearning_job_postings`
--

INSERT INTO `elearning_job_postings` (`id`, `company_name`, `company_website`, `company_photo`, `position`, `employment_type`, `location`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'grand mercure', 'https://grandmercurebandung.com/', 'elearning/loker/ulzaRQNL5pRTFhTf59jebCuyfC4rz0Dmsi6cxYC5.jpg', 'front office', 'Part Time', 'bandung', 'contoh', 'open', '2026-08-11 10:06:20', '2026-08-11 10:08:56');

-- --------------------------------------------------------

--
-- Table structure for table `elearning_materials`
--

CREATE TABLE `elearning_materials` (
  `id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `elearning_payments`
--

CREATE TABLE `elearning_payments` (
  `id` bigint UNSIGNED NOT NULL,
  `student_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `amount` decimal(12,0) NOT NULL,
  `details` text COLLATE utf8mb4_general_ci,
  `payment_channel` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `slip_number` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `program` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `manual_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `manual_nim` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Tunggakan',
  `paid_at` timestamp NULL DEFAULT NULL,
  `payment_proof_link` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `proof_type` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `proof_note` text COLLATE utf8mb4_general_ci,
  `proof_submitted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `elearning_payments`
--

INSERT INTO `elearning_payments` (`id`, `student_id`, `title`, `amount`, `details`, `payment_channel`, `slip_number`, `program`, `manual_name`, `manual_nim`, `due_date`, `status`, `paid_at`, `payment_proof_link`, `proof_type`, `proof_note`, `proof_submitted_at`, `created_at`, `updated_at`) VALUES
(3, 1, 'spp', '2500000', NULL, NULL, NULL, NULL, NULL, NULL, '2026-08-29', 'Tunggakan', NULL, NULL, NULL, NULL, NULL, '2026-08-12 08:50:54', '2026-08-12 08:50:54'),
(4, 1, 'UKT', '1000000', '[{\"title\":\"SPP semeter 1\",\"amount\":1000000}]', 'BANK BRI', 'SIHI/20260812/0004', 'perhotelan', NULL, NULL, '2026-08-12', 'Tunggakan', NULL, NULL, NULL, NULL, NULL, '2026-08-12 09:36:57', '2026-08-12 09:36:57'),
(5, NULL, 'UKT', '2000000', '[{\"title\":\"SPP semeter 1\",\"amount\":2000000}]', 'KANTOR SIHI', 'SIHI/20260812/0005', 'perhotelan', 'Ucup', '2306700', '2026-08-13', 'Tunggakan', NULL, NULL, NULL, NULL, NULL, '2026-08-12 10:06:22', '2026-08-12 10:06:22');

-- --------------------------------------------------------

--
-- Table structure for table `elearning_users`
--

CREATE TABLE `elearning_users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `staff_type` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nomor_induk` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `program` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `elearning_users`
--

INSERT INTO `elearning_users` (`id`, `name`, `email`, `password`, `role`, `staff_type`, `nomor_induk`, `photo`, `program`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Gusti Ardana Betra', 'apaweh@gmail.com', '$2y$12$Zb4pSnLTLUb.QZtA3QFvJum.to6PSNUkhhA5mS4.yKczKlZFkag1m', 'mahasiswa', NULL, '2306700080', 'elearning/profiles/IMG_3907-20260812-104530.JPG', 'perhotelan', 1, '2026-08-05 03:43:24', '2026-08-12 03:45:30'),
(5, 'Yushini Muliawanti, S.Pd', 'yushi@gmail.com', '$2y$12$0ndmjzESxanRqdbX5er6OerCe4/XDjOyF7U3oxseT3cppwRzfmPOO', 'staff', 'direktur', '201607011', 'elearning/profiles/Direktur-Lembaga-20260812-132332.jpeg', NULL, 1, '2026-08-12 05:04:24', '2026-08-12 06:27:16'),
(6, 'Hemmy Nur Hamidah,S.PD', 'hemmy@gmail.com', '$2y$12$vB9NTROsX4XrMboP0uc25eGzeiUGiwfDWPWbt6EUnI0L1X08.xrF6', 'staff', 'wakil_direktur', '202502022', NULL, NULL, 1, '2026-08-12 06:18:57', '2026-08-12 06:25:24'),
(7, 'Asmi Putri Purwaningsih,S.I.Kom', 'miputrip@gmail.com', '$2y$12$ZJqMDbTh5dtOPh459FWiXejj2OyOxPhXqAji68SrBlZIF9hwHY.z.', 'staff', 'administrasi', '201905016', NULL, NULL, 1, '2026-08-12 06:31:07', '2026-08-12 06:31:07'),
(8, 'Windu Yanuar, S.Tr.Par', 'windu@gmail.com', '$2y$12$lSoajZ21Yo/r5H6w15UXMu6Vl5tOKDW0Ve7UHE7vq.tIWpOBYwIn6', 'staff', 'wakil_direktur', '202002019', NULL, NULL, 1, '2026-08-12 06:32:26', '2026-08-12 06:32:26'),
(9, 'Iif Miftahul Khoer, SE', 'iif@gmail.com', '$2y$12$QaAYJsX1rpfA0GJurK7SR.hUmnzjHh9DmRVyMeiBuvWC8Q74Yqawq', 'staff', 'administrasi', '202501116', NULL, NULL, 1, '2026-08-12 06:34:40', '2026-08-12 06:34:40'),
(10, 'Zahra Fadla Amalia, A. Ma. Par', 'zahra@gmail.com', '$2y$12$w.v3xBseoOzu7/qjcDk8oOds3cDMmX1rfdlNM8UaLK0NJRoaF8uF6', 'staff', 'administrasi', '12345678', NULL, NULL, 1, '2026-08-12 06:37:19', '2026-08-12 06:37:19'),
(11, 'DENA SOLIHIN GARNIDA ROSYADI', 'dena@gmail.com', '$2y$12$OgGXfstAGei3U9UpWRi.4uMwcdF1WwJv5gd/HYe6a80qCXgwMbWBW', 'staff', 'pengajar', '201810008', NULL, NULL, 1, '2026-08-12 06:39:43', '2026-08-12 06:39:43'),
(12, 'REGGY RIZQIARTA DWIRACHFI', 'reggy@gmail.com', '$2y$12$Wg2mVSmSR0sn4SPV0KGhFOGYWdYliFr9e742IDt2nXdqh8aDykcS6', 'staff', 'pengajar', '202007007', NULL, NULL, 1, '2026-08-12 06:41:30', '2026-08-12 06:41:30'),
(13, 'DEBI FITRIA DEWI OKTAPIANI, SE.Par', 'debi@gmailcom', '$2y$12$4/Y3UGP0qPOpcIHuKSJcme8JdrXoJ5KbTSI1IA24mrs9uMAw1qQxC', 'staff', 'pengajar', '201307010', NULL, NULL, 1, '2026-08-12 06:42:59', '2026-08-12 06:42:59'),
(14, 'Fadillah Wulansari., M.Pd', 'fad@gmail.com', '$2y$12$4Cfzbv6GYY76GxedWc38GuIV2dkohe/Dhmdt.2ZNEw.ND4MXX9Tgm', 'staff', 'pengajar', '1415049503', NULL, NULL, 1, '2026-08-12 06:43:46', '2026-08-12 06:43:46'),
(15, 'IWAN SETIAWAN', 'iwan@gmail.com', '$2y$12$r.A1dTRBUpha9vDrZCNWde31ztXYbi3XzvbQB.kQZKKuWHpTWlpau', 'staff', 'pengajar', '202505025', NULL, NULL, 1, '2026-08-12 06:44:53', '2026-08-12 06:44:53'),
(16, 'TONI SUHARDIMAN', 'toni@gmail.com', '$2y$12$FvUOOrR01FRjRkAyIQRYaeiDddF/U2g2cW/PHsjzuFRDrs8QcmN62', 'staff', 'pengajar', '123455', NULL, NULL, 1, '2026-08-12 06:45:44', '2026-08-12 06:45:44'),
(17, 'ROBI SURACHMAN, S.Pd', 'robi@gmail.com', '$2y$12$ZsFN7YBCDX39LC0abu/DF.dC7zQ0RgnooCVkxssFmzxX2d1nISnSG', 'staff', 'pengajar', '202504014', NULL, NULL, 1, '2026-08-12 06:46:39', '2026-08-12 06:46:39'),
(18, 'SONI KUSDINAR', 'soni@gmail.com', '$2y$12$/UfJ8r.sn4KkY2PvxlnVe.lmwcRw0A3YV0m6/kErAuC6rNMyLeOJy', 'staff', 'pengajar', '201607012', NULL, NULL, 1, '2026-08-12 06:47:46', '2026-08-12 06:47:46'),
(19, 'YOPSI APRILIKA, S.Pd', 'yopsi@gmail.com', '$2y$12$sdmac5cq3IOrsUo6WWqjc.DYi.jCai3JSR08UXUooB9eTYFC94sjK', 'staff', 'pengajar', '201207007', NULL, NULL, 1, '2026-08-12 06:48:44', '2026-08-12 06:48:44'),
(20, 'ALIP MAULANA', 'alip@gmail.com', '$2y$12$UEmbnlzy.pS3z7NnaYcBf.uerUq1EuTz7oKOoRoTQHpI5CrHhIOCq', 'staff', 'pengajar', '12345677', NULL, NULL, 1, '2026-08-12 06:49:54', '2026-08-12 06:49:54'),
(21, 'ARYAPUTRA BIJAKSANA', 'arya@gmail.com', '$2y$12$k0LzUtKVWI5ACwqzAHgx0eMN/UEPdmDihEeRMmZ4FtpNejGnRXu2a', 'staff', 'pengajar', '32145', NULL, NULL, 1, '2026-08-12 06:50:49', '2026-08-12 06:50:49'),
(22, 'Abdul Japar', '2623033@student.sihi.ac.id', '$2y$12$yuoISYZamXh8XuByMXZBtuv4YZG3k8TJgjrmxXwa5wU2Nj26uFfEK', 'mahasiswa', NULL, '2623033', NULL, NULL, 1, '2026-08-13 05:03:41', '2026-08-13 05:03:41'),
(23, 'Alfaira R Sabili Akbar', '2623034@student.sihi.ac.id', '$2y$12$g6.tFF.SLMG/d3zZM0qpveIbvgOn76OBFykJ6kX5ei2R1ZMDPv5SC', 'mahasiswa', NULL, '2623034', NULL, NULL, 1, '2026-08-13 05:03:42', '2026-08-13 05:03:42'),
(24, 'Anisa Agustiani', '2623035@student.sihi.ac.id', '$2y$12$FA7apSP8w6R18zaMcz3v.ORLJcvfCEz1Sww1Fzeue/Se03jgUfd5O', 'mahasiswa', NULL, '2623035', NULL, NULL, 1, '2026-08-13 05:03:42', '2026-08-13 05:03:42'),
(25, 'Ayu Fara Agustin', '2623036@student.sihi.ac.id', '$2y$12$sveoagWzrRT2rhLV7M7IluPY4w73MjvXGpBtPxr1oYdxHvbTrYnUG', 'mahasiswa', NULL, '2623036', NULL, NULL, 1, '2026-08-13 05:03:42', '2026-08-13 05:03:42'),
(26, 'Catur Putra Wijaya', '2623037@student.sihi.ac.id', '$2y$12$7wbukgT/oJHpir0dAiHbxuIpCGtjWLddgi5AN/Xl2B4tF6iT/et6a', 'mahasiswa', NULL, '2623037', NULL, NULL, 1, '2026-08-13 05:03:43', '2026-08-13 05:03:43'),
(27, 'Cica Susanti', '2623038@student.sihi.ac.id', '$2y$12$vCGumlAklf9hHE1dMmLDDe/MaFrg2QUg1poc84qp0LlSnNLOATNGG', 'mahasiswa', NULL, '2623038', NULL, NULL, 1, '2026-08-13 05:03:43', '2026-08-13 05:03:43'),
(28, 'Dimaz Satrio Ardiansyah', '2623039@student.sihi.ac.id', '$2y$12$wEkKB0uiRHvNvodya01k7OQa0nHjH.Ae0zIy.9rAc.ChFemkn9gca', 'mahasiswa', NULL, '2623039', NULL, NULL, 1, '2026-08-13 05:03:44', '2026-08-13 05:03:44'),
(29, 'Dina Septiani', '2623040@student.sihi.ac.id', '$2y$12$T6Ac35QRi3UY37zTGJUckeVcCqxa7VFG/pQob7MQTlbeVMz9CNi8C', 'mahasiswa', NULL, '2623040', NULL, NULL, 1, '2026-08-13 05:03:44', '2026-08-13 05:03:44'),
(30, 'Elnino Pratama Sebat', '2623041@student.sihi.ac.id', '$2y$12$Fc0e4Bd/tL8VJbqM7NuDjOPOE/5CgwlfbvIO4UInZUFzfPlhwlYN.', 'mahasiswa', NULL, '2623041', NULL, NULL, 1, '2026-08-13 05:03:44', '2026-08-13 05:03:44'),
(31, 'Fikriani Aulia', '2623042@student.sihi.ac.id', '$2y$12$6VdiuGZmiv0vRXs5gQSFPOB/4jz8exkPup9P2yql/0VVqrzxChZpa', 'mahasiswa', NULL, '2623042', NULL, NULL, 1, '2026-08-13 05:03:45', '2026-08-13 05:03:45'),
(32, 'Fina Komalasari', '2623043@student.sihi.ac.id', '$2y$12$Pq49/jY3nqquJgBfaLTi1.OTUw4Nnffg3KpEofZSwNbzYCnBSa/ru', 'mahasiswa', NULL, '2623043', NULL, NULL, 1, '2026-08-13 05:03:45', '2026-08-13 05:03:45'),
(33, 'Keysa Nazmi Hanifa', '2623044@student.sihi.ac.id', '$2y$12$yLgp3DJ3jW9dGDzBhtQybe4ycaaYjfCcss66aLgvk556gOGqEtqZ6', 'mahasiswa', NULL, '2623044', NULL, NULL, 1, '2026-08-13 05:03:45', '2026-08-13 05:03:45'),
(34, 'Keysa Nur Ikhsan', '2623045@student.sihi.ac.id', '$2y$12$XnEgJf7RueibKdM.u7SacuP9qlPVnnOEJqnjklv5W1ZfjCcUUkime', 'mahasiswa', NULL, '2623045', NULL, NULL, 1, '2026-08-13 05:03:46', '2026-08-13 05:03:46'),
(35, 'Levski Ray Gunawan', '2623046@student.sihi.ac.id', '$2y$12$Zs4VNWg5cszUiScJ5MsXgOXkkMmL4ks/JMKSI4D0mifs1gUcC0Cei', 'mahasiswa', NULL, '2623046', NULL, NULL, 1, '2026-08-13 05:03:46', '2026-08-13 05:03:46'),
(36, 'Muhammad Ammar Firdaus', '2623047@student.sihi.ac.id', '$2y$12$JjE9ZzaeoSDajRXUdpvGAO62PfT7h56bdpaUcO1bxhmXZCDRvw/AG', 'mahasiswa', NULL, '2623047', NULL, NULL, 1, '2026-08-13 05:03:46', '2026-08-13 05:03:46'),
(37, 'Naila Siti Nurhaliza', '2623048@student.sihi.ac.id', '$2y$12$oLSwABWII/00AROCRLfWoeZUcEgNK.i55mTznjMUCapxpSZiMZLyq', 'mahasiswa', NULL, '2623048', NULL, NULL, 1, '2026-08-13 05:03:47', '2026-08-13 05:03:47'),
(38, 'Nur Fitria Amalia', '2623049@student.sihi.ac.id', '$2y$12$XoJzx6RqWXAYvKk0HZCmE.DJm.88AUyQbMe8NtUVIXzO7cP6/mHCq', 'mahasiswa', NULL, '2623049', NULL, NULL, 1, '2026-08-13 05:03:47', '2026-08-13 05:03:47'),
(39, 'Regina Putri Amelia', '2623050@student.sihi.ac.id', '$2y$12$yEST8dzf4GWaANWcWIoXBuYtKLjjCGO.vW3BqOp.hWeRECMoAdG6e', 'mahasiswa', NULL, '2623050', NULL, NULL, 1, '2026-08-13 05:03:47', '2026-08-13 05:03:47'),
(40, 'Reyhan prakas al bukhari', '2623051@student.sihi.ac.id', '$2y$12$X5eBU8tTxeQmAr2IN6U4mOK9ETC9k/CYTanF/CTBcn73lx/CjZi06', 'mahasiswa', NULL, '2623051', NULL, NULL, 1, '2026-08-13 05:03:48', '2026-08-13 05:03:48'),
(41, 'Rika Indriyani', '2623052@student.sihi.ac.id', '$2y$12$qaNwHcw1uDQgTbnet5VBMeJJT.H8rNJjQojsDD.fXc1tLYgdlB2J6', 'mahasiswa', NULL, '2623052', NULL, NULL, 1, '2026-08-13 05:03:48', '2026-08-13 05:03:48'),
(42, 'Shilva Rizqiyatunissa', '2623053@student.sihi.ac.id', '$2y$12$rohaeOB/E3w5puw9kh5zS.dgl.qbO6oLJWXnEfsE6bonQBwHa8AOO', 'mahasiswa', NULL, '2623053', NULL, NULL, 1, '2026-08-13 05:03:49', '2026-08-13 05:03:49'),
(43, 'Silvi Nureani Oktaria', '2623054@student.sihi.ac.id', '$2y$12$sKSdulKJjj.i1fPAM4T8v.EzFdj1au3vGxa38pEzzlEVDmUxcPxiO', 'mahasiswa', NULL, '2623054', NULL, NULL, 1, '2026-08-13 05:03:49', '2026-08-13 05:03:49'),
(44, 'Siti Khodijah', '2623055@student.sihi.ac.id', '$2y$12$W0qsSmftAkoJWi233u69WulhqbVf477GjeWZnSkG1g10I5KNL8Js2', 'mahasiswa', NULL, '2623055', NULL, NULL, 1, '2026-08-13 05:03:49', '2026-08-13 05:03:49'),
(45, 'Vera Solihat', '2623056@student.sihi.ac.id', '$2y$12$JSeXtak8MSNlumFq/s749ufXaFPdlaFHoBEckFCWMcHYxewmlMoQq', 'mahasiswa', NULL, '2623056', NULL, NULL, 1, '2026-08-13 05:03:50', '2026-08-13 05:03:50'),
(46, 'Wita Febriyanti', '2623057@student.sihi.ac.id', '$2y$12$7cSPZXwm0kAIQxlWJ7dcxeud8cMXnx6YYZDeUPb1T6f69eetUNQ92', 'mahasiswa', NULL, '2623057', NULL, NULL, 1, '2026-08-13 05:03:50', '2026-08-13 05:03:50'),
(47, 'Yoga Bahari', '2623058@student.sihi.ac.id', '$2y$12$LV.QGySprLzkMvPcw7aImeP0fg8PCb2gKesN7DbBuH.fWSTvVDlOu', 'mahasiswa', NULL, '2623058', NULL, NULL, 1, '2026-08-13 05:03:50', '2026-08-13 05:03:50'),
(48, 'Zahara Yuliarti Dwi', '2623059@student.sihi.ac.id', '$2y$12$4KW0q9AJQ0fHlgTLuNK8ruYdHvKZjXwpiJOMorQLq32vymZhBxaPK', 'mahasiswa', NULL, '2623059', NULL, NULL, 1, '2026-08-13 05:03:51', '2026-08-13 05:03:51'),
(49, 'Zeva Zakiah Farrel', '2623060@student.sihi.ac.id', '$2y$12$ofOON/y93tEBMyO/b1.CtOjkwzBCURAo7E17xvebuDKDoxh2bhrm6', 'mahasiswa', NULL, '2623060', NULL, NULL, 1, '2026-08-13 05:03:51', '2026-08-13 05:03:51'),
(50, 'Zikri Ibrahim', '2623061@student.sihi.ac.id', '$2y$12$.S9B9oakyM40gu6zeXQ8Oe2BO9j1LSSSr2ewTUMfuXpz0yZe9HF5C', 'mahasiswa', NULL, '2623061', NULL, NULL, 1, '2026-08-13 05:03:51', '2026-08-13 05:03:51');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `jurusan_id` bigint UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `excerpt` text COLLATE utf8mb4_general_ci,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `start_datetime` datetime DEFAULT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `speaker` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `organizer` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `period` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Period (contoh: "2024-2029") - optional, jika NULL berarti event bersifat umum',
  `attachment` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `custom1` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `custom2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `custom3` text COLLATE utf8mb4_general_ci,
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `slug`, `category_id`, `jurusan_id`, `description`, `excerpt`, `image`, `banner`, `location`, `start_datetime`, `end_datetime`, `speaker`, `organizer`, `period`, `attachment`, `custom1`, `custom2`, `custom3`, `is_public`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(11, 'English Camp', 'english-camp', NULL, NULL, '<p><strong>SIHI English Camp — \"English Today, Global Hospitality Tomorrow\"</strong></p><p>&nbsp;</p><p>SIHI English Camp merupakan program immersif pembelajaran Bahasa Inggris yang diselenggarakan oleh Subang International Hotel Institute (SIHI). Kegiatan ini dirancang untuk membangun kepercayaan diri, kemampuan komunikasi, dan kecintaan peserta terhadap Bahasa Inggris melalui suasana belajar yang menyenangkan, interaktif, dan penuh kebersamaan. Mengusung tagline <strong>\"English Today, Global Hospitality Tomorrow\"</strong>, SIHI English Camp menekankan bahwa penguasaan Bahasa Inggris hari ini adalah kunci kesuksesan di industri perhotelan dan hospitality global di masa depan. Selama kegiatan berlangsung, peserta didorong untuk aktif berbahasa Inggris dalam berbagai aktivitas — mulai dari permainan interaktif, simulasi percakapan perhotelan, hingga penampilan kreatif di malam keakraban. Lebih dari sekadar belajar bahasa, English Camp menjadi wadah pembentukan karakter: melatih kerja sama tim, kepemimpinan, keberanian tampil di depan umum, serta wawasan lintas budaya — nilai-nilai yang menjadi fondasi utama insan hospitality profesional.</p>', '', 'agendas/images/k8u9tlHx4fiz3cbtl3SkqjJKEooL3f7rgXkJQiem.jpg', 'agendas/banners/1sXqsOZPimprU8YoIB4RlgS7fnSWhIgtzfP8OmJa.jpg', 'Kampus SIHI', '2026-08-10 08:00:00', '2026-09-13 08:00:00', '', 'LP3 SIHI', 'Tahun Ajaran 2026/2027', NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2026-08-10 05:00:37', '2026-08-10 05:55:28');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `connection` text COLLATE utf8mb4_general_ci NOT NULL,
  `queue` text COLLATE utf8mb4_general_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `jurusan_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `upload_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `slug`, `category_id`, `jurusan_id`, `title`, `description`, `upload_by`, `created_at`, `updated_at`) VALUES
(11, 'praktek-table-manner', 178, NULL, 'Praktek Table Manner', 'lorem ipsum', 1, '2026-08-03 08:55:38', '2026-08-03 08:55:38'),
(12, 'cooking', 177, NULL, 'Cooking', 'lorem ipsum', 1, '2026-08-03 08:59:05', '2026-08-03 08:59:05'),
(13, 'sertifikat-akreditasi', 180, NULL, 'Sertifikat Akreditasi', 'lorem ipsum', 1, '2026-08-03 09:18:09', '2026-08-03 09:18:09'),
(14, 'alumni-lulusan-sih', NULL, NULL, 'Alumni Lulusan SIHI', 'alumni sihi yang sekarang sudah membuktikan bahwa lulusan sihi mampu bersaing di dunia industri, dan mereka sekarang bekerja di kanca internasional', 1, '2026-08-04 05:02:38', '2026-08-04 05:02:38'),
(15, 'kunjungan-langsung-belajar-industri', 176, NULL, 'Kunjungan Langsung Belajar Industri', 'Kunjungan Langsung Belajar Industri atau KLBI merupakan program yang dilakukan 1 (satu) kali selama pembelajaran. Kegiatan selama KLBI  yaitu Pembelajaran langsung industri, peserta didik akan belajar dengan pihak industri secara langsung, Uji Kompetensi (Ujikom) bersama Industri, Tour de Hotel, Table Manner, dan beberapa kegiatan seminar mengenai pengetahuan perhotelan lainnya dengan natrasumber dari pihak industri. Kegiatan ini dilakukan selama 2 hari 1 malam. KLBI diadakan di hotel nasional dan/atau internasional bintang 4 atau 5. \r\n\r\nKegiatan KLBI ini bertujuan sebagai langkah nyata SIHI dalam memastikan kurikulum dan pembelajaran yag dilaksanakan telah sama dan berstandar industri, sehinggga para lulusan SIHI akan menjadi Sumber Daya Manusia (SDM) yang siap kerja serta memiliki keterampilan berstandar industri dan berdaya saing tinggi', 1, '2026-08-10 07:30:16', '2026-08-10 07:30:16'),
(16, 'day-one-english-camp', 175, NULL, 'Day One English Camp', 'kegiatan hari pertama pada english camp yaitu perkenalan serta pemaparan profile dan tata tertib di SIHI', 1, '2026-08-10 07:41:19', '2026-08-10 07:41:19'),
(17, 'olahraga-pagi-bersama-mahasiswai-baru-di-sihi', 175, NULL, 'olahraga pagi bersama mahasiswa/i baru di sihi', 'sebelum memulai kegiatan pembelajaran, mahasiswa/i baru sihi melakukan olahraga pagi bersama agar badan terasa sehat dan segar ketika pembelajaran berlangsung', 1, '2026-08-12 03:00:46', '2026-08-12 03:00:46');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` bigint UNSIGNED NOT NULL,
  `gallery_id` bigint UNSIGNED NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `gallery_id`, `image_path`, `sort_order`, `created_at`, `updated_at`) VALUES
(38, 11, 'gallery/foto-2_1785747338.jpeg', 0, '2026-08-03 08:55:39', '2026-08-03 08:55:39'),
(39, 12, 'gallery/foto-1_1785747545.jpeg', 0, '2026-08-03 08:59:05', '2026-08-03 08:59:05'),
(40, 13, 'gallery/foto-1_1785748689.jpeg', 0, '2026-08-03 09:18:09', '2026-08-03 09:18:09'),
(41, 13, 'gallery/foto-2_1785748689.jpeg', 1, '2026-08-03 09:18:10', '2026-08-03 09:18:10'),
(42, 13, 'gallery/foto-3_1785748690.jpeg', 2, '2026-08-03 09:18:10', '2026-08-03 09:18:10'),
(43, 13, 'gallery/foto-4_1785748690.jpeg', 3, '2026-08-03 09:18:10', '2026-08-03 09:18:10'),
(44, 14, 'gallery/galeri-alumni_1785819758.png', 0, '2026-08-04 05:02:43', '2026-08-04 05:02:43'),
(45, 15, 'gallery/cooking_1786347016.jpeg', 0, '2026-08-10 07:30:16', '2026-08-10 07:30:16'),
(46, 15, 'gallery/d2_1786347016.jpeg', 1, '2026-08-10 07:30:17', '2026-08-10 07:30:17'),
(47, 15, 'gallery/kbli_1786347017.jpeg', 2, '2026-08-10 07:30:18', '2026-08-10 07:30:18'),
(49, 16, 'gallery/day-1_1786347679.jpeg', 0, '2026-08-10 07:41:20', '2026-08-10 07:41:20'),
(50, 17, 'gallery/whatsapp-image-2026-08-12-at-053547_1786503646.jpeg', 0, '2026-08-12 03:00:51', '2026-08-12 03:00:51'),
(51, 17, 'gallery/whatsapp-image-2026-08-12-at-053548_1786503651.jpeg', 1, '2026-08-12 03:00:51', '2026-08-12 03:00:51');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_general_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint UNSIGNED NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `location` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `link_type` enum('page','structure','route','url','group') COLLATE utf8mb4_general_ci DEFAULT 'url',
  `page_id` bigint UNSIGNED DEFAULT NULL,
  `structure_id` bigint UNSIGNED DEFAULT NULL,
  `custom_url` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `icon` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `css_class` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `open_new_tab` tinyint(1) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_general_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `parent_id`, `location`, `title`, `slug`, `link_type`, `page_id`, `structure_id`, `custom_url`, `icon`, `css_class`, `order`, `is_active`, `open_new_tab`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, NULL, 'header', 'Beranda', NULL, 'route', NULL, NULL, '/site', NULL, NULL, 1, 1, 0, NULL, 1, 1, '2026-06-13 06:50:28', '2026-07-29 08:04:18'),
(2, NULL, 'header', 'Profil', NULL, 'group', NULL, NULL, NULL, NULL, NULL, 2, 1, 0, NULL, 1, NULL, '2026-06-14 13:09:56', '2026-07-29 08:04:18'),
(4, 2, 'header', 'Sejarah SIHI', NULL, 'page', 3, NULL, NULL, NULL, NULL, 2, 1, 0, NULL, 1, 1, '2026-06-14 13:10:51', '2026-07-31 04:25:41'),
(5, 2, 'header', 'Visi & Misi', NULL, 'page', 4, NULL, NULL, NULL, 'custom-class', 3, 1, 0, NULL, 1, 1, '2026-06-14 13:11:12', '2026-07-31 04:41:00'),
(6, 2, 'header', 'TIM manajemen DAN INSTRUKTUR', NULL, 'structure', 5, NULL, NULL, NULL, NULL, 4, 1, 0, NULL, 1, 1, '2026-06-14 13:11:28', '2026-08-10 04:40:04'),
(8, 2, 'header', 'Akreditasi', NULL, 'page', 6, NULL, NULL, NULL, NULL, 6, 1, 0, NULL, 1, 1, '2026-06-14 13:12:06', '2026-08-03 05:36:49'),
(9, 2, 'header', 'Fasilitas', NULL, 'route', NULL, NULL, '/fasilitas', NULL, NULL, 7, 1, 0, NULL, 1, 1, '2026-06-14 13:12:22', '2026-07-31 06:40:31'),
(17, NULL, 'header', 'Program Diploma', NULL, 'group', NULL, NULL, NULL, NULL, NULL, 4, 1, 0, NULL, 1, NULL, '2026-06-14 13:17:39', '2026-07-30 03:02:36'),
(18, 17, 'header', 'Diploma 2 (Fastrack) Layanan Hotel Terapung', NULL, 'route', NULL, NULL, '/jurusan/LHT', NULL, NULL, 2, 1, 0, NULL, 1, 1, '2026-06-14 13:20:44', '2026-07-31 03:20:47'),
(19, 17, 'header', 'Diploma 3 Perhotelan', NULL, 'route', NULL, NULL, '/jurusan/DPH', NULL, NULL, 3, 1, 0, NULL, 1, 1, '2026-06-14 13:21:33', '2026-08-04 08:28:05'),
(20, 17, 'header', 'Diploma 4 Pengelolaan Perhotelan', NULL, 'route', NULL, NULL, '/jurusan/PP', NULL, NULL, 4, 1, 0, NULL, 1, 1, '2026-06-14 13:26:26', '2026-08-10 07:33:13'),
(24, 17, 'header', 'Diploma 1 Perhotelan', NULL, 'route', NULL, NULL, '/jurusan/PH', NULL, '', 1, 1, 0, NULL, 1, 1, '2026-06-14 13:30:12', '2026-07-31 03:23:13'),
(25, NULL, 'header', 'Layanan', NULL, 'group', NULL, NULL, NULL, NULL, NULL, 6, 1, 0, NULL, 1, NULL, '2026-06-14 13:47:01', '2026-07-29 08:04:18'),
(26, 25, 'header', 'E-Learning', NULL, 'route', NULL, NULL, '/elearning/login', NULL, NULL, 1, 1, 0, NULL, 1, 1, '2026-06-14 13:47:31', '2026-08-05 07:54:14'),
(27, 25, 'header', 'Job Carier', NULL, 'route', NULL, NULL, '/karir', NULL, NULL, 2, 1, 0, NULL, 1, 1, '2026-06-14 13:48:02', '2026-08-04 09:39:18'),
(30, 2, 'header', 'Detail MOU', NULL, 'route', NULL, NULL, '/site/mitra-industri', NULL, NULL, 9, 1, 0, NULL, 1, 1, '2026-06-14 13:53:16', '2026-08-03 03:26:01'),
(31, NULL, 'header', 'Alumni', NULL, 'group', NULL, NULL, NULL, NULL, NULL, 7, 1, 0, NULL, 1, NULL, '2026-06-14 13:53:54', '2026-07-29 08:04:18'),
(32, 31, 'header', 'Tracer Study', NULL, 'route', NULL, NULL, '/alumni', NULL, NULL, 1, 1, 0, NULL, 1, 1, '2026-06-14 13:54:33', '2026-08-03 09:08:42'),
(34, 31, 'header', 'Testimoni Alumni', NULL, 'route', NULL, NULL, '/testimoni_alumni', NULL, NULL, 3, 1, 0, NULL, 1, NULL, '2026-06-14 13:55:53', '2026-06-14 13:57:13'),
(36, NULL, 'header', 'Publikasi', NULL, 'group', NULL, NULL, NULL, NULL, NULL, 8, 1, 0, NULL, 1, NULL, '2026-06-14 14:01:36', '2026-07-29 08:04:18'),
(37, 36, 'header', 'Berita & Pengumuman', NULL, 'route', NULL, NULL, '/berita', NULL, NULL, 1, 1, 0, NULL, 1, 1, '2026-06-14 14:01:55', '2026-08-03 09:22:42'),
(39, 36, 'header', 'Agenda & Event', NULL, 'route', NULL, NULL, '/agenda', NULL, NULL, 3, 1, 0, NULL, 1, NULL, '2026-06-14 14:02:47', '2026-06-14 14:02:47'),
(40, 36, 'header', 'Prestasi', NULL, 'route', NULL, NULL, '/prestasi', NULL, NULL, 4, 1, 0, NULL, 1, NULL, '2026-06-14 14:03:24', '2026-06-14 14:03:24'),
(41, 36, 'header', 'Gallery', NULL, 'route', NULL, NULL, '/gallery', NULL, NULL, 5, 1, 0, NULL, 1, 1, '2026-06-14 14:03:50', '2026-06-16 07:21:32'),
(43, NULL, 'jurusan_pplg', 'Kurikulum', NULL, 'page', 1, NULL, NULL, NULL, NULL, 1, 1, 0, NULL, 1, NULL, '2026-06-17 20:09:48', '2026-06-17 20:09:48'),
(45, NULL, 'header', 'Pelatihan Kerja', NULL, 'route', NULL, NULL, '/site/pelatihan-kerja', NULL, NULL, 5, 1, 0, NULL, 1, 1, '2026-07-29 07:59:55', '2026-08-03 08:24:07');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `batch` int NOT NULL
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
(51, '2026_06_26_000001_create_social_media_settings_and_home_section', 13),
(52, '2026_08_04_105944_create_registrations_table', 14),
(53, '2026_08_05_092235_create_elearning_tables', 15);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_general_ci,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `author` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `jurusan_id` bigint UNSIGNED DEFAULT NULL,
  `period` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Period (contoh: "2024-2029") - optional, jika NULL berarti berita bersifat umum',
  `published_at` datetime DEFAULT NULL,
  `status` enum('draft','published','archived') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'draft',
  `tags` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `view_count` int NOT NULL DEFAULT '0',
  `share_count` int NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `source` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_general_ci,
  `is_have_file` tinyint(1) NOT NULL DEFAULT '0',
  `file` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `content`, `excerpt`, `image`, `author`, `created_by`, `updated_by`, `category_id`, `jurusan_id`, `period`, `published_at`, `status`, `tags`, `view_count`, `share_count`, `is_featured`, `source`, `meta_title`, `meta_description`, `is_have_file`, `file`, `created_at`, `updated_at`) VALUES
(16, 'Penerimaan Mahasiswa Baru', 'penerimaan-mahasiswa-baru', '<p>Pendaftaran penerimaan mahasiswa baru telah dibuka ayo segera daftarkan diri anda menjadi calon mahasiswa di Subang International Hotel Institute, pendidikan satu tahun siap kerja dan mampu bersaing di dunia kerja, biaya pendaftaran murah dan terjangkau, Free Wifi, ruangan praktek yang nyaman, TUNGGUU APALAGII AYOOO SEGERAA DAFTARRRR</p>', 'Penerimaan Mahasiswa Baru', 'news/f_1785471363.jpeg', 'Admin Subang International Hotel Institute', 1, 1, 157, NULL, 'Tahun Ajaran 2026/2027', '2026-06-15 05:49:12', 'published', NULL, 4, 0, 1, NULL, 'Penerimaan Mahasiswa Baru', 'Penerimaan Mahasiswa Baru', 0, NULL, '2026-06-14 22:49:12', '2026-08-12 03:01:37'),
(22, 'Penyambutan Sekaligus Penempatan Ke Asrama Mahasiswa Baru Di Kampus LP3 SIHI', 'penyambutan-sekaligus-penempatan-ke-asrama-mahasiswa-baru-di-kampus-lp3-sihi', '<p>Pada hari Minggu jam 10.00-15.00 Kampus LP3 Sihi melakukan penyambutan kedatangan mahasiswa baru, sekaligus langsung mengarahkan mahasiswa baru ke asrama mereka untuk melakukan penyimpanan barnag bawaan mereka&nbsp;</p>', NULL, 'news/whatsapp-image-2026-08-09-at-194415-1_1786338498.jpeg', 'Admin Subang International Hotel Institute', 1, 1, 160, NULL, 'Tahun Ajaran 2026/2027', '2026-08-10 12:08:23', 'published', NULL, 1, 0, 1, NULL, 'Penyambutan Sekaligus Penempatan Ke Asrama Mahasiswa Baru Di Kampus LP3 SIHI', NULL, 0, NULL, '2026-08-10 05:08:23', '2026-08-10 09:17:13'),
(23, 'Class English Camp Day one', 'class-english-camp-day-one', '<p>pada tanggal 10 agustus 2026, di kegiatan day one Class English Camp, para mahasiswa melakukan kegiatan belajar sekaligus perkenalan terhadap semua instruktur yang ada di sihi, dan pemaparan jadwal, profile dan tata tertib yang ada di sihi</p>', NULL, 'news/day-1_1786338872.jpeg', 'Admin Subang International Hotel Institute', 1, NULL, 159, NULL, 'Tahun Ajaran 2026/2027', '2026-08-10 12:14:32', 'published', NULL, 2, 0, 1, NULL, 'Class English Camp Day one', NULL, 0, NULL, '2026-08-10 05:14:32', '2026-08-11 03:20:54'),
(25, 'Class English Camp Day 3', 'class-english-camp-day-3', '<p>Pada hari rabu tanggal 12 agustus 2026, mahasiswa baru sihi sedang melanjutkan kegiatan english camp yang dimana kegiatan dimulai dari olahraga pagi bersama, lalu dilanjut sholat dhuha dan kemudian dilanjut dengan pembelajaran dikelas dengan jadwal yang sudah diberikan.</p>', NULL, '[\"news\\/Z8aNbpCKErMINNBN9Dtt1K6ZPXwjdeJVMYPrPNvq.jpg\",\"news\\/EvgHOT4tnnJXzLaer8h2jaV6cQEn5Ez8EordWuDz.jpg\"]', 'Admin Subang International Hotel Institute', 1, NULL, 159, NULL, 'Tahun Ajaran 2026/2027', '2026-08-12 09:55:38', 'published', NULL, 2, 0, 1, NULL, 'Class English Camp Day 3', NULL, 0, NULL, '2026-08-12 02:55:38', '2026-08-12 02:55:49');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `page_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'page',
  `structure_common_id` bigint UNSIGNED DEFAULT NULL,
  `structure_type` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `period` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jurusan_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_general_ci,
  `excerpt` text COLLATE utf8mb4_general_ci,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `custom1` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `custom2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `custom3` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `custom4` text COLLATE utf8mb4_general_ci,
  `custom5` text COLLATE utf8mb4_general_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `slug`, `page_type`, `structure_common_id`, `structure_type`, `period`, `jurusan_id`, `title`, `subtitle`, `content`, `excerpt`, `image`, `banner`, `attachment`, `custom1`, `custom2`, `custom3`, `custom4`, `custom5`, `is_active`, `is_public`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'sambutan-kepala-sekolah', 'page', NULL, NULL, NULL, NULL, 'Sambutan Kepala Sekolah', NULL, '<h2>Assalamu\'alaikum Warahmatullahi Wabarakatuh<br>&nbsp;</h2><p style=\"text-align:justify;\">Puji syukur kita panjatkan ke hadirat Allah SWT atas segala rahmat dan karunia-Nya sehingga SMK PGRI Subang terus dapat berkontribusi dalam mencetak generasi yang unggul, berkarakter, dan siap menghadapi tantangan dunia kerja maupun pendidikan di masa depan.</p><p style=\"text-align:justify;\">Selamat datang di website resmi SMK PGRI Subang. Website ini hadir sebagai sarana informasi dan komunikasi bagi peserta didik, orang tua, alumni, dunia usaha dan dunia industri, serta masyarakat luas untuk mengenal lebih dekat profil, program, prestasi, dan berbagai kegiatan yang ada di sekolah kami.</p><p style=\"text-align:justify;\">Sebagai sekolah kejuruan yang berkomitmen pada peningkatan kualitas pendidikan, SMK PGRI Subang senantiasa berupaya menghadirkan pembelajaran yang relevan dengan perkembangan teknologi dan kebutuhan industri. Melalui berbagai program unggulan, kerja sama dengan dunia usaha dan dunia industri, serta dukungan tenaga pendidik yang profesional, kami bertekad menciptakan lulusan yang kompeten, berakhlak mulia, kreatif, inovatif, dan siap bersaing di era global.</p><p style=\"text-align:justify;\">Kami percaya bahwa pendidikan yang berkualitas tidak hanya membentuk kemampuan akademik dan keterampilan, tetapi juga karakter, kedisiplinan, dan tanggung jawab sebagai bekal kehidupan bermasyarakat.</p><p style=\"text-align:justify;\">Akhir kata, kami mengucapkan terima kasih atas kepercayaan dan dukungan semua pihak terhadap SMK PGRI Subang. Semoga website ini dapat memberikan manfaat dan menjadi media informasi yang efektif bagi seluruh pengunjung.</p><p style=\"text-align:justify;\">Wassalamu\'alaikum Warahmatullahi Wabarakatuh.</p><p>&nbsp;</p><p>&nbsp;</p><p><strong>Kepala SMK PGRI Subang</strong></p><p><strong>Andika Aulia</strong></p>', NULL, 'pages/screenshot-2026-05-29-215617_1781473032.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, '2026-06-14 21:37:12', '2026-06-14 21:37:12'),
(2, 'Struktur Institusi', 'structure', 258, 'yayasan', 'Tahun Ajaran 2026/2027', NULL, 'Struktural Institusi', NULL, NULL, NULL, 'pages/backgroundd_1785483811.jpeg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2026-06-17 17:01:59', '2026-07-31 07:43:31'),
(3, 'sejarah-sihi', 'page', NULL, NULL, NULL, NULL, 'Sejarah SIHI', NULL, '<p>Subang Internasional Hotel Institute (SIHI) merupakan lembaga pendidikan dan pelatihan di bawah naungan Yayasan Utomo Bhakti, didirikan pada tahun 2004 oleh Raden Sutijadi. Bertempat di jl. Ki Hajar Dewantara Gg. Bumisari Rt 042/Rw 005 Kel. Dangdeur Kec.Subang, Subang-Jawa Barat. Berfokus pada pengembangan pendidikan dan pelatihan perhotelan dan kapal pesiar, SIHI mencetak individu tenaga ahli di bidang perhotelan dan kapal pesiar berkepribadian disiplin dan religius serta memeiliki kesiapan untuk menghadapi persaingan industri global. SIHI telah mencetak ratusan tenaga ahli di bidang perhotelan dan kapal pesiar yang tersebar di dalam maupun luar negeri meliputi Asia, Eropa, dan Timur Tengah. SIHI telah terakreditasi dan juga bekerja sama dengan industri pariwisata, restoran, hotel dan agen kapal pesiar untuk menyelaraskan pendidikan dan pelatihan yang kami terapkan sesuai dengan kebutuhan industri yang di butuhkan berkelanjutan.</p>', NULL, 'pages/sejarah_1785471898.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, '2026-07-31 04:24:59', '2026-07-31 04:24:59'),
(4, 'visi-misi-tujuan-sihi', 'page', NULL, NULL, NULL, NULL, 'Visi Misi & Tujuan SIHI', NULL, '<p><strong>VISI :</strong></p><p>Menjadikan pusat lembaga pendidikan dan pelatihan hotel dan kapal pesiar yang unggul di tingkat nasional dan internasional.</p><p>&nbsp;</p><p><strong>MISI :</strong></p><ol><li>Mendidik siswa yang siap pakai.</li><li>Menyiapkan tenaga kerja untuk merebut peluang kerja khususnya bidang perhotelan dan kapal pesiar nasional dan internasional</li></ol><p><strong>TUJUAN :</strong></p><p>Menciptakan lulusan yang memiliki kompetensi unggul dan handal di dunia kerja perhotelan dan kapal pesiar baik nasional maupun internasional</p>', NULL, 'pages/bg-visi-misi_1785472792.jpeg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, '2026-07-31 04:39:52', '2026-07-31 04:39:52'),
(5, 'tim-manajemen-dan-instruktur', 'structure', NULL, 'yayasan', 'Tahun Ajaran 2026/2027', NULL, 'TIM manajemen DAN INSTRUKTUR', NULL, NULL, NULL, 'pages/backgroundd_1785919642.jpeg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2026-07-31 07:01:23', '2026-08-10 04:39:47'),
(6, 'akreditasi-sihi', 'page', NULL, NULL, 'Tahun Ajaran 2026/2027', NULL, 'Akreditasi SIHI', NULL, '<p>Subang International Hotel Institute (SIHI) merupakan lembaga pendidikan dan pelatihan di bawah naungan Yayasan Utomo Bhakti yang telah memperoleh akreditasi resmi sebagai pengakuan atas mutu penyelenggaraan pendidikan. Akreditasi ini menjadi jaminan bahwa seluruh program pendidikan dan pelatihan yang diselenggarakan oleh SIHI telah memenuhi standar kualitas yang ditetapkan oleh badan akreditasi nasional.<br>Melalui proses akreditasi, SIHI terus melakukan evaluasi dan peningkatan berkelanjutan dalam aspek kurikulum, sarana prasarana, kualitas pengajar, serta tata kelola lembaga, demi menghasilkan lulusan yang kompeten dan diakui oleh dunia industri perhotelan dan kapal pesiar, Sebagai bentuk komitmen terhadap mutu pendidikan, SIHI telah meraih akreditasi yang mengakui kualitas penyelenggaraan pendidikan dan pelatihan di bidang perhotelan dan kapal pesiar. Akreditasi ini mencerminkan:<br>Kurikulum yang selaras dengan standar kompetensi industri nasional dan internasional<br>Tenaga pendidik profesional dan berpengalaman di bidang hospitality<br>Fasilitas praktik modern yang mendukung pembelajaran berbasis industri<br>Kerjasama strategis dengan hotel, restoran, dan agen kapal pesiar ternama<br>Dengan akreditasi ini, SIHI terus berupaya mencetak tenaga ahli perhotelan dan kapal pesiar yang siap kerja, berdaya saing global, dan tersebar di berbagai negara di Asia, Eropa, dan Timur Tengah.</p>', NULL, 'pages/foto-2_1785735524.jpeg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 1, '2026-08-03 05:36:02', '2026-08-03 05:38:44');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_general_ci,
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
  `id` bigint UNSIGNED NOT NULL,
  `kode` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `singkatan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `ka_prodi` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `akreditasi` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `video_url` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tahun_berdiri` int UNSIGNED DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci,
  `deskripsi_singkat` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `visi` text COLLATE utf8mb4_general_ci,
  `misi` text COLLATE utf8mb4_general_ci,
  `tujuan` text COLLATE utf8mb4_general_ci,
  `profil_lulusan` text COLLATE utf8mb4_general_ci,
  `kurikulum` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `order` smallint UNSIGNED NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `kode`, `singkatan`, `nama`, `ka_prodi`, `akreditasi`, `logo`, `banner`, `video_url`, `email`, `phone`, `tahun_berdiri`, `deskripsi`, `deskripsi_singkat`, `visi`, `misi`, `tujuan`, `profil_lulusan`, `kurikulum`, `order`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(4, 'PP', 'D4PP', 'Diploma 4 Pengelolaan Perhotelan, gelar S.Tr.Par', NULL, 'A', 'programs/nmzPUdTGcpdZCGFuALHu76eZOQraQ4q5hTRblxyD.jpg', NULL, '', '', '', NULL, '', 'Menyiapkan tenaga profesional pariwisata konseptual yang dapat menggabungkan keterampilan teknis dan keterampilan manajerial dan etika perhotelan berdasarkan standar kompetensi untuk bidang Operasi Perhotelan.', '', '', '', '', 'Kurikulum Merdeka', 4, 1, NULL, 1, '2026-06-14 20:07:00', '2026-08-10 07:19:27'),
(5, 'DPH', 'D3PH', ' Diploma 3 Perhotelan, gelar A.Md.Par', NULL, 'A', 'programs/01Hzag82vnlNkCrUVmf79tACmaM6i7CI0F5beiBg.jpg', NULL, '', '', '', NULL, '', 'Mencetak SDM profesional dalam hal manajerial yang mampu mensinergikan antara penguasaan manajemen dengan keahlian bidang operasional perhotelan dan usaha perjalanan wisata. Dijamin pendampingan karir sampai kerja di semester 4.', '', '', '', '', 'Kurikulum Merdeka', 5, 1, NULL, 1, '2026-06-14 20:07:00', '2026-08-10 07:18:20'),
(6, 'LHT', 'LHT', 'Diploma 2 (Fastrack) Layanan Hotel Terapung, gelar', NULL, 'A', 'programs/e3EOhH1ybVQZAbr2FM8xGdnLcRKWQzud0jvMFSQQ.jpg', NULL, '', '', '', NULL, '', 'Lulusan dipersiapkan untuk cepat bekerja di industri dengan kompetensi layanan hotel dan kapal pesiar, solusi tepat untuk Anda yang berminat kerja di kapal pesiar', '', '', '', '', 'Kurikulum Merdeka', 6, 1, NULL, 1, '2026-06-14 20:07:00', '2026-08-10 07:15:39'),
(7, 'PH', 'PH', 'Diploma 1 Perhotelan, gelar A.P.Par', NULL, 'A', 'programs/HC3tdtekd78MJKLBLbKqfZJ4Vn3Xd9ZmnOHThTcJ.jpg', 'programs/banners/Px5dFbgXoyJCkdxIK8jFBK7YawlwAt3jHKSqiNU2.jpg', '', '', '', NULL, '', 'Solusi untuk mahasiswa yang ingin supaya cepat bekerja di industri perhotelan, dijamin pendampingan karir sampai kerja setelah lulus.', '', '', '', '', 'Kurikulum Merdeka', 7, 1, NULL, 1, '2026-06-14 20:07:00', '2026-08-10 07:18:48');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_kelamin` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_lahir` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `asal_sekolah` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat_rumah` text COLLATE utf8mb4_general_ci NOT NULL,
  `tahun_lulus` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `jurusan_sekolah` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `no_whatsapp` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `no_ortu` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `program` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Baru',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `nama_lengkap`, `jenis_kelamin`, `tgl_lahir`, `asal_sekolah`, `alamat_rumah`, `tahun_lulus`, `jurusan_sekolah`, `no_whatsapp`, `no_ortu`, `email`, `program`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Riko Tegal', 'Perempuan', '1945-08-17', 'SMAN 1 KALIJATI', 'TEGAL KELAPA TAPI TIDAK ADA KELAPA', '2023', 'IPS', '08432942374287', '028340174921387', 'apaaja@gmail.com', 'Diploma 3 Perhotelan, gelar A.Md.Par', 'Diterima', '2026-08-04 04:19:52', '2026-08-04 04:48:51'),
(2, 'sadd', 'Laki-laki', '2026-08-04', 'sdq', 'dada', '2026', 'ipa', '03402342034', '09349283492', 'naonwae@gmail.com', 'Diploma 1 Perhotelan, gelar A.P.Par', 'Baru', '2026-08-04 04:53:54', '2026-08-04 04:53:54');

-- --------------------------------------------------------

--
-- Table structure for table `secretariat`
--

CREATE TABLE `secretariat` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nip` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `position` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `division` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `security_logs`
--

CREATE TABLE `security_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_general_ci,
  `action` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('allowed','blocked','suspicious') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'allowed',
  `details` text COLLATE utf8mb4_general_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `security_settings`
--

CREATE TABLE `security_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `value` text COLLATE utf8mb4_general_ci,
  `description` text COLLATE utf8mb4_general_ci,
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
  `id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_general_ci,
  `payload` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `last_activity` int NOT NULL
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
  `id` bigint UNSIGNED NOT NULL,
  `institution_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `managed_by` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `office_hours` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fax` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `website` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `google_map` text COLLATE utf8mb4_general_ci,
  `logo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `logo_square` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `youtube` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `whatsapp` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tiktok` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ppdb_link` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `vision` text COLLATE utf8mb4_general_ci,
  `mission` text COLLATE utf8mb4_general_ci,
  `description` text COLLATE utf8mb4_general_ci,
  `active_period` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `institution_name`, `managed_by`, `address`, `email`, `phone`, `office_hours`, `fax`, `website`, `google_map`, `logo`, `logo_square`, `favicon`, `facebook`, `instagram`, `twitter`, `linkedin`, `youtube`, `whatsapp`, `tiktok`, `ppdb_link`, `vision`, `mission`, `description`, `active_period`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Subang International Hotel Institute', NULL, 'Jl. DI.Panjaitan No.73, Karanganyar, Kec. Subang, Kabupaten Subang, Jawa Barat 41211', 'sihi.online@gmail.com', '(0260) 4247867', NULL, '-', 'https://smkpgrisubang.sch.id', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.6563537776665!2d107.76508517428738!3d-6.564986864175238!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e693b633769f013%3A0xb75fb4a255b69bd5!2sSIHI%20-%20Subang%20International%20Hotel%20Institute!5e0!3m2!1sid!2sid!4v1785379602260!5m2!1sid!2sid\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"strict-origin-when-cross-origin\"></iframe>', 'settings/logo-sihi_1785379797.png', NULL, NULL, 'https://www.facebook.com/sihi.subang', 'https://instagram.com/sihi.subang', 'https://x.com/lp3sihi', NULL, 'https://www.youtube.com/@sihi.subang6609', '6282123230470', 'https://www.tiktok.com/@sihi.subang', '', 'Menjadikan pusat lembaga pendidikan dan pelatihan hotel dan kapal pesiar yang unggul di tingkat nasional dan internasional', '1. Mendidik siswa yang siap pakai\n2. Menyiapkan tenaga kerja untuk merebut peluang kerja khususnya bidang perhotelan dan kapal pesiar nasional dan internasional', 'Sihi merupakan lembaga Pendidikan dan Pelatihan Perhotelan dan Kapal pesiar dengan program pendidikan satu tahun. 6 bulan Materi dan 6 bulan On The Job Training.', '2026-2027', 1, 1, '2026-06-11 21:12:52', '2026-08-04 08:19:20');

-- --------------------------------------------------------

--
-- Table structure for table `structural_members`
--

CREATE TABLE `structural_members` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'male',
  `birth_place` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jabatan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `order` smallint UNSIGNED NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_general_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `structural_members`
--

INSERT INTO `structural_members` (`id`, `name`, `photo`, `gender`, `birth_place`, `birth_date`, `address`, `phone`, `email`, `jabatan`, `order`, `is_active`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'ROSWANTI, SH', 'structural/structural_6a2ba9cee5ad27.69841199.jpg', 'female', '-', NULL, '-', '-', 'yayasaan@yayasan.org', 'Ketua Yayasan', 1, 1, '', 1, 1, '2026-06-11 21:12:53', '2026-08-05 08:59:16'),
(2, 'DINAS TENAGA KERJA', 'structural/dummy.jpg', 'male', '-', NULL, '-', '-', 'pembina@yayasan.org', 'Pembina', 2, 1, '-', 1, 1, '2026-06-11 21:12:53', '2026-07-30 09:33:28'),
(4, 'HIPKI', 'structural/dummy.jpg', 'male', '-', NULL, '-', '-', 'penasehat@gmail.com', 'Penasehat', 1, 1, '-', 1, 1, '2026-06-16 09:29:46', '2026-07-30 09:27:27'),
(5, 'Asmi Putri Purwaningsih,S.I.Kom', 'structural/structural_6a793c884d3cb4.56894039.jpg', 'female', 'Madiun', '1995-06-07', 'Dangdeur,Subang', '', 'asmiputrip@gmail.com', 'Sekertaris Direktur', 2, 1, 'Lulus dari Universitas Pasundan Program Studi S1 Ilmu Komunikasi pada tahun 2017 dan saat ini menjabat sebagai Sekretaris Direktur dan aktif mengajar pada bidang Public Speaking dan Pendidikan Karakter.', 1, 1, '2026-06-16 09:29:46', '2026-08-10 02:50:48'),
(6, 'Budi Sentosa', 'structural/dummy.jpg', 'male', '-', NULL, '-', '-', 'wadir@yayasan.org', 'Wakil Direktur Bidang Kemahasiswaan Dan Alumni', 3, 1, '-', 1, 1, '2026-06-16 09:29:46', '2026-07-30 09:37:22'),
(7, 'Yushini Muliawanti, S.Pd', 'structural/structural_6a6b193ca80882.65772646.jpg', 'female', 'Subang', '1995-01-28', 'Cigadung,Subang', '0853-5315-5308', 'Yushi.sihisubang@gmail.com', 'Direktur Lembaga', 4, 1, 'Lulus dari STKIP Subang Program Studi S1 Pendidikan Bahasa Inggris pada tahun 2016 dan saat ini menjabat sebagai Direktur Lembaga SIHI periode 2024 - 2029.', 1, 1, '2026-06-16 09:29:46', '2026-08-10 02:41:00'),
(8, 'Hemmy Nur Hamidah,S.PD', 'structural/structural_6a793cfc5a04e0.40057739.jpg', 'female', '-', '1991-02-09', 'Dangdeur,Subang', '-', 'wadir@yayasan.org', 'Wakil Direktur Bidang Akademik', 6, 1, 'Lulus dari Universitas Pendidikan Indonesia Program Studi S1 Pendidikan Bahasa Inggris pada tahun 2014 dan saat ini menjabat sebagai Wakil Direktur bidang akademik. Sebelumnya pernah menjadi pengajar bahasa inggris, translator, customer service, admin to personal manager, social media manager dan content creator.', 1, 1, '2026-06-16 09:29:46', '2026-08-10 02:52:44'),
(9, 'Windu Yanuar, S.Tr.Par', 'structural/structural_6a793db3031bf4.24564458.jpg', 'female', 'Subang', '1982-01-10', 'Dangdeur,Subang', '-', 'wadir@yayasan.org', 'Wakil Direktur Bidang Marketing Dan Instruktur Bar', 3, 1, 'Merupakan lulusan D3 Usaha Akomodasi/Perhotelan di STIEPAR YAPARI AKTRIPA Bandung dan melanjutkan kuliah D4 Manajemen Perhotelan di Politeknik Sahid Jakarta. Saat ini masih berkarir di Virgin Voyages Cruiseline sebagai Bar dan juga aktif sebagai pengajar Bartender di LP3 SIHI', 1, 1, '2026-06-17 09:53:03', '2026-08-10 02:58:21'),
(10, 'HILSI', 'structural/dummy.jpg', 'male', '-', NULL, '-', '-', 'penasehat@yayasan.org', 'Penasehat', 5, 1, '-', 1, 1, '2026-06-17 09:53:03', '2026-07-30 09:30:25'),
(12, 'DINAS PENDIDIKAN', 'structural/dummy.jpg', 'male', '-', NULL, '-', '-', 'pembina@yayasan.org', 'Pembina', 7, 1, '', 1, 1, '2026-06-17 09:53:03', '2026-07-30 09:32:36'),
(13, 'R. Utomo Hadi Sutijadi Putro', 'structural/structural_6a6b1be65d9f06.18946812.jpg', 'male', '-', NULL, '-', '-', 'asdir@yayasan.org', 'Asisten Wakil DIrektur', 0, 1, '-', 1, NULL, '2026-07-30 09:39:50', '2026-07-30 09:39:50'),
(14, 'Yopsi Aprilika, S.Pd', 'structural/structural_6a6b1c1e16e881.54917704.jpg', 'male', '-', NULL, '-', '-', 'bidang@yayasan.org', 'Bidang Bahasa', 0, 1, '-', 1, NULL, '2026-07-30 09:40:46', '2026-07-30 09:40:46'),
(15, 'Robi Surachman, S.Pd', 'structural/structural_6a6b1c45de3109.62481978.jpg', 'male', '-', NULL, '-', '-', 'bidang@yayasan.org', 'Bidang Bahasa', 0, 1, '-', 1, NULL, '2026-07-30 09:41:25', '2026-07-30 09:41:25'),
(16, 'Anugrah J. S.', 'structural/structural_6a7941317717a3.39714698.jpg', 'male', '-', NULL, '-', '-', 'bidang@yayasan.org', 'Bidang Marketing', 0, 1, 'Saat ini aktif sebagai Praktisi Pariwisata sebagai Tour Planner dan Tour Leader yang telah memiliki sertifikasi BNSP. Sebelumnya pernah menjabat sebagai Manajer Marketing di Travel Cahaya Raudhah Subang selama 5 tahun. ', 1, 1, '2026-07-30 09:42:15', '2026-08-10 03:10:41'),
(17, 'Soni Kusdinar', 'structural/structural_6a6b1cb8ba8c48.81857004.jpg', 'male', '-', NULL, '-', '-', 'bidang@yayasan.org', 'Bidang Bimbingan Karir', 0, 1, '-', 1, NULL, '2026-07-30 09:43:20', '2026-07-30 09:43:20'),
(18, 'Ratni', 'structural/structural_6a6b1cf8e9e0c2.33660000.jpg', 'female', '-', NULL, '-', '-', 'bidang@yayasan.org', 'Pembantu Umum', 0, 1, '-', 1, NULL, '2026-07-30 09:44:24', '2026-07-30 09:44:24'),
(19, 'Dian Lestari', 'structural/structural_6a79450f3d5014.07094920.jpg', 'female', 'Subang', '1972-10-06', 'Nyimpung,Subang', '-', 'bidang@yayasan.org', 'Bidang Kemitraan', 0, 1, 'Merupakan praktisi yang berpengalaman di bidang kecantikan di Kabupaten Subang. Selain itu, aktif menjalin relasi dengan pemerintahan daerhan, BUMD, dan lembaga lainnya.', 1, 1, '2026-07-30 09:45:33', '2026-08-10 03:27:11'),
(20, 'Ryan Firmansyah', 'structural/structural_6a6b1d5abf6972.93612511.jpg', 'male', '-', NULL, '-', '-', 'bidang@yayasan.org', 'Bidang Digital Marketing', 0, 1, '-', 1, NULL, '2026-07-30 09:46:02', '2026-07-30 09:46:02'),
(21, 'Zahra Fadla Amalia, A. Ma. Par', 'structural/structural_6a79409d2841c8.18613797.jpg', 'female', '-', NULL, '-', '-', 'menyusul@gmail.com', 'Staff Administrasi', 0, 1, 'Merupakan lulusan D2 Layanan Hotel Terapung, kolaborasi LP3 SIHI dan Politeknik Sahid. Memiliki pengalaman di hotel di La Berza Resort, Ciater sebagai Front Desk Agent dan room attendant. Selain itu memiliki pengalaman di Light Hotel Penang, Malaysia sebagai waitress dan room attendant. Saat ini berkarir sebagai staff administrasi di LP3 SIHI.', 1, NULL, '2026-08-10 03:08:13', '2026-08-10 03:08:13'),
(22, 'DODDY P, S.E', 'structural/structural_6a7941d36ba012.47470879.jpg', 'male', '-', NULL, '-', '-', 'menyusul@gmail.com', 'Bidang Marketing', 0, 1, 'Merupakan praktisi di bidang Perekonomian dan dibidang Marketing, sebelumnya menjabat sebagai kepala cabang Travel Umroh PT Cahaya Raudah di Subang Utara.', 1, NULL, '2026-08-10 03:13:23', '2026-08-10 03:13:23'),
(23, 'IIF MIFTAHUL KHOER., S.E', 'structural/structural_6a7c1dad4fe022.32093445.jpg', 'male', 'Subang', '1995-05-07', 'Soklat, Subang', '-', 'Iifmiftah76@gmail.com', 'WAKIL DIREKTUR BIDANG KEUANGAN', 0, 1, 'Adalah lulusan dari STIE Tribuana Bekasi yang memiliki pengalaman 5 tahun sebagai manager di beberapa perusahaan yang bergerak di bidang migas. Saat ini menjabat sebagai wakil direktur bagian keuangan di SIHI.', 1, 1, '2026-08-10 08:17:43', '2026-08-12 07:15:57');

-- --------------------------------------------------------

--
-- Table structure for table `structure_members`
--

CREATE TABLE `structure_members` (
  `id` bigint UNSIGNED NOT NULL,
  `common_id` bigint UNSIGNED NOT NULL COMMENT 'Reference ke common (structure: Dapil 1, Komisi A, dll)',
  `section_id` bigint UNSIGNED DEFAULT NULL COMMENT 'FK to structure_sections',
  `member_id` bigint UNSIGNED NOT NULL COMMENT 'Reference ke members',
  `member_type` varchar(100) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'AppModelsTeacher' COMMENT 'Polymorphic relation class name',
  `period` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Period (contoh: "2019-2024") - reference ke common atau string',
  `position` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Posisi di struktur (contoh: "Ketua", "Anggota", "Wakil Ketua")',
  `order` int NOT NULL DEFAULT '0' COMMENT 'Urutan tampil',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `structure_members`
--

INSERT INTO `structure_members` (`id`, `common_id`, `section_id`, `member_id`, `member_type`, `period`, `position`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(28, 258, 13, 7, 'App\\Models\\StructuralMember', 'Tahun Ajaran 2026/2027', 'Direktur Lembaga', 1, 1, '2026-07-30 09:50:51', '2026-07-30 09:50:51'),
(33, 258, 18, 5, 'App\\Models\\StructuralMember', 'Tahun Ajaran 2026/2027', 'Sekertaris Direktur', 2, 1, '2026-07-30 09:52:05', '2026-07-30 09:52:05'),
(44, 258, 19, 8, 'App\\Models\\StructuralMember', 'Tahun Ajaran 2026/2027', 'Wakil Direktur Bidang Akademik', 8, 1, '2026-07-31 02:52:39', '2026-07-31 02:52:39'),
(45, 258, 19, 9, 'App\\Models\\StructuralMember', 'Tahun Ajaran 2026/2027', 'Wakil Direktur Bidang Marketing Dan Instruktur Bar', 9, 1, '2026-07-31 02:53:01', '2026-08-10 02:58:59'),
(78, 258, 27, 21, 'App\\Models\\StructuralMember', 'Tahun Ajaran 2026/2027', 'Staff Administrasi', 10, 1, '2026-08-10 03:08:46', '2026-08-10 03:08:46'),
(79, 258, 28, 22, 'App\\Models\\StructuralMember', 'Tahun Ajaran 2026/2027', 'Bidang Marketing', 11, 1, '2026-08-10 03:14:09', '2026-08-10 03:14:09'),
(80, 258, 28, 16, 'App\\Models\\StructuralMember', 'Tahun Ajaran 2026/2027', 'Bidang Marketing', 12, 1, '2026-08-10 03:15:16', '2026-08-10 03:15:16'),
(82, 258, 28, 19, 'App\\Models\\StructuralMember', 'Tahun Ajaran 2026/2027', 'Bidang Kemitraan', 13, 1, '2026-08-10 03:28:38', '2026-08-10 03:28:38'),
(83, 258, 29, 21, 'App\\Models\\Teacher', 'Tahun Ajaran 2026/2027', 'Instruktur Housekeeping', 14, 1, '2026-08-10 03:33:04', '2026-08-10 03:33:04'),
(84, 258, 29, 24, 'App\\Models\\Teacher', 'Tahun Ajaran 2026/2027', 'INSTRUKTUR FRONT OFFICE', 15, 1, '2026-08-10 04:14:35', '2026-08-10 04:14:35'),
(85, 258, 29, 13, 'App\\Models\\Teacher', 'Tahun Ajaran 2026/2027', 'INSTRUKTUR FRONT OFFICE', 16, 1, '2026-08-10 04:35:39', '2026-08-10 04:35:39'),
(86, 258, 29, 27, 'App\\Models\\Teacher', 'Tahun Ajaran 2026/2027', 'INSTRUKTUR FRONT OFFICE', 17, 1, '2026-08-10 04:36:01', '2026-08-10 04:36:01'),
(87, 258, 29, 23, 'App\\Models\\Teacher', 'Tahun Ajaran 2026/2027', 'Instruktur Food And Beverage Service', 18, 1, '2026-08-10 04:36:11', '2026-08-10 04:36:11'),
(88, 258, 29, 9, 'App\\Models\\Teacher', 'Tahun Ajaran 2026/2027', 'Instruktur Food And Beverage Service', 19, 1, '2026-08-10 04:36:25', '2026-08-10 04:36:25'),
(89, 258, 29, 26, 'App\\Models\\Teacher', 'Tahun Ajaran 2026/2027', 'Instruktur General English', 20, 1, '2026-08-10 04:36:39', '2026-08-10 04:36:39'),
(90, 258, 29, 12, 'App\\Models\\Teacher', 'Tahun Ajaran 2026/2027', 'Instruktur Housekeeping', 21, 1, '2026-08-10 04:36:46', '2026-08-10 04:36:46'),
(91, 258, 29, 25, 'App\\Models\\Teacher', 'Tahun Ajaran 2026/2027', 'Instruktur Mata Ajar English Conversation', 22, 1, '2026-08-10 04:36:56', '2026-08-10 04:36:56'),
(92, 258, 19, 23, 'App\\Models\\StructuralMember', 'Tahun Ajaran 2026/2027', 'WAKIL DIREKTUR BIDANG KEUANGAN', 23, 1, '2026-08-10 08:18:05', '2026-08-10 08:18:05'),
(93, 258, 29, 28, 'App\\Models\\Teacher', 'Tahun Ajaran 2026/2027', 'Instruktur Kitchen', 24, 1, '2026-08-10 08:34:35', '2026-08-10 08:34:35'),
(94, 258, 29, 29, 'App\\Models\\Teacher', 'Tahun Ajaran 2026/2027', 'Instruktur Kitchen', 25, 1, '2026-08-10 08:34:44', '2026-08-10 08:34:44');

-- --------------------------------------------------------

--
-- Table structure for table `structure_sections`
--

CREATE TABLE `structure_sections` (
  `id` bigint UNSIGNED NOT NULL,
  `common_id` bigint UNSIGNED NOT NULL COMMENT 'FK to common (structure)',
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `order` smallint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `structure_sections`
--

INSERT INTO `structure_sections` (`id`, `common_id`, `name`, `order`, `created_at`, `updated_at`) VALUES
(13, 258, 'Direktur Lembaga', 2, '2026-06-16 09:29:46', '2026-07-30 09:19:50'),
(18, 258, 'Sekretaris Direktur', 5, '2026-07-30 09:20:49', '2026-07-30 09:20:49'),
(19, 258, 'Wakil Direktur', 6, '2026-07-30 09:21:05', '2026-07-30 09:21:05'),
(27, 258, 'Staff Administrasi', 7, '2026-08-10 03:03:53', '2026-08-10 03:03:53'),
(28, 258, 'Bidang', 8, '2026-08-10 03:04:22', '2026-08-10 03:04:22'),
(29, 258, 'Instruktur', 9, '2026-08-10 03:29:25', '2026-08-10 03:29:25');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nis` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nisn` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'male',
  `birth_place` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kelas_id` bigint UNSIGNED DEFAULT NULL,
  `jurusan_id` bigint UNSIGNED DEFAULT NULL,
  `order` smallint UNSIGNED NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_general_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
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
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nip` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Nomor Induk Pegawai',
  `photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_general_ci DEFAULT NULL,
  `birth_place` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jabatan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis` enum('guru','tendik') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'guru' COMMENT 'guru = Guru, tendik = Tenaga Kependidikan',
  `bidang_studi` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Mata pelajaran atau bidang keahlian',
  `pendidikan` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Pendidikan terakhir: S1, S2, dll',
  `status_kepegawaian` enum('PNS','PPPK','Honorer','DTT','DTY') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jurusan_id` bigint UNSIGNED DEFAULT NULL COMMENT 'FK ke common.id (table_name=jurusan), untuk guru yang terikat jurusan',
  `order` smallint UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Urutan tampil',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `description` text COLLATE utf8mb4_general_ci,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `nip`, `photo`, `gender`, `birth_place`, `birth_date`, `address`, `phone`, `email`, `jabatan`, `jenis`, `bidang_studi`, `pendidikan`, `status_kepegawaian`, `jurusan_id`, `order`, `is_active`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(9, 'TONI SUHARDIMAN', '-', 'teachers/teacher_6a798b6a46b6b6.01044226.jpg', 'male', 'Majalengka', '1975-08-18', 'Desa Mekarwangi, Kec.Argapura, Kab.Majalengka', '-', 'apaaja@gmail.com', 'Instruktur Food And Beverage Service', 'tendik', '', 'Diploma III (Bahasa Inggis), STBA-ABA YAPARI Bandung', 'DTY', NULL, 0, 1, 'Merupakan alumni SIHI tahun 2006. Saat ini aktif menjadi waiter di Holland America Cruise Line dan aktif menjadi instruktur F&B Service di SIHI.', 1, 1, '2026-08-03 04:02:20', '2026-08-10 08:27:22'),
(11, 'ABDUL MALIK KAOKAB, ST', '201606014', 'teachers/teacher_6a72f161d2e3a2.76588664.jpg', 'male', '-', NULL, '', '-', 'aku@gmail.com', 'apa', 'tendik', '', '-', 'DTY', NULL, 0, 1, '', 1, 1, '2026-08-05 08:16:33', '2026-08-06 06:20:32'),
(12, 'SONI KUSDINAR', '201607012', 'teachers/teacher_6a79510172b174.34382908.jpg', 'male', 'Subang', '1985-06-18', 'Desa Cimanglid, Kec.Kasomalang, Subang', '-', 'aku@gmail.com', 'Instruktur Housekeeping', 'tendik', '', 'MA Al- Husna', 'DTY', NULL, 0, 1, 'Merupakan salah satu alumni SIHI Tahun 2005 yang berkarir di Kapal pesiar sejak tahun 2013 hingga saat ini di Holland America Line. Satt ini beliau mengajar Housekeeping di SIHI dan telah mendapatkan sertifikasi kompetensi dari LSK di bidang yang sama.', 1, 1, '2026-08-05 08:20:17', '2026-08-10 04:18:09'),
(13, 'DEBI FITRIA DEWI OKTAPIANI, SE.Par', '201307010', 'teachers/teacher_6a795236321657.71726507.jpg', 'male', 'Subang', '1984-10-09', 'Desa Gandasoli, Kec.Tanjungsiang, Subang', '-', 'aku@gmail.com', 'INSTRUKTUR FRONT OFFICE', 'tendik', '', 'S1 (Manajemen Pariwisata) STMP ARS Internasional', 'DTY', NULL, 0, 1, 'Merupakan lulusan S1 - Manajemen Pariwisata di STP ARS International Bandung. Beliau aktif di dunia pendidikan vokasi LPP MH Yasin, SMK Bina Nusantara, dan SIHI. Beliau mengajar mata diklat Front Office. Beliau juga telah mendapatkan sertifikat kompetensi bidang Metode Penelitian dari BNSP, Sertifikat penguji uji kompetensi Front Office jenjang II, hingga sertifikat pelatihan metodologi instruktur kualifikasi III dari kemnaker', 1, 1, '2026-08-05 08:22:01', '2026-08-10 04:23:18'),
(14, 'DIAN LESTARI', '201207009', 'teachers/teacher_6a72f2e1181b72.86444658.jpg', 'male', '-', NULL, '', '-', 'aku@gmail.com', '', 'tendik', '', '-', 'DTY', NULL, 0, 1, '', 1, NULL, '2026-08-05 08:22:57', '2026-08-05 08:22:57'),
(15, 'YOHAN SAMBO, S.Pd', '201907017', 'teachers/teacher_6a72f31e3910b7.09777219.jpg', 'male', '', NULL, '', '', '', '', 'guru', '', '-', NULL, NULL, 0, 1, '', 1, NULL, '2026-08-05 08:23:58', '2026-08-05 08:23:58'),
(16, 'REISA LAKSMI RIANI, S.Pd', '201808015', 'teachers/teacher_6a72f369bd9d00.65472423.jpg', 'male', '-', NULL, '', '', 'ku@gmail.com', '', 'tendik', '', '-', 'DTY', NULL, 0, 1, '', 1, NULL, '2026-08-05 08:25:13', '2026-08-05 08:25:13'),
(17, 'Dra. POPPY PERWATIAH', '201907018', 'teachers/teacher_6a72f39947be80.79768455.jpg', 'male', '', NULL, '', '', 'ku@gmail.com', '', 'tendik', '', '-', 'DTY', NULL, 0, 1, '', 1, NULL, '2026-08-05 08:26:01', '2026-08-05 08:26:01'),
(18, 'ANDIKA AULIA, S.Kom', '202006020', 'teachers/teacher_6a72f3ba4f72c5.22621395.jpg', 'male', '', NULL, '', '', 'ku@gmail.com', '', 'guru', '', '', NULL, NULL, 0, 1, '', 1, NULL, '2026-08-05 08:26:34', '2026-08-05 08:26:34'),
(19, 'BUDI SENTOSA', '201107011', 'teachers/teacher_6a72f3d94d36b3.81919514.jpg', 'male', '', NULL, '', '', 'ku@gmail.com', '', 'guru', '', '', NULL, NULL, 0, 1, '', 1, NULL, '2026-08-05 08:27:05', '2026-08-05 08:27:05'),
(20, 'EGI GINANJAR', '202008008', 'teachers/teacher_6a72f40521b5c7.49607735.jpg', 'male', '', NULL, '', '', 'ku@gmail.com', '', 'tendik', '', '', 'DTY', NULL, 0, 1, '', 1, NULL, '2026-08-05 08:27:49', '2026-08-05 08:27:49'),
(21, 'DENA SOLIHIN GARNIDA ROSYADI', '201810008', 'teachers/teacher_6a7946e6bbdf23.41103627.jpg', 'male', 'Sumedang', '1982-07-19', '', '', 'ku@gmail.com', '', 'tendik', '', '', NULL, NULL, 0, 1, 'Merupakan salah satu alumni SIHI 2007 yang berkarir di kapal pesiar sejak tahun 2010 hingga saat ini di Holland America Line sebagai Stateroom Attendant. Saat ini beliau mengajar Housekeeping di SIHI.', 1, 1, '2026-08-05 08:28:26', '2026-08-10 03:35:02'),
(22, 'WINDU YANUAR, A.Md', '201909009', 'teachers/teacher_6a72f4518b1857.68626647.jpg', 'male', '', NULL, '', '', 'ku@gmail.com', '', 'tendik', '', '', 'DTY', NULL, 0, 1, '', 1, NULL, '2026-08-05 08:29:05', '2026-08-05 08:29:05'),
(23, 'IWAN SETIAWAN', '202505025', 'teachers/teacher_6a7953cb729558.89475396.jpg', 'male', '-', NULL, '', '-', 'ku@gmail.com', 'Instruktur Food And Beverage Service', 'tendik', '', '', NULL, NULL, 0, 1, 'Lulusan Wisakti Jakarta tahun 1991, memiliki pengalaman sebagai F&B Supervisor di hotel Hilton Jakarta selama 11 tahun dan berkarir di kapal pesiar Carnival sebagai Head Waiter selama 14 tahun.', 1, 1, '2026-08-05 08:29:36', '2026-08-10 04:30:03'),
(24, 'REGGY RIZQIARTA DWIRACHFI', '202007007', 'teachers/teacher_6a794ffd6bc3d9.76302714.jpg', 'male', 'Bandung', '1997-12-02', 'Pasirkareumbi subang', '', '', '', 'tendik', '', 'SMAN 1 SUBANG', NULL, NULL, 0, 1, 'Merupakan salah satu alumni SIHI tahun 2020 yang berkarir di hotel Harper by Aston, Purwakarta, Jawa Barat tahun 2021 - 2023 di departemen Front Office. Saat ini sedang bekerja sebagai front officer di Golden Sun Hotel Turkiye. Di SIHI diamanahkan sebagai pengajar Front Office.', 1, NULL, '2026-08-10 04:13:49', '2026-08-10 04:13:49'),
(25, 'YOPSI APRILIKA, S.Pd', '201207007', 'teachers/teacher_6a7952b854ac15.16373480.jpg', 'female', '-', NULL, '-', '-', 'menyusul@gmail.com', 'Instruktur Mata Ajar English Conversation', 'tendik', '', 'S1(Bahasa Inggris) UNSUB', 'DTY', NULL, 0, 1, 'Merupakan alumni SIHI 2009 dan mengajar di SIHI dari 2012 dan Instruktur Bahasa Inggris di LPK Hospitality Education Institute pada tahun 2023 - 2024. Saat ini aktif mengajar Bahasa Inggris di SDIT Bahrul Ulum.', 1, 1, '2026-08-10 04:25:28', '2026-08-10 04:34:32'),
(26, 'ROBI SURACHMAN, S.Pd', '202504014', 'teachers/teacher_6a79536aa9a448.45244407.jpg', 'male', 'Subang', '1988-11-10', 'Pamanukan Subang', '-', 'menyusul@gmail.com', 'Instruktur General English', 'tendik', '', 'S1(Bahasa Inggris) UNSUB', 'DTY', NULL, 0, 1, 'Lulusan STKIP Subang Jurusan Bahasa Inggris dan memiliki pengalaman kerja di Beachwalk Resto Bali sebagai Waiter dan sebagai Barista di CBTL’s SINGAPURA. Saat ini sedang aktif berkarir di bidang FB Service di Golden Sun Hotel Turkey. Di SIHI diberikan amanah sebagai Instruktur.', 1, 1, '2026-08-10 04:28:26', '2026-08-10 04:34:50'),
(27, 'Fadillah Wulansari., M.Pd', '1415049503', 'teachers/teacher_6a7954a7d30276.59782036.jpg', 'male', 'Jayapura', '1995-04-15', 'Pasirkareumbi,Subang', '-', 'menyusul@gmail.com', 'INSTRUKTUR FRONT OFFICE', 'tendik', '', 'S2(Pendidikan Bahasa Inggris) Universitas Cenderawasih', NULL, NULL, 0, 1, 'Merupakan lulusan S2 di Universitas Cendrawasih. Saat ini sedang aktif menjadi dosen Bahasa Inggris di Universitas Doktor Husni Ingratubun Papua. Saat ini mengajar juga di SIHI sebagai instruktur Bahasa Inggris.\n', 1, 1, '2026-08-10 04:33:43', '2026-08-10 04:38:00'),
(28, 'ALIP MAULANA', '-', 'teachers/teacher_6a798caf63cf80.55439087.jpg', 'male', '', NULL, '', '', '', 'Instruktur Kitchen', 'tendik', '', '', NULL, NULL, 0, 1, 'Merupakan alumni SIHI tahun 2021. Saat ini aktif menjadi tim cook di P&O Cruise Line dan diamani menjadi instruktur kitchen di SIHI.', 1, 1, '2026-08-10 08:32:47', '2026-08-10 08:34:14'),
(29, 'ARYAPUTRA BIJAKSANA', '-', 'teachers/teacher_6a798cfd988a11.67467181.jpg', 'male', '', NULL, '', '', '', 'Instruktur Kitchen', 'tendik', '', '', NULL, NULL, 0, 1, 'Merupakan alumni SIHI tahun 2024. Memiliki pengalaman bekerja di hotel Johor Bahru Malaysia, dan akan bergabung dengan AIDA Cruise line. Saat ini diamani menjadi instruktur di SIHI.', 1, NULL, '2026-08-10 08:34:05', '2026-08-10 08:34:05');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rating` tinyint UNSIGNED NOT NULL DEFAULT '5',
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `order` smallint UNSIGNED NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `role`, `photo`, `rating`, `content`, `order`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(16, 'DANDI ARIPUDIN', 'Almuni SIHI 2020, Room Attendant  Taaktana a Luxury Collection Resort and Spa Labuan Bajo', 'testimonials/testimonial_6a79714e3fd7c7.09850642.jpg', 5, 'OJT pada saat COVID 19 magang dari Aston Marina Ancol sehingga sempat terhenti. Tapi SIHI terus mendampingi saya hingga akhirnya saya melanjutkan ke GH Universal dan mendapatkan pekerjaan di le Meridien Fairways Dubai dan saat ini di Labuan Bajo', 1, 1, 1, NULL, '2026-08-10 06:35:58', '2026-08-10 06:35:58'),
(17, 'HERMAWAN', 'Alumni SIHI 2020, Room Attendant - Le Meridien Hotel Dubai', 'testimonials/testimonial_6a79719c5f3947.70175916.jpg', 5, 'Terima kasih SIHI! ini tahun ketiga saya di Le Meridien Hotel Dubai sebelum tahun depan lanjut ke Kapal Pesiar :)', 2, 1, 1, 1, '2026-08-10 06:36:55', '2026-08-10 06:37:16'),
(18, 'SEPTIANA PRATAMA', 'Alumni SIHI 2018, Reservation Supervisor - Movenpick Hotel Jakarta', 'testimonials/testimonial_6a7972022974a6.41572182.jpg', 5, 'Setelah 5 tahun lulus dari SIHI saya diamanahi untuk menjadi seorang supervisor di hotel bintang 5. Terima kasih yang sebesar-besarnya kepada SIHI yang sudah membimbing saya.', 3, 1, 1, 1, '2026-08-10 06:38:31', '2026-08-10 06:38:58'),
(19, 'WIDANINGSIH', 'Alumni SIHI 2021', 'testimonials/testimonial_6a79727fdc02f3.26309593.jpg', 5, 'Belajar di SIHI itu menyenangkan banget ~ Saat saya magang, saya ditempatkan di Holiday Inn Jababeka Cikarang dan tidak lama ditarik kerja dan mendapatkan Best Employee. Saya saat ini fokus bimbingan karir untuk ke Kapal Pesiar dan Hotel Luar Negeri. Sambil menunggu, saya melanjutkan karir di Pullman Ciawi Vimala Hills Hotel and Resort di Bogor', 4, 1, 1, NULL, '2026-08-10 06:41:03', '2026-08-10 06:41:03');

-- --------------------------------------------------------

--
-- Table structure for table `transparency`
--

CREATE TABLE `transparency` (
  `id` bigint UNSIGNED NOT NULL,
  `type` enum('anggaran','kinerja') COLLATE utf8mb4_general_ci NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `file` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `year` int DEFAULT NULL,
  `period` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `custom1` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `custom2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('SuperAdmin','Admin','Operator') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Operator',
  `jurusan_id` bigint UNSIGNED DEFAULT NULL COMMENT 'FK ke common.id (table_name=jurusan) — diisi jika role = Admin',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login` datetime DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `email`, `phone`, `photo`, `role`, `jurusan_id`, `is_active`, `last_login`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Andhika', '$2y$12$z5gPTJ9HbWLmaKMeZsUkmuSYej.lhf49y4wjxO7vwGUSuCj.pQiqW', 'Andhika Aulia', 'admin@smk.sch.id', '6281312901432', 'users/avatar_6a2b8899a86636.03657490.jpg', 'SuperAdmin', NULL, 1, '2026-08-13 11:36:47', 'NOdsIX4avAEUfCI5U3xX5wBqNhq0lVMy4GyCOr2ZpPsHzJmOODl22iACOJBn', '2026-06-11 21:12:52', '2026-08-13 04:36:47');

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
-- Indexes for table `elearning_attendances`
--
ALTER TABLE `elearning_attendances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `elearning_attendances_user_id_date_unique` (`user_id`,`date`);

--
-- Indexes for table `elearning_courses`
--
ALTER TABLE `elearning_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `elearning_courses_owner_id_foreign` (`owner_id`);

--
-- Indexes for table `elearning_documents`
--
ALTER TABLE `elearning_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_docs_student` (`student_id`);

--
-- Indexes for table `elearning_exams`
--
ALTER TABLE `elearning_exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `elearning_exams_course_id_foreign` (`course_id`);

--
-- Indexes for table `elearning_exam_submissions`
--
ALTER TABLE `elearning_exam_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `elearning_exam_submissions_exam_id_foreign` (`exam_id`),
  ADD KEY `elearning_exam_submissions_student_id_foreign` (`student_id`);

--
-- Indexes for table `elearning_job_applications`
--
ALTER TABLE `elearning_job_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `elearning_job_postings`
--
ALTER TABLE `elearning_job_postings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `elearning_materials`
--
ALTER TABLE `elearning_materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `elearning_materials_course_id_foreign` (`course_id`);

--
-- Indexes for table `elearning_payments`
--
ALTER TABLE `elearning_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `elearning_payments_student_id_foreign` (`student_id`);

--
-- Indexes for table `elearning_users`
--
ALTER TABLE `elearning_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `elearning_users_email_unique` (`email`);

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
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `common`
--
ALTER TABLE `common`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=319;

--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `elearning_attendances`
--
ALTER TABLE `elearning_attendances`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `elearning_courses`
--
ALTER TABLE `elearning_courses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `elearning_documents`
--
ALTER TABLE `elearning_documents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `elearning_exams`
--
ALTER TABLE `elearning_exams`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `elearning_exam_submissions`
--
ALTER TABLE `elearning_exam_submissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `elearning_job_applications`
--
ALTER TABLE `elearning_job_applications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `elearning_job_postings`
--
ALTER TABLE `elearning_job_postings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `elearning_materials`
--
ALTER TABLE `elearning_materials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `elearning_payments`
--
ALTER TABLE `elearning_payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `elearning_users`
--
ALTER TABLE `elearning_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `secretariat`
--
ALTER TABLE `secretariat`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `security_logs`
--
ALTER TABLE `security_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `security_settings`
--
ALTER TABLE `security_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `structural_members`
--
ALTER TABLE `structural_members`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `structure_members`
--
ALTER TABLE `structure_members`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `structure_sections`
--
ALTER TABLE `structure_sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `transparency`
--
ALTER TABLE `transparency`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- Constraints for table `elearning_attendances`
--
ALTER TABLE `elearning_attendances`
  ADD CONSTRAINT `elearning_attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `elearning_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `elearning_courses`
--
ALTER TABLE `elearning_courses`
  ADD CONSTRAINT `elearning_courses_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `elearning_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `elearning_documents`
--
ALTER TABLE `elearning_documents`
  ADD CONSTRAINT `fk_docs_student` FOREIGN KEY (`student_id`) REFERENCES `elearning_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `elearning_exams`
--
ALTER TABLE `elearning_exams`
  ADD CONSTRAINT `elearning_exams_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `elearning_courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `elearning_exam_submissions`
--
ALTER TABLE `elearning_exam_submissions`
  ADD CONSTRAINT `elearning_exam_submissions_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `elearning_exams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `elearning_exam_submissions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `elearning_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `elearning_materials`
--
ALTER TABLE `elearning_materials`
  ADD CONSTRAINT `elearning_materials_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `elearning_courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `elearning_payments`
--
ALTER TABLE `elearning_payments`
  ADD CONSTRAINT `elearning_payments_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `elearning_users` (`id`) ON DELETE CASCADE;

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
