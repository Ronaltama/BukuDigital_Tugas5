<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kategori Buku Digital</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../style.css" />

  <style>
  .buttonberanda {
    background-color: #ffc107;
    border-radius: 5px;
    width: 100px;
    height: 40px;
  }

  :root {
    --primary-color: #4a4a6a;
    --secondary-color: #6b7caa;
    --accent-color: #e5e9f2;
    --text-color: #2c3e50;
    --background-color: #f4f6f9;
  }

  html,
  body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
  }

  body {
    background: var(--background-color);
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    color: var(--text-color);
    padding-top: 70px;
    /* Menghindari navbar tertutup header */
  }

  .container {
    flex: 1;
  }

  footer {
    margin-top: auto;
    width: 100%;
  }

  .category-card {
    transition: all 0.3s ease;
    cursor: pointer;
    background: white;
    border: none;
    box-shadow: 0 8px 15px rgba(76, 87, 128, 0.1);
    transform-origin: center;
    border-radius: 12px;
    overflow: hidden;
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
  <?php include("../modular/headerBack.php"); ?>

  <!-- Kategori Buku -->
  <div class="container mt-4">
    <h2 class="text-center mb-5 page-title">Temukan Dunia Buku Digital Anda</h2>
    <div class="row g-4">
      <!-- Kategori 1 -->
      <div class="col-md-4">
        <div class="card category-card text-center p-4 position-relative">
          <div class="category-card-icon mb-3">
            <i class="fas fa-book-open" style="font-size: 3rem"></i>
          </div>
          <h5 class="card-title mb-3" style="color: var(--primary-color)">Fiksi</h5>
          <p class="text-muted">Jelajahi dunia imajinasi tanpa batas</p>
        </div>
      </div>

      <!-- Kategori 2 -->
      <div class="col-md-4">
        <div class="card category-card text-center p-4 position-relative">
          <div class="category-card-icon mb-3">
            <i class="fas fa-laptop" style="font-size: 3rem"></i>
          </div>
          <h5 class="card-title mb-3" style="color: var(--primary-color)">Teknologi</h5>
          <p class="text-muted">Update pengetahuan digital terkini</p>
        </div>
      </div>

      <!-- Kategori 3 -->
      <div class="col-md-4">
        <div class="card category-card text-center p-4 position-relative">
          <div class="category-card-icon mb-3">
            <i class="fas fa-chart-line" style="font-size: 3rem"></i>
          </div>
          <h5 class="card-title mb-3" style="color: var(--primary-color)">Bisnis</h5>
          <p class="text-muted">Strategi dan wawasan pengembangan usaha</p>
        </div>
      </div>

      <!-- Kategori 4 -->
      <div class="col-md-4">
        <div class="card category-card text-center p-4 position-relative">
          <div class="category-card-icon mb-3">
            <i class="fas fa-heart" style="font-size: 3rem"></i>
          </div>
          <h5 class="card-title mb-3" style="color: var(--primary-color)">Romansa</h5>
          <p class="text-muted">Cerita cinta yang menginspirasi</p>
        </div>
      </div>

      <!-- Kategori 5 -->
      <div class="col-md-4">
        <div class="card category-card text-center p-4 position-relative">
          <div class="category-card-icon mb-3">
            <i class="fas fa-flask" style="font-size: 3rem"></i>
          </div>
          <h5 class="card-title mb-3" style="color: var(--primary-color)">Sains</h5>
          <p class="text-muted">Pengetahuan ilmiah yang menarik</p>
        </div>
      </div>

      <!-- Kategori 6 -->
      <div class="col-md-4">
        <div class="card category-card text-center p-4 position-relative">
          <div class="category-card-icon mb-3">
            <i class="fas fa-globe" style="font-size: 3rem"></i>
          </div>
          <h5 class="card-title mb-3" style="color: var(--primary-color)">Geografi</h5>
          <p class="text-muted">Eksplorasi dunia dan budaya</p>
        </div>
      </div>

      <!-- Tambahkan lebih banyak kategori -->
      <div class="col-md-4">
        <div class="card category-card text-center p-4 position-relative">
          <div class="category-card-icon mb-3">
            <i class="fas fa-music" style="font-size: 3rem"></i>
          </div>
          <h5 class="card-title mb-3" style="color: var(--primary-color)">Musik</h5>
          <p class="text-muted">Dunia musik dan harmoni</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card category-card text-center p-4 position-relative">
          <div class="category-card-icon mb-3">
            <i class="fas fa-paint-brush" style="font-size: 3rem"></i>
          </div>
          <h5 class="card-title mb-3" style="color: var(--primary-color)">Seni</h5>
          <p class="text-muted">Kreativitas tanpa batas</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card category-card text-center p-4 position-relative">
          <div class="category-card-icon mb-3">
            <i class="fas fa-tree" style="font-size: 3rem"></i>
          </div>
          <h5 class="card-title mb-3" style="color: var(--primary-color)">Lingkungan</h5>
          <p class="text-muted">Pelajari dunia hijau</p>
        </div>
      </div>
    </div>
  </div>

  <br>
  <br>

  <?php include("../modular/footerFitur.php"); ?>

  <!-- Bootstrap JS -->
  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Font Awesome untuk ikon -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"
    integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMN8Q4zF1RX6iD9E7z5q6U6y5R6F5F5F5F5F5F5" crossorigin="anonymous">
  </script>
</body>

</html>