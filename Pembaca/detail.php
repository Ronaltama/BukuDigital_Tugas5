<?php
// Selalu mulai session di baris paling atas
session_start();

// Menampilkan semua error untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Menyertakan koneksi
// DIUBAH: Tambahkan ../ untuk naik satu level folder
include("../koneksi.php"); 

// -----------------------------------------------------------------------------
// TAHAP 1: VALIDASI INPUT DAN PENGGUNA
// -----------------------------------------------------------------------------

// Ambil ID buku dari URL, jika tidak ada, hentikan proses
$id_buku = $_GET['id'] ?? null;
if (!$id_buku) {
    die("Error: ID Buku tidak ditemukan.");
}

// Ambil ID pembaca dari session
$id_pembaca = $_SESSION['id_pembaca'] ?? null;
if (!$id_pembaca) {
    // Jika belum login, alihkan ke halaman login
    header("Location: ../features/loginpage.php?redirect=Pembaca/detail.php?id=" . urlencode($id_buku));
    exit();
}

// -----------------------------------------------------------------------------
// TAHAP 2: VERIFIKASI HAK AKSES SEWA (LOGIKA INTI)
// -----------------------------------------------------------------------------

$sewa_aktif = null; // Variabel untuk menyimpan data sewa jika valid

$sql_cek_akses = "SELECT tgl_kembali FROM sewa 
                  WHERE id_pembaca = ? AND id_buku = ? AND status_sewa = 'dipinjam' AND tgl_kembali >= CURDATE()
                  LIMIT 1";

$stmt_cek = $conn->prepare($sql_cek_akses);
$stmt_cek->bind_param("ss", $id_pembaca, $id_buku);
$stmt_cek->execute();
$result_cek = $stmt_cek->get_result();

if ($result_cek->num_rows > 0) {
    $sewa_aktif = $result_cek->fetch_assoc();
} else {
    http_response_code(403);
    die("<h2>Akses Ditolak</h2><p>Masa sewa Anda untuk buku ini telah berakhir atau Anda tidak memiliki hak akses.</p><a href='../index.php'>Kembali ke Beranda</a>");
}
$stmt_cek->close();

// -----------------------------------------------------------------------------
// TAHAP 3: AMBIL DETAIL LENGKAP BUKU (JIKA AKSES DIBERIKAN)
// -----------------------------------------------------------------------------

$buku = null;

$sql_detail_buku = "SELECT
                        b.judul, b.deskripsi, b.cover_url, b.rating, b.kategori,
                        b.file_buku,
                        p.username AS nama_penulis
                    FROM buku AS b
                    JOIN penulis AS p ON b.id_penulis = p.id_penulis
                    WHERE b.id_buku = ? AND b.status_verifikasi = 'terverifikasi'";

$stmt_detail = $conn->prepare($sql_detail_buku);
$stmt_detail->bind_param("s", $id_buku);
$stmt_detail->execute();
$result_detail = $stmt_detail->get_result();

if ($result_detail->num_rows > 0) {
    $buku = $result_detail->fetch_assoc();
} else {
    http_response_code(404);
    die("<h2>404 - Not Found</h2><p>Buku yang Anda cari tidak dapat ditemukan.</p>");
}
$stmt_detail->close();
$conn->close();

// Logika untuk menampilkan bintang rating
$rating_value = floatval($buku['rating']);
$full_stars = floor($rating_value);
$half_star = ($rating_value - $full_stars >= 0.5);
$empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Detail: <?php echo htmlspecialchars($buku['judul']); ?></title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../style.css" />
  <style>
  .book-cover-detail {
    max-width: 85%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  }

  .book-title-detail {
    font-weight: 700;
    color: #333;
  }

  .list-group-item .icon {
    width: 20px;
    margin-right: 10px;
    text-align: center;
  }
  </style>
</head>

