-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2025 at 02:45 PM
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
('BKU014', 'RonggengDukuhParuk', 'Sebuah cerita yang memotret kehidupan urban, hiruk pikuk kota, dan perjuangan individu di dalamnya. Menggambarkan kerumitan hubungan antarmanusia dan pencarian makna di tengah modernitas.', 'http://localhost/Web%20Buku%20Digital%20Online/BukuDigital_Tugas5/covers/Ronggeng%20Dukuh%20Paruk_Ahmad%20Tohari.jpg', 4.2, 10500.00, 'ronggeng_dukuh_paruk.pdf', 'Fiksi', 'terverifikasi', '2024-03-10', 'PEN0008', 'OP04'),
('BKU017', 'Sebuah Seni untuk Bersikap Bodo Amat', 'Buku ini mengajak pembaca untuk melihat hidup dari sudut pandang yang lebih realistis dan jujur. Mark Manson, seorang blogger dan penulis populer, menyampaikan pesan bahwa hidup tidak harus selalu bahagia dan sempurna. Justru dengan menerima kenyataan pahit, kegagalan, dan keterbatasan, seseorang bisa menemukan kedamaian dan makna hidup yang lebih dalam.\r\n\r\nMelalui gaya bahasa yang lugas, blak-blakan, dan kadang sarkastik, Manson menyampaikan filosofi “bodo amat” — bukan berarti tidak peduli sama sekali, tapi lebih kepada memilih dengan bijak apa yang layak untuk dipedulikan. Kita sering terlalu sibuk mencoba membahagiakan semua orang, mengejar validasi, atau khawatir tentang hal-hal sepele. Buku ini menekankan pentingnya memfokuskan perhatian dan energi hanya pada hal-hal yang benar-benar penting bagi kita.', 'http://localhost/Web%20Buku%20Digital%20Online/BukuDigital_Tugas5/covers/cover_685c8386808b6.jpg', 0.0, 20000.00, 'buku_685c8386818dd.pdf', 'Fiksi', 'terverifikasi', '2025-06-26', 'PEN0001', 'OP01'),
('BKU018', 'Yellow Face', 'Yellowface adalah novel satire tajam yang membongkar sisi gelap industri penerbitan, rasisme sistemik, dan obsesi terhadap kepemilikan narasi. Cerita mengikuti June Hayward, seorang penulis kulit putih biasa-biasa saja yang menyaksikan sahabat sekaligus rivalnya, Athena Liu — penulis Asia-Amerika sukses — meninggal mendadak. Dalam kekalutan dan iri hati, June mengambil naskah terakhir Athena, menyuntingnya, dan menerbitkannya atas nama barunya: Juniper Song, menyamarkan identitasnya agar terlihat sebagai penulis keturunan Asia.\r\n\r\nKesuksesan cepat datang, tapi begitu pula tekanan dan pertanyaan tentang keaslian. Ketika kebenaran mulai mengintai dan orang-orang mulai curiga, June harus menghadapi pertanyaan besar tentang identitas, moralitas, dan siapa yang berhak menceritakan kisah siapa.', 'http://localhost/Web%20Buku%20Digital%20Online/BukuDigital_Tugas5/covers/cover_685c8baa87662.jpg', 0.0, 15000.00, 'buku_685c8baa87988.pdf', 'Pengembangan Diri', 'terverifikasi', '2025-06-26', 'PEN0001', 'OP01');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_pemesanan` char(8) NOT NULL,
  `id_pembaca` char(7) NOT NULL,
  `id_buku` char(8) NOT NULL,
  `durasi_sewa` int(11) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `status_pemesanan` enum('menunggu','selesai','dibatalkan') NOT NULL,
  `tanggal_pesanan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_pemesanan`, `id_pembaca`, `id_buku`, `durasi_sewa`, `total_harga`, `status_pemesanan`, `tanggal_pesanan`) VALUES
('DP000001', 'PBC0001', 'BKU007', 7, 5215.00, 'selesai', '2025-06-10'),
('DP000002', 'PBC0002', 'BKU010', 30, 16950.00, 'selesai', '2025-06-11'),
('DP000003', 'PBC0003', 'BKU004', 14, 9560.00, 'selesai', '2025-05-01'),
('DP000004', 'PBC0003', 'BKU014', 3, 3680.00, 'selesai', '2025-06-12'),
('DP000005', 'PBC0003', 'BKU001', 3, 4400.00, 'selesai', '2025-06-12'),
('DP000006', 'PBC0003', 'BKU017', 30, 17000.00, 'selesai', '2025-06-26'),
('DP000007', 'PBC0025', 'BKU017', 14, 10400.00, 'selesai', '2025-06-26'),
('DP000008', 'PBC0002', 'BKU018', 7, 6987.50, 'menunggu', '2025-06-26');

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
('PBC0001', 'rexy12', 'rexy12@gmail.com', '$2y$10$5kBBKtW6k8XogZrey2KSkeZj1XJHH39D9ZCpsOUzE9uy/oUgm2bI2', 'nonaktif', '2024-01-01'),
('PBC0002', 'zayn88', 'zayn88@gmail.com', '$2y$10$2KpfWgqZXsFaDUjjRXG2veWilKfJDbbDcUMBCibXCwUwKrUpGUfPi', 'nonaktif', '2024-01-03'),
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
('PBC0024', 'aaa', 'aaa@gmail.com', '$2y$10$flxhY7O8F6VyFKLkT.mBk.gjw5ybdNNt5JA.FC1ECRIVuO764gVVK', 'aktif', '0000-00-00'),
('PBC0025', 'bagas', 'bagasardian@gmail.com', '$2y$10$CmDXyNmfFJwNbd3lQdX7IeshIM1PJ/XC14mHc5K/IIQI/ts2xPlCW', 'aktif', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` varchar(8) NOT NULL,
  `id_pemesanan` char(8) NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `tgl_pembayaran` date NOT NULL,
  `status_pembayaran` enum('pending','berhasil','gagal') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pemesanan`, `jumlah`, `tgl_pembayaran`, `status_pembayaran`) VALUES
('1', 'DP000001', 5215.00, '2025-06-10', 'berhasil'),
('2', 'DP000002', 16950.00, '2025-06-11', 'berhasil'),
('3', 'DP000003', 9560.00, '2025-05-01', 'berhasil'),
('4', 'DP000004', 3680.00, '2025-06-12', 'berhasil'),
('5', 'DP000005', 4400.00, '2025-06-12', 'berhasil'),
('6', 'DP000006', 17000.00, '2025-06-26', 'berhasil'),
('7', 'DP000007', 10400.00, '2025-06-26', 'berhasil'),
('8', 'DP000008', 6987.50, '2025-06-26', 'pending');

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
  `id_pemesanan` char(8) DEFAULT NULL,
  `tgl_sewa` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `durasi_sewa` int(11) NOT NULL,
  `status_sewa` enum('dipinjam','kembali') NOT NULL,
  `id_pembaca` char(7) NOT NULL,
  `id_buku` char(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sewa`
