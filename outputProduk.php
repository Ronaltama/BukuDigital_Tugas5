<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_produk = $_POST["nama_produk"];
    $harga = $_POST["harga"];
    $deskripsi = $_POST["deskripsi"];
    
    // Simpan gambar ke folder uploads
    $gambar = $_FILES["gambar"]["name"];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($gambar);
    move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-success text-white">Detail Produk</div>
        <div class="card-body">
            <h3><?= htmlspecialchars($nama_produk) ?></h3>
            <p><strong>Harga:</strong> Rp<?= number_format($harga, 0, ',', '.') ?></p>
            <p><?= nl2br(htmlspecialchars($deskripsi)) ?></p>
            <img src="<?= $target_file ?>" alt="Gambar Produk" class="img-fluid" width="300">
            <br><br>
            <a href="index.php" class="btn btn-primary">Input Produk Lain</a>
        </div>
    </div>
</div>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