<body>
  <?php 
      // DIUBAH: Tambahkan ../ pada path include
      include("../modular/headerPembaca.php"); 
    ?>

  <main class="container my-5">
    <div class="row">
      <div class="col-md-4 text-center">
        <img src="<?php echo htmlspecialchars($buku['cover_url']); ?>"
          alt="Cover <?php echo htmlspecialchars($buku['judul']); ?>" class="book-cover-detail mb-4">

        <div class="d-grid gap-2 px-4">
          <a href="baca.php?id=<?php echo htmlspecialchars($id_buku); ?>" class="btn btn-success">
            <i class="fas fa-book-open me-2"></i>Baca Buku Sekarang
          </a>
        </div>
      </div>

      <div class="col-md-8">
        <h1 class="book-title-detail mb-3"><?php echo htmlspecialchars($buku['judul']); ?></h1>

        <ul class="list-group list-group-flush mb-4">
          <li class="list-group-item d-flex align-items-center">
            <i class="fas fa-user-edit icon text-muted"></i>
            <strong>Penulis:</strong>&nbsp; <?php echo htmlspecialchars($buku['nama_penulis']); ?>
          </li>
          <li class="list-group-item d-flex align-items-center">
            <i class="fas fa-tags icon text-muted"></i>
            <strong>Kategori:</strong>&nbsp; <span
              class="badge bg-primary"><?php echo htmlspecialchars($buku['kategori']); ?></span>
          </li>
          <li class="list-group-item d-flex align-items-center">
            <i class="fas fa-star icon text-muted"></i>
            <strong>Rating:</strong>&nbsp;
            <span class="text-warning">
              <?php
                            for ($i = 0; $i < $full_stars; $i++) { echo '<i class="fas fa-star"></i>'; }
                            if ($half_star) { echo '<i class="fas fa-star-half-alt"></i>'; }
                            for ($i = 0; $i < $empty_stars; $i++) { echo '<i class="far fa-star"></i>'; }
                        ?>
            </span>
            <span class="ms-2">(<?php echo number_format($rating_value, 1); ?>)</span>
          </li>
          <li class="list-group-item d-flex align-items-center bg-light">
            <i class="fas fa-clock icon text-danger"></i>
            <strong>Sewa Berakhir:</strong>&nbsp; <span
              class="fw-bold text-danger"><?php echo date("d F Y", strtotime($sewa_aktif['tgl_kembali'])); ?></span>
          </li>
        </ul>

        <h4 class="mt-4">Deskripsi</h4>
        <p style="text-align: justify;"><?php echo nl2br(htmlspecialchars($buku['deskripsi'])); ?></p>
      </div>
    </div>
  </main>

  <?php 
      // DIUBAH: Tambahkan ../ pada path include
      include("../modular/footerFitur.php"); 
    ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../script.js"></script>
  <script>
  // JavaScript untuk fungsionalitas scroll horizontal
  document.addEventListener('DOMContentLoaded', function() {
    function setupScroll(containerId, leftBtnClass, rightBtnClass) {
      const scrollContainer = document.getElementById(containerId);
      const leftBtn = document.querySelector(`.${leftBtnClass}`);
      const rightBtn = document.querySelector(`.${rightBtnClass}`);

      if (scrollContainer && leftBtn && rightBtn) {
        leftBtn.addEventListener('click', () => {
          scrollContainer.scrollBy({
            left: -220, // Lebar card + gap
            behavior: 'smooth'
          });
        });

        rightBtn.addEventListener('click', () => {
          scrollContainer.scrollBy({
            left: 220, // Lebar card + gap
            behavior: 'smooth'
          });
        });

        // Sembunyikan/tampilkan tombol scroll berdasarkan posisi scroll
        const toggleScrollButtons = () => {
          if (scrollContainer.scrollWidth > scrollContainer.clientWidth) {
            if (scrollContainer.scrollLeft === 0) {
              leftBtn.style.display = 'none';
              rightBtn.style.display = 'flex'; // Tampilkan tombol kanan
            } else if (scrollContainer.scrollLeft + scrollContainer.clientWidth >= scrollContainer.scrollWidth) {
              rightBtn.style.display = 'none';
              leftBtn.style.display = 'flex'; // Tampilkan tombol kiri
            } else {
              leftBtn.style.display = 'flex';
              rightBtn.style.display = 'flex';
            }
          } else {
            leftBtn.style.display = 'none';
            rightBtn.style.display = 'none';
          }
        };

        scrollContainer.addEventListener('scroll', toggleScrollButtons);
        // Panggil saat halaman dimuat untuk mengatur tampilan awal tombol
        toggleScrollButtons();
        // Juga panggil jika ada perubahan ukuran window (misal: resize)
        window.addEventListener('resize', toggleScrollButtons);
      }
    }

    setupScroll('new-releases-books', 'new-releases-scroll-left', 'new-releases-scroll-right');
    setupScroll('popular-books', 'popular-scroll-left', 'popular-scroll-right');
    setupScroll('cheapest-books', 'cheapest-scroll-left', 'cheapest-scroll-right');
    setupScroll('most-expensive-books', 'most-expensive-scroll-left', 'most-expensive-scroll-right');
    setupScroll('recommendation-books', 'recommendation-scroll-left', 'recommendation-scroll-right');
  });
  </script>
</body>

</html>