--

INSERT INTO `sewa` (`id_sewa`, `id_pemesanan`, `tgl_sewa`, `tgl_kembali`, `durasi_sewa`, `status_sewa`, `id_pembaca`, `id_buku`) VALUES
('00000001', 'DP000001', '2025-06-10', '2025-06-17', 7, 'dipinjam', 'PBC0001', 'BKU007'),
('00000002', 'DP000003', '2025-05-01', '2025-05-15', 14, 'kembali', 'PBC0003', 'BKU004'),
('00000003', 'DP000002', '2025-06-12', '2025-07-12', 30, 'dipinjam', 'PBC0002', 'BKU010'),
('00000004', 'DP000004', '2025-06-12', '2025-06-15', 3, 'dipinjam', 'PBC0003', 'BKU014'),
('00000005', 'DP000005', '2025-06-12', '2025-06-15', 3, 'dipinjam', 'PBC0003', 'BKU001'),
('00000006', 'DP000006', '2025-06-26', '2025-07-26', 30, 'dipinjam', 'PBC0003', 'BKU017'),
('00000007', 'DP000007', '2025-06-26', '2025-07-10', 14, 'dipinjam', 'PBC0025', 'BKU017');

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
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `id_pembaca_pesanan_idx` (`id_pembaca`);

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
  ADD KEY `id_pemesanan_pembayaran_idx` (`id_pemesanan`);

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
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `id_pemesanan_sewa_idx` (`id_pemesanan`);

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
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_pembaca`) REFERENCES `pembaca` (`id_pembaca`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pemesanan`) REFERENCES `detail_pesanan` (`id_pemesanan`);

--
-- Constraints for table `sewa`
--
ALTER TABLE `sewa`
  ADD CONSTRAINT `sewa_ibfk_1` FOREIGN KEY (`id_pembaca`) REFERENCES `pembaca` (`id_pembaca`),
  ADD CONSTRAINT `sewa_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`),
  ADD CONSTRAINT `sewa_ibfk_3` FOREIGN KEY (`id_pemesanan`) REFERENCES `detail_pesanan` (`id_pemesanan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
