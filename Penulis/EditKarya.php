<?php
session_start();
include("../modular/headerPenulis.php");
include("../koneksi.php");

if (!isset($_SESSION['id_penulis'])) {
    header("Location: ../features/loginpage.php");
    exit();
}

if (!isset($_GET['id'])) {
    // Tambahkan pesan jika mau, sebelum redirect
    $_SESSION['message'] = "ID Buku tidak ditemukan untuk diedit.";
    $_SESSION['msg_type'] = "warning";
    header("Location: Karya.php"); // Redirect if no ID is provided
    exit();
}

$id_buku_to_edit = $_GET['id'];
$bookData = null;
$errorMessage = "";

// Ambil pesan dari session jika ada (setelah redirect dari Proses_Update.php)
if (isset($_SESSION['message'])) {
    $errorMessage = $_SESSION['message']; // Bisa juga ada $successMessage jika msg_type success
    // Anda bisa membuat logic untuk menampilkan $errorMessage dengan class alert yang sesuai $_SESSION['msg_type']
    unset($_SESSION['message']);
    unset($_SESSION['msg_type']);
}


try {
    // Fetch book data
    $stmt = $conn->prepare("SELECT * FROM buku WHERE id_buku = ? AND id_penulis = ?");
    if (!$stmt) {
        $errorMessage = "Gagal mempersiapkan query: " . $conn->error;
    } else {
        $stmt->bind_param("ss", $id_buku_to_edit, $_SESSION['id_penulis']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $bookData = $result->fetch_assoc();
        } else {
            // Set pesan error jika buku tidak ditemukan atau bukan milik penulis
            // Pesan ini mungkin sudah di-handle oleh redirect dari Proses_Update,
            // tapi baik untuk ada di sini jika user langsung akses URL edit.
            if (empty($errorMessage)) { // Hanya set jika belum ada pesan dari session
                 $errorMessage = "Buku tidak ditemukan atau Anda tidak memiliki izin untuk mengeditnya.";
            }
        }
        $stmt->close();
    }
} catch (mysqli_sql_exception $e) {
    $errorMessage = "Error saat mengambil data buku: " . $e->getMessage();
}
// Jangan tutup koneksi di sini jika form masih membutuhkan $conn (misal untuk dropdown dinamis)
// Koneksi akan ditutup otomatis di akhir skrip PHP jika tidak ditutup manual.
// Tapi jika ini adalah akhir dari penggunaan $conn di halaman ini, bisa ditutup.
// if (isset($conn)) { $conn->close(); }


