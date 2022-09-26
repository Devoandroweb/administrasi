-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Sep 2022 pada 05.31
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `administrasi_sekolah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `administrasi`
--

CREATE TABLE `administrasi` (
  `id_administrasi` int(11) NOT NULL,
  `id_siswa` bigint(20) UNSIGNED NOT NULL,
  `id_jenis_administrasi` int(11) DEFAULT NULL,
  `nominal` bigint(20) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='ini juga di sebut biaya siswa';

--
-- Dumping data untuk tabel `administrasi`
--

INSERT INTO `administrasi` (`id_administrasi`, `id_siswa`, `id_jenis_administrasi`, `nominal`) VALUES
(1, 1, 56, 750000),
(2, 1, 62, 0),
(3, 1, 68, 200000),
(4, 1, 74, 250000),
(5, 1, 80, 90000),
(6, 1, 86, 100000),
(7, 2, 57, 1800000),
(8, 2, 63, 30000),
(9, 2, 69, 200000),
(10, 2, 75, 250000),
(11, 2, 81, 90000),
(12, 2, 87, 100000),
(13, 2, 89, 2000000),
(14, 4, 52, 1800000),
(15, 4, 60, 30000),
(16, 4, 64, 200000),
(17, 4, 70, 250000),
(18, 4, 76, 90000),
(19, 4, 82, 100000),
(20, 5, 53, 1800000),
(21, 5, 61, 30000),
(22, 5, 65, 200000),
(23, 5, 71, 250000),
(24, 5, 77, 90000),
(25, 5, 83, 100000),
(26, 5, 88, 2000000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `h_transaksi`
--

CREATE TABLE `h_transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `kode` varchar(150) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `id_siswa` bigint(20) UNSIGNED NOT NULL,
  `biaya` text DEFAULT NULL,
  `tunggakan` text DEFAULT NULL,
  `total` bigint(20) NOT NULL DEFAULT 0,
  `terbayar` bigint(20) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `h_transaksi`
--

