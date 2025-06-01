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
  .preview-image {
    max-width: 200px;
    max-height: 200px;
    margin-top: 10px;
    border: 1px solid #ddd;
    padding: 5px;
    display: none;
    /* Sembunyikan awal, tampilkan jika ada gambar */
  }

  /* Tambahan style lain jika ada */
  </style>
</head>

<body>

  <?php
    // Mulai session jika belum (seharusnya sudah dari header, tapi untuk keamanan ganda)
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include("../modular/headerPenulis.php"); // Pastikan headerPenulis.php juga memanggil session_start() jika perlu akses session
  ?>

  <div class="container mt-3"> <?php
    // Tampilkan pesan dari session jika ada
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-' . htmlspecialchars($_SESSION['msg_type']) . ' alert-dismissible fade show" role="alert">';
        echo htmlspecialchars($_SESSION['message']);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
        unset($_SESSION['message']);
        unset($_SESSION['msg_type']);
    }
    ?>
  </div>

  <div class="container mt-4 pt-3">
    <h2 class="text-center text-success mb-4">Unggah Buku Baru</h2>

    <div class="card shadow-lg border-0">
      <div class="card-header bg-warning text-dark">
        <h4 class="mb-0">Informasi Buku</h4>
      </div>
      <div class="card-body">

        <form action="Proses_Unggah.php" method="POST" enctype="multipart/form-data" id="unggahBukuForm">

          <div class="mb-3">
            <label for="cover" class="form-label">Cover Buku (*)</label>
            <input type="file" class="form-control" id="cover" name="cover" accept="image/jpeg,image/png,image/gif"
              required>
            <img id="coverPreview" src="#" alt="Preview Cover" class="preview-image" />
            <small class="text-muted">Format: JPG, JPEG, PNG, GIF.</small>
          </div>

          <div class="mb-3">
            <label for="file_buku" class="form-label">File Buku (PDF) (*)</label>
            <input class="form-control" type="file" id="file_buku" name="file_buku" accept="application/pdf" required />
            <small class="text-muted">Hanya file PDF yang diizinkan.</small>
          </div>

          <div class="mb-3">
            <label for="judul" class="form-label">Judul (*)</label>
            <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul buku" required>
          </div>

          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi (*)</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5"
              placeholder="Ketikan deskripsi singkat buku Anda" required></textarea>
          </div>

          <div class="mb-3">
            <label for="kategori" class="form-label">Kategori (*)</label>
            <select class="form-select" id="kategori" name="kategori" required>
              <option value="">Pilih Kategori</option>
              <option value="Fiksi">Fiksi</option>
              <option value="Non-Fiksi">Non-Fiksi</option>
              <option value="Pendidikan">Pendidikan</option>
              <option value="Komik">Komik</option>
              <option value="Pengembangan Diri">Pengembangan Diri</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="tanggal_upload" class="form-label">Tanggal Upload (*)</label>
            <input type="date" class="form-control" id="tanggal_upload" name="tanggal_upload" required>
          </div>

          <div class="mb-3">
            <label class="form-label" for="harga_sewa">Harga Sewa (*)</label>
            <div class="input-group">
              <span class="input-group-text">Rp</span>
              <input type="number" id="harga_sewa" name="harga_sewa" class="form-control" placeholder="0" min="0"
                step="100" required />
            </div>
          </div>

          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="persetujuan" name="persetujuan" required>
            <label class="form-check-label" for="persetujuan">Saya menyatakan informasi buku yang diunggah sudah benar
              dan sesuai (*)</label>
          </div>

          <button type="submit" name="upload" class="btn btn-warning w-100 fw-bold">Unggah Buku</button>
        </form>

      </div>
    </div>
  </div>
  <br>

  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
  // Preview cover buku
  document.getElementById('cover').addEventListener('change', function(event) {
    const reader = new FileReader();
    const previewImage = document.getElementById('coverPreview');

    reader.onload = function(e) {
      previewImage.src = e.target.result;
      previewImage.style.display = 'block';
    }
    if (event.target.files && event.target.files[0]) {
      reader.readAsDataURL(event.target.files[0]);
    } else {
      previewImage.src = '#';
      previewImage.style.display = 'none';
    }
  });

  // Validasi harga sewa & persetujuan sisi klien (opsional, validasi utama tetap di server)
  document.getElementById('unggahBukuForm').addEventListener('submit', function(event) {
    const hargaSewaInput = document.getElementById('harga_sewa');
    const persetujuanCheckbox = document.getElementById('persetujuan');

    if (hargaSewaInput && parseFloat(hargaSewaInput.value) < 0) {
      alert('Harga sewa tidak boleh negatif!');
      event.preventDefault(); // Hentikan submit
      return;
    }
    if (!persetujuanCheckbox.checked) {
      alert('Anda harus menyetujui persyaratan sebelum mengunggah.');
      event.preventDefault(); // Hentikan submit
      return;
    }
  });
  </script>

  <?php include("../modular/footerfitur.php"); ?>
</body>

</html>