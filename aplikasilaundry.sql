-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Bulan Mei 2025 pada 07.02
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aplikasilaundry`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(11) NOT NULL,
  `nama_customer` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `jenis_kelamin` enum('l','p') NOT NULL,
  `no_telp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id_customer`, `nama_customer`, `alamat`, `jenis_kelamin`, `no_telp`) VALUES
(1, 'Andi Setiawan', 'Jl. Merdeka No. 1, Jakarta', 'l', '081234567890'),
(2, 'Siti Aminah', 'Jl. Pahlawan No. 2, Bandung', 'p', '081234567891'),
(3, 'Budi Santoso', 'Jl. Kebangsaan No. 3, Surabaya', 'l', '081234567892'),
(4, 'Dewi Lestari', 'Jl. Cinta No. 4, Yogyakarta', 'p', '081234567893'),
(5, 'Joko Widodo', 'Jl. Sejahtera No. 5, Semarang', 'l', '081234567894'),
(6, 'Rina Sari', 'Jl. Bahagia No. 6, Medan', 'p', '081234567895'),
(7, 'Tono Prabowo', 'Jl. Damai No. 7, Makassar', 'l', '081234567896'),
(8, 'Nina Rahmawati', 'Jl. Harapan No. 8, Palembang', 'p', '081234567897'),
(9, 'Eko Susanto', 'Jl. Sukses No. 9, Bali', 'l', '081234567898'),
(10, 'Lina Fitriani', 'Jl. Cemerlang No. 10, Bogor', 'p', '081234567899'),
(11, 'Rudi Hartono', 'Jl. Maju No. 11, Depok', 'l', '081234567900'),
(12, 'Sari Wulandari', 'Jl. Indah No. 12, Tangerang', 'p', '081234567901'),
(13, 'Fajar Nugroho', 'Jl. Cinta No. 13, Batam', 'l', '081234567902'),
(14, 'Maya Kurniawati', 'Jl. Bahagia No. 14, Cirebon', 'p', '081234567903'),
(15, 'Agus Salim', 'Jl. Sejahtera No. 15, Solo', 'l', '081234567904'),
(16, 'Tina Yulianti', 'Jl. Damai No. 16, Malang', 'p', '081234567905'),
(17, 'Hendra Wijaya', 'Jl. Harapan No. 17, Banjarmasin', 'l', '081234567906'),
(18, 'Dina Puspitasari', 'Jl. Sukses No. 18, Balikpapan', 'p', '081234567907'),
(19, 'Rizky Pratama', 'Jl. Cemerlang No. 19, Kupang', 'l', '081234567908'),
(20, 'Nadia Anjani', 'Jl. Maju No. 20, Manado', 'p', '081234567909'),
(21, 'Slamet Rahardjo', 'Jl. Merdeka No. 21, Jember', 'l', '081234567910'),
(22, 'Wati Sari', 'Jl. Pahlawan No. 22, Cilegon', 'p', '081234567911'),
(23, 'Dani Setiawan', 'Jl. Kebangsaan No. 23, Sukabumi', 'l', '081234567912'),
(24, 'Rina Melati', 'Jl. Cinta No. 24, Tasikmalaya', 'p', '081234567913'),
(25, 'Yudi Prabowo', 'Jl. Sejahtera No. 25, Jombang', 'l', '081234567914'),
(26, 'Siti Khadijah', 'Jl. Bahagia No. 26, Ciamis', 'p', '081234567915'),
(27, 'Ferry Hidayat', 'Jl. Damai No. 27, Pati', 'l', '081234567916'),
(28, 'Lina Sari', 'Jl. Harapan No. 28, Probolinggo', 'p', '081234567917'),
(29, 'Rudiansyah', 'Jl. Sukses No. 29, Sukoharjo', 'l', '081234567918'),
(30, 'Dewi Anggraini', 'Jl. Cemerlang No. 30, Cirebon', 'p', '081234567919'),
(31, 'Agung Prasetyo', 'Jl. Maju No. 31, Semarang', 'l', '081234567920'),
(32, 'Nina Sari', 'Jl. Merdeka No. 32, Jakarta', 'p', '081234567921'),
(33, 'Budi Setiawan', 'Jl. Pahlawan No. 33, Bandung', 'l', '081234567922'),
(34, 'Siti Nurhaliza', 'Jl. Kebangsaan No. 34, Surabaya', 'p', '081234567923'),
(35, 'Rizal Maulana', 'Jl. Cinta No. 35, Yogyakarta', 'l', '081234567924'),
(36, 'Maya Lestari', 'Jl. Bahagia No. 36, Medan', 'p', '081234567925'),
(37, 'Hendra Gunawan', 'Jl. Damai No. 37, Makassar', 'l', '081234567926'),
(38, 'Diana Rahmawati', 'Jl. Harapan No. 38, Palembang', 'p', '081234567927'),
(39, 'Eko Prabowo', 'Jl. Sukses No. 39, Bali', 'l', '081234567928'),
(40, 'Lina Fitri', 'Jl. Cemerlang No. 40, Bogor', 'p', '081234567929'),
(41, 'Rudi Hartono', 'Jl. Maju No. 41, Depok', 'l', '081234567930'),
(42, 'Sari Wulandari', 'Jl. Indah No. 42, Tangerang', 'p', '081234567931'),
(43, 'Fajar Nugroho', 'Jl. Cinta No. 43, Batam', 'l', '081234567932'),
(44, 'Maya Kurniawati', 'Jl. Bahagia No. 44, Cirebon', 'p', '081234567933'),
(45, 'Agus Salim', 'Jl. Sejahtera No. 45, Solo', 'l', '081234567934'),
(46, 'Tina Yulianti', 'Jl. Damai No. 46, Malang', 'p', '081234567935'),
(47, 'Hendra Wijaya', 'Jl. Harapan No. 47, Banjarmasin', 'l', '081234567936'),
(48, 'Dina Puspitasari', 'Jl. Sukses No. 48, Balikpapan', 'p', '081234567937'),
(49, 'Rizky Pratama', 'Jl. Cemerlang No. 49, Kupang', 'l', '081234567938'),
(50, 'Nadia Anjani', 'Jl. Maju No. 50, Manado', 'p', '081234567939'),
(51, 'Slamet Rahardjo', 'Jl. Merdeka No. 51, Jember', 'l', '081234567940'),
(52, 'Wati Sari', 'Jl. Pahlawan No. 52, Cilegon', 'p', '081234567941'),
(53, 'Dani Setiawan', 'Jl. Kebangsaan No. 53, Sukabumi', 'l', '081234567942'),
(54, 'Rina Melati', 'Jl. Cinta No. 54, Tasikmalaya', 'p', '081234567943'),
(55, 'Yudi Prabowo', 'Jl. Sejahtera No. 55, Jombang', 'l', '081234567944'),
(56, 'Siti Khadijah', 'Jl. Bahagia No. 56, Ciamis', 'p', '081234567945'),
(57, 'Ferry Hidayat', 'Jl. Damai No. 57, Pati', 'l', '081234567946'),
(58, 'Lina Sari', 'Jl. Harapan No. 58, Probolinggo', 'p', '081234567947'),
(59, 'Rudiansyah', 'Jl. Sukses No. 59, Sukoharjo', 'l', '081234567948'),
(60, 'Dewi Anggraini', 'Jl. Cemerlang No. 60, Cirebon', 'p', '085718670690'),
(61, 'Agung Prasetyo', 'Jl. Maju No. 61, Semarang', 'l', '081234567949'),
(62, 'Nina Sari', 'Jl. Merdeka No. 62, Jakarta', 'p', '081234567950'),
(63, 'Budi Setiawan', 'Jl. Pahlawan No. 63, Bandung', 'l', '081234567951'),
(64, 'Siti Nurhaliza', 'Jl. Kebangsaan No. 64, Surabaya', 'p', '081234567952'),
(65, 'Rizal Maulana', 'Jl. Cinta No. 65, Yogyakarta', 'l', '081234567953'),
(66, 'Maya Lestari', 'Jl. Bahagia No. 66, Medan', 'p', '081234567954'),
(67, 'Hendra Gunawan', 'Jl. Damai No. 67, Makassar', 'l', '081234567955'),
(68, 'Diana Rahmawati', 'Jl. Harapan No. 68, Palembang', 'p', '081234567956'),
(69, 'Eko Prabowo', 'Jl. Sukses No. 69, Bali', 'l', '081234567957'),
(70, 'Lina Fitri', 'Jl. Cemerlang No. 70, Bogor', 'p', '081234567958'),
(71, 'Rudi Hartono', 'Jl. Maju No. 71, Depok', 'l', '081234567959'),
(72, 'Sari Wulandari', 'Jl. Indah No. 72, Tangerang', 'p', '081234567960'),
(73, 'Fajar Nugroho', 'Jl. Cinta No. 73, Batam', 'l', '081234567961'),
(74, 'Maya Kurniawati', 'Jl. Bahagia No. 74, Cirebon', 'p', '081234567962'),
(75, 'Agus Salim', 'Jl. Sejahtera No. 75, Solo', 'l', '081234567963'),
(76, 'Tina Yulianti', 'Jl. Damai No. 76, Malang', 'p', '081234567964'),
(77, 'Hendra Wijaya', 'Jl. Harapan No. 77, Banjarmasin', 'l', '081234567965'),
(78, 'Dina Puspitasari', 'Jl. Sukses No. 78, Balikpapan', 'p', '081234567966'),
(79, 'Rizky Pratama', 'Jl. Cemerlang No. 79, Kupang', 'l', '081234567967'),
(80, 'Nadia Anjani', 'Jl. Maju No. 80, Manado', 'p', '081234567968'),
(81, 'Slamet Rahardjo', 'Jl. Merdeka No. 81, Jember', 'l', '081234567969'),
(82, 'Wati Sari', 'Jl. Pahlawan No. 82, Cilegon', 'p', '081234567970'),
(83, 'Dani Setiawan', 'Jl. Kebangsaan No. 83, Sukabumi', 'l', '081234567971'),
(84, 'Rina Melati', 'Jl. Cinta No. 84, Tasikmalaya', 'p', '081234567972'),
(85, 'Yudi Prabowo', 'Jl. Sejahtera No. 85, Jombang', 'l', '081234567973'),
(86, 'Siti Khadijah', 'Jl. Bahagia No. 86, Ciamis', 'p', '081234567974'),
(87, 'Ferry Hidayat', 'Jl. Damai No. 87, Pati', 'l', '081234567975'),
(88, 'Lina Sari', 'Jl. Harapan No. 88, Probolinggo', 'p', '081234567976'),
(89, 'Rudiansyah', 'Jl. Sukses No. 89, Sukoharjo', 'l', '081234567977'),
(90, 'Dewi Anggraini', 'Jl. Cemerlang No. 90, Cirebon', 'p', '081234567978'),
(91, 'Agung Prasetyo', 'Jl. Maju No. 91, Semarang', 'l', '081234567979'),
(92, 'Nina Sari', 'Jl. Merdeka No. 92, Jakarta', 'p', '081234567980'),
(94, 'Siti Nurhaliza', 'Jl. Kebangsaan No. 94, Surabaya', 'p', '081234567982'),
(95, 'Rizal Maulana', 'Jl. Cinta No. 95, Yogyakarta', 'l', '081234567983'),
(96, 'Maya Lestari', 'Jl. Bahagia No. 96, Medan', 'p', '081234567984'),
(97, 'Hendra Gunawan', 'Jl. Damai No. 97, Makassar', 'l', '081234567985'),
(98, 'Diana Rahmawati', 'Jl. Harapan No. 98, Palembang', 'p', '081234567986'),
(99, 'Eko Prabowo', 'Jl. Sukses No. 99, Bali', 'l', '081234567987'),
(101, 'Edo Priyatna', 'Jalan Kelurahan Buaran', 'l', '085718670690');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail_transaksi` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_jenis_cucian` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `total_bayar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail_transaksi`, `id_transaksi`, `id_jenis_cucian`, `qty`, `total_harga`, `total_bayar`) VALUES
(1, 1, 3, 2, 30000, 30000),
(2, 1, 5, 1, 40000, 30000),
(3, 2, 1, 3, 60000, 150000),
(4, 2, 4, 1, 50000, 150000),
(5, 3, 2, 2, 40000, 40000),
(6, 3, 6, 1, 35000, 40000),
(7, 4, 7, 5, 300000, 300000),
(8, 4, 9, 1, 20000, 300000),
(9, 5, 8, 2, 140000, 140000),
(10, 5, 10, 1, 80000, 140000),
(11, 6, 1, 4, 80000, 80000),
(12, 6, 3, 2, 30000, 80000),
(13, 7, 2, 1, 20000, 20000),
(14, 8, 5, 3, 120000, 120000),
(15, 8, 11, 2, 60000, 120000),
(16, 9, 4, 1, 50000, 50000),
(17, 10, 6, 5, 175000, 175000),
(18, 11, 12, 2, 50000, 50000),
(19, 12, 13, 1, 40000, 40000),
(20, 12, 14, 3, 90000, 40000),
(21, 13, 15, 1, 45000, 45000),
(22, 14, 1, 2, 40000, 40000),
(23, 15, 2, 3, 60000, 60000),
(24, 16, 3, 1, 15000, 15000),
(25, 17, 4, 2, 100000, 100000),
(51, 26, 1, 4, 80000, 80000),
(52, 27, 14, 1, 30000, 190000),
(53, 27, 9, 3, 60000, 190000),
(54, 27, 4, 2, 100000, 190000),
(55, 28, 13, 4, 160000, 400000),
(56, 28, 5, 4, 160000, 400000),
(57, 28, 9, 4, 80000, 400000),
(58, 29, 11, 1, 30000, 30000),
(59, 30, 15, 4, 180000, 220000),
(60, 30, 13, 1, 40000, 220000),
(61, 31, 9, 2, 40000, 140000),
(62, 31, 9, 5, 100000, 140000),
(63, 32, 5, 1, 40000, 40000),
(64, 33, 5, 2, 80000, 285000),
(65, 33, 14, 1, 30000, 285000),
(66, 33, 6, 5, 175000, 285000),
(67, 34, 8, 2, 140000, 420000),
(68, 34, 8, 1, 70000, 420000),
(69, 34, 8, 3, 210000, 420000),
(70, 35, 11, 4, 120000, 120000),
(71, 36, 9, 1, 20000, 20000),
(72, 37, 7, 4, 240000, 340000),
(73, 37, 9, 5, 100000, 340000),
(74, 38, 2, 2, 40000, 290000),
(75, 38, 13, 5, 200000, 290000),
(76, 38, 4, 1, 50000, 290000),
(77, 39, 12, 3, 75000, 150000),
(78, 39, 3, 5, 75000, 150000),
(79, 40, 15, 3, 135000, 475000),
(80, 40, 10, 3, 240000, 475000),
(81, 40, 12, 4, 100000, 475000),
(82, 41, 9, 5, 100000, 190000),
(83, 41, 6, 2, 70000, 190000),
(84, 41, 1, 1, 20000, 190000),
(85, 42, 7, 1, 60000, 520000),
(86, 42, 13, 4, 160000, 520000),
(87, 42, 7, 5, 300000, 520000),
(88, 43, 4, 1, 50000, 50000),
(89, 44, 11, 1, 30000, 155000),
(90, 44, 12, 3, 75000, 155000),
(91, 44, 4, 1, 50000, 155000),
(92, 45, 9, 4, 80000, 290000),
(93, 45, 15, 2, 90000, 290000),
(94, 45, 11, 4, 120000, 290000),
(95, 46, 2, 5, 100000, 100000),
(96, 47, 5, 1, 40000, 85000),
(97, 47, 3, 3, 45000, 85000),
(98, 48, 13, 5, 200000, 430000),
(99, 48, 2, 4, 80000, 430000),
(100, 48, 4, 3, 150000, 430000),
(101, 49, 14, 3, 90000, 390000),
(102, 49, 13, 5, 200000, 390000),
(103, 49, 2, 5, 100000, 390000),
(104, 50, 14, 4, 120000, 270000),
(105, 50, 11, 5, 150000, 270000),
(106, 51, 2, 3, 60000, 70000),
(107, 52, 6, 2, 70000, 210000),
(108, 52, 7, 3, 180000, 210000),
(109, 53, 3, 4, 60000, 60000),
(110, 54, 10, 5, 400000, 400000),
(111, 55, 12, 3, 75000, 75000),
(112, 56, 5, 4, 160000, 400000),
(113, 56, 15, 4, 180000, 400000),
(114, 56, 8, 2, 140000, 400000),
(115, 57, 11, 5, 150000, 200000),
(116, 57, 9, 5, 100000, 200000),
(117, 58, 13, 4, 160000, 160000),
(118, 59, 2, 5, 100000, 100000),
(119, 60, 3, 2, 30000, 195000),
(120, 60, 4, 2, 100000, 195000),
(121, 60, 1, 3, 60000, 195000),
(122, 61, 6, 4, 140000, 140000),
(123, 62, 7, 5, 300000, 300000),
(124, 63, 15, 2, 90000, 250000),
(125, 63, 12, 4, 100000, 250000),
(126, 63, 9, 3, 60000, 250000),
(127, 64, 8, 1, 70000, 70000),
(128, 65, 9, 5, 100000, 250000),
(129, 65, 2, 4, 80000, 250000),
(130, 65, 14, 2, 60000, 250000),
(131, 66, 5, 5, 200000, 350000),
(132, 66, 3, 5, 75000, 350000),
(133, 67, 15, 3, 135000, 135000),
(134, 68, 2, 2, 40000, 40000),
(135, 69, 1, 5, 100000, 100000),
(136, 70, 10, 2, 160000, 240000),
(137, 70, 6, 3, 105000, 240000),
(138, 71, 11, 4, 120000, 120000),
(139, 72, 13, 5, 200000, 300000),
(140, 72, 15, 2, 90000, 300000),
(141, 73, 14, 1, 30000, 175000),
(142, 73, 5, 2, 80000, 175000),
(143, 73, 9, 3, 60000, 175000),
(144, 74, 8, 3, 210000, 210000),
(145, 75, 4, 5, 250000, 250000),
(146, 76, 2, 3, 60000, 60000),
(147, 77, 6, 2, 70000, 210000),
(148, 77, 7, 3, 180000, 210000),
(149, 78, 3, 4, 60000, 60000),
(150, 79, 10, 5, 400000, 400000),
(151, 80, 12, 3, 75000, 75000),
(152, 81, 5, 4, 160000, 400000),
(153, 81, 15, 4, 180000, 400000),
(154, 81, 8, 2, 140000, 400000),
(155, 82, 11, 5, 150000, 200000),
(156, 82, 9, 5, 100000, 200000),
(157, 83, 13, 4, 160000, 160000),
(158, 84, 2, 5, 100000, 100000),
(159, 85, 3, 2, 30000, 195000),
(160, 85, 4, 2, 100000, 195000),
(161, 85, 1, 3, 60000, 195000),
(162, 86, 6, 4, 140000, 140000),
(163, 87, 7, 5, 300000, 300000),
(164, 88, 15, 2, 90000, 250000),
(165, 88, 12, 4, 100000, 250000),
(166, 88, 9, 3, 60000, 250000),
(167, 89, 8, 1, 70000, 70000),
(168, 90, 9, 5, 100000, 250000),
(169, 90, 2, 4, 80000, 250000),
(170, 90, 14, 2, 60000, 250000),
(171, 91, 5, 5, 200000, 350000),
(172, 91, 3, 5, 75000, 350000),
(173, 92, 15, 3, 135000, 135000),
(174, 93, 2, 2, 40000, 40000),
(175, 94, 1, 5, 100000, 100000),
(176, 95, 10, 2, 160000, 240000),
(177, 95, 6, 3, 105000, 240000),
(178, 96, 11, 4, 120000, 120000),
(179, 97, 13, 5, 200000, 300000),
(180, 97, 15, 2, 90000, 300000),
(181, 98, 14, 1, 30000, 175000),
(182, 98, 5, 2, 80000, 175000),
(183, 98, 9, 3, 60000, 175000),
(184, 99, 8, 3, 210000, 210000),
(185, 100, 4, 5, 250000, 250000),
(186, 119, 3, 1, 15000, 500000),
(187, 119, 4, 4, 200000, 500000),
(188, 120, 1, 1, 20000, 40000),
(190, 122, 3, 1, 15000, 0),
(193, 125, 4, 1, 50000, 100000),
(194, 126, 1, 1, 20000, 100000),
(195, 127, 3, 1, 15000, 15000),
(196, 128, 3, 1, 15000, 45000),
(197, 128, 2, 1, 20000, 45000),
(198, 103, 2, 1, 20000, 20),
(199, 123, 11, 1, 30000, 50),
(204, 132, 1, 1, 20000, 15000),
(205, 133, 2, 1, 20000, 20000),
(206, 134, 2, 1, 20000, 60000),
(207, 134, 5, 1, 40000, 60000),
(208, 135, 2, 1, 30000, 80000),
(209, 135, 4, 1, 50000, 80000),
(210, 136, 2, 1, 30000, 30000),
(211, 137, 1, 1, 10000, 40000),
(212, 137, 2, 1, 30000, 40000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_cucian`
--

