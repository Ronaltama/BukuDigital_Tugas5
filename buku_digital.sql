-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2025 at 04:25 PM
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
  `cover_url` varchar(255) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT 0.0,
  `harga_sewa` decimal(10,2) DEFAULT 0.00,
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

INSERT INTO `buku` (`id_buku`, `judul`, `deskripsi`, `cover_url`, `rating`, `harga_sewa`, `file_buku`, `kategori`, `status_verifikasi`, `tanggal_upload`, `id_penulis`, `id_operator`) VALUES
('BKU001', 'Amba', 'Novel yang mengangkat kisah Amba, sebuah epik yang menggali kedalaman mitologi Mahābhārata, namun disajikan dengan sentuhan modern dan humanis yang kuat. Kisah ini penuh drama, makna, dan refleksi tentang takdir dan pilihan hidup yang sulit.', 'http://localhost/Web%20Buku%20Digital%20Online/BukuDigital_Tugas5/covers/Amba_Laksmi%20Pamunjak.jpg', 4.5, 15000.00, 'amba.pdf', 'Fiksi', 'terverifikasi', '2024-01-10', 'PEN0003', 'OP01'),
('BKU002', 'Sisi Tergelap Surga', 'Sebuah cerita yang memukau dan mendalam, menjelajahi konflik batin dan pencarian harapan di tengah kegelapan. Novel ini menghadirkan karakter-karakter yang kompleks dan alur yang tak terduga, memaksa pembaca untuk merenungkan arti penderitaan dan penebusan.', 'http://localhost/Web%20Buku%20Digital%20Online/BukuDigital_Tugas5/covers/Sisi%20Tergelap%20Surga_Brian%20Krisna.jpg', 4.2, 12500.00, 'sisi_tergelap_surga.pdf', 'Fiksi', 'terverifikasi', '2024-01-12', 'PEN0008', 'OP02'),
('BKU003', 'Bulan', 'Novel romantis yang memikat hati, sarat dengan misteri dan intrik yang membuat pembaca terus bertanya-tanya. Kisah cinta yang terjalin dengan latar belakang yang magis dan penuh teka-teki, menghadirkan pengalaman membaca yang tak terlupakan.', 'http://localhost/Web%20Buku%20Digital%20Online/BukuDigital_Tugas5/covers/Bulan_Tere%20Liye.jpg', 4.7, 18000.00, 'bulan.pdf', 'Fiksi', 'terverifikasi', '2024-01-15', 'PEN0002', 'OP03'),
('BKU004', 'Cantik Itu Luka', 'Sebuah kisah kelam yang indah dan menghancurkan, sebuah novel yang merobek batasan antara keindahan dan penderitaan. Mengungkap realitas pahit sejarah dan fantasi yang mencekam, disajikan dengan bahasa yang puitis dan menggetarkan.', 'http://localhost/Web%20Buku%20Digital%20Online/BukuDigital_Tugas5/covers/Cantik%20itu%20Luka_Eka%20Kurniawan.jpg', 4.8, 16000.00, 'cantik_itu_luka.pdf', 'Fiksi', 'terverifikasi', '2024-01-20', 'PEN0004', 'OP04'),
('BKU005', 'Dompet Ayah Sepatu Ibu', 'Cerita keluarga yang mengharukan, penuh dengan cinta, pengorbanan, dan perjuangan hidup. Menggambarkan ikatan yang kuat antar anggota keluarga dan bagaimana mereka saling mendukung melewati berbagai cobaan.', 'http://localhost/Web%20Buku%20Digital%20Online/BukuDigital_Tugas5/covers/Dompet%20Ayah%20Sepatu%20Ibu_JS.%20Khairen.jpg', 4.0, 11000.00, 'dompet_ayah_sepatu_ibu.pdf', 'Fiksi', 'terverifikasi', '2024-01-25', 'PEN0005', 'OP05'),
('BKU006', 'Hujan', 'Novel yang menghadirkan renungan mendalam tentang kehidupan, kehilangan, dan ujian yang harus dihadapi setiap manusia. Mengisahkan perjalanan emosional seorang tokoh yang belajar menerima takdir dan menemukan kekuatan di tengah badai.', 'http://localhost/Web%20Buku%20Digital%20Online/BukuDigital_Tugas5/covers/Hujan_Tere%20Liye.jpg', 4.6, 14000.00, 'hujan.pdf', 'Fiksi', 'terverifikasi', '2024-01-30', 'PEN0002', 'OP01'),
('BKU007', 'Laskar Pelangi', 'Sebuah inspirasi abadi dari perjuangan anak-anak di Belitung yang gigih mengejar mimpi dan pendidikan di tengah keterbatasan. Kisah nyata yang penuh semangat, persahabatan, dan harapan yang tak pernah padam.', 'http://localhost/Web%20Buku%20Digital%20Online/BukuDigital_Tugas5/covers/Laskar%20Pelangi_Andrea%20Hirata.jpg', 4.9, 13500.00, 'laskar_pelangi.pdf', 'Fiksi', 'terverifikasi', '2024-02-04', 'PEN0001', 'OP02'),
('BKU008', 'Luka Cita', 'Novel yang menyentuh hati dengan tema cinta, kehilangan, dan proses penyembuhan luka batin. Menggambarkan perjuangan seorang individu dalam menghadapi duka dan menemukan kembali makna hidup.', 'http://localhost/Web%20Buku%20Digital%20Online/BukuDigital_Tugas5/covers/Luka%20Cita_Valerie%20Patkar.jpg', 4.1, 10000.00, 'luka_cita.pdf', 'Fiksi', 'terverifikasi', '2024-02-10', 'PEN0007', 'OP03'),
('BKU009', 'Retrocession', 'Cerita yang kuat tentang perjuangan melawan arus dan perubahan yang tak terhindarkan. Mengisahkan perjalanan seorang tokoh dalam menghadapi tantangan besar dan beradaptasi dengan realitas baru.', 'http://localhost/Web%20Buku%20Digital%20Online/BukuDigital_Tugas5/covers/Retrocession_Ayunita%20Kuraisy.jpg', 3.9, 9500.00, 'retrocession.pdf', 'Fiksi', 'terverifikasi', '2024-02-15', 'PEN0006', 'OP04'),
('BKU010', 'Filosofi Teras', 'Buku motivasi dan filosofi hidup sederhana yang memberikan panduan praktis untuk mencapai ketenangan batin dan kebahagiaan. Mengajarkan prinsip-prinsip Stoisisme untuk menghadapi tantangan hidup dengan bijaksana.', 'http://localhost/Web%20Buku%20Digital%20Online/BukuDigital_Tugas5/covers/Filosofi%20Teras_Henry%20Manampiring.jpg', 4.8, 17000.00, 'filosofi_teras.pdf', 'Non Fiksi', 'terverifikasi', '2024-02-20', 'PEN0009', 'OP05'),
('BKU011', 'Insecurity is my Middle Name', 'Buku self-help yang jujur dan menginspirasi tentang pentingnya membangun kepercayaan diri dan mengatasi rasa tidak aman. Memberikan wawasan dan strategi untuk mencintai diri sendiri apa adanya.', 'http://localhost/Web%20Buku%20Digital%20Online/BukuDigital_Tugas5/covers/Insecurity%20is%20my%20Middle%20Name_Alvi%20Syahrin.jpg', 4.3, 11500.00, 'insecurity.pdf', 'Non Fiksi', 'terverifikasi', '2024-02-25', 'PEN0010', 'OP01'),
('BKU012', 'You do You', 'Buku motivasi yang mendorong pembaca untuk menjadi diri sendiri, merangkul keunikan, dan tidak terpaku pada ekspektasi orang lain. Mengajarkan pentingnya otentisitas dan kebahagiaan dari dalam diri.', 'http://localhost/Web%20Buku%20Digital%20Online/BukuDigital_Tugas5/covers/You%20do%20You_Fellexandro%20Ruby.jpg', 4.4, 12000.00, 'you_do_you.pdf', 'Non Fiksi', 'terverifikasi', '2024-03-01', 'PEN0011', 'OP02'),
('BKU013', 'Gadis Kretek', 'Gadis Kretek adalah sebuah novel fiksi sejarah yang ditulis oleh Ratih Kumala dan pertama kali diterbitkan pada tahun 2012. Novel ini sukses besar dan bahkan diadaptasi menjadi serial populer oleh Netflix pada tahun 2023.\r\n\r\nNovel ini bukan sekadar kisah romansa, tetapi juga menyelami sejarah industri kretek di Indonesia, intrik keluarga, persaingan bisnis,', 'http://localhost/Web%20Buku%20Digital%20Online/BukuDigital_Tugas5/covers/Gadis%20Kretek-Ratih%20Kumala.jpg', 4.0, 13000.00, 'Gadis Kretek.pdf', 'Fiksi', 'pending', '2024-03-05', 'PEN0003', 'OP01'),
('BKU014', 'Ronggeng Dukuh Paruk', 'Sebuah cerita yang memotret kehidupan urban, hiruk pikuk kota, dan perjuangan individu di dalamnya. Menggambarkan kerumitan hubungan antarmanusia dan pencarian makna di tengah modernitas.', 'http://localhost/Web%20Buku%20Digital%20Online/BukuDigital_Tugas5/covers/Ronggeng%20Dukuh%20Paruk_Ahmad%20Tohari.jpg', 4.2, 10500.00, 'Ronggeng Dukuh Paruk.pdf', 'Fiksi', 'terverifikasi', '2024-03-10', 'PEN0008', 'OP04'),
('BKU015', 'Tanah Para Bandit', '\"Tanah Para Bandit\" adalah novel karya Tere Liye, seorang penulis fiksi populer asal Indonesia. Buku ini merupakan bagian dari seri petualangan \"Aldi dan Amelia\", atau lebih dikenal sebagai serial \"Negeri Para Bedebah\" dan \"Negeri di Ujung Tanduk\". Meskipun sering disebut sebagai prekuel atau pelengkap dari kedua novel tersebut, \"Tanah Para Bandit\" memiliki fokus cerita yang berbeda dengan sudut pandang yang lebih spesifik.', 'http://localhost/Web%20Buku%20Digital%20Online/BukuDigital_Tugas5/covers/cover_683c4abaa5d09.jpg', 0.0, 30000.00, 'http://localhost/Web%20Buku%20Digital%20Online/BukuDigital_Tugas5/files/buku_683c4abaa6174.pdf', 'Non-Fiksi', 'pending', '2025-06-01', 'PEN0001', 'OP01');

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
('DP000014', '00000014', 'BKU014', 35000.00, 'diproses', '2024-04-14');

