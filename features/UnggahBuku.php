<!-- inputProduk.php -->/
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Unggah Buku</title>
<<<<<<< Updated upstream:features/UnggahBuku.php
  <!-- Bootstrap CSS -->
=======
>>>>>>> Stashed changes:features/inputProduk.php
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <style>
    body {
      background-color: #f8f9fa;
      font-family: Arial, sans-serif;
    }

    .card {
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    card-header {
      background-color:rgb(253, 185, 13);
      color: white;
    }

    .preview-image {
      max-height: 200px;
      margin-top: 10px;
      display: none;
    }
  </style>
</head>

<body>
  <?php
    include("../modular/headerBack.php");
    ?>


  <div class="container mt-5 pt-5">
<<<<<<< Updated upstream:features/UnggahBuku.php
    <div class="card">
      <div class="card-header">Informasi Buku</div>
      <div class="card-body">
        <form id="produkForm" action="outputProduk.php" method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="Judul Buku" class="form-control" required />
          </div>
          <div class="mb-3">
            <label class="form-label">N</label>
            <input type="text" name="penjual" class="form-control" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Tanggal Rilis</label>
            <input type="date" name="tanggal_rilis" class="form-control" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Harga</label>
=======
    <h2 class="text-center text-success mb-4">Unggah Buku</h2>

    <!-- Bootstrap CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
  <div class="card shadow-lg border-0">
    <div class="card-header bg-warning text-dark">
      <h4 class="mb-0">Informasi Buku</h4>
    </div>
    <div class="card-body">

    <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Sewa</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
          </div>

      <form action="proses_upload.php" method="POST" enctype="multipart/form-data">

        <!-- Cover Buku -->
        <div class="mb-3">
          <label for="cover" class="form-label">Cover Buku</label>
          <input type="file" class="form-control" id="cover" name="cover" accept="image/*" required>
        </div>

        <!-- Judul -->
        <div class="mb-3">
          <label for="judul" class="form-label">Judul</label>
          <input type="text" class="form-control" id="judul" name="judul" required>
        </div>

        <!-- Deskripsi -->
        <div class="mb-3">
          <label for="deskripsi" class="form-label">Deskripsi</label>
          <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
        </div>

        <!-- Kategori -->
        <div class="mb-3">
          <label for="kategori" class="form-label">Kategori</label>
          <select class="form-select" id="kategori" name="kategori" required>
            <option value="">Pilih Kategori</option>
            <option value="fiksi">Fiksi</option>
            <option value="non-fiksi">Non-Fiksi</option>
            <option value="pendidikan">Pendidikan</option>
            <option value="komik">Komik</option>
          </select>
        </div>

        <!-- Tanggal Terbit -->
        <div class="mb-3">
          <label for="tanggal" class="form-label">Tanggal Terbit</label>
          <input type="date" class="form-control" id="tanggal" name="tanggal" required>
        </div>

        <!-- Harga Sewa -->
        <div class="mb-3">
            <label class="form-label">Harga Sewa</label>
>>>>>>> Stashed changes:features/inputProduk.php
            <div class="input-group">
              <span class="input-group-text">Rp</span>
              <input type="number" name="harga_sewa" class="form-control" placeholder="Harga sewa" required />
            </div>
          </div>

        <!-- Checkbox -->
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="persetujuan" required>
          <label class="form-check-label" for="persetujuan">Informasi buku sudah sesuai</label>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-warning w-100 fw-bold">Unggah Buku</button>
      </form>

    </div>
  </div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Preview cover buku
    document.getElementById('imageInput').addEventListener('change', function(event) {
      const reader = new FileReader();
      const previewImage = document.getElementById('imagePreview');
      reader.onload = function(e) {
        previewImage.src = e.target.result;
        previewImage.style.display = 'block';
      }
      reader.readAsDataURL(event.target.files[0]);
    });

    // Validasi harga sewa
    document.getElementById('unggahBukuForm').addEventListener('submit', function(event) {
      const hargaSewa = document.querySelector('input[name="harga_sewa"]').value;
      if (hargaSewa <= 0) {
        event.preventDefault();
        alert('Harga sewa harus lebih dari 0!');
      }
    });
  </script>

  <?php include("../modular/footerFitur.php"); ?>
</body>

</html>
<<<<<<< Updated upstream:features/UnggahBuku.php

=======
>>>>>>> Stashed changes:features/inputProduk.php
