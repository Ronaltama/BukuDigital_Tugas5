<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
    /* Sesuaikan dengan tinggi header dan navbar */
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
    <h2 class="text-center text-primary mb-4">Perpustakaan Digital</h2>
    <div class="row row-cols-1 row-cols-md-4 g-4">
      <!-- Buku 1 -->
      <div class="col">
        <div class="card book-card shadow-sm h-100">
          <img src="../img/Buku cover jdul/fiksi/Cantik itu Luka_Eka Kurniawan.jpg" class="card-img-top"
            alt="Cantik itu Luka">
          <div class="card-body">
            <h5 class="card-title">Cantik itu Luka</h5>
            <p class="card-text text-muted small">Eka Kurniawan</p>
          </div>
        </div>
      </div>

      <!-- Buku 2 -->
      <div class="col">
        <div class="card book-card shadow-sm h-100">
          <img src="../img/Buku cover jdul/fiksi/Laskar Pelangi_Andrea Hirata.jpg" class="card-img-top"
            alt="Laskar Pelangi">
          <div class="card-body">
            <h5 class="card-title">Laskar Pelangi</h5>
            <p class="card-text text-muted small">Andrea Hirata</p>
          </div>
        </div>
      </div>

      <!-- Buku 3 -->
      <div class="col">
        <div class="card book-card shadow-sm h-100">
          <img src="../img/Buku cover jdul/fiksi/Amba_Laksmi Pamunjak.jpg" class="card-img-top" alt="Amba">
          <div class="card-body">
            <h5 class="card-title">Amba</h5>
            <p class="card-text text-muted small">Laksmi Pamunjak</p>
          </div>
        </div>
      </div>

      <!-- Buku 4 -->
      <div class="col">
        <div class="card book-card shadow-sm h-100">
          <img src="../img/Buku cover jdul/fiksi/Bulan_Tere Liye.jpg" class="card-img-top" alt="Bulan">
          <div class="card-body">
            <h5 class="card-title">Bulan</h5>
            <p class="card-text text-muted small">Tere Liye</p>
          </div>
        </div>
      </div>

      <!-- Buku 5 -->
      <div class="col">
        <div class="card book-card shadow-sm h-100">
          <img src="../img/Buku cover jdul/fiksi/Hujan_Tere Liye.jpg" class="card-img-top" alt="Hujan">
          <div class="card-body">
            <h5 class="card-title">Hujan</h5>
            <p class="card-text text-muted small">Tere Liye</p>
          </div>
        </div>
      </div>

      <!-- Buku 6 -->
      <div class="col">
        <div class="card book-card shadow-sm h-100">
          <img src="../img/Buku cover jdul/fiksi/Sisi Tergelap Surga_Brian Krisna.jpg" class="card-img-top"
            alt="Sisi Tergelap Suara">
          <div class="card-body">
            <h5 class="card-title">Sisi Tergelap Surga</h5>
            <p class="card-text text-muted small">Brian Krisna</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <br>
  <br>
  <!-- Footer -->
  <?php include("../modular/footerFitur.php"); ?>

  <script src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>