INSERT INTO `h_transaksi` (`id_transaksi`, `kode`, `tanggal`, `id_siswa`, `biaya`, `tunggakan`, `total`, `terbayar`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'SIA-HmKKb4uRBG360Lq', '2022-09-25 19:52:38', 1, '[{\"nama_biaya\":\"SPP untuk bulan Januari\",\"id_jenis_administrasi\":\"56\",\"nominal\":\"150000\",\"ajaran\":\"2021 - 2022\",\"bulan_spp\":\"januari\"},{\"nama_biaya\":\"SPP untuk bulan Juli\",\"id_jenis_administrasi\":\"56\",\"nominal\":\"150000\",\"ajaran\":\"2021 - 2022\",\"bulan_spp\":\"juli\"},{\"nama_biaya\":\"SPP untuk bulan Desember\",\"id_jenis_administrasi\":\"56\",\"nominal\":\"150000\",\"ajaran\":\"2021 - 2022\",\"bulan_spp\":\"desember\"},{\"nama_biaya\":\"DAFTAR ULANG tahap ke 1\",\"id_jenis_administrasi\":\"62\",\"nominal\":30000,\"ajaran\":\"2021 - 2022\"}]', '[]', 480000, 0, '2022-09-25 19:52:38', 1, '2022-09-25 19:52:38', 1),
(2, 'SIA-Kyg0A7TTixZMsiE', '2022-09-25 19:54:55', 1, '[{\"nama_biaya\":\"SPP untuk bulan Februari\",\"id_jenis_administrasi\":\"56\",\"nominal\":\"150000\",\"ajaran\":\"2021 - 2022\",\"bulan_spp\":\"februari\"},{\"nama_biaya\":\"SPP untuk bulan September\",\"id_jenis_administrasi\":\"56\",\"nominal\":\"150000\",\"ajaran\":\"2021 - 2022\",\"bulan_spp\":\"september\"}]', '[]', 300000, 0, '2022-09-25 19:54:55', 1, '2022-09-25 19:54:55', 1),
(3, 'SIA-IgcLFqjwZqIXvlh', '2022-09-25 20:00:04', 1, '[{\"nama_biaya\":\"SPP untuk bulan Maret\",\"id_jenis_administrasi\":\"56\",\"nominal\":\"150000\",\"ajaran\":\"2021 - 2022\",\"bulan_spp\":\"maret\"},{\"nama_biaya\":\"SPP untuk bulan November\",\"id_jenis_administrasi\":\"56\",\"nominal\":\"150000\",\"ajaran\":\"2021 - 2022\",\"bulan_spp\":\"november\"}]', '[]', 300000, 0, '2022-09-25 20:00:04', 1, '2022-09-25 20:00:04', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `h_user`
--

CREATE TABLE `h_user` (
  `id_h_user` int(11) NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `date_login` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `h_user`
--

INSERT INTO `h_user` (`id_h_user`, `id_user`, `date_login`) VALUES
(73, 2, '2022-08-23 00:41:25'),
(155, 1, '2022-09-25 14:31:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_ajaran`
--

CREATE TABLE `m_ajaran` (
  `id` int(11) NOT NULL,
  `tahun_awal` varchar(11) DEFAULT NULL,
  `tahun_akhir` varchar(11) NOT NULL,
  `status` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `m_ajaran`
--

INSERT INTO `m_ajaran` (`id`, `tahun_awal`, `tahun_akhir`, `status`) VALUES
(1, '2020', '2021', 0),
(54, '2021', '2022', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_jenis_administrasi`
--

CREATE TABLE `m_jenis_administrasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biaya` bigint(20) DEFAULT 0,
  `id_kelas` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT 1,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `m_jenis_administrasi`
--

INSERT INTO `m_jenis_administrasi` (`id`, `nama`, `biaya`, `id_kelas`, `deleted`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(52, 'SPP', 150000, 1, 1, 1, 1, '2022-09-24 15:20:09', '2022-09-24 15:20:09'),
(53, 'SPP', 150000, 2, 1, 1, 1, '2022-09-24 15:20:10', '2022-09-24 15:20:10'),
(54, 'SPP', 150000, 5, 1, 1, 1, '2022-09-24 15:20:10', '2022-09-24 15:20:10'),
(55, 'SPP', 150000, 6, 1, 1, 1, '2022-09-24 15:20:10', '2022-09-24 15:20:10'),
(56, 'SPP', 150000, 7, 1, 1, 1, '2022-09-24 15:20:10', '2022-09-24 15:20:10'),
(57, 'SPP', 150000, 8, 1, 1, 1, '2022-09-24 15:20:10', '2022-09-24 15:20:10'),
(58, 'PENDAFTARAN SISWA BARU', 50000, 5, 1, 1, 1, '2022-09-24 15:22:52', '2022-09-24 15:22:52'),
(59, 'PENDAFTARAN SISWA BARU', 50000, 6, 1, 1, 1, '2022-09-24 15:22:52', '2022-09-24 15:22:52'),
(60, 'DAFTAR ULANG', 30000, 1, 1, 1, 1, '2022-09-24 15:25:22', '2022-09-24 15:25:22'),
(61, 'DAFTAR ULANG', 30000, 2, 1, 1, 1, '2022-09-24 15:25:23', '2022-09-24 15:25:23'),
(62, 'DAFTAR ULANG', 30000, 7, 1, 1, 1, '2022-09-24 15:25:23', '2022-09-24 15:25:23'),
(63, 'DAFTAR ULANG', 30000, 8, 1, 1, 1, '2022-09-24 15:25:23', '2022-09-24 15:25:23'),
(64, 'LKS SEMESTER - I', 200000, 1, 1, 1, 1, '2022-09-24 15:36:16', '2022-09-24 15:36:16'),
(65, 'LKS SEMESTER - I', 200000, 2, 1, 1, 1, '2022-09-24 15:36:16', '2022-09-24 15:36:16'),
(66, 'LKS SEMESTER - I', 200000, 5, 1, 1, 1, '2022-09-24 15:36:16', '2022-09-24 15:36:16'),
(67, 'LKS SEMESTER - I', 200000, 6, 1, 1, 1, '2022-09-24 15:36:16', '2022-09-24 15:36:16'),
(68, 'LKS SEMESTER - I', 200000, 7, 1, 1, 1, '2022-09-24 15:36:16', '2022-09-24 15:36:16'),
(69, 'LKS SEMESTER - I', 200000, 8, 1, 1, 1, '2022-09-24 15:36:17', '2022-09-24 15:36:17'),
(70, 'LKS SEMESTER - II', 250000, 1, 1, 1, 1, '2022-09-24 15:37:05', '2022-09-24 15:37:05'),
(71, 'LKS SEMESTER - II', 250000, 2, 1, 1, 1, '2022-09-24 15:37:05', '2022-09-24 15:37:05'),
(72, 'LKS SEMESTER - II', 250000, 5, 1, 1, 1, '2022-09-24 15:37:05', '2022-09-24 15:37:05'),
(73, 'LKS SEMESTER - II', 250000, 6, 1, 1, 1, '2022-09-24 15:37:05', '2022-09-24 15:37:05'),
(74, 'LKS SEMESTER - II', 250000, 7, 1, 1, 1, '2022-09-24 15:37:05', '2022-09-24 15:37:05'),
(75, 'LKS SEMESTER - II', 250000, 8, 1, 1, 1, '2022-09-24 15:37:05', '2022-09-24 15:37:05'),
(76, 'PENILAIAN TENGAH SEMESTER - I', 90000, 1, 1, 1, 1, '2022-09-24 15:38:45', '2022-09-24 15:38:45'),
(77, 'PENILAIAN TENGAH SEMESTER - I', 90000, 2, 1, 1, 1, '2022-09-24 15:38:45', '2022-09-24 15:38:45'),
(78, 'PENILAIAN TENGAH SEMESTER - I', 90000, 5, 1, 1, 1, '2022-09-24 15:38:45', '2022-09-24 15:38:45'),
(79, 'PENILAIAN TENGAH SEMESTER - I', 90000, 6, 1, 1, 1, '2022-09-24 15:38:45', '2022-09-24 15:38:45'),
(80, 'PENILAIAN TENGAH SEMESTER - I', 90000, 7, 1, 1, 1, '2022-09-24 15:38:45', '2022-09-24 15:38:45'),
(81, 'PENILAIAN TENGAH SEMESTER - I', 90000, 8, 1, 1, 1, '2022-09-24 15:38:45', '2022-09-24 15:38:45'),
(82, 'PENILAIAN AKHIR tahun - II', 100000, 1, 1, 1, 1, '2022-09-24 15:39:28', '2022-09-24 15:40:51'),
(83, 'PENILAIAN AKHIR SEMESTER - II', 100000, 2, 1, 1, 1, '2022-09-24 15:39:29', '2022-09-24 15:39:29'),
(84, 'PENILAIAN AKHIR SEMESTER - II', 100000, 5, 1, 1, 1, '2022-09-24 15:39:29', '2022-09-24 15:39:29'),
(85, 'PENILAIAN AKHIR SEMESTER - II', 100000, 6, 1, 1, 1, '2022-09-24 15:39:29', '2022-09-24 15:39:29'),
(86, 'PENILAIAN AKHIR SEMESTER - II', 100000, 7, 1, 1, 1, '2022-09-24 15:39:29', '2022-09-24 15:39:29'),
(87, 'PENILAIAN AKHIR SEMESTER - II', 100000, 8, 1, 1, 1, '2022-09-24 15:39:29', '2022-09-24 15:39:29'),
(88, 'UNAS / USEK / UHB-BKS', 2000000, 2, 1, 1, 1, '2022-09-24 16:34:50', '2022-09-24 16:34:50'),
(89, 'UNAS / USEK / UHB-BKS', 2000000, 8, 1, 1, 1, '2022-09-24 16:34:51', '2022-09-24 16:34:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_jurusan`
--

CREATE TABLE `m_jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `m_jurusan`
--

INSERT INTO `m_jurusan` (`id_jurusan`, `nama`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'IPS', '2022-07-29 13:43:01', 1, '2022-08-14 10:47:32', 1),
(5, 'MIPA', '2022-08-12 13:37:14', 1, '2022-08-13 12:25:49', 1),
(6, 'Alumni', '2022-09-19 21:52:42', 2, '2022-09-19 16:52:10', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_kelas`
--

CREATE TABLE `m_kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `id_jurusan` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `no_urut` int(11) NOT NULL DEFAULT 0,
  `indikasi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `m_kelas`
--

INSERT INTO `m_kelas` (`id_kelas`, `nama`, `id_jurusan`, `created_at`, `created_by`, `updated_at`, `updated_by`, `no_urut`, `indikasi`) VALUES
(1, 'XI', 1, '2022-07-30 06:45:07', 1, '2022-08-14 10:46:27', 1, 4, 11),
(2, 'XII', 1, '2022-08-02 03:31:37', 1, '2022-08-14 10:46:37', 1, 6, 12),
(5, 'X', 5, '2022-08-12 13:50:19', 1, '2022-08-14 10:46:45', 1, 1, 10),
(6, 'X', 1, '2022-08-12 13:53:50', 1, '2022-08-14 10:46:53', 1, 2, 10),
(7, 'XI', 5, '2022-08-12 14:07:38', 1, '2022-08-14 10:47:02', 1, 3, 11),
(8, 'XII', 5, '2022-08-12 16:14:55', 1, '2022-08-14 10:47:09', 1, 5, 12),
(10, 'Alumni', 6, '2022-09-19 21:51:44', 2, '2022-09-19 16:51:13', 2, 0, 13);

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_rekap`
--

CREATE TABLE `m_rekap` (
  `id_rekap` int(11) NOT NULL,
  `id_jenis_administrasi` bigint(20) UNSIGNED NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `total` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `m_rekap`
--

INSERT INTO `m_rekap` (`id_rekap`, `id_jenis_administrasi`, `id_kelas`, `total`) VALUES
(1, 52, 1, 0),
(2, 52, 1, 0),
(3, 53, 2, 0),
(4, 52, 1, 0),
(5, 53, 2, 0),
(6, 54, 5, 0),
(7, 52, 1, 0),
(8, 53, 2, 0),
(9, 54, 5, 0),
(10, 55, 6, 0),
(11, 52, 1, 0),
(12, 53, 2, 0),
(13, 54, 5, 0),
(14, 55, 6, 0),
(15, 56, 7, 1050000),
(16, 52, 1, 0),
(17, 53, 2, 0),
(18, 54, 5, 0),
(19, 55, 6, 0),
(20, 56, 7, 0),
(21, 57, 8, 0),
(22, 52, 1, 0),
(23, 53, 2, 0),
(24, 54, 5, 0),
(25, 55, 6, 0),
(26, 56, 7, 0),
(27, 57, 8, 0),
(28, 58, 5, 0),
(29, 52, 1, 0),
(30, 53, 2, 0),
(31, 54, 5, 0),
(32, 55, 6, 0),
(33, 56, 7, 0),
(34, 57, 8, 0),
(35, 58, 5, 0),
(36, 59, 6, 0),
(37, 52, 1, 0),
(38, 53, 2, 0),
(39, 54, 5, 0),
(40, 55, 6, 0),
(41, 56, 7, 0),
(42, 57, 8, 0),
(43, 58, 5, 0),
(44, 59, 6, 0),
(45, 60, 1, 0),
(46, 52, 1, 0),
(47, 53, 2, 0),
(48, 54, 5, 0),
(49, 55, 6, 0),
(50, 56, 7, 0),
(51, 57, 8, 0),
(52, 58, 5, 0),
(53, 59, 6, 0),
(54, 60, 1, 0),
(55, 61, 2, 0),
(56, 52, 1, 0),
(57, 53, 2, 0),
(58, 54, 5, 0),
(59, 55, 6, 0),
(60, 56, 7, 0),
(61, 57, 8, 0),
(62, 58, 5, 0),
(63, 59, 6, 0),
(64, 60, 1, 0),
(65, 61, 2, 0),
(66, 62, 7, 30000),
(67, 52, 1, 0),
(68, 53, 2, 0),
(69, 54, 5, 0),
(70, 55, 6, 0),
(71, 56, 7, 0),
(72, 57, 8, 0),
(73, 58, 5, 0),
(74, 59, 6, 0),
(75, 60, 1, 0),
(76, 61, 2, 0),
(77, 62, 7, 0),
(78, 63, 8, 0),
(79, 52, 1, 0),
(80, 53, 2, 0),
(81, 54, 5, 0),
(82, 55, 6, 0),
(83, 56, 7, 0),
(84, 57, 8, 0),
(85, 58, 5, 0),
(86, 59, 6, 0),
(87, 60, 1, 0),
(88, 61, 2, 0),
(89, 62, 7, 0),
(90, 63, 8, 0),
(91, 64, 1, 0),
(92, 52, 1, 0),
(93, 53, 2, 0),
(94, 54, 5, 0),
(95, 55, 6, 0),
(96, 56, 7, 0),
(97, 57, 8, 0),
(98, 58, 5, 0),
(99, 59, 6, 0),
(100, 60, 1, 0),
(101, 61, 2, 0),
(102, 62, 7, 0),
(103, 63, 8, 0),
(104, 64, 1, 0),
(105, 65, 2, 0),
(106, 52, 1, 0),
(107, 53, 2, 0),
(108, 54, 5, 0),
(109, 55, 6, 0),
(110, 56, 7, 0),
(111, 57, 8, 0),
(112, 58, 5, 0),
(113, 59, 6, 0),
(114, 60, 1, 0),
(115, 61, 2, 0),
(116, 62, 7, 0),
(117, 63, 8, 0),
(118, 64, 1, 0),
(119, 65, 2, 0),
(120, 66, 5, 0),
(121, 52, 1, 0),
(122, 53, 2, 0),
(123, 54, 5, 0),
(124, 55, 6, 0),
(125, 56, 7, 0),
(126, 57, 8, 0),
(127, 58, 5, 0),
(128, 59, 6, 0),
(129, 60, 1, 0),
(130, 61, 2, 0),
(131, 62, 7, 0),
(132, 63, 8, 0),
(133, 64, 1, 0),
(134, 65, 2, 0),
(135, 66, 5, 0),
(136, 67, 6, 0),
(137, 52, 1, 0),
(138, 53, 2, 0),
(139, 54, 5, 0),
(140, 55, 6, 0),
(141, 56, 7, 0),
(142, 57, 8, 0),
(143, 58, 5, 0),
(144, 59, 6, 0),
(145, 60, 1, 0),
(146, 61, 2, 0),
(147, 62, 7, 0),
(148, 63, 8, 0),
(149, 64, 1, 0),
(150, 65, 2, 0),
(151, 66, 5, 0),
(152, 67, 6, 0),
(153, 68, 7, 0),
(154, 52, 1, 0),
(155, 53, 2, 0),
(156, 54, 5, 0),
(157, 55, 6, 0),
(158, 56, 7, 0),
(159, 57, 8, 0),
(160, 58, 5, 0),
(161, 59, 6, 0),
(162, 60, 1, 0),
(163, 61, 2, 0),
(164, 62, 7, 0),
(165, 63, 8, 0),
(166, 64, 1, 0),
(167, 65, 2, 0),
(168, 66, 5, 0),
(169, 67, 6, 0),
(170, 68, 7, 0),
(171, 69, 8, 0),
(172, 52, 1, 0),
(173, 53, 2, 0),
(174, 54, 5, 0),
(175, 55, 6, 0),
(176, 56, 7, 0),
(177, 57, 8, 0),
(178, 58, 5, 0),
(179, 59, 6, 0),
(180, 60, 1, 0),
(181, 61, 2, 0),
(182, 62, 7, 0),
(183, 63, 8, 0),
(184, 64, 1, 0),
(185, 65, 2, 0),
(186, 66, 5, 0),
(187, 67, 6, 0),
(188, 68, 7, 0),
(189, 69, 8, 0),
(190, 70, 1, 0),
(191, 52, 1, 0),
(192, 53, 2, 0),
(193, 54, 5, 0),
(194, 55, 6, 0),
(195, 56, 7, 0),
(196, 57, 8, 0),
(197, 58, 5, 0),
(198, 59, 6, 0),
(199, 60, 1, 0),
(200, 61, 2, 0),
(201, 62, 7, 0),
(202, 63, 8, 0),
(203, 64, 1, 0),
(204, 65, 2, 0),
(205, 66, 5, 0),
(206, 67, 6, 0),
(207, 68, 7, 0),
(208, 69, 8, 0),
(209, 70, 1, 0),
(210, 71, 2, 0),
(211, 52, 1, 0),
(212, 53, 2, 0),
(213, 54, 5, 0),
(214, 55, 6, 0),
(215, 56, 7, 0),
(216, 57, 8, 0),
(217, 58, 5, 0),
(218, 59, 6, 0),
(219, 60, 1, 0),
(220, 61, 2, 0),
(221, 62, 7, 0),
(222, 63, 8, 0),
(223, 64, 1, 0),
(224, 65, 2, 0),
(225, 66, 5, 0),
(226, 67, 6, 0),
(227, 68, 7, 0),
(228, 69, 8, 0),
(229, 70, 1, 0),
(230, 71, 2, 0),
(231, 72, 5, 0),
(232, 52, 1, 0),
(233, 53, 2, 0),
(234, 54, 5, 0),
(235, 55, 6, 0),
(236, 56, 7, 0),
(237, 57, 8, 0),
(238, 58, 5, 0),
(239, 59, 6, 0),
(240, 60, 1, 0),
(241, 61, 2, 0),
(242, 62, 7, 0),
(243, 63, 8, 0),
(244, 64, 1, 0),
(245, 65, 2, 0),
(246, 66, 5, 0),
(247, 67, 6, 0),
(248, 68, 7, 0),
(249, 69, 8, 0),
(250, 70, 1, 0),
(251, 71, 2, 0),
(252, 72, 5, 0),
(253, 73, 6, 0),
(254, 52, 1, 0),
(255, 53, 2, 0),
(256, 54, 5, 0),
(257, 55, 6, 0),
(258, 56, 7, 0),
(259, 57, 8, 0),
(260, 58, 5, 0),
(261, 59, 6, 0),
(262, 60, 1, 0),
(263, 61, 2, 0),
(264, 62, 7, 0),
(265, 63, 8, 0),
(266, 64, 1, 0),
(267, 65, 2, 0),
(268, 66, 5, 0),
(269, 67, 6, 0),
(270, 68, 7, 0),
(271, 69, 8, 0),
(272, 70, 1, 0),
(273, 71, 2, 0),
(274, 72, 5, 0),
(275, 73, 6, 0),
(276, 74, 7, 0),
(277, 52, 1, 0),
(278, 53, 2, 0),
(279, 54, 5, 0),
(280, 55, 6, 0),
(281, 56, 7, 0),
(282, 57, 8, 0),
(283, 58, 5, 0),
(284, 59, 6, 0),
(285, 60, 1, 0),
(286, 61, 2, 0),
(287, 62, 7, 0),
(288, 63, 8, 0),
(289, 64, 1, 0),
(290, 65, 2, 0),
(291, 66, 5, 0),
(292, 67, 6, 0),
(293, 68, 7, 0),
(294, 69, 8, 0),
(295, 70, 1, 0),
(296, 71, 2, 0),
(297, 72, 5, 0),
(298, 73, 6, 0),
(299, 74, 7, 0),
(300, 75, 8, 0),
(301, 52, 1, 0),
(302, 53, 2, 0),
(303, 54, 5, 0),
(304, 55, 6, 0),
(305, 56, 7, 0),
(306, 57, 8, 0),
(307, 58, 5, 0),
(308, 59, 6, 0),
(309, 60, 1, 0),
(310, 61, 2, 0),
(311, 62, 7, 0),
(312, 63, 8, 0),
(313, 64, 1, 0),
(314, 65, 2, 0),
(315, 66, 5, 0),
(316, 67, 6, 0),
(317, 68, 7, 0),
(318, 69, 8, 0),
(319, 70, 1, 0),
(320, 71, 2, 0),
(321, 72, 5, 0),
(322, 73, 6, 0),
(323, 74, 7, 0),
(324, 75, 8, 0),
(325, 76, 1, 0),
(326, 52, 1, 0),
(327, 53, 2, 0),
(328, 54, 5, 0),
(329, 55, 6, 0),
(330, 56, 7, 0),
(331, 57, 8, 0),
(332, 58, 5, 0),
(333, 59, 6, 0),
(334, 60, 1, 0),
(335, 61, 2, 0),
(336, 62, 7, 0),
(337, 63, 8, 0),
(338, 64, 1, 0),
(339, 65, 2, 0),
(340, 66, 5, 0),
(341, 67, 6, 0),
(342, 68, 7, 0),
(343, 69, 8, 0),
(344, 70, 1, 0),
(345, 71, 2, 0),
(346, 72, 5, 0),
(347, 73, 6, 0),
(348, 74, 7, 0),
(349, 75, 8, 0),
(350, 76, 1, 0),
(351, 77, 2, 0),
(352, 52, 1, 0),
(353, 53, 2, 0),
(354, 54, 5, 0),
(355, 55, 6, 0),
(356, 56, 7, 0),
(357, 57, 8, 0),
(358, 58, 5, 0),
(359, 59, 6, 0),
(360, 60, 1, 0),
(361, 61, 2, 0),
(362, 62, 7, 0),
(363, 63, 8, 0),
(364, 64, 1, 0),
(365, 65, 2, 0),
(366, 66, 5, 0),
(367, 67, 6, 0),
(368, 68, 7, 0),
(369, 69, 8, 0),
(370, 70, 1, 0),
(371, 71, 2, 0),
(372, 72, 5, 0),
(373, 73, 6, 0),
(374, 74, 7, 0),
(375, 75, 8, 0),
(376, 76, 1, 0),
(377, 77, 2, 0),
(378, 78, 5, 0),
(379, 52, 1, 0),
(380, 53, 2, 0),
(381, 54, 5, 0),
(382, 55, 6, 0),
(383, 56, 7, 0),
(384, 57, 8, 0),
(385, 58, 5, 0),
(386, 59, 6, 0),
(387, 60, 1, 0),
(388, 61, 2, 0),
(389, 62, 7, 0),
(390, 63, 8, 0),
(391, 64, 1, 0),
(392, 65, 2, 0),
(393, 66, 5, 0),
(394, 67, 6, 0),
(395, 68, 7, 0),
(396, 69, 8, 0),
(397, 70, 1, 0),
(398, 71, 2, 0),
(399, 72, 5, 0),
(400, 73, 6, 0),
(401, 74, 7, 0),
(402, 75, 8, 0),
(403, 76, 1, 0),
(404, 77, 2, 0),
(405, 78, 5, 0),
(406, 79, 6, 0),
(407, 52, 1, 0),
(408, 53, 2, 0),
(409, 54, 5, 0),
(410, 55, 6, 0),
(411, 56, 7, 0),
(412, 57, 8, 0),
(413, 58, 5, 0),
(414, 59, 6, 0),
(415, 60, 1, 0),
(416, 61, 2, 0),
(417, 62, 7, 0),
(418, 63, 8, 0),
(419, 64, 1, 0),
(420, 65, 2, 0),
(421, 66, 5, 0),
(422, 67, 6, 0),
(423, 68, 7, 0),
(424, 69, 8, 0),
(425, 70, 1, 0),
(426, 71, 2, 0),
(427, 72, 5, 0),
(428, 73, 6, 0),
(429, 74, 7, 0),
(430, 75, 8, 0),
(431, 76, 1, 0),
(432, 77, 2, 0),
(433, 78, 5, 0),
(434, 79, 6, 0),
(435, 80, 7, 0),
(436, 52, 1, 0),
(437, 53, 2, 0),
(438, 54, 5, 0),
(439, 55, 6, 0),
(440, 56, 7, 0),
(441, 57, 8, 0),
(442, 58, 5, 0),
(443, 59, 6, 0),
(444, 60, 1, 0),
(445, 61, 2, 0),
(446, 62, 7, 0),
(447, 63, 8, 0),
(448, 64, 1, 0),
(449, 65, 2, 0),
(450, 66, 5, 0),
(451, 67, 6, 0),
(452, 68, 7, 0),
(453, 69, 8, 0),
(454, 70, 1, 0),
(455, 71, 2, 0),
(456, 72, 5, 0),
(457, 73, 6, 0),
(458, 74, 7, 0),
(459, 75, 8, 0),
(460, 76, 1, 0),
(461, 77, 2, 0),
(462, 78, 5, 0),
(463, 79, 6, 0),
(464, 80, 7, 0),
(465, 81, 8, 0),
(466, 52, 1, 0),
(467, 53, 2, 0),
(468, 54, 5, 0),
(469, 55, 6, 0),
(470, 56, 7, 0),
(471, 57, 8, 0),
(472, 58, 5, 0),
(473, 59, 6, 0),
(474, 60, 1, 0),
(475, 61, 2, 0),
(476, 62, 7, 0),
(477, 63, 8, 0),
(478, 64, 1, 0),
(479, 65, 2, 0),
(480, 66, 5, 0),
(481, 67, 6, 0),
(482, 68, 7, 0),
(483, 69, 8, 0),
(484, 70, 1, 0),
(485, 71, 2, 0),
(486, 72, 5, 0),
(487, 73, 6, 0),
(488, 74, 7, 0),
(489, 75, 8, 0),
(490, 76, 1, 0),
(491, 77, 2, 0),
(492, 78, 5, 0),
(493, 79, 6, 0),
(494, 80, 7, 0),
(495, 81, 8, 0),
(496, 82, 1, 0),
(497, 52, 1, 0),
(498, 53, 2, 0),
(499, 54, 5, 0),
(500, 55, 6, 0),
(501, 56, 7, 0),
(502, 57, 8, 0),
(503, 58, 5, 0),
(504, 59, 6, 0),
(505, 60, 1, 0),
(506, 61, 2, 0),
(507, 62, 7, 0),
(508, 63, 8, 0),
(509, 64, 1, 0),
(510, 65, 2, 0),
(511, 66, 5, 0),
(512, 67, 6, 0),
(513, 68, 7, 0),
(514, 69, 8, 0),
(515, 70, 1, 0),
(516, 71, 2, 0),
(517, 72, 5, 0),
(518, 73, 6, 0),
(519, 74, 7, 0),
(520, 75, 8, 0),
(521, 76, 1, 0),
(522, 77, 2, 0),
(523, 78, 5, 0),
(524, 79, 6, 0),
(525, 80, 7, 0),
(526, 81, 8, 0),
(527, 82, 1, 0),
(528, 83, 2, 0),
(529, 52, 1, 0),
(530, 53, 2, 0),
(531, 54, 5, 0),
(532, 55, 6, 0),
(533, 56, 7, 0),
(534, 57, 8, 0),
(535, 58, 5, 0),
(536, 59, 6, 0),
(537, 60, 1, 0),
(538, 61, 2, 0),
(539, 62, 7, 0),
(540, 63, 8, 0),
(541, 64, 1, 0),
(542, 65, 2, 0),
(543, 66, 5, 0),
(544, 67, 6, 0),
(545, 68, 7, 0),
(546, 69, 8, 0),
(547, 70, 1, 0),
(548, 71, 2, 0),
(549, 72, 5, 0),
(550, 73, 6, 0),
(551, 74, 7, 0),
(552, 75, 8, 0),
(553, 76, 1, 0),
(554, 77, 2, 0),
(555, 78, 5, 0),
(556, 79, 6, 0),
(557, 80, 7, 0),
(558, 81, 8, 0),
(559, 82, 1, 0),
(560, 83, 2, 0),
(561, 84, 5, 0),
(562, 52, 1, 0),
(563, 53, 2, 0),
(564, 54, 5, 0),
(565, 55, 6, 0),
(566, 56, 7, 0),
(567, 57, 8, 0),
(568, 58, 5, 0),
(569, 59, 6, 0),
(570, 60, 1, 0),
(571, 61, 2, 0),
(572, 62, 7, 0),
(573, 63, 8, 0),
(574, 64, 1, 0),
(575, 65, 2, 0),
(576, 66, 5, 0),
(577, 67, 6, 0),
(578, 68, 7, 0),
(579, 69, 8, 0),
(580, 70, 1, 0),
(581, 71, 2, 0),
(582, 72, 5, 0),
(583, 73, 6, 0),
(584, 74, 7, 0),
(585, 75, 8, 0),
(586, 76, 1, 0),
(587, 77, 2, 0),
(588, 78, 5, 0),
(589, 79, 6, 0),
(590, 80, 7, 0),
(591, 81, 8, 0),
(592, 82, 1, 0),
(593, 83, 2, 0),
(594, 84, 5, 0),
(595, 85, 6, 0),
(596, 52, 1, 0),
(597, 53, 2, 0),
(598, 54, 5, 0),
(599, 55, 6, 0),
(600, 56, 7, 0),
(601, 57, 8, 0),
(602, 58, 5, 0),
(603, 59, 6, 0),
(604, 60, 1, 0),
(605, 61, 2, 0),
(606, 62, 7, 0),
(607, 63, 8, 0),
(608, 64, 1, 0),
(609, 65, 2, 0),
(610, 66, 5, 0),
(611, 67, 6, 0),
(612, 68, 7, 0),
(613, 69, 8, 0),
(614, 70, 1, 0),
(615, 71, 2, 0),
(616, 72, 5, 0),
(617, 73, 6, 0),
(618, 74, 7, 0),
(619, 75, 8, 0),
(620, 76, 1, 0),
(621, 77, 2, 0),
(622, 78, 5, 0),
(623, 79, 6, 0),
(624, 80, 7, 0),
(625, 81, 8, 0),
(626, 82, 1, 0),
(627, 83, 2, 0),
(628, 84, 5, 0),
(629, 85, 6, 0),
(630, 86, 7, 0),
(631, 52, 1, 0),
(632, 53, 2, 0),
(633, 54, 5, 0),
(634, 55, 6, 0),
(635, 56, 7, 0),
(636, 57, 8, 0),
(637, 58, 5, 0),
(638, 59, 6, 0),
(639, 60, 1, 0),
(640, 61, 2, 0),
(641, 62, 7, 0),
(642, 63, 8, 0),
(643, 64, 1, 0),
(644, 65, 2, 0),
(645, 66, 5, 0),
(646, 67, 6, 0),
(647, 68, 7, 0),
(648, 69, 8, 0),
(649, 70, 1, 0),
(650, 71, 2, 0),
(651, 72, 5, 0),
(652, 73, 6, 0),
(653, 74, 7, 0),
(654, 75, 8, 0),
(655, 76, 1, 0),
(656, 77, 2, 0),
(657, 78, 5, 0),
(658, 79, 6, 0),
(659, 80, 7, 0),
(660, 81, 8, 0),
(661, 82, 1, 0),
(662, 83, 2, 0),
(663, 84, 5, 0),
(664, 85, 6, 0),
(665, 86, 7, 0),
(666, 87, 8, 0),
(667, 52, 1, 0),
(668, 53, 2, 0),
(669, 54, 5, 0),
(670, 55, 6, 0),
(671, 56, 7, 0),
(672, 57, 8, 0),
(673, 58, 5, 0),
(674, 59, 6, 0),
(675, 60, 1, 0),
(676, 61, 2, 0),
(677, 62, 7, 0),
(678, 63, 8, 0),
(679, 64, 1, 0),
(680, 65, 2, 0),
(681, 66, 5, 0),
(682, 67, 6, 0),
(683, 68, 7, 0),
(684, 69, 8, 0),
(685, 70, 1, 0),
(686, 71, 2, 0),
(687, 72, 5, 0),
(688, 73, 6, 0),
(689, 74, 7, 0),
(690, 75, 8, 0),
(691, 76, 1, 0),
(692, 77, 2, 0),
(693, 78, 5, 0),
(694, 79, 6, 0),
(695, 80, 7, 0),
(696, 81, 8, 0),
(697, 82, 1, 0),
(698, 83, 2, 0),
(699, 84, 5, 0),
(700, 85, 6, 0),
(701, 86, 7, 0),
(702, 87, 8, 0),
(703, 88, 2, 0),
(704, 52, 1, 0),
(705, 53, 2, 0),
(706, 54, 5, 0),
(707, 55, 6, 0),
(708, 56, 7, 0),
(709, 57, 8, 0),
(710, 58, 5, 0),
(711, 59, 6, 0),
(712, 60, 1, 0),
(713, 61, 2, 0),
(714, 62, 7, 0),
(715, 63, 8, 0),
(716, 64, 1, 0),
(717, 65, 2, 0),
(718, 66, 5, 0),
(719, 67, 6, 0),
(720, 68, 7, 0),
(721, 69, 8, 0),
(722, 70, 1, 0),
(723, 71, 2, 0),
(724, 72, 5, 0),
(725, 73, 6, 0),
(726, 74, 7, 0),
(727, 75, 8, 0),
(728, 76, 1, 0),
(729, 77, 2, 0),
(730, 78, 5, 0),
(731, 79, 6, 0),
(732, 80, 7, 0),
(733, 81, 8, 0),
(734, 82, 1, 0),
(735, 83, 2, 0),
(736, 84, 5, 0),
(737, 85, 6, 0),
(738, 86, 7, 0),
(739, 87, 8, 0),
(740, 88, 2, 0),
(741, 89, 8, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_saldo`
--

CREATE TABLE `m_saldo` (
  `id` int(11) NOT NULL,
  `saldo` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `m_saldo`
--

INSERT INTO `m_saldo` (`id`, `saldo`) VALUES
(1, 1080000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_setting`
--

CREATE TABLE `m_setting` (
  `id_setting` int(11) NOT NULL,
  `kode` varchar(100) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `m_setting`
--

INSERT INTO `m_setting` (`id_setting`, `kode`, `value`) VALUES
(1, 'spp', '2022-08-12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_siswa`
--

CREATE TABLE `m_siswa` (
  `id_siswa` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nisn` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `jk` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_kelas` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `deleted` int(11) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL DEFAULT 0,
  `updated_by` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `m_siswa`
--

INSERT INTO `m_siswa` (`id_siswa`, `username`, `password`, `nisn`, `nama`, `tempat_lahir`, `tgl_lahir`, `jk`, `no_telp`, `alamat`, `foto`, `id_kelas`, `status`, `deleted`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '1', '$2y$10$75jLOGBbaPE5tdMlHZf/P.nPeUpbMb0.BnuXnQeNVW31VhbN52F1G', '1', 'Siti Fatimah', 'Malang', '1999-01-01', 'L', '081803319221', 'Jln. Panglima Sudirman Malang', NULL, 7, 1, 0, 1, 1, '2022-09-25 14:33:34', '2022-09-25 19:47:31'),
(2, '2', '$2y$10$8Z8WDut20CR/IjD9aOw2cemWC/wh2ZQaHEFvO6G/SsVU8aY7bwfCG', '2', 'Ahmad Subhan', 'Malang', '2000-01-01', 'L', '081803319221', 'Jln. Ahmad Yani 01 Wajak', NULL, 8, 1, 0, 1, 1, '2022-09-25 14:33:35', '2022-09-25 19:47:34'),
(3, '3', '$2y$10$ow.IJEJR15dOhTz5kmgtc.ZxEbBdVD0U1PGKbFxA90vkzNxK.QIbq', '3', 'Adi Pratama', 'Malang', '2001-01-01', 'L', '081803319221', 'Jln. Aja Dulu siapa tahu cocok', NULL, 10, 0, 0, 1, 1, '2022-09-25 14:33:36', '2022-09-25 19:47:35'),
(4, '4', '$2y$10$7OKwt0gkrAcACzklbXtxyO3Y.lAIMYINY6TARao4A0JIZNE6Avn7.', '4', 'Algita Margareta', 'Malang', '2002-01-01', 'P', '081803319221', 'Jln. Hidupku untuk mencintaimu', NULL, 1, 1, 0, 1, 1, '2022-09-25 14:33:37', '2022-09-25 19:47:35'),
(5, '5', '$2y$10$.bqImsPePYVJv8EjMl2mJ.ac3/MlHqT2IuisuAtwbCV3xTdsaCQDG', '5', 'Zaenal Arifin', 'Malang', '2003-01-01', 'L', '081803319221', 'Jln. Sokerno-Hatta Malang', NULL, 2, 1, 0, 1, 1, '2022-09-25 14:33:37', '2022-09-25 19:47:35'),
(6, '6', '$2y$10$sjak6qyYADHRW.0nEOBDKeBJiGEjRfPxJpEBODDufVlVjseGg3ZT2', '6', 'Yeni Inka', 'Malang', '2004-01-01', 'P', '081803319221', 'Jln. Sokerno-Hatta Malang', NULL, 10, 0, 0, 1, 1, '2022-09-25 14:33:38', '2022-09-25 19:47:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_whatsapp`
--

CREATE TABLE `m_whatsapp` (
  `id_whatsapp` int(11) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `pesan` text DEFAULT NULL,
  `tipe` tinyint(4) NOT NULL COMMENT '1 : Text\n2 : File',
  `file` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL COMMENT '1 : Success\n2 : Failed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `m_whatsapp`
--

INSERT INTO `m_whatsapp` (`id_whatsapp`, `no_telp`, `pesan`, `tipe`, `file`, `created_by`, `created_at`, `updated_at`, `updated_by`, `status`) VALUES
(1, '081803319221', 'Terima Kasih,\nPembayaran atas nama :\n*Siti Fatimah* \ntelah kami terima.\n\nDengan detail pembayaran sebagai berikut: \n\n------------------------------------------------- \n\n*Tanggungan pada TA 2021 - 2022* \n1. SPP Rp. 450000  tahan ke 1 \n2. DAFTAR ULANG Rp. 30.000  tahan ke 1 \n\n*Total* \nRp 480.000 \n\n*Uang Diterima* \nRp 0 \n\n*Uang Kembalian* \nRp 0 ', 1, NULL, 1, '2022-09-25 19:52:38', '2022-09-25 19:52:38', 1, 2),
(2, '081803319221', 'Terima Kasih,\nPembayaran atas nama :\n*Siti Fatimah* \ntelah kami terima.\n\nDengan detail pembayaran sebagai berikut: \n\n------------------------------------------------- \n\n*Tanggungan pada TA 2021 - 2022* \n1. SPP Rp. 300000  tahan ke 2 \n\n*Total* \nRp 300.000 \n\n*Uang Diterima* \nRp 0 \n\n*Uang Kembalian* \nRp 0 ', 1, NULL, 1, '2022-09-25 19:54:55', '2022-09-25 19:54:55', 1, 2),
(3, '081803319221', 'Terima Kasih,\nPembayaran atas nama :\n*Siti Fatimah* \ntelah kami terima.\n\nDengan detail pembayaran sebagai berikut: \n\n------------------------------------------------- \n\n*Tanggungan pada TA 2021 - 2022* \n1. SPP Rp. 300000  tahan ke 1 \n\n*Total* \nRp 300.000 \n\n*Uang Diterima* \nRp 0 \n\n*Uang Kembalian* \nRp 0 ', 1, NULL, 1, '2022-09-25 20:00:04', '2022-09-25 20:00:04', 1, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendanaan`
--

CREATE TABLE `pendanaan` (
  `id_pemasukan` int(11) NOT NULL,
  `tipe` tinyint(4) DEFAULT NULL COMMENT '1 : Pemasukan\n2 : Pengeluaran',
  `tipe_pemasukan` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 : Siswa\r\n2 : Lain-lain',
  `id_siswa` bigint(20) DEFAULT 0,
  `nama` varchar(255) DEFAULT NULL COMMENT 'untuk nama dana',
  `detail` text DEFAULT NULL COMMENT 'pemasukan dari siswa atau tipe pemasukan 1 \nformat json :\n[''spp'':10000,...] or [''BOS'':20000000]',
  `total` bigint(20) DEFAULT 0,
  `saldo` bigint(20) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pendanaan`
--

INSERT INTO `pendanaan` (`id_pemasukan`, `tipe`, `tipe_pemasukan`, `id_siswa`, `nama`, `detail`, `total`, `saldo`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 2, 0, 'Siti Fatimah', '[{\"nama_biaya\":\"SPP untuk bulan Januari\",\"id_jenis_administrasi\":\"56\",\"nominal\":\"150000\",\"ajaran\":\"2021 - 2022\",\"bulan_spp\":\"januari\"},{\"nama_biaya\":\"SPP untuk bulan Juli\",\"id_jenis_administrasi\":\"56\",\"nominal\":\"150000\",\"ajaran\":\"2021 - 2022\",\"bulan_spp\":\"juli\"},{\"nama_biaya\":\"SPP untuk bulan Desember\",\"id_jenis_administrasi\":\"56\",\"nominal\":\"150000\",\"ajaran\":\"2021 - 2022\",\"bulan_spp\":\"desember\"},{\"nama_biaya\":\"DAFTAR ULANG tahap ke 1\",\"id_jenis_administrasi\":\"62\",\"nominal\":30000,\"ajaran\":\"2021 - 2022\"}]', 480000, 480000, '2022-09-25 19:52:39', NULL, NULL, NULL),
(2, 1, 2, 0, 'Siti Fatimah', '[{\"nama_biaya\":\"SPP untuk bulan Februari\",\"id_jenis_administrasi\":\"56\",\"nominal\":\"150000\",\"ajaran\":\"2021 - 2022\",\"bulan_spp\":\"februari\"},{\"nama_biaya\":\"SPP untuk bulan September\",\"id_jenis_administrasi\":\"56\",\"nominal\":\"150000\",\"ajaran\":\"2021 - 2022\",\"bulan_spp\":\"september\"}]', 300000, 780000, '2022-09-25 19:54:56', NULL, NULL, NULL),
(3, 1, 2, 0, 'Siti Fatimah', '[{\"nama_biaya\":\"SPP untuk bulan Maret\",\"id_jenis_administrasi\":\"56\",\"nominal\":\"150000\",\"ajaran\":\"2021 - 2022\",\"bulan_spp\":\"maret\"},{\"nama_biaya\":\"SPP untuk bulan November\",\"id_jenis_administrasi\":\"56\",\"nominal\":\"150000\",\"ajaran\":\"2021 - 2022\",\"bulan_spp\":\"november\"}]', 300000, 1080000, '2022-09-25 20:00:04', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekap_tunggakan`
--

CREATE TABLE `rekap_tunggakan` (
  `id_rekap_tunggakan` int(11) NOT NULL,
  `nama_tunggakan` varchar(125) DEFAULT NULL,
  `ajaran` varchar(100) DEFAULT NULL,
  `total` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tunggakan`
--

CREATE TABLE `tunggakan` (
  `id_tunggakan` int(11) NOT NULL,
  `id_siswa` bigint(20) UNSIGNED NOT NULL,
  `nama_tunggakan` varchar(150) DEFAULT NULL,
  `nominal` bigint(20) UNSIGNED DEFAULT NULL,
  `ajaran` varchar(20) DEFAULT NULL COMMENT 'untuk tahun ajaran'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tunggakan`
--

INSERT INTO `tunggakan` (`id_tunggakan`, `id_siswa`, `nama_tunggakan`, `nominal`, `ajaran`) VALUES
(1, 1, 'SPP', 1800000, '2020 - 2021'),
(2, 1, 'PENDAFTARAN SISWA BARU', 50000, '2020 - 2021'),
(3, 1, 'LKS SEMESTER - I', 200000, '2020 - 2021'),
(4, 1, 'LKS SEMESTER - II', 250000, '2020 - 2021'),
(5, 1, 'PENILAIAN TENGAH SEMESTER - I', 90000, '2020 - 2021'),
(6, 1, 'PENILAIAN AKHIR SEMESTER - II', 100000, '2020 - 2021'),
(7, 2, 'SPP', 1800000, '2020 - 2021'),
(8, 2, 'DAFTAR ULANG', 30000, '2020 - 2021'),
(9, 2, 'LKS SEMESTER - I', 200000, '2020 - 2021'),
(10, 2, 'LKS SEMESTER - II', 250000, '2020 - 2021'),
(11, 2, 'PENILAIAN TENGAH SEMESTER - I', 90000, '2020 - 2021'),
(12, 2, 'PENILAIAN AKHIR SEMESTER - II', 100000, '2020 - 2021'),
(13, 3, 'SPP', 1800000, '2020 - 2021'),
(14, 3, 'DAFTAR ULANG', 30000, '2020 - 2021'),
(15, 3, 'LKS SEMESTER - I', 200000, '2020 - 2021'),
(16, 3, 'LKS SEMESTER - II', 250000, '2020 - 2021'),
(17, 3, 'PENILAIAN TENGAH SEMESTER - I', 90000, '2020 - 2021'),
(18, 3, 'PENILAIAN AKHIR SEMESTER - II', 100000, '2020 - 2021'),
(19, 3, 'UNAS / USEK / UHB-BKS', 2000000, '2020 - 2021'),
(20, 4, 'SPP', 1800000, '2020 - 2021'),
(21, 4, 'PENDAFTARAN SISWA BARU', 50000, '2020 - 2021'),
(22, 4, 'LKS SEMESTER - I', 200000, '2020 - 2021'),
(23, 4, 'LKS SEMESTER - II', 250000, '2020 - 2021'),
(24, 4, 'PENILAIAN TENGAH SEMESTER - I', 90000, '2020 - 2021'),
(25, 4, 'PENILAIAN AKHIR SEMESTER - II', 100000, '2020 - 2021'),
(26, 5, 'SPP', 1800000, '2020 - 2021'),
(27, 5, 'DAFTAR ULANG', 30000, '2020 - 2021'),
(28, 5, 'LKS SEMESTER - I', 200000, '2020 - 2021'),
(29, 5, 'LKS SEMESTER - II', 250000, '2020 - 2021'),
(30, 5, 'PENILAIAN TENGAH SEMESTER - I', 90000, '2020 - 2021'),
(31, 5, 'PENILAIAN AKHIR tahun - II', 100000, '2020 - 2021'),
(32, 6, 'SPP', 1800000, '2020 - 2021'),
(33, 6, 'DAFTAR ULANG', 30000, '2020 - 2021'),
(34, 6, 'LKS SEMESTER - I', 200000, '2020 - 2021'),
(35, 6, 'LKS SEMESTER - II', 250000, '2020 - 2021'),
(36, 6, 'PENILAIAN TENGAH SEMESTER - I', 90000, '2020 - 2021'),
(37, 6, 'PENILAIAN AKHIR SEMESTER - II', 100000, '2020 - 2021'),
(38, 6, 'UNAS / USEK / UHB-BKS', 2000000, '2020 - 2021');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_cicilan`
--

CREATE TABLE `t_cicilan` (
  `id_cicilan` int(11) NOT NULL,
  `tipe` int(11) NOT NULL COMMENT '1 : Administrasi Ajaran Sekarang\r\n2 : Tunggakan',
  `id_administrasi` int(11) NOT NULL COMMENT 'administrasi now / tunggakan',
  `deskripsi` text DEFAULT NULL,
  `total_cicilan` bigint(20) NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_cicilan`
--

INSERT INTO `t_cicilan` (`id_cicilan`, `tipe`, `id_administrasi`, `deskripsi`, `total_cicilan`, `updated_at`) VALUES
(77, 1, 1, '[300000]', 0, NULL),
(78, 1, 2, NULL, 0, NULL),
(79, 1, 3, NULL, 0, NULL),
(80, 1, 4, NULL, 0, NULL),
(81, 1, 5, NULL, 0, NULL),
(82, 1, 6, NULL, 0, NULL),
(83, 1, 7, NULL, 0, NULL),
(84, 1, 8, NULL, 0, NULL),
(85, 1, 9, NULL, 0, NULL),
(86, 1, 10, NULL, 0, NULL),
(87, 1, 11, NULL, 0, NULL),
(88, 1, 12, NULL, 0, NULL),
(89, 1, 13, NULL, 0, NULL),
(90, 1, 14, NULL, 0, NULL),
(91, 1, 15, NULL, 0, NULL),
(92, 1, 16, NULL, 0, NULL),
(93, 1, 17, NULL, 0, NULL),
(94, 1, 18, NULL, 0, NULL),
(95, 1, 19, NULL, 0, NULL),
(96, 1, 20, NULL, 0, NULL),
(97, 1, 21, NULL, 0, NULL),
(98, 1, 22, NULL, 0, NULL),
(99, 1, 23, NULL, 0, NULL),
(100, 1, 24, NULL, 0, NULL),
(101, 1, 25, NULL, 0, NULL),
(102, 1, 26, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_spp`
--

CREATE TABLE `t_spp` (
  `id_spp` int(11) NOT NULL,
  `id_siswa` bigint(20) UNSIGNED NOT NULL,
  `januari` bigint(20) DEFAULT 0,
  `februari` bigint(20) DEFAULT 0,
  `maret` bigint(20) DEFAULT 0,
  `april` bigint(20) DEFAULT 0,
  `mei` bigint(20) DEFAULT 0,
  `juni` bigint(20) DEFAULT 0,
  `juli` bigint(20) DEFAULT 0,
  `agustus` bigint(20) DEFAULT 0,
  `september` bigint(20) DEFAULT 0,
  `oktober` bigint(20) DEFAULT 0,
  `november` bigint(20) DEFAULT 0,
  `desember` bigint(20) DEFAULT 0,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_spp`
--

INSERT INTO `t_spp` (`id_spp`, `id_siswa`, `januari`, `februari`, `maret`, `april`, `mei`, `juni`, `juli`, `agustus`, `september`, `oktober`, `november`, `desember`, `updated_at`) VALUES
(1, 1, 0, 0, 0, 150000, 150000, 150000, 0, 150000, 0, 150000, 0, 0, NULL),
(2, 2, 150000, 150000, 150000, 150000, 150000, 150000, 150000, 150000, 150000, 150000, 150000, 150000, NULL),
(3, 4, 150000, 150000, 150000, 150000, 150000, 150000, 150000, 150000, 150000, 150000, 150000, 150000, NULL),
(4, 5, 150000, 150000, 150000, 150000, 150000, 150000, 150000, 150000, 150000, 150000, 150000, 150000, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) NOT NULL COMMENT '1 : Admin\n2 : Bendahara\n3 :  Kepala Sekolah',
  `email_verified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `deleted`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@mail.com', 1, '2022-08-09 16:43:28', '$2y$10$VJk3LuiQ8kS7Gacl3pzUK.q5JMGHwczGiY5FlWJ9J1rn3YdlOvkgK', 0, NULL, '2022-07-29 09:36:27', '2022-07-29 09:36:27'),
(2, 'kepala sekolah', 'kepala_sekolah@mail.com', 3, '2022-08-09 16:43:39', '$2y$10$IKPqoPu53aBmf1MmQKtLPeqXOuOfBWPrMN7f3o2EkGgaDJRYyOEkK', 0, NULL, '2022-07-29 22:59:15', '2022-07-29 22:59:15'),
(4, 'bendahara', 'bendahara@mail.com', 2, '2022-08-09 16:43:44', '$2y$10$az0jfHUNTFgGbF9Z8tW/rO9OyuVViUZeQaxzC4lmB3EYWOdSRPsku', 0, NULL, '2022-08-02 14:04:50', '2022-08-02 14:04:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `whatsapp_send`
--

CREATE TABLE `whatsapp_send` (
  `id` int(11) NOT NULL,
  `id_whatsapp` int(10) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1 : Sukses\n2 : Gagal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `administrasi`
--
ALTER TABLE `administrasi`
  ADD PRIMARY KEY (`id_administrasi`),
  ADD KEY `id_jenis_administrasi` (`id_jenis_administrasi`),
  ADD KEY `id_siswa_2` (`id_siswa`);

--
-- Indeks untuk tabel `h_transaksi`
--
ALTER TABLE `h_transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `h_user`
--
ALTER TABLE `h_user`
  ADD PRIMARY KEY (`id_h_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `m_ajaran`
--
ALTER TABLE `m_ajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `m_jenis_administrasi`
--
ALTER TABLE `m_jenis_administrasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indeks untuk tabel `m_jurusan`
--
ALTER TABLE `m_jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indeks untuk tabel `m_kelas`
--
ALTER TABLE `m_kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `id_jurusan` (`id_jurusan`);

--
-- Indeks untuk tabel `m_rekap`
--
ALTER TABLE `m_rekap`
  ADD PRIMARY KEY (`id_rekap`),
  ADD KEY `id_jenis_administrasi` (`id_jenis_administrasi`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indeks untuk tabel `m_saldo`
--
ALTER TABLE `m_saldo`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `m_setting`
--
ALTER TABLE `m_setting`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indeks untuk tabel `m_siswa`
--
ALTER TABLE `m_siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indeks untuk tabel `m_whatsapp`
--
ALTER TABLE `m_whatsapp`
  ADD PRIMARY KEY (`id_whatsapp`);

--
-- Indeks untuk tabel `pendanaan`
--
ALTER TABLE `pendanaan`
  ADD PRIMARY KEY (`id_pemasukan`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `rekap_tunggakan`
--
ALTER TABLE `rekap_tunggakan`
  ADD PRIMARY KEY (`id_rekap_tunggakan`);

--
-- Indeks untuk tabel `tunggakan`
--
ALTER TABLE `tunggakan`
  ADD PRIMARY KEY (`id_tunggakan`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `t_cicilan`
--
ALTER TABLE `t_cicilan`
  ADD PRIMARY KEY (`id_cicilan`),
  ADD KEY `id_administrasi` (`id_administrasi`);

--
-- Indeks untuk tabel `t_spp`
--
ALTER TABLE `t_spp`
  ADD PRIMARY KEY (`id_spp`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `whatsapp_send`
--
ALTER TABLE `whatsapp_send`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `administrasi`
--
ALTER TABLE `administrasi`
  MODIFY `id_administrasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `h_transaksi`
--
ALTER TABLE `h_transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `h_user`
--
ALTER TABLE `h_user`
  MODIFY `id_h_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT untuk tabel `m_ajaran`
--
ALTER TABLE `m_ajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `m_jenis_administrasi`
--
ALTER TABLE `m_jenis_administrasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT untuk tabel `m_jurusan`
--
ALTER TABLE `m_jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `m_kelas`
--
ALTER TABLE `m_kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `m_rekap`
--
ALTER TABLE `m_rekap`
  MODIFY `id_rekap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=742;

--
-- AUTO_INCREMENT untuk tabel `m_saldo`
--
ALTER TABLE `m_saldo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `m_setting`
--
ALTER TABLE `m_setting`
  MODIFY `id_setting` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `m_siswa`
--
ALTER TABLE `m_siswa`
  MODIFY `id_siswa` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `m_whatsapp`
--
ALTER TABLE `m_whatsapp`
  MODIFY `id_whatsapp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pendanaan`
--
ALTER TABLE `pendanaan`
  MODIFY `id_pemasukan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `rekap_tunggakan`
--
ALTER TABLE `rekap_tunggakan`
  MODIFY `id_rekap_tunggakan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tunggakan`
--
ALTER TABLE `tunggakan`
  MODIFY `id_tunggakan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `t_cicilan`
--
ALTER TABLE `t_cicilan`
  MODIFY `id_cicilan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT untuk tabel `t_spp`
--
ALTER TABLE `t_spp`
  MODIFY `id_spp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `whatsapp_send`
--
ALTER TABLE `whatsapp_send`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `administrasi`
--
ALTER TABLE `administrasi`
  ADD CONSTRAINT `rsl_siswa_adm` FOREIGN KEY (`id_siswa`) REFERENCES `m_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `h_transaksi`
--
ALTER TABLE `h_transaksi`
  ADD CONSTRAINT `rls_siswa_transaksi` FOREIGN KEY (`id_siswa`) REFERENCES `m_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `h_user`
--
ALTER TABLE `h_user`
  ADD CONSTRAINT `rls_user_history` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `m_jenis_administrasi`
--
ALTER TABLE `m_jenis_administrasi`
  ADD CONSTRAINT `rls_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `m_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `m_kelas`
--
ALTER TABLE `m_kelas`
  ADD CONSTRAINT `rls_jurusan` FOREIGN KEY (`id_jurusan`) REFERENCES `m_jurusan` (`id_jurusan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `m_rekap`
--
ALTER TABLE `m_rekap`
  ADD CONSTRAINT `rls_jenis_adm_rekap` FOREIGN KEY (`id_jenis_administrasi`) REFERENCES `m_jenis_administrasi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rls_kelas_rekap` FOREIGN KEY (`id_kelas`) REFERENCES `m_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `m_siswa`
--
ALTER TABLE `m_siswa`
  ADD CONSTRAINT `rls_siswa_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `m_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tunggakan`
--
ALTER TABLE `tunggakan`
  ADD CONSTRAINT `rsl_siswa_tunggakan` FOREIGN KEY (`id_siswa`) REFERENCES `m_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `t_spp`
--
ALTER TABLE `t_spp`
  ADD CONSTRAINT `rsl_siswa_spp` FOREIGN KEY (`id_siswa`) REFERENCES `m_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
