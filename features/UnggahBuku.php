<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Unggah Buku</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="../style.css" />
  <style>
  /* ... your existing styles ... */
  </style>
</head>

<body>

  <?php
    include("../modular/headerFeatures.php");
    ?>
  <div class="container mt-5 pt-3">

    <h2 class="text-center text-success mb-4">Unggah Buku</h2>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container mt-5">
      <div class="card shadow-lg border-0">
        <div class="card-header bg-warning text-dark">
          <h4 class="mb-0">Informasi Buku</h4>
        </div>
        <div class="card-body">

          <form action="Proses_Unggah.php" method="POST" enctype="multipart/form-data">

            <div class="mb-3">
              <label for="cover" class="form-label">Cover Buku</label>
              <input type="file" class="form-control" id="cover" name="cover" accept="image/*" required>
            </div>

            <div class="mb-3">
              <label for="file_buku" class="form-label">Unggah File Buku (PDF)</label>
              <input class="form-control" type="file" id="file_buku" name="file_buku" accept="application/pdf"
                required />
              <small class="text-muted">Hanya file PDF yang diizinkan.</small>
            </div>

            <div class="mb-3">
              <label for="judul" class="form-label">Judul</label>
              <input type="text" class="form-control" id="judul" name="judul" required>
            </div>

            <div class="mb-3">
              <label for="deskripsi" class="form-label">Deskripsi</label>
              <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5"
                placeholder="Ketikan deskripsi singkat buku mu"></textarea>
            </div>

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

            <div class="mb-3">
              <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
              <input type="date" class="form-control" id="tanggal_terbit" name="tanggal_terbit" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Harga Sewa</label>
              <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number" name="harga_sewa" class="form-control" placeholder="Harga sewa" required />
              </div>
            </div>

            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="persetujuan" required>
              <label class="form-check-label" for="persetujuan">Informasi buku sudah sesuai</label>
            </div>

            <button type="submit" name="upload" class="btn btn-warning w-100 fw-bold">Unggah Buku</button>
          </form>

        </div>
      </div>
    </div>
    <br>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../script.js"></script>
    <script>
    // Preview cover buku
    document.getElementById('cover').addEventListener('change', function(event) {
      const reader = new FileReader();
      const previewImage = document.createElement('img');
      previewImage.classList.add('img-thumbnail', 'preview-image');
      const coverLabel = this.previousElementSibling;
      if (this.parentNode.contains(document.querySelector('.preview-image'))) {
        this.parentNode.removeChild(document.querySelector('.preview-image'));
      }
      this.parentNode.insertBefore(previewImage, this);

      reader.onload = function(e) {
        previewImage.src = e.target.result;
        previewImage.style.display = 'block';
      }
      reader.readAsDataURL(event.target.files[0]);
    });

    // Validasi harga sewa
    document.querySelector('form').addEventListener('submit', function(event) {
      const hargaSewaInput = this.querySelector('input[name="harga_sewa"]');
      if (hargaSewaInput && parseFloat(hargaSewaInput.value) <= 0) {
        event.preventDefault();
        alert('Harga sewa harus lebih dari 0!');
      }
    });
    </script>



</body>

</html>