CREATE TABLE `jenis_cucian` (
  `id_jenis_cucian` int(11) NOT NULL,
  `nama_jenis_cucian` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jenis_cucian`
--

INSERT INTO `jenis_cucian` (`id_jenis_cucian`, `nama_jenis_cucian`, `harga`, `status`) VALUES
(1, 'Cuci Kiloan', 10000, '1'),
(2, 'Cuci Setrika', 30000, '1'),
(3, 'Cuci Sepatu', 15000, '1'),
(4, 'Cuci Karpet', 50000, '1'),
(5, 'Cuci Baju Formal', 30000, '1'),
(6, 'Cuci Baju Olahraga', 35000, '1'),
(7, 'Cuci Selimut', 60000, '1'),
(8, 'Cuci Gorden', 70000, '1'),
(9, 'Cuci Baju Anak', 20000, '1'),
(10, 'Cuci Baju Musim Dingin', 80000, '1'),
(11, 'Cuci Baju Renang', 30000, '1'),
(12, 'Cuci Baju Tidur', 25000, '1'),
(13, 'Cuci Baju Kerja', 40000, '1'),
(14, 'Cuci Boneka', 30000, '1'),
(15, 'Cuci Tas', 45000, '1'),
(16, 'Cuci Peralatan Sholat', 15000, '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `kode_transaksi` varchar(100) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('baru','proses','selesai','diambil') NOT NULL DEFAULT 'baru',
  `status_pembayaran` enum('0','1') NOT NULL DEFAULT '0',
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_customer`, `kode_transaksi`, `tanggal`, `status`, `status_pembayaran`, `id_user`) VALUES
(1, 75, 'TRANS-202502230001', '2025-02-23 15:30:37', 'baru', '0', 2),
(2, 72, 'TRANS-202502230002', '2025-02-23 15:30:50', 'baru', '1', 2),
(3, 33, 'TRANS-202502230003', '2025-02-23 08:05:03', 'baru', '0', 2),
(4, 48, 'TRANS-202502230004', '2025-02-23 08:05:03', 'proses', '0', 2),
(5, 42, 'TRANS-202502230005', '2025-02-23 15:30:50', 'baru', '0', 2),
(6, 65, 'TRANS-202502230006', '2025-02-23 08:05:03', 'diambil', '0', 2),
(7, 97, 'TRANS-202502230007', '2025-02-23 15:30:50', 'baru', '0', 2),
(8, 89, 'TRANS-202502230008', '2025-02-23 08:05:03', 'baru', '0', 2),
(9, 55, 'TRANS-202502230009', '2025-02-23 08:05:03', 'proses', '0', 2),
(10, 7, 'TRANS-202502230010', '2025-02-23 15:30:50', 'baru', '0', 2),
(11, 68, 'TRANS-202502230011', '2025-02-23 08:05:03', 'baru', '0', 2),
(12, 19, 'TRANS-202502230012', '2025-02-23 08:05:03', 'proses', '0', 2),
(13, 90, 'TRANS-202502230013', '2025-02-23 15:30:50', 'baru', '0', 2),
(14, 92, 'TRANS-202502230014', '2025-02-23 08:05:03', 'diambil', '0', 2),
(15, 89, 'TRANS-202502230015', '2025-02-23 15:30:50', 'baru', '0', 2),
(16, 70, 'TRANS-202502230016', '2025-02-23 15:30:50', 'baru', '0', 2),
(17, 81, 'TRANS-202502230017', '2025-02-23 08:05:03', 'baru', '0', 2),
(18, 97, 'TRANS-202502230018', '2025-02-23 08:05:03', 'proses', '0', 2),
(19, 41, 'TRANS-202502230019', '2025-02-23 15:30:50', 'baru', '0', 2),
(20, 13, 'TRANS-202502230020', '2025-02-23 08:05:03', 'diambil', '0', 2),
(21, 42, 'TRANS-202502230021', '2025-02-23 15:30:50', 'baru', '0', 2),
(22, 71, 'TRANS-202502230022', '2025-02-23 08:05:03', 'baru', '0', 2),
(23, 27, 'TRANS-202502230023', '2025-02-23 08:05:03', 'proses', '0', 2),
(24, 21, 'TRANS-202502230024', '2025-02-23 15:30:50', 'baru', '0', 2),
(25, 26, 'TRANS-202502230025', '2025-02-23 08:05:03', 'diambil', '0', 2),
(26, 97, 'TRANS-202501010026', '2025-02-23 15:30:50', 'baru', '0', 2),
(27, 74, 'TRANS-202501010027', '2025-01-06 08:05:03', 'baru', '0', 2),
(28, 77, 'TRANS-202501010028', '2025-01-12 08:05:03', 'proses', '0', 2),
(29, 63, 'TRANS-202501010029', '2025-02-23 15:32:11', 'baru', '0', 2),
(30, 82, 'TRANS-202501010030', '2025-01-12 08:05:03', 'diambil', '0', 2),
(31, 23, 'TRANS-202501010031', '2025-02-23 15:34:15', 'baru', '0', 2),
(32, 66, 'TRANS-202501010032', '2025-01-05 08:05:03', 'baru', '0', 2),
(33, 63, 'TRANS-202501010033', '2025-01-16 08:05:03', 'proses', '0', 2),
(34, 15, 'TRANS-202501010034', '2025-02-23 15:34:15', 'baru', '0', 2),
(35, 86, 'TRANS-202501010035', '2025-01-28 08:05:03', 'diambil', '0', 2),
(36, 86, 'TRANS-202501010036', '2025-02-23 15:34:15', 'baru', '0', 2),
(37, 69, 'TRANS-202501010037', '2025-01-30 08:05:03', 'baru', '0', 2),
(38, 88, 'TRANS-202501010038', '2025-01-26 08:05:03', 'proses', '0', 2),
(39, 30, 'TRANS-202501010039', '2025-02-23 15:34:15', 'baru', '0', 2),
(40, 89, 'TRANS-202501010040', '2025-01-01 08:05:03', 'diambil', '0', 2),
(41, 53, 'TRANS-202501010041', '2025-02-23 15:34:15', 'baru', '0', 2),
(42, 96, 'TRANS-202501010042', '2025-01-23 08:05:03', 'baru', '0', 2),
(43, 21, 'TRANS-202501010043', '2025-01-11 08:05:03', 'proses', '0', 2),
(44, 16, 'TRANS-202501010044', '2025-02-23 15:34:15', 'baru', '0', 2),
(45, 16, 'TRANS-202501010045', '2025-02-23 08:05:03', 'diambil', '0', 2),
(46, 31, 'TRANS-202501010046', '2025-02-23 15:35:15', 'proses', '0', 2),
(47, 7, 'TRANS-202501010047', '2025-01-28 08:05:03', 'baru', '0', 2),
(48, 41, 'TRANS-202501010048', '2025-01-12 08:05:03', 'proses', '0', 2),
(49, 85, 'TRANS-202501010049', '2025-02-23 15:34:15', 'baru', '0', 2),
(50, 99, 'TRANS-202501010050', '2025-01-13 08:05:03', 'diambil', '0', 2),
(51, 66, 'TRANS-202412010051', '2025-02-25 06:26:09', 'diambil', '1', 2),
(52, 60, 'TRANS-202412010052', '2024-12-15 08:05:03', 'baru', '0', 2),
(53, 5, 'TRANS-202412010053', '2024-12-03 08:05:03', 'proses', '0', 2),
(54, 42, 'TRANS-202412010054', '2025-02-23 15:34:15', 'baru', '0', 2),
(55, 94, 'TRANS-202412010055', '2024-12-09 08:05:03', 'diambil', '0', 2),
(56, 46, 'TRANS-202412010056', '2025-02-23 15:35:15', 'proses', '0', 2),
(57, 44, 'TRANS-202412010057', '2024-12-12 08:05:03', 'baru', '0', 2),
(58, 85, 'TRANS-202412010058', '2024-12-31 08:05:03', 'proses', '0', 2),
(59, 92, 'TRANS-202412010059', '2025-02-23 15:35:15', 'proses', '0', 2),
(60, 5, 'TRANS-202412010060', '2024-12-25 08:05:03', 'diambil', '0', 2),
(61, 47, 'TRANS-202412010061', '2025-02-23 15:34:15', 'baru', '0', 2),
(62, 22, 'TRANS-202412010062', '2024-12-03 08:05:03', 'baru', '0', 2),
(63, 67, 'TRANS-202412010063', '2024-12-11 08:05:03', 'proses', '0', 2),
(64, 68, 'TRANS-202412010064', '2025-02-23 15:34:15', 'baru', '0', 2),
(65, 38, 'TRANS-202412010065', '2024-12-01 08:05:03', 'diambil', '0', 2),
(66, 86, 'TRANS-202412010066', '2025-02-23 15:35:15', 'proses', '0', 2),
(67, 15, 'TRANS-202412010067', '2024-12-13 08:05:03', 'baru', '0', 2),
(68, 18, 'TRANS-202412010068', '2024-12-11 08:05:03', 'proses', '0', 2),
(69, 44, 'TRANS-202412010069', '2025-02-23 15:34:15', 'baru', '0', 2),
(70, 63, 'TRANS-202412010070', '2024-12-18 08:05:03', 'diambil', '0', 2),
(71, 85, 'TRANS-202412010071', '2025-02-23 15:34:15', 'baru', '0', 2),
(72, 36, 'TRANS-202412010072', '2024-12-22 08:05:03', 'baru', '0', 2),
(73, 24, 'TRANS-202412010073', '2024-12-18 08:05:03', 'proses', '0', 2),
(74, 13, 'TRANS-202412010074', '2025-02-23 15:35:15', 'proses', '0', 2),
(75, 90, 'TRANS-202412010075', '2024-12-08 08:05:03', 'diambil', '0', 2),
(76, 28, 'TRANS-202411010076', '2025-02-23 15:35:15', 'proses', '0', 2),
(77, 22, 'TRANS-202411010077', '2024-11-12 08:05:03', 'baru', '0', 2),
(78, 26, 'TRANS-202411010078', '2024-11-19 08:05:03', 'proses', '0', 2),
(79, 63, 'TRANS-202411010079', '2025-02-23 15:35:42', 'proses', '0', 2),
(80, 36, 'TRANS-202411010080', '2024-11-26 08:05:03', 'diambil', '0', 2),
(81, 92, 'TRANS-202411010081', '2025-02-23 15:35:15', 'proses', '0', 2),
(82, 51, 'TRANS-202411010082', '2024-11-11 08:05:03', 'baru', '0', 2),
(83, 78, 'TRANS-202411010083', '2024-11-20 08:05:03', 'proses', '0', 2),
(84, 36, 'TRANS-202411010084', '2025-02-23 15:35:15', 'proses', '0', 2),
(85, 44, 'TRANS-202411010085', '2024-11-16 08:05:03', 'diambil', '0', 2),
(86, 14, 'TRANS-202411010086', '2025-02-23 15:35:15', 'proses', '0', 2),
(87, 39, 'TRANS-202411010087', '2024-11-02 08:05:03', 'baru', '0', 2),
(88, 49, 'TRANS-202411010088', '2024-11-11 08:05:03', 'proses', '0', 2),
(89, 30, 'TRANS-202411010089', '2025-02-23 15:35:15', 'proses', '0', 2),
(90, 2, 'TRANS-202411010090', '2024-11-26 08:05:03', 'diambil', '0', 2),
(91, 39, 'TRANS-202410010091', '2025-02-23 15:35:15', 'proses', '0', 2),
(92, 68, 'TRANS-202410010092', '2024-11-22 08:05:03', 'baru', '0', 2),
(93, 23, 'TRANS-202410010093', '2024-11-06 08:05:03', 'proses', '0', 2),
(94, 11, 'TRANS-202410010094', '2025-02-23 15:35:15', 'proses', '0', 2),
(95, 85, 'TRANS-202410010095', '2024-11-09 08:05:03', 'diambil', '0', 2),
(96, 94, 'TRANS-202410010096', '2025-02-23 15:35:15', 'proses', '0', 2),
(97, 12, 'TRANS-202410010097', '2024-11-18 08:05:03', 'baru', '0', 2),
(98, 78, 'TRANS-202410010098', '2024-11-18 08:05:03', 'proses', '0', 2),
(99, 54, 'TRANS-202410010099', '2025-02-23 15:35:15', 'proses', '0', 2),
(100, 36, 'TRANS-20241001100', '2024-11-09 08:05:03', 'diambil', '0', 2),
(101, 17, 'TRANS-20241001101', '2025-02-23 15:36:33', 'baru', '0', 2),
(102, 75, 'TRANS-20241001102', '2025-02-23 08:05:03', 'baru', '0', 2),
(103, 25, 'TRANS-20241001103', '2025-02-25 15:40:38', 'proses', '1', 2),
(104, 97, 'TRANS-20241001104', '2025-02-23 15:37:09', 'baru', '0', 2),
(105, 11, 'TRANS-20241001105', '2025-02-23 15:37:09', 'baru', '0', 2),
(106, 64, 'TRANS-20241001106', '2025-02-23 15:37:09', 'baru', '0', 2),
(107, 87, 'TRANS-20241001107', '2025-02-23 08:05:03', 'baru', '0', 2),
(108, 41, 'TRANS-20241001108', '2025-02-23 15:37:09', 'baru', '0', 2),
(109, 45, 'TRANS-20241001109', '2025-02-23 15:37:09', 'baru', '0', 2),
(110, 1, 'TRANS-20241001110', '2025-02-23 15:37:09', 'baru', '0', 2),
(111, 70, 'TRANS-20241001111', '2025-02-23 15:37:09', 'baru', '0', 2),
(112, 48, 'TRANS-20241001112', '2025-02-23 08:05:03', 'baru', '0', 2),
(113, 27, 'TRANS-20241001113', '2025-02-23 15:37:09', 'baru', '0', 2),
(114, 90, 'TRANS-20241001114', '2025-02-23 15:37:09', 'baru', '0', 2),
(115, 67, 'TRANS-20241001115', '2025-02-23 15:37:09', 'baru', '0', 2),
(116, 67, 'TRANS-20241001116', '2025-02-23 15:37:09', 'baru', '0', 2),
(117, 35, 'TRANS-20241001117', '2025-02-23 08:05:03', 'baru', '0', 2),
(118, 72, 'TRANS-20241001118', '2025-02-25 06:31:38', 'proses', '0', 2),
(119, 5, 'TRANS-202502234113', '2025-02-23 15:08:04', 'baru', '1', 2),
(120, 4, 'TRANS-202502241234', '2025-02-24 13:53:43', 'selesai', '1', 2),
(122, 101, 'TRANS-202502245051', '2025-02-25 06:22:23', '', '0', 2),
(123, 101, 'TRANS-202502244635', '2025-02-25 15:40:55', 'proses', '1', 2),
(125, 101, 'TRANS-202502253234', '2025-02-25 06:42:24', 'diambil', '1', 2),
(126, 101, 'TRANS-202502254736', '2025-02-25 07:01:35', 'selesai', '1', 2),
(127, 2, 'TRANS-202502254928', '2025-03-01 02:54:42', 'selesai', '1', 2),
(128, 101, 'TRANS-202502253501', '2025-02-27 01:07:35', 'diambil', '1', 2),
(132, 4, 'TRANS-202502264910', '2025-02-25 23:12:20', 'proses', '1', 2),
(133, 9, 'TRANS-202502260230', '2025-02-25 23:31:42', 'proses', '1', 2),
(134, 52, 'TRANS-202502261132', '2025-02-25 23:40:55', 'proses', '1', 2),
(135, 101, 'TRANS-202502261354', '2025-02-26 04:04:44', 'diambil', '1', 2),
(136, 3, 'TRANS-202502272208', '2025-02-27 01:08:45', 'diambil', '1', 2),
(137, 4, 'TRANS-202502284248', '2025-03-01 02:49:18', 'selesai', '1', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `no_telp` varchar(13) NOT NULL,
  `password` text NOT NULL,
  `level` enum('admin','petugas','off') NOT NULL DEFAULT 'petugas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `username`, `no_telp`, `password`, `level`) VALUES
(1, 'admin', 'admin', '085718670690', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(2, 'Edo', 'Edo', '089612264122', 'd2d612f72e42577991f4a5936cecbcc0', 'petugas'),
(3, 'Budi Santoso', 'budi_santoso', '081234567892', '5f4dcc3b5aa765d61d8327deb882cf99', 'petugas'),
(4, 'Dewi Lestari', 'dewi_lestari', '081234567893', '5f4dcc3b5aa765d61d8327deb882cf99', 'petugas'),
(5, 'Joko Widodo', 'joko_widodo', '081234567894', '5f4dcc3b5aa765d61d8327deb882cf99', 'petugas'),
(6, 'Rina Sari', 'rina_sari', '081234567895', '5f4dcc3b5aa765d61d8327deb882cf99', 'petugas'),
(7, 'Tono Prabowo', 'tono_prabowo', '081234567896', '5f4dcc3b5aa765d61d8327deb882cf99', 'petugas'),
(8, 'Nina Rahmawati', 'nina_rahmawati', '081234567897', '5f4dcc3b5aa765d61d8327deb882cf99', 'petugas'),
(9, 'Eko Susanto', 'eko_susanto', '081234567898', '5f4dcc3b5aa765d61d8327deb882cf99', 'petugas'),
(10, 'Lina Fitriani', 'lina_fitriani', '081234567899', '5f4dcc3b5aa765d61d8327deb882cf99', 'petugas'),
(11, 'Rudi Hartono', 'rudi_hartono', '081234567900', '5f4dcc3b5aa765d61d8327deb882cf99', 'petugas'),
(12, 'Sari Wulandari', 'sari_wulandari', '081234567901', '5f4dcc3b5aa765d61d8327deb882cf99', 'petugas'),
(13, 'Fajar Nugroho', 'fajar_nugroho', '081234567902', '5f4dcc3b5aa765d61d8327deb882cf99', 'petugas'),
(14, 'Maya Kurniawati', 'maya_kurniawati', '081234567903', '5f4dcc3b5aa765d61d8327deb882cf99', 'petugas'),
(15, 'Agus Salim', 'agus_salim', '081234567904', '5f4dcc3b5aa765d61d8327deb882cf99', 'petugas'),
(16, 'Tina Yulianti', 'tina_yulianti', '081234567905', '5f4dcc3b5aa765d61d8327deb882cf99', 'petugas'),
(17, 'Hendra Wijaya', 'hendra_wijaya', '081234567906', '5f4dcc3b5aa765d61d8327deb882cf99', 'petugas'),
(18, 'Diana Putri', 'diana_putri', '081234567907', '5f4dcc3b5aa765d61d8327deb882cf99', 'petugas'),
(19, 'Rizky Ramadhan', 'rizky_ramadhan', '081234567908', '5f4dcc3b5aa765d61d8327deb882cf99', 'petugas'),
(20, 'Citra Dewi', 'citra_dewi', '081234567909', '5f4dcc3b5aa765d61d8327deb882cf99', 'petugas'),
(21, 'Fahmi Hidayat', 'fahmi_hidayat', '081234567910', '5f4dcc3b5aa765d61d8327deb882cf99', 'petugas'),
(22, 'Siti Khadijah', 'siti_khadijah', '081234567911', '5f4dcc3b5aa765d61d8327deb882cf99', 'off'),
(23, 'Yusuf Alamsyah', 'yusuf_alamsyah', '081234567912', '5f4dcc3b5aa765d61d8327deb882cf99', 'petugas'),
(24, 'Lutfi Anwar', 'lutfi_anwar', '081234567913', '5f4dcc3b5aa765d61d8327deb882cf99', 'off'),
(30, 'petugas', 'petugas', '085718670690', 'afb91ef692fd08c445e8cb1bab2ccf9c', 'petugas');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indeks untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail_transaksi`),
  ADD KEY `id_transaksi` (`id_transaksi`),
  ADD KEY `id_jenis_cucian` (`id_jenis_cucian`);

--
-- Indeks untuk tabel `jenis_cucian`
--
ALTER TABLE `jenis_cucian`
  ADD PRIMARY KEY (`id_jenis_cucian`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_member` (`id_customer`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=213;

--
-- AUTO_INCREMENT untuk tabel `jenis_cucian`
--
ALTER TABLE `jenis_cucian`
  MODIFY `id_jenis_cucian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`id_jenis_cucian`) REFERENCES `jenis_cucian` (`id_jenis_cucian`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
