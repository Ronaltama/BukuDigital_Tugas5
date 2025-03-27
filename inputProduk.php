<!-- inputProduk.php -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Input Produk Digital</title>
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
      .preview-image {
        max-height: 200px;
        margin-top: 10px;
        display: none;
      }
    </style>
  </head>
  <body>
    <header class="bg-dark py-2 fixed-top">
      <div class="container d-flex justify-content-between align-items-center">
        <h3 class="text-light">Input Produk Digital</h3>
        <a href="index.html" class="btn btn-warning">Beranda</a>
      </div>
    </header>

    <div class="container mt-5 pt-5">
      <div class="card">
        <div class="card-header">Form Input Produk Digital</div>
        <div class="card-body">
          <form id="produkForm" action="outputProduk.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label class="form-label">Nama Produk</label>
              <input type="text" name="nama" class="form-control" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Nama Penjual</label>
              <input type="text" name="penjual" class="form-control" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Tanggal Rilis</label>
              <input type="date" name="tanggal_rilis" class="form-control" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Harga</label>
              <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number" name="harga_beli" class="form-control" placeholder="Harga beli" required />
                <span class="input-group-text">/</span>
                <input type="number" name="harga_sewa" class="form-control" placeholder="Harga sewa" required />
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Opsi Pembelian</label><br>
              <input type="checkbox" name="opsi[]" value="beli"> Beli
              <input type="checkbox" name="opsi[]" value="sewa"> Sewa
            </div>
            <div class="mb-3">
              <label class="form-label">Ketersediaan</label><br>
              <input type="radio" name="ketersediaan" value="tersedia" required> Tersedia
              <input type="radio" name="ketersediaan" value="tidak tersedia"> Tidak Tersedia
            </div>
            <div class="mb-3">
              <label class="form-label">Deskripsi</label>
              <textarea name="deskripsi" class="form-control" rows="4"></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Gambar Produk</label>
              <input type="file" name="gambar" class="form-control" accept="image/*" id="imageInput" required />
              <img id="imagePreview" class="img-fluid preview-image" src="#" alt="Preview Gambar Produk" />
            </div>
              <button type="submit" class="btn btn-success">Simpan Produk</button>
           
          </form>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Image preview
      document.getElementById('imageInput').addEventListener('change', function(event) {
        const reader = new FileReader();
        const previewImage = document.getElementById('imagePreview');
        reader.onload = function(e) {
          previewImage.src = e.target.result;
          previewImage.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
      });

      // Form validation
      document.getElementById('produkForm').addEventListener('submit', function(event) {
        const hargaBeli = document.querySelector('input[name="harga_beli"]').value;
        const hargaSewa = document.querySelector('input[name="harga_sewa"]').value;
        if (hargaBeli <= 0 || hargaSewa <= 0) {
          event.preventDefault();
          alert('Harga beli dan harga sewa harus lebih dari 0!');
        }
      });
    </script>
  </body>
</html>
