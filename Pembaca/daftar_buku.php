<?php
// Menampilkan semua error untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Menyertakan koneksi
include("../koneksi.php");

// Memeriksa parameter kategori dari URL
if (!isset($_GET['kategori'])) {
    header("Location: kategori.php");
    exit();
}
$kategori = $conn->real_escape_string($_GET['kategori']);

// Query SQL untuk mengambil buku berdasarkan kategori
$sql_filtered_books = "SELECT
    b.id_buku, b.judul, p.username AS nama_penulis, b.cover_url, b.tanggal_upload,
    b.rating, b.harga_sewa, b.kategori
FROM buku AS b
JOIN penulis AS p ON b.id_penulis = p.id_penulis
WHERE b.kategori = ? AND b.status_verifikasi = 'terverifikasi'
ORDER BY b.rating DESC, b.tanggal_upload DESC";

// Menyiapkan dan menjalankan query
$stmt = $conn->prepare($sql_filtered_books);
$stmt->bind_param("s", $kategori);
$stmt->execute();
$result_filtered_books = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Buku Kategori: <?php echo htmlspecialchars($kategori); ?></title>
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

  <main class="container my-5">
    <h2 class="text-center mb-4 page-title">Kategori: <?php echo htmlspecialchars($kategori); ?></h2>

    <div class="row">
      <?php
            // LOGIKA TIDAK LAGI MENGGUNAKAN FUNGSI, LANGSUNG DI SINI
            if ($result_filtered_books && $result_filtered_books->num_rows > 0) {
                // Perulangan untuk setiap baris data buku
                while ($row = $result_filtered_books->fetch_assoc()) {
                    // Pemrosesan data yang sebelumnya ada di dalam fungsi
                    $rating_value = floatval($row['rating']);
                    $full_stars = floor($rating_value);
                    $half_star = ($rating_value - $full_stars >= 0.5);
                    $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);
            ?>
      <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
        <div class="card book-card shadow-sm h-100">
          <a href="detailBuku.php?id=<?php echo $row['id_buku']; ?>">
            <img src="<?php echo htmlspecialchars($row['cover_url']); ?>" class="card-img-top"
              alt="Cover <?php echo htmlspecialchars($row['judul']); ?>" style="height: 250px; object-fit: cover;" />
          </a>
          <div class="card-body d-flex flex-column">
            <h5 class="card-title text-truncate"><?php echo htmlspecialchars($row['judul']); ?></h5>
            <p class="card-text text-muted small text-truncate"><?php echo htmlspecialchars($row['nama_penulis']); ?>
            </p>
            <div class="d-flex justify-content-between align-items-center mb-2">
              <span class="badge bg-primary"><?php echo htmlspecialchars($row['kategori'] ?? 'Umum'); ?></span>
            </div>
            <div class="rating-stars mb-2">
              <?php
                                    for ($i = 0; $i < $full_stars; $i++) { echo '<i class="fas fa-star text-warning"></i>'; }
                                    if ($half_star) { echo '<i class="fas fa-star-half-alt text-warning"></i>'; }
                                    for ($i = 0; $i < $empty_stars; $i++) { echo '<i class="far fa-star text-warning"></i>'; }
                                    ?>
              <span>(<?php echo number_format($rating_value, 1); ?>)</span>
            </div>
            <div class="mt-auto">
              <div class="d-flex justify-content-between align-items-center">
                <span class="text-success fw-bold">Rp
                  <?php echo number_format($row['harga_sewa'], 0, ',', '.'); ?></span>
                <a href="detailBuku.php?id=<?php echo $row['id_buku']; ?>" class="btn btn-sm btn-info"
                  title="Lihat Detail">
                  Detail
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
                } // Akhir dari loop while
            } else {
                // Pesan jika tidak ada buku ditemukan
                echo "<div class='col-12'><p class='alert alert-warning text-center'>Tidak ada buku yang ditemukan untuk kategori ini.</p></div>";
            }
            ?>
    </div>

    <div class="text-center mt-5">
      <a href="kategori.php" class="btn btn-warning"><i class="fas fa-arrow-left me-2"></i>Kembali ke Semua Kategori</a>
    </div>
  </main>

  <?php 
      include("../modular/footerFitur.php"); 
      $stmt->close();
      $conn->close();
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