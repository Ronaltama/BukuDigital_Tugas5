<!-- outputProduk.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #0d6efd;
            color: white;
        }
        .product-image {
            max-height: 300px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <header class="bg-dark py-2 fixed-top">
        <div class="container d-flex justify-content-between align-items-center">
            <h3 class="text-light">Detail Produk</h3>
            <a href="inputProduk.php" class="btn btn-warning">Input Produk Baru</a>
        </div>
    </header>

    <div class="container mt-5 pt-5">
        <div class="card">
            <div class="card-header">Detail Produk Digital</div>
            <div class="card-body">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $nama = htmlspecialchars($_POST['nama']);
                    $penjual = htmlspecialchars($_POST['penjual']);
                    $tanggal_rilis = htmlspecialchars($_POST['tanggal_rilis']);
                    $harga_beli = htmlspecialchars($_POST['harga_beli']);
                    $harga_sewa = htmlspecialchars($_POST['harga_sewa']);
                    $ketersediaan = htmlspecialchars($_POST['ketersediaan']);
                    $deskripsi = htmlspecialchars($_POST['deskripsi']);
                    $opsi = isset($_POST['opsi']) ? implode(", ", $_POST['opsi']) : "Tidak ada";
                    
                    // Handle file upload
                    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
                        $file_tmp = $_FILES['gambar']['tmp_name'];
                        $file_name = "uploads/" . time() . "_" . $_FILES['gambar']['name'];
                        move_uploaded_file($file_tmp, $file_name);
                    } else {
                        $file_name = "https://via.placeholder.com/300"; // Placeholder jika tidak ada gambar
                    }
                ?>
                    <div class="row">
                        <div class="col-md-4">
                            <img src="<?= $file_name ?>" alt="Gambar Produk" class="img-fluid product-image">
                        </div>
                        <div class="col-md-8">
                            <h3><?= $nama ?></h3>
                            <p><strong>Penjual:</strong> <?= $penjual ?></p>
                            <p><strong>Tanggal Rilis:</strong> <?= $tanggal_rilis ?></p>
                            <p><strong>Harga:</strong> Rp<?= number_format($harga_beli, 0, ',', '.') ?> (Beli) / Rp<?= number_format($harga_sewa, 0, ',', '.') ?> (Sewa)</p>
                            <p><strong>Opsi Pembelian:</strong> <?= $opsi ?></p>
                            <p><strong>Ketersediaan:</strong> <?= ucfirst($ketersediaan) ?></p>
                            <p><strong>Deskripsi:</strong> <?= nl2br($deskripsi) ?></p>
                        </div>
                    </div>
                <?php
                } else {
                    echo "<p class='text-danger'>Tidak ada data yang dikirim.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
