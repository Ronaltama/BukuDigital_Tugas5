<?php
include '../koneksi.php';

$idBuku = $_GET['id'] ?? '';

$sql = "SELECT buku.*, penulis.username 
        FROM buku 
        JOIN penulis ON buku.id_penulis = penulis.id_penulis 
        WHERE buku.id_buku = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $idBuku);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$buku = mysqli_fetch_assoc($result);

if (!$buku) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Buku tidak ditemukan.</div></div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Detail Buku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  body {
    background-color: #f8f9fa;
    padding-top: 40px;
  }

  .card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  .card-header {
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: white;
    text-align: center;
    padding: 20px;
  }

  .btn-custom {
    width: 120px;
    font-weight: bold;
  }

  .img-fluid {
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  }
  </style>
</head>

<body>
  <div class="container mt-5">
    <div class="card">
      <div class="card-header">
        <h3>Detail Buku</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <!-- Gambar -->
          <div class="col-md-4 text-center">
            <img src="<?php echo htmlspecialchars($buku['cover_url']); ?>" alt="Cover Buku" class="img-fluid">
          </div>
          <!-- Detail -->
          <div class="col-md-8">
            <h5><strong>Judul:</strong> <?php echo htmlspecialchars($buku['judul']); ?></h5>
            <p><strong>Penulis:</strong> <?php echo htmlspecialchars($buku['username']); ?></p>
            <p><strong>Tahun Terbit:</strong> <?php echo htmlspecialchars($buku['tanggal_upload']); ?></p>
            <p><strong>Deskripsi:</strong> <?php echo nl2br(htmlspecialchars($buku['deskripsi'])); ?></p>

            <!-- Tombol Sewa -->
            <div class="mt-3">
              <a href="../features/loginpage.php?action=sewa&id=<?php echo htmlspecialchars($buku['id_buku']); ?>"
                class="btn btn-success btn-custom">
                Sewa Buku
              </a>
            </div>
            <a href="berandaPenulis.php" class="btn btn-secondary mt-3">Kembali</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>