-- --------------------------------------------------------

--
-- Table structure for table `operator`
--

CREATE TABLE `operator` (
  `id_operator` char(4) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL,
  `tanggal_daftar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `operator`
--

INSERT INTO `operator` (`id_operator`, `username`, `email`, `password`, `status`, `tanggal_daftar`) VALUES
('OP01', 'nadhira', 'nadhira@gmail.com', '$2y$10$JpqowIFstmqxeiymjUOzOen', 'aktif', '2024-01-10'),
('OP02', 'ariefk', 'ariefk@gmail.com', '$2y$10$pJdWEdrha2L3NRtZLrox1uoeWr3IZl3wLri9huwreC3BNQokGLNSe', 'aktif', '2024-01-12'),
('OP03', 'dian_ri', 'dian.ri@gmail.com', '$2y$10$JyyJITD9RDp8MFoZg6WNauYtCxbHEK83xGFds7WUoI4bENr9Ig1TK', 'nonaktif', '2024-01-14'),
('OP04', 'febrian', 'febrian@gmail.com', '$2y$10$zzUnGhSWUb0vJ4spGzk/2.b529oGp6yUFgNgQgTIqv1ZbmgoS.GCO', 'aktif', '2024-01-16'),
('OP05', 'mellya', 'mellya@gmail.com', '$2y$10$ehaOenCRwq0sEWNk.Y2DMuI2u7a3EScrohypv8anFA6LBMs84lzHu', 'nonaktif', '2024-01-18');

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
('PBC0001', 'rexy12', 'rexy12@gmail.com', '$2y$10$5kBBKtW6k8XogZrey2KSkeZj1XJHH39D9ZCpsOUzE9uy/oUgm2bI2', 'aktif', '2024-01-01'),
('PBC0002', 'zayn88', 'zayn88@gmail.com', '$2y$10$2KpfWgqZXsFaDUjjRXG2veWilKfJDbbDcUMBCibXCwUwKrUpGUfPi', 'aktif', '2024-01-03'),
('PBC0003', 'alya_kk', 'alya_kk@gmail.com', '$2y$10$8xY..ZQ3r9eRbiGib.m2T.k3ljIWmvzoIqmbpyLbPb/yzInjctc7y', 'aktif', '2024-01-05'),
('PBC0004', 'thaliax', 'thaliax@gmail.com', '$2y$10$CUG7ThO/KTUVzvTLX19vYucmL58HDR7mCVGaww6uIdt2awD5wPbwq', 'aktif', '2024-01-08'),
('PBC0005', 'donny12', 'donny12@gmail.com', '$2y$10$urbOo4q/X5GhWJL4eQ/7/ePhWIb0Y6zOaETPVHtH74L6l0lHgOF/W', 'nonaktif', '2024-01-10'),
('PBC0006', 'yuna88', 'yuna88@gmail.com', '$2y$10$e9zfGfp5BT.PzEJf160.AefuZXnX2WPr9pta9pTcK2CC0L9wrE6s2', 'aktif', '2024-01-12'),
('PBC0007', 'kean_k', 'kean_k@gmail.com', '$2y$10$ff5vWiayd106p7jaUSext.bmqgGrDDu9DFaLTXPbxpQ6NqoNLCvge', 'aktif', '2024-01-14'),
('PBC0008', 'nabila', 'nabila@gmail.com', '$2y$10$kiVGs6NdCo1qD8P/l3.WCOe7GAwqrldUjXSK7EFJC34iMPUTXvh8S', 'aktif', '2024-01-16'),
('PBC0009', 'salma_', 'salma_@gmail.com', '$2y$10$dNvAbHsfdQFHu6d0B5qWAufjBIysT0HvrUlZYmVO9SbrvWSH.oTs.', 'nonaktif', '2024-01-18'),
('PBC0010', 'andhika', 'andhika@gmail.com', '$2y$10$u0L9sGsHnwIdBpdr7pNaPeQQNhkrmlWvM4gxh2aEwQJWEW4/VESBm', 'aktif', '2024-01-20'),
('PBC0011', 'gita12', 'gita12@gmail.com', '$2y$10$pabMch2RXvJcAL7DKsNj9u450HMze.Za9p6rxHnH9/kuflVGltKdO', 'aktif', '2024-01-22'),
('PBC0012', 'raihanx', 'raihanx@gmail.com', '$2y$10$RGhfgE1tmpofc0GwGjn3T.8oItg9LXk9b0hBFlHSCowgAmf79Z6m2', 'aktif', '2024-01-24'),
('PBC0013', 'vina99', 'vina99@gmail.com', '$2y$10$ijp1IrmS8uO.440MLQZC..p8I2s/Vne6I8XU02m5UhwWUeF6kiipq', 'nonaktif', '2024-01-26'),
('PBC0014', 'hannaq', 'hannaq@gmail.com', '$2y$10$h12fnDReliphMav6mbI33u7YTvO1hitwtNdznwRl8v7m1ieXsjUVy', 'aktif', '2024-01-28'),
('PBC0015', 'ali_a', 'ali_a@gmail.com', '$2y$10$lBcCT/V5UjjEp.JAtHrT9ezBqoegJJXwK6YWWej5C5QdWrFF6Gf6.', 'aktif', '2024-01-30'),
('PBC0016', 'febbyx', 'febbyx@gmail.com', '$2y$10$bAD2h4hm.1QwnRjdhU94B.d4TnIbBhOO6JfuzHzq84MnBVm5Dgsg.', 'nonaktif', '2024-02-01'),
('PBC0017', 'zakiya', 'zakiya@gmail.com', '$2y$10$5DQPJn1sdQ3tqY0xz0dAbuAdTbzLSEwEOW9qYoWaMA2SYCVu3dpka', 'aktif', '2024-02-03'),
('PBC0018', 'farhan', 'farhan@gmail.com', '$2y$10$0PJTNtHT.keC1Dq0ZOr/zuBuv.QvJwT8T64UfF8Bs/Ra1OWdo3aBe', 'aktif', '2024-02-05'),
('PBC0019', 'syifa_', 'syifa_@gmail.com', '$2y$10$2HEZ9zaqRf8JqkRkQSaiPeTmgRsQ0QA5OMA/41FGPNroO0tOdmcEi', 'nonaktif', '2024-02-07'),
('PBC0020', 'mariox', 'mariox@gmail.com', '$2y$10$wZ/mxO5SMUQC6k.QMBEeBu02/eSpP7KqinVjxPs9sVH1yYL3XWGDS', 'aktif', '2024-02-09'),
('PBC0021', 'tama', 'apaja@gmail.com', '$2y$10$af0qoIzVBVt4A0GggmwmGOvGJprH6wWwTa/AjzF8kO0dMedwdWKnq', 'aktif', '0000-00-00'),
('PBC0022', 'iqbal', 'iqbaall@student.uns.ac.id', '$2y$10$jVhvnkYn5dCNtU2MLl8mIeWlpY8jD1ReYmYjyHoIjIcJgtoKSmpK2', 'aktif', '0000-00-00'),
('PBC0023', 'aqila', 'aqila@gmail.com', '$2y$10$798NeGMQIwSsDXE9k/iu7eOBbyNGrS6Fp66eVEeeFGg/hyE9emJ2y', 'aktif', '0000-00-00'),
('PBC0024', 'aaa', 'aaa@gmail.com', '$2y$10$flxhY7O8F6VyFKLkT.mBk.gjw5ybdNNt5JA.FC1ECRIVuO764gVVK', 'aktif', '0000-00-00');

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
('PEN0001', 'andrea_h', 'andrea.h@gmail.com', '$2y$10$mFH7s9EFWoBPC7f2ehUxTOFmjuMvkc8PH63t4FMr8pBFWzKqVSCAe', 'aktif', '2024-01-01'),
('PEN0002', 'tere_liye', 'tere.liye@gmail.com', 'TereLiye@24', 'aktif', '2024-01-05'),
('PEN0003', 'laksmi_p', 'laksmi.p@gmail.com', '$2y$10$7.5YXNnkZtDkPFA2ASYRaej6JlXGV/V.pnKuxv98YVZ64YWx14yGK', 'nonaktif', '2024-01-10'),
('PEN0004', 'eka_kurniawan', 'eka.k@gmail.com', '$2y$10$GbFEWqdlYZp3mW3qp8FY1e/o/a7gs/2259ykYlOhBLL09Bftc0zou', 'aktif', '2024-01-15'),
('PEN0005', 'js_khairen', 'js.khairen@gmail.com', '$2y$10$dQbAsryTByVUWdEd.hPoMenwrp/bHwLFkXALJzggJNntkd2vw0Y4C', 'aktif', '2024-01-20'),
('PEN0006', 'ayunita_k', 'ayunita.k@gmail.com', '$2y$10$Z8on1b9tC5S2rCgy3lRBbOxqQuNQf688GDZTz6u07Y0fi3are81ke', 'nonaktif', '2024-01-25'),
('PEN0007', 'valerie_p', 'valerie.p@gmail.com', '$2y$10$y/kBpGrvillHZ1q2Om063.InB6B60JQHa7HJ87NzzVDtwFx2ApwSu', 'aktif', '2024-02-01'),
('PEN0008', 'brian_k', 'brian.k@gmail.com', '$2y$10$mwLhNtF/3caT/fYkQp4.8O0OGgAnjWKyxeaeIu1o89j2CG3poJ8Lq', 'aktif', '2024-02-06'),
('PEN0009', 'henry_m', 'henry.m@gmail.com', '$2y$10$w2dIFxAlTo3RkSqLnAYu/O/KfQMi57m9/cRAPvG1Vcsd7UwrC4xYS', 'nonaktif', '2024-02-11'),
('PEN0010', 'alvi_s', 'alvi.s@gmail.com', '$2y$10$Vs5g/T01a4J0ImfrTXgPPuWcwhkKl8it/dC00egG3UUvsnRgXnhYG', 'aktif', '2024-02-16'),
('PEN0011', 'fellex_r', 'fellex.r@gmail.com', '$2y$10$nf/uw4wkdDJ3knDWJUIyEOqlZEonEfAKNiFrfNA8hMmfK4TeONnR6', 'aktif', '2024-02-21'),
('PEN0012', 'intan_w', 'intan.w@gmail.com', '$2y$10$wsNrBgpb5vt5VdO4.NkueOjiFNisxAJw/P2R6wCRhNtIYudGmZZCi', 'aktif', '2024-02-26'),
('PEN0013', 'gilang_r', 'gilang.r@gmail.com', '$2y$10$jjBEH285V6CfgcnC9jVDWer/vqt6X8F9Qd7vb/ZRraEHE9Flo6vSO', 'nonaktif', '2024-03-02'),
('PEN0014', 'risa_s', 'risa.s@gmail.com', '$2y$10$Q0lpqTUGdFbPW0HTUyTHuubgkRyPM3oDNXFt2X5GftSXWEoP.d17S', 'aktif', '2024-03-07'),
('PEN0015', 'niko_a', 'niko.a@gmail.com', '$2y$10$DV1F5VjXcqZUOMOCENBeMuGnpqIN9s4n7LID6Wn.O9gJdtD8FvwdC', 'aktif', '2024-03-12'),
('PEN0016', 'dina_l', 'dina.l@gmail.com', '$2y$10$5//gRnUTVVFz9BtNYkep8udyxvCLfxYtJoNBiQRsgOLb7Mt5Q3B.m', 'nonaktif', '2024-03-17'),
('PEN0017', 'wulan_m', 'wulan.m@gmail.com', '$2y$10$FbGFXe2rFIDqMYCLddqu.OhbQJkAX8T5pmQzgUAV/QHoQlXnB8h8.', 'aktif', '2024-03-22'),
('PEN0018', 'reza_y', 'reza.y@gmail.com', '$2y$10$lob/TmrtDnSYljrPW9LF1elrnbOFYI.61Fwemfr4crlcy5ftQf4Bm', 'aktif', '2024-03-27'),
('PEN0019', 'cihuy', 'hitamnegro@gmail.com', '$2y$10$nAak.wJwAHDyhNXufeGKheicNFHseHB1OGCIoiVD5Xcgtk.Jp5PhO', 'aktif', '0000-00-00'),
('PEN0020', 'abc', 'abc@gmail.com', '$2y$10$NHu5B9JUiihmYlM7gDFV9uGLy4o8npkXg46ACA91dp9kIVtdQrtJC', 'aktif', '0000-00-00');

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
