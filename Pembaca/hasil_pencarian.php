<?php
// Bagian Logika/Proses - Tetap di paling atas
include("../koneksi.php");


$hasil_pencarian = [];
$search_query = '';

if (isset($_GET['query']) && !empty(trim($_GET['query']))) {
    $search_query = trim($_GET['query']);
    $search_term = "%" . $search_query . "%";

    // --- PERUBAHAN 3: QUERY CASE-INSENSITIVE ---
    // Menggunakan LOWER() pada kolom database dan placeholder '?'
    // untuk memastikan pencarian tidak membedakan huruf besar/kecil.
    $sql_search = "SELECT
                      b.id_buku, b.judul, p.username AS nama_penulis, b.cover_url,
                      b.tanggal_upload, b.rating, b.harga_sewa, b.kategori
                   FROM buku b
                   JOIN penulis p ON b.id_penulis = p.id_penulis
                   WHERE
                      b.status_verifikasi = 'terverifikasi' AND
                      (LOWER(b.judul) LIKE LOWER(?) OR LOWER(p.username) LIKE LOWER(?))
                   ORDER BY b.rating DESC";

    $stmt = $conn->prepare($sql_search);
    $stmt->bind_param("ss", $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $hasil_pencarian[] = $row;
        }
    }
    $stmt->close();
}

function displayBookCards($buku, $badge_class = 'bg-secondary') {
    $formatted_date = date("j F Y", strtotime($buku['tanggal_upload']));
    $full_stars = floor($buku['rating']);
    $half_star = ($buku['rating'] - $full_stars >= 0.5);
    $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);
?>
<div class="book-card">
  <div class="card shadow-sm h-100">
    <a href="detailBuku.php?id=<?php echo $buku['id_buku']; ?>" class="card-img-top-container">
      <img src="<?php echo htmlspecialchars($buku['cover_url']); ?>" class="card-img-top" alt="Cover" />
    </a>
    <div class="card-body d-flex flex-column">
      <h5 class="card-title text-truncate"><?php echo htmlspecialchars($buku['judul']); ?></h5>
      <p class="card-text text-muted small text-truncate"><?php echo htmlspecialchars($buku['nama_penulis']); ?></p>
      <div class="d-flex justify-content-between align-items-center mb-2">
        <span
          class="badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($buku['kategori'] ?? 'Umum'); ?></span>
        <small class="text-muted"><?php echo $formatted_date; ?></small>
      </div>
      <div class="rating-stars mb-2">
        <?php
                for ($i = 0; $i < $full_stars; $i++) echo '<i class="fas fa-star text-warning"></i>';
                if ($half_star) echo '<i class="fas fa-star-half-alt text-warning"></i>';
                for ($i = 0; $i < $empty_stars; $i++) echo '<i class="far fa-star text-warning"></i>';
                ?>
        <span>(<?php echo number_format($buku['rating'], 1); ?>)</span>
      </div>
      <div class="mt-auto text-end">
        <span class="text-success fw-bold">Sewa Rp <?php echo number_format($buku['harga_sewa'], 0, ',', '.'); ?></span>
      </div>
    </div>
  </div>
</div>
<?php
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Hasil Pencarian - Buku Digital</title>

  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="../style.css" />

  <style>
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
    width: 250px;
    /* Sesuaikan lebar kartu buku */
    flex-shrink: 0;
    /* Penting untuk mencegah item menyusut dalam flexbox */
  }

  */ .book-card .card-img-top {
    height: 400px;
    /* Tinggi gambar cover yang konsisten */
    object-fit: cover;
    /* Menjaga rasio aspek gambar */
  }
  </style>
</head>

<body>

  <?php
    include("../modular/headerPembaca.php");
  ?>

  <main class="container mt-5" style="margin-top: 120px !important;">
    <section class="mb-5">
      <h3 class="mb-4">
        <?php if (!empty($search_query)): ?>
        Hasil Pencarian untuk: <span class="text-success"><?php echo htmlspecialchars($search_query); ?></span>
        <?php else: ?>
        Silakan masukkan kata kunci pencarian pada kolom di atas.
        <?php endif; ?>
      </h3>

      <?php if (!empty($search_query)): ?>
      <?php if (!empty($hasil_pencarian)): ?>
      <p class="text-muted">Ditemukan <?php echo count($hasil_pencarian); ?> buku yang cocok.</p>
      <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-4">
        <?php
            foreach ($hasil_pencarian as $buku) {
              displayBookCards($buku, 'bg-info');
            }
            ?>
      </div>
      <?php else: ?>
      <div class="text-center py-5">
        <i class="fas fa-search fa-3x text-muted mb-3"></i>
        <h4>Oops! Tidak Ada Hasil</h4>
        <p class="text-muted">Kami tidak dapat menemukan buku yang cocok dengan kata kunci
          "<?php echo htmlspecialchars($search_query); ?>".<br>Coba gunakan kata kunci yang lain.</p>
      </div>
      <?php endif; ?>
      <?php endif; ?>
    </section>
  </main>

  <?php
    include("../modular/footer.php");
    $conn->close();
  ?>

  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../script.js"></script>
</body>

</html>