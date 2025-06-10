<?php
session_start();
include("../koneksi.php"); // Pastikan ini file koneksi ke database
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek apakah pembaca sudah login
$id_pembaca = $_SESSION['id_pembaca'] ?? null;

if (!$id_pembaca) {
  echo "<p class='text-danger text-center'>Anda belum login sebagai pembaca.</p>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perpustakaan Digital</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      background-color: #f8f9fa;
      padding-top: 70px;
    }

    .card-img-top {
      height: auto;
      max-height: 300px;
      object-fit: contain;
      background-color: #f8f9fa;
    }

    .book-card {
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .book-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body>
  <!-- Header -->
  <?php include("../modular/headerPembaca.php"); ?>

  <!-- Main Content -->
  <div class="container">
    <h2 class="text-center text-primary mb-4">Buku Anda</h2>
    <div class="row row-cols-1 row-cols-md-4 g-4">
      <?php
      
      $id_pembaca = $_SESSION['id_pembaca'];
      $sql = "SELECT buku.*
              FROM sewa
              JOIN buku ON sewa.id_buku = buku.id_buku
              WHERE sewa.id_pembaca = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $id_pembaca);
      $stmt->execute();
      $result = $stmt->get_result();


      while ($row = $result->fetch_assoc()) {
        $cover = $row['cover'] ?? 'default.jpg';
      ?>
        <div class="col">
          <div class="card h-100 book-card">
            <img src="../cover/<?= htmlspecialchars($cover) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['judul']) ?>">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
              <p class="card-text"><?= htmlspecialchars($row['penulis']) ?></p>
              <!-- Tombol detail bisa diarahkan ke halaman detail -->
              <a href="detail.php?id=<?= $row['id_buku'] ?>" class="btn btn-primary btn-sm">Detail</a>
            </div>
          </div>
        </div>
      <?php
      }
      ?>
    </div>
  </div>

  <br><br>
  <!-- Footer -->
  <?php include("../modular/footerFitur.php"); ?>

  <script src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
