<?php
// Data buku (simulasi data dari database)
$bukuList = [
    [
        "id" => 1,
        "judul" => "Hujan",
        "penulis" => "Tere Liye",
        "penerbit" => "ronaltama",
        "tahun_terbit" => 2024,
        "deskripsi" => "Buku ini bercerita tentang hujan yang terjadi.",
        "cover" => "../img/Buku cover jdul/fiksi/Hujan_Tere Liye.jpg"
    ],
    [
        "id" => 2,
        "judul" => "Mastering Laravel",
        "penulis" => "Jane Smith",
        "penerbit" => "Web Dev Publisher",
        "tahun_terbit" => 2022,
        "deskripsi" => "Panduan lengkap untuk menguasai framework Laravel.",
        "cover" => "../img/Buku cover jdul/fiksi/Amba_Laksmi Pamunjak.jpg"
    ],
    [
        "id" => 3,
        "judul" => "JavaScript Modern",
        "penulis" => "Alice Johnson",
        "penerbit" => "Frontend Publisher",
        "tahun_terbit" => 2021,
        "deskripsi" => "Pelajari JavaScript modern dengan contoh praktis.",
        "cover" => "../img/Buku cover jdul/fiksi/Bulan_Tere Liye.jpg"
    ]
];

// Pilih salah satu buku untuk ditampilkan (contoh: buku pertama)
$buku = $bukuList[0];
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Buku</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  .buttonberanda {
    background-color: #ffc107;
    border-radius: 5px;
    width: 100px;
    height: 40px;
  }

  body {
    background-color: #f8f9fa;
    padding-top: 70px;
  }

  .card {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .card-header {
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: white;
    text-align: center;
    padding: 20px;
  }

  .card-header h3 {
    margin: 0;
    font-size: 1.8rem;
  }

  .btn-custom {
    width: 120px;
    font-weight: bold;
  }

  .btn-custom:hover {
    transform: scale(1.05);
  }

  .btn-success {
    background-color: #28a745;
    border: none;
  }

  .btn-warning {
    background-color: #ffc107;
    border: none;
  }

  .btn-secondary {
    margin-top: 15px;
  }

  .img-fluid {
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }
  </style>
</head>

<body>
  <?php
    include("../modular/headerBack.php");
    ?>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h3>Detail Buku</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <!-- Cover Buku -->
          <div class="col-md-4 text-center">
            <img src="<?php echo htmlspecialchars($buku['cover']); ?>" alt="Cover Buku" class="img-fluid">
          </div>
          <!-- Detail Buku -->
          <div class="col-md-8">
            <h5 class="card-title"><strong>Judul:</strong> <?php echo htmlspecialchars($buku['judul']); ?></h5>
            <p class="card-text"><strong>Penulis:</strong> <?php echo htmlspecialchars($buku['penulis']); ?></p>
            <p class="card-text"><strong>Penerbit:</strong> <?php echo htmlspecialchars($buku['penerbit']); ?></p>
            <p class="card-text"><strong>Tahun Terbit:</strong> <?php echo htmlspecialchars($buku['tahun_terbit']); ?>
            </p>
            <p class="card-text"><strong>Deskripsi:</strong> <?php echo nl2br(htmlspecialchars($buku['deskripsi'])); ?>
            </p>
            <!-- Tombol Sewa dan Beli -->
            <div class="mt-3">
              <a href="#" class="btn btn-success btn-custom">Sewa Buku</a>
              <a href="#" class="btn btn-warning btn-custom">Beli Buku</a>
            </div>
            <a href="../index.php" class="btn btn-secondary mt-3">Kembali ke Daftar Buku</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <br>
  <br>
  <?php
    include("../modular/footerFitur.php");
    ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>