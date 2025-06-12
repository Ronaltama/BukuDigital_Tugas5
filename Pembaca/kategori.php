<?php
// Sisipkan file koneksi untuk menghubungkan ke database
include("../koneksi.php");
// Inisialisasi array untuk memetakan nama kategori ke kelas ikon Font Awesome
$icon_map = [
    'Fiksi' => 'fas fa-book-open',
    'Teknologi' => 'fas fa-laptop-code',
    'Bisnis' => 'fas fa-chart-line',
    'Romansa' => 'fas fa-heart',
    'Sains' => 'fas fa-flask',
    'Geografi' => 'fas fa-globe-asia',
    'Musik' => 'fas fa-music',
    'Seni' => 'fas fa-paint-brush',
    'Lingkungan' => 'fas fa-leaf',
    'Non Fiksi' => 'fas fa-brain',
    'Non-Fiksi' => 'fas fa-brain' // Menangani variasi penulisan
];
// Ikon default jika kategori tidak ada dalam pemetaan
$default_icon = 'fas fa-book';
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kategori Buku Digital</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../style.css" />

  <style>
  :root {
    --primary-color: #4a4a6a;
    --secondary-color: #6b7caa;
    --accent-color: #e5e9f2;
    --text-color: #2c3e50;
    --background-color: #f4f6f9;
  }

  .category-link {
    text-decoration: none;
  }

  .category-card {
    transition: all 0.3s ease;
    cursor: pointer;
    background: white;
    border: none;
    box-shadow: 0 8px 15px rgba(76, 87, 128, 0.1);
    border-radius: 12px;
    overflow: hidden;
    height: 100%;
    /* Membuat semua kartu memiliki tinggi yang sama */
  }

  .category-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 25px rgba(76, 87, 128, 0.15);
  }

  .category-card-icon {
    color: var(--secondary-color);
    margin-bottom: 15px;
    transition: transform 0.3s ease;
  }

  .category-card:hover .category-card-icon {
    transform: scale(1.1);
  }

  .page-title {
    color: var(--primary-color);
    font-weight: 700;
    position: relative;
  }

  .page-title::after {
    content: "";
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 3px;
    background: var(--secondary-color);
  }
  </style>
</head>

<body>
  <?php include("../modular/headerPembaca.php"); ?>

  <div class="container mt-4">
    <h2 class="text-center mb-5 page-title">Temukan Dunia Buku Digital Anda</h2>
    <div class="row g-4">
      <?php
      // Query untuk mengambil kategori yang unik dari buku yang sudah terverifikasi
      $query = "SELECT DISTINCT kategori FROM buku WHERE status_verifikasi = 'terverifikasi' ORDER BY kategori ASC";
      $result = $conn->query($query);

      // Periksa apakah ada kategori yang ditemukan
      if ($result->num_rows > 0) {
          // Loop melalui setiap baris hasil query
          while ($row = $result->fetch_assoc()) {
              $kategori = $row['kategori'];
              // Tentukan ikon berdasarkan pemetaan, atau gunakan ikon default
              $icon_class = isset($icon_map[$kategori]) ? $icon_map[$kategori] : $default_icon;
      ?>
      <div class="col-md-4">
        <a href="daftar_buku.php?kategori=<?php echo urlencode($kategori); ?>" class="category-link">
          <div class="card category-card text-center p-4">
            <div class="category-card-icon mb-3">
              <i class="<?php echo $icon_class; ?>" style="font-size: 3rem"></i>
            </div>
            <h5 class="card-title mb-3" style="color: var(--primary-color)"><?php echo htmlspecialchars($kategori); ?>
            </h5>
            <p class="text-muted">Lihat semua buku dalam kategori <?php echo htmlspecialchars(strtolower($kategori)); ?>
            </p>
          </div>
        </a>
      </div>
      <?php
          }
      } else {
          // Tampilkan pesan jika tidak ada kategori yang ditemukan
          echo "<p class='text-center'>Tidak ada kategori buku yang tersedia saat ini.</p>";
      }
      // Tutup koneksi database
      $conn->close();
      ?>
    </div>
  </div>

  <br><br><br><br><br> <br><br>
  <?php include("../modular/footerFitur.php"); ?>





  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>