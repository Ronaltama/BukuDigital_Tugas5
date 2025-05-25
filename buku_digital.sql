-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2025 at 06:56 AM
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
-- Database: `buku_digital`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` char(6) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `file_buku` varchar(250) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `status_verifikasi` enum('terverifikasi','pending','ditolak') NOT NULL,
  `tanggal_upload` date NOT NULL,
  `id_penulis` char(7) NOT NULL,
  `id_operator` char(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `deskripsi`, `file_buku`, `kategori`, `status_verifikasi`, `tanggal_upload`, `id_penulis`, `id_operator`) VALUES
('BKU001', 'Amba', 'Novel yang mengangkat kisah Amba penuh drama dan makna.', 'amba.pdf', 'Fiksi', 'terverifikasi', '2024-01-10', 'PEN0003', 'OP01'),
('BKU002', 'Sisi Tergelap Surga', 'Cerita penuh konflik dan harapan.', 'sisi_tergelap_surga.pdf', 'Fiksi', 'terverifikasi', '2024-01-12', 'PEN0008', 'OP02'),
('BKU003', 'Bulan', 'Novel romantis dan penuh misteri.', 'bulan.pdf', 'Fiksi', 'terverifikasi', '2024-01-15', 'PEN0002', 'OP03'),
('BKU004', 'Cantik Itu Luka', 'Kisah kelam dan indah dalam satu novel.', 'cantik_itu_luka.pdf', 'Fiksi', 'terverifikasi', '2024-01-20', 'PEN0004', 'OP04'),
('BKU005', 'Dompet Ayah Sepatu Ibu', 'Cerita keluarga penuh cinta dan perjuangan.', 'dompet_ayah_sepatu_ibu.pdf', 'Fiksi', 'terverifikasi', '2024-01-25', 'PEN0005', 'OP05'),
('BKU006', 'Hujan', 'Novel tentang kehidupan dan ujian.', 'hujan.pdf', 'Fiksi', 'terverifikasi', '2024-01-30', 'PEN0002', 'OP01'),
('BKU007', 'Laskar Pelangi', 'Inspirasi dari perjuangan anak-anak di Belitung.', 'laskar_pelangi.pdf', 'Fiksi', 'terverifikasi', '2024-02-04', 'PEN0001', 'OP02'),
('BKU008', 'Luka Cita', 'Novel dengan tema cinta dan kehilangan.', 'luka_cita.pdf', 'Fiksi', 'terverifikasi', '2024-02-10', 'PEN0007', 'OP03'),
('BKU009', 'Retrocession', 'Cerita perjuangan dan perubahan.', 'retrocession.pdf', 'Fiksi', 'terverifikasi', '2024-02-15', 'PEN0006', 'OP04'),
('BKU010', 'Filosofi Teras', 'Buku motivasi dan filosofi hidup sederhana.', 'filosofi_teras.pdf', 'Pengembangan Diri', 'terverifikasi', '2024-02-20', 'PEN0009', 'OP05'),
('BKU011', 'Insecurity is my Middle Name', 'Buku self-help tentang percaya diri.', 'insecurity.pdf', 'Pengembangan Diri', 'terverifikasi', '2024-02-25', 'PEN0010', 'OP01'),
('BKU012', 'You do You', 'Motivasi untuk menjadi diri sendiri.', 'you_do_you.pdf', 'Pengembangan Diri', 'terverifikasi', '2024-03-01', 'PEN0011', 'OP02'),
('BKU013', 'Jejak Langkah', 'Novel perjalanan hidup dan pencarian jati diri.', 'jejak_langkah.pdf', 'Fiksi', 'pending', '2024-03-05', 'PEN0003', 'OP03'),
('BKU014', 'Senja di Kota', 'Cerita tentang kehidupan urban dan perjuangan.', 'senja_di_kota.pdf', 'Fiksi', 'terverifikasi', '2024-03-10', 'PEN0008', 'OP04'),
('BKU015', 'Lautan Hati', 'Drama keluarga dan cinta.', 'lautan_hati.pdf', 'Fiksi', 'ditolak', '2024-03-15', 'PEN0004', 'OP05'),
('BKU016', 'Langit Biru', 'Novel romantis dan inspiratif.', 'langit_biru.pdf', 'Fiksi', 'terverifikasi', '2024-03-20', 'PEN0005', 'OP01'),
('BKU017', 'Cahaya di Ujung Jalan', 'Cerita penuh harapan dan impian.', 'cahaya_ujung_jalan.pdf', 'Fiksi', 'pending', '2024-03-25', 'PEN0001', 'OP02'),
('BKU018', 'Rindu yang Tak Terucap', 'Novel tentang kerinduan dan kehilangan.', 'rindu_tak_terucap.pdf', 'Fiksi', 'terverifikasi', '2024-03-30', 'PEN0007', 'OP03'),
('BKU019', 'Melodi Hati', 'Cerita musik dan cinta.', 'melodi_hati.pdf', 'Fiksi', 'terverifikasi', '2024-04-04', 'PEN0006', 'OP04'),
('BKU020', 'Pelangi Setelah Hujan', 'Harapan baru setelah kesulitan.', 'pelangi_setelah_hujan.pdf', 'Fiksi', 'terverifikasi', '2024-04-10', 'PEN0009', 'OP05');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_pemesanan` char(8) NOT NULL,
  `id_sewa` char(8) NOT NULL,
  `id_buku` char(8) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `status_pemesanan` enum('menunggu','diproses','selesai','dibatalkan') NOT NULL,
  `tanggal_pesanan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_pemesanan`, `id_sewa`, `id_buku`, `total_harga`, `status_pemesanan`, `tanggal_pesanan`) VALUES