if (!$bookData && empty($errorMessage)) {
    $errorMessage = "Buku tidak ditemukan atau data tidak dapat dimuat.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Buku</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../style.css">
  <style>
  .preview-image {
    max-width: 200px;
    height: auto;
    margin-top: 10px;
    display: block;
  }

  .current-cover-label,
  .current-file-label {
    font-size: 0.875em;
    color: #6c757d;
    display: block;
    margin-top: 5px;
  }
  </style>
</head>

<body>
  <div class="container mt-5 pt-3">
    <h2 class="text-center text-success mb-4">Edit Buku</h2>

    <?php if (!empty($errorMessage) && !$bookData) : // Tampilkan error hanya jika buku gagal dimuat ?>
    <div class="alert alert-danger" role="alert">
      <?php echo htmlspecialchars($errorMessage); ?>
    </div>
    <a href="Karya.php" class="btn btn-primary">Kembali ke Karya Saya</a>
    <?php elseif ($bookData) : ?>

    <?php if (!empty($errorMessage)): // Tampilkan pesan dari Proses_Update jika ada ?>
    <div
      class="alert alert-<?php echo isset($_SESSION['msg_type_display']) ? $_SESSION['msg_type_display'] : 'info'; ?>"
      role="alert">
      <?php echo htmlspecialchars($errorMessage); ?>
    </div>
    <?php
            unset($_SESSION['msg_type_display']); // Hapus setelah ditampilkan
        ?>
    <?php endif; ?>

    <div class="card shadow-lg border-0">
      <div class="card-header bg-warning text-dark">
        <h4 class="mb-0">Informasi Buku</h4>
      </div>
      <div class="card-body">
        <form action="Proses_Update.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="id_buku" value="<?php echo htmlspecialchars($bookData['id_buku']); ?>">

          <div class="mb-3">
            <label for="cover" class="form-label">Cover Buku (Kosongkan jika tidak ingin mengubah)</label>
            <input type="file" class="form-control" id="cover" name="cover" accept="image/*">
            <?php if (!empty($bookData['cover_url'])) : ?>
            <span class="current-cover-label">Cover Saat Ini:</span>
            <img src="../covers/<?php echo htmlspecialchars($bookData['cover_url']); ?>" alt="Current Cover"
              class="img-thumbnail preview-image mt-2" id="currentCoverPreview">
            <?php else: ?>
            <img src="#" alt="Preview Cover" class="img-thumbnail preview-image mt-2" id="currentCoverPreview"
              style="display:none;">
            <?php endif; ?>
            <small class="text-muted">Hanya file gambar yang diizinkan.</small>
          </div>

          <div class="mb-3">
            <label for="file_buku" class="form-label">File Buku (PDF) (Kosongkan jika tidak ingin mengubah)</label>
            <input class="form-control" type="file" id="file_buku" name="file_buku" accept="application/pdf" />
            <?php if (!empty($bookData['file_buku'])) : ?>
            <span class="current-file-label">File PDF Saat Ini: <a
                href="../files/<?php echo htmlspecialchars($bookData['file_buku']); ?>"
                target="_blank"><?php echo htmlspecialchars($bookData['file_buku']); ?></a></span>
            <?php endif; ?>
            <small class="text-muted">Hanya file PDF yang diizinkan.</small>
          </div>

          <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul"
              value="<?php echo htmlspecialchars($bookData['judul']); ?>" required>
          </div>

          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5"
              placeholder="Ketikan deskripsi singkat buku mu"><?php echo htmlspecialchars($bookData['deskripsi']); ?></textarea>
          </div>

          <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select class="form-select" id="kategori" name="kategori" required>
              <option value="">Pilih Kategori</option>
              <option value="fiksi" <?php echo ($bookData['kategori'] == 'fiksi') ? 'selected' : ''; ?>>Fiksi</option>
              <option value="non-fiksi" <?php echo ($bookData['kategori'] == 'non-fiksi') ? 'selected' : ''; ?>>
                Non-Fiksi</option>
              <option value="pendidikan" <?php echo ($bookData['kategori'] == 'pendidikan') ? 'selected' : ''; ?>>
                Pendidikan</option>
              <option value="komik" <?php echo ($bookData['kategori'] == 'komik') ? 'selected' : ''; ?>>Komik</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="tanggal_upload" class="form-label">Tanggal Upload</label>
            <input type="date" class="form-control" id="tanggal_upload" name="tanggal_upload"
              value="<?php echo htmlspecialchars(isset($bookData['tanggal_upload']) ? $bookData['tanggal_upload'] : ''); ?>"
              required>
          </div>

          <div class="mb-3">
            <label class="form-label" for="harga_sewa">Harga Sewa</label>
            <div class="input-group">
              <span class="input-group-text">Rp</span>
              <input type="number" name="harga_sewa" id="harga_sewa" class="form-control" placeholder="0"
                value="<?php echo htmlspecialchars($bookData['harga_sewa']); ?>" required min="1" />
            </div>
          </div>

          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="persetujuan" name="persetujuan" required>
            <label class="form-check-label" for="persetujuan">Saya menyatakan informasi buku yang diubah sudah benar dan
              sesuai.</label>
          </div>

          <button type="submit" name="update" class="btn btn-warning w-100 fw-bold">Update Buku</button>
        </form>
      </div>
    </div>
    <?php else: ?>
    <?php // Fallback jika $bookData tidak ada dan $errorMessage kosong (seharusnya tidak terjadi jika logic di atas benar) ?>
    <div class="alert alert-info" role="alert">
      Data buku tidak dapat dimuat. Silakan coba lagi.
    </div>
    <a href="Karya.php" class="btn btn-primary">Kembali ke Karya Saya</a>
    <?php endif; ?>

    <br>
  </div>
  <script>
  // Preview cover buku
  document.getElementById('cover').addEventListener('change', function(event) {
    const reader = new FileReader();
    let previewImage = document.getElementById('currentCoverPreview'); // Gunakan ID yang sudah ada

    reader.onload = function(e) {
      previewImage.src = e.target.result;
      previewImage.style.display = 'block';
    }
    if (event.target.files[0]) {
      reader.readAsDataURL(event.target.files[0]);
    } else {
      // Jika tidak ada file baru dipilih, kembalikan ke cover lama (jika ada)
      <?php if (!empty($bookData['cover_url'])) : ?>
      previewImage.src = '../covers/<?php echo htmlspecialchars($bookData['cover_url']); ?>';
      previewImage.style.display = 'block';
      <?php else: ?>
      previewImage.src = '#'; // Atau gambar placeholder
      previewImage.style.display = 'none';
      <?php endif; ?>
    }
  });

  // Validasi harga sewa dan persetujuan pada submit
  document.querySelector('form').addEventListener('submit', function(event) {
    const hargaSewaInput = this.querySelector('input[name="harga_sewa"]');
    const persetujuanCheckbox = this.querySelector('input[name="persetujuan"]');
    let formIsValid = true;

    if (hargaSewaInput && parseFloat(hargaSewaInput.value) <= 0) {
      alert('Harga sewa harus lebih dari 0!');
      formIsValid = false;
    }

    if (persetujuanCheckbox && !persetujuanCheckbox.checked) {
      alert('Anda harus menyetujui bahwa informasi buku sudah sesuai.');
      formIsValid = false;
    }

    if (!formIsValid) {
      event.preventDefault(); // Hentikan submit form jika tidak valid
    }
  });
  </script>
  <?php
    // Pastikan $conn ditutup jika masih terbuka (jika tidak ditutup di blok try/catch di atas)
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
    include("../modular/footerFitur.php"); // Pastikan footer di-include
  ?>
</body>

</html>