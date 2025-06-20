<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../koneksi.php");

$id_pembaca = $_SESSION['id_pembaca'] ?? null;
$buku_sewaan = [];
$pesan_error = '';

if ($id_pembaca) {
    // ================== PERUBAHAN ADA DI KLAUSA WHERE ==================
    $sql = "SELECT 
                buku.id_buku, 
                buku.judul, 
                penulis.username AS penulis,
                buku.cover_url AS cover
            FROM sewa
            JOIN buku ON sewa.id_buku = buku.id_buku
            JOIN penulis ON buku.id_penulis = penulis.id_penulis
            WHERE sewa.id_pembaca = ? AND sewa.status_sewa = 'dipinjam'"; // <-- Tambahan kondisi di sini
    // ===================================================================

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $id_pembaca);
        $stmt->execute();
        $result = $stmt->get_result();
        $buku_sewaan = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    } else {
        $pesan_error = "Terjadi kesalahan dalam persiapan query database.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perpustakaan Digital - Buku Saya</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../style.css" />
  <style>
  .page-title {
    color: #4a4a6a;
    font-weight: 700;
  }

  /* Tambahkan atau sesuaikan gaya CSS yang dibutuhkan di sini */
  .scroll-container {
    overflow-x: auto;
    /* Mengaktifkan scroll horizontal */
    white-space: nowrap;
    /* Mencegah item melompat ke baris baru */
    -webkit-overflow-scrolling: touch;
    /* Untuk scrolling yang lebih halus di iOS */
    padding-bottom: 10px;
    /* Ruang untuk scrollbar */
  }

  .scroll-container::-webkit-scrollbar {
    height: 8px;
  }

  .scroll-container::-webkit-scrollbar-thumb {
    background-color: #ccc;
    border-radius: 4px;
  }

  .scroll-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    background-color: #fff;
    /* Pastikan tombol terlihat */
    border: 1px solid #eee;
    /* Tambah border agar lebih jelas */
  }

  .scroll-btn.left {
    left: -20px;
    /* Sesuaikan posisi agar tombol terlihat */
  }

  .scroll-btn.right {
    right: -20px;
    /* Sesuaikan posisi agar tombol terlihat */
  }

  .book-card {
    width: 200px;
    /* Sesuaikan lebar kartu buku */
    flex-shrink: 0;
    /* Penting untuk mencegah item menyusut dalam flexbox */
  }

  .book-card .card-img-top {
    height: 250px;
    /* Tinggi gambar cover yang konsisten */
    object-fit: cover;
    /* Menjaga rasio aspek gambar */
  }
  </style>
</head>

<body>
  <?php include("../modular/headerPembaca.php"); ?>
  <div class="container mt-5">
    <h2 class="text-center text-primary mb-4">Buku Aktif Anda</h2>

    <?php if (!$id_pembaca) : ?>
    <div class="alert alert-warning text-center" role="alert">
      Anda harus <a href="login.php" class="alert-link">login</a> terlebih dahulu untuk melihat buku Anda.
    </div>
    <?php elseif ($pesan_error) : ?>
    <div class="alert alert-danger text-center" role="alert">
      <?php echo htmlspecialchars($pesan_error); ?>
    </div>
    <?php elseif (empty($buku_sewaan)) : ?>
    <div class="alert alert-info text-center" role="alert">
      Anda tidak memiliki buku yang sedang aktif disewa.
    </div>
    <?php else : ?>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
      <?php foreach ($buku_sewaan as $buku) : ?>
      <div class="col">
        <div class="card h-100 book-card">
          <?php $cover_path = !empty($buku['cover']) ? $buku['cover'] : 'default.jpg'; ?>
          <img src="<?php echo htmlspecialchars($cover_path); ?>" class="card-img-top"
            alt="Cover <?php echo htmlspecialchars($buku['judul']); ?>">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?php echo htmlspecialchars($buku['judul']); ?></h5>
            <p class="card-text text-muted"><?php echo htmlspecialchars($buku['penulis']); ?></p>
            <a href="detail.php?id=<?php echo $buku['id_buku']; ?>" class="btn btn-primary btn-sm mt-auto">Baca
              Sekarang</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
  <br>
  <br>
  <?php include("../modular/footerFitur.php"); ?>

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