('DP000001', '00000001', 'BKU001', 15000.00, 'diproses', '2024-04-01'),
('DP000002', '00000002', 'BKU002', 35000.00, 'diproses', '2024-04-02'),
('DP000003', '00000003', 'BKU003', 70000.00, 'selesai', '2024-04-03'),
('DP000004', '00000004', 'BKU004', 150000.00, 'diproses', '2024-04-04'),
('DP000005', '00000005', 'BKU005', 15000.00, 'diproses', '2024-04-05'),
('DP000006', '00000006', 'BKU006', 35000.00, 'selesai', '2024-04-06'),
('DP000007', '00000007', 'BKU007', 70000.00, 'diproses', '2024-04-07'),
('DP000008', '00000008', 'BKU008', 150000.00, 'selesai', '2024-04-08'),
('DP000009', '00000009', 'BKU009', 15000.00, 'diproses', '2024-04-09'),
('DP000010', '00000010', 'BKU010', 35000.00, 'diproses', '2024-04-10'),
('DP000011', '00000011', 'BKU011', 70000.00, 'diproses', '2024-04-11'),
('DP000012', '00000012', 'BKU012', 150000.00, 'selesai', '2024-04-12'),
('DP000013', '00000013', 'BKU013', 15000.00, 'diproses', '2024-04-13'),
('DP000014', '00000014', 'BKU014', 35000.00, 'diproses', '2024-04-14'),
('DP000015', '00000015', 'BKU015', 70000.00, 'selesai', '2024-04-15'),
('DP000016', '00000016', 'BKU016', 150000.00, 'diproses', '2024-04-16'),
('DP000017', '00000017', 'BKU017', 15000.00, 'diproses', '2024-04-17'),
('DP000018', '00000018', 'BKU018', 35000.00, 'selesai', '2024-04-18'),
('DP000019', '00000019', 'BKU019', 70000.00, 'diproses', '2024-04-19'),
('DP000020', '00000020', 'BKU020', 150000.00, 'diproses', '2024-04-20');

-- --------------------------------------------------------

--
-- Table structure for table `operator`
--

CREATE TABLE `operator` (
  `id_operator` char(4) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL,
  `tanggal_daftar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `operator`
--

INSERT INTO `operator` (`id_operator`, `username`, `email`, `password`, `status`, `tanggal_daftar`) VALUES
('OP01', 'nadhira', 'nadhira@gmail.com', 'Nadhira#01', 'aktif', '2024-01-10'),
('OP02', 'ariefk', 'ariefk@gmail.com', 'AriefK*22', 'aktif', '2024-01-12'),
('OP03', 'dian_ri', 'dian.ri@gmail.com', 'DianR!33', 'nonaktif', '2024-01-14'),
('OP04', 'febrian', 'febrian@gmail.com', 'Febri#44', 'aktif', '2024-01-16'),
('OP05', 'mellya', 'mellya@gmail.com', 'Mellya@55', 'nonaktif', '2024-01-18');

-- --------------------------------------------------------

--
-- Table structure for table `pembaca`
--

CREATE TABLE `pembaca` (
  `id_pembaca` char(7) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL,
  `tanggal_daftar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembaca`
--

INSERT INTO `pembaca` (`id_pembaca`, `username`, `email`, `password`, `status`, `tanggal_daftar`) VALUES
('PBC0001', 'rexy12', 'rexy12@gmail.com', 'Rexy!2024', 'aktif', '2024-01-01'),
('PBC0002', 'zayn88', 'zayn88@gmail.com', 'ZayN#33', 'nonaktif', '2024-01-03'),
('PBC0003', 'alya_kk', 'alya_kk@gmail.com', 'AlYa@pass', 'aktif', '2024-01-05'),
('PBC0004', 'thaliax', 'thaliax@gmail.com', 'Th@1234', 'aktif', '2024-01-08'),
('PBC0005', 'donny12', 'donny12@gmail.com', 'd0nny_pass!', 'nonaktif', '2024-01-10'),
('PBC0006', 'yuna88', 'yuna88@gmail.com', 'Yuna777!', 'aktif', '2024-01-12'),
('PBC0007', 'kean_k', 'kean_k@gmail.com', 'Kean2024', 'aktif', '2024-01-14'),
('PBC0008', 'nabila', 'nabila@gmail.com', 'Nabila!88', 'aktif', '2024-01-16'),
('PBC0009', 'salma_', 'salma_@gmail.com', 'Salma2024!', 'nonaktif', '2024-01-18'),
('PBC0010', 'andhika', 'andhika@gmail.com', 'andhi#98', 'aktif', '2024-01-20'),
('PBC0011', 'gita12', 'gita12@gmail.com', 'Gita!@23', 'aktif', '2024-01-22'),
('PBC0012', 'raihanx', 'raihanx@gmail.com', 'Raih@n88', 'aktif', '2024-01-24'),
('PBC0013', 'vina99', 'vina99@gmail.com', 'ViNa1234', 'nonaktif', '2024-01-26'),
('PBC0014', 'hannaq', 'hannaq@gmail.com', 'HannaPass', 'aktif', '2024-01-28'),
('PBC0015', 'ali_a', 'ali_a@gmail.com', 'Ali!!777', 'aktif', '2024-01-30'),
('PBC0016', 'febbyx', 'febbyx@gmail.com', 'febby_12', 'nonaktif', '2024-02-01'),
('PBC0017', 'zakiya', 'zakiya@gmail.com', 'Zak1ya!', 'aktif', '2024-02-03'),
('PBC0018', 'farhan', 'farhan@gmail.com', 'Farhan.88', 'aktif', '2024-02-05'),
('PBC0019', 'syifa_', 'syifa_@gmail.com', 'syifa@33', 'nonaktif', '2024-02-07'),
('PBC0020', 'mariox', 'mariox@gmail.com', 'Mari0#pass', 'aktif', '2024-02-09'),
('PBC0021', 'tama', 'apaja@gmail.com', '$2y$10$af0qoIzVBVt4A0GggmwmGOvGJprH6wWwTa/AjzF8kO0dMedwdWKnq', 'aktif', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` varchar(8) NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `status_pembayaran` varchar(20) NOT NULL,
  `id_sewa` char(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `jumlah`, `tgl_pembayaran`, `status_pembayaran`, `id_sewa`) VALUES
('1', 50000.00, '2025-01-05', 'berhasil', '00000001'),
('10', 55000.00, '2025-01-21', 'berhasil', '00000010'),
('11', 62000.00, '2025-01-23', 'gagal', '00000011'),
('12', 47000.00, '2025-01-25', 'berhasil', '00000012'),
('13', 100000.00, '2025-01-26', 'berhasil', '00000013'),
('14', 39000.00, '2025-01-28', 'berhasil', '00000014'),
('15', 89000.00, '2025-01-30', 'pending', '00000015'),
('16', 73000.00, '2025-02-01', 'berhasil', '00000016'),
('17', 81000.00, '2025-02-03', 'berhasil', '00000017'),
('18', 45000.00, '2025-02-05', 'berhasil', '00000018'),
('19', 92000.00, '2025-02-07', 'gagal', '00000019'),
('2', 75000.00, '2025-01-07', 'berhasil', '00000002'),
('20', 67000.00, '2025-02-10', 'berhasil', '00000020'),
('3', 100000.00, '2025-01-09', 'pending', '00000003'),
('4', 30000.00, '2025-01-10', 'berhasil', '00000004'),
('5', 65000.00, '2025-01-11', 'gagal', '00000005'),
('6', 80000.00, '2025-01-13', 'berhasil', '00000006'),
('7', 95000.00, '2025-01-15', 'berhasil', '00000007'),
('8', 50000.00, '2025-01-17', 'pending', '00000008'),
('9', 70000.00, '2025-01-20', 'berhasil', '00000009');

-- --------------------------------------------------------

--
-- Table structure for table `penulis`
--

CREATE TABLE `penulis` (
  `id_penulis` char(7) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL,
  `tanggal_daftar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penulis`
--

INSERT INTO `penulis` (`id_penulis`, `username`, `email`, `password`, `status`, `tanggal_daftar`) VALUES
('', 'ronal', 'tama.ronal@student.uns.ac.id', '$2y$10$j21DcCtO/BMOwafXm54UBurVcTE31QegVVNWrx7IT7XowhyHvbQx6', 'aktif', '0000-00-00'),
('PEN0001', 'andrea_h', 'andrea.h@gmail.com', 'Andrea#123', 'aktif', '2024-01-01'),
('PEN0002', 'tere_liye', 'tere.liye@gmail.com', 'TereLiye@24', 'aktif', '2024-01-05'),
('PEN0003', 'laksmi_p', 'laksmi.p@gmail.com', 'LaksmiP@321', 'nonaktif', '2024-01-10'),
('PEN0004', 'eka_kurniawan', 'eka.k@gmail.com', 'Eka!2024', 'aktif', '2024-01-15'),
('PEN0005', 'js_khairen', 'js.khairen@gmail.com', 'JsK1234!', 'aktif', '2024-01-20'),
('PEN0006', 'ayunita_k', 'ayunita.k@gmail.com', 'Ayunita77', 'nonaktif', '2024-01-25'),
('PEN0007', 'valerie_p', 'valerie.p@gmail.com', 'ValerieP$24', 'aktif', '2024-02-01'),
('PEN0008', 'brian_k', 'brian.k@gmail.com', 'Brian!567', 'aktif', '2024-02-06'),
('PEN0009', 'henry_m', 'henry.m@gmail.com', 'Henry88!', 'nonaktif', '2024-02-11'),
('PEN0010', 'alvi_s', 'alvi.s@gmail.com', 'AlviS#2024', 'aktif', '2024-02-16'),
('PEN0011', 'fellex_r', 'fellex.r@gmail.com', 'Fellex@rub', 'aktif', '2024-02-21'),
('PEN0012', 'intan_w', 'intan.w@gmail.com', 'IntanW#45', 'aktif', '2024-02-26'),
('PEN0013', 'gilang_r', 'gilang.r@gmail.com', 'GilangR!22', 'nonaktif', '2024-03-02'),
('PEN0014', 'risa_s', 'risa.s@gmail.com', 'RisaS*89', 'aktif', '2024-03-07'),
('PEN0015', 'niko_a', 'niko.a@gmail.com', 'NikoA_99', 'aktif', '2024-03-12'),
('PEN0016', 'dina_l', 'dina.l@gmail.com', 'DinaL@02', 'nonaktif', '2024-03-17'),
('PEN0017', 'wulan_m', 'wulan.m@gmail.com', 'WulanM#55', 'aktif', '2024-03-22'),
('PEN0018', 'reza_y', 'reza.y@gmail.com', 'RezaY123!', 'aktif', '2024-03-27');

-- --------------------------------------------------------

--
-- Table structure for table `sewa`
--

CREATE TABLE `sewa` (
  `id_sewa` char(8) NOT NULL,
  `tgl_sewa` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `durasi_sewa` int(11) NOT NULL,
  `status_sewa` varchar(20) NOT NULL,
  `id_pembaca` char(7) NOT NULL,
  `id_buku` char(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sewa`
--

INSERT INTO `sewa` (`id_sewa`, `tgl_sewa`, `tgl_kembali`, `durasi_sewa`, `status_sewa`, `id_pembaca`, `id_buku`) VALUES
('00000001', '2024-04-01', '2024-04-04', 3, 'dipinjam', 'PBC0001', 'BKU001'),
('00000002', '2024-04-02', '2024-04-09', 7, 'dipinjam', 'PBC0002', 'BKU002'),
('00000003', '2024-04-03', '2024-04-17', 14, 'kembali', 'PBC0003', 'BKU003'),
('00000004', '2024-04-04', '2024-05-04', 30, 'dipinjam', 'PBC0004', 'BKU004'),
('00000005', '2024-04-05', '2024-04-08', 3, 'dipinjam', 'PBC0005', 'BKU005'),
('00000006', '2024-04-06', '2024-04-13', 7, 'kembali', 'PBC0006', 'BKU006'),
('00000007', '2024-04-07', '2024-04-21', 14, 'dipinjam', 'PBC0007', 'BKU007'),
('00000008', '2024-04-08', '2024-05-08', 30, 'kembali', 'PBC0008', 'BKU008'),
('00000009', '2024-04-09', '2024-04-12', 3, 'dipinjam', 'PBC0009', 'BKU009'),
('00000010', '2024-04-10', '2024-04-17', 7, 'dipinjam', 'PBC0010', 'BKU010'),
('00000011', '2024-04-11', '2024-04-25', 14, 'dipinjam', 'PBC0011', 'BKU011'),
('00000012', '2024-04-12', '2024-05-12', 30, 'kembali', 'PBC0012', 'BKU012'),
('00000013', '2024-04-13', '2024-04-16', 3, 'dipinjam', 'PBC0013', 'BKU013'),
('00000014', '2024-04-14', '2024-04-21', 7, 'dipinjam', 'PBC0014', 'BKU014'),
('00000015', '2024-04-15', '2024-04-29', 14, 'kembali', 'PBC0015', 'BKU015'),
('00000016', '2024-04-16', '2024-05-16', 30, 'dipinjam', 'PBC0016', 'BKU016'),
('00000017', '2024-04-17', '2024-04-20', 3, 'dipinjam', 'PBC0017', 'BKU017'),
('00000018', '2024-04-18', '2024-04-25', 7, 'kembali', 'PBC0018', 'BKU018'),
('00000019', '2024-04-19', '2024-05-03', 14, 'dipinjam', 'PBC0019', 'BKU019'),
('00000020', '2024-04-20', '2024-05-20', 30, 'dipinjam', 'PBC0020', 'BKU020');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `id_penulis` (`id_penulis`),
  ADD KEY `id_operator` (`id_operator`);

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD UNIQUE KEY `id_pemesanan` (`id_pemesanan`),
  ADD KEY `id_sewa` (`id_sewa`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indexes for table `operator`
--
ALTER TABLE `operator`
  ADD PRIMARY KEY (`id_operator`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pembaca`
--
ALTER TABLE `pembaca`
  ADD PRIMARY KEY (`id_pembaca`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD UNIQUE KEY `id_sewa` (`id_sewa`);

--
-- Indexes for table `penulis`
--
ALTER TABLE `penulis`
  ADD PRIMARY KEY (`id_penulis`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `sewa`
--
ALTER TABLE `sewa`
  ADD PRIMARY KEY (`id_sewa`),
  ADD KEY `id_pembaca` (`id_pembaca`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_penulis`) REFERENCES `penulis` (`id_penulis`),
  ADD CONSTRAINT `buku_ibfk_2` FOREIGN KEY (`id_operator`) REFERENCES `operator` (`id_operator`);

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_sewa`) REFERENCES `sewa` (`id_sewa`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_sewa`) REFERENCES `sewa` (`id_sewa`);

--
-- Constraints for table `sewa`
--
ALTER TABLE `sewa`
  ADD CONSTRAINT `sewa_ibfk_1` FOREIGN KEY (`id_pembaca`) REFERENCES `pembaca` (`id_pembaca`),
  ADD CONSTRAINT `sewa_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
