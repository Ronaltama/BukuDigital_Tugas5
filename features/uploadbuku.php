<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Unggah Buku</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: Arial, sans-serif;
    }

    .card {
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      background-color: #0d6efd;
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
  <?php include("../modular/headerBack.php"); ?>

  <div class="container mt-5 pt-5">
    <div class="card">
      <div class="card-header">Form Unggah Buku</div>
      <div class="card-body">
        <form id="unggahBukuForm" action="outputProduk.php" method="POST" enctype="multipart/form-data">
          
          <div class="mb-3">
            <label class="form-label">Judul Buku</label>
            <input type="text" name="judul_buku" class="form-control" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Nama Penulis</label>
            <input type="text" name="penulis" class="form-control" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="kategori" class="form-select" required>
              <option value="">-- Pilih Kategori --</option>
              <option value="fiksi">Fiksi</option>
              <option value="non-fiksi">Non-Fiksi</option>
              <option value="pendidikan">Pendidikan</option>
              <option value="novel">Novel</option>
              <option value="komik">Komik</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Tanggal Rilis</label>
            <input type="date" name="tanggal_rilis" class="form-control" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Harga Sewa</label>
            <div class="input-group">
              <span class="input-group-text">Rp</span>
              <input type="number" name="harga_sewa" class="form-control" placeholder="Harga sewa" required />
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Ketersediaan</label><br>
            <input type="radio" name="ketersediaan" value="tersedia" required> Tersedia
            <input type="radio" name="ketersediaan" value="tidak tersedia"> Tidak Tersedia
          </div>

          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Cover Buku</label>
            <input type="file" name="cover" class="form-control" accept="image/*" id="imageInput" required />
            <img id="imagePreview" class="img-fluid preview-image" src="#" alt="Preview Cover Buku" />
          </div>

          <button type="submit" class="btn btn-success">Unggah Buku</button>
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
