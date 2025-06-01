<?php
session_start(); // Mulai session di paling atas

// 1. Include file koneksi database terlebih dahulu
// Pastikan file koneksi.php ini HANYA berisi logika koneksi dan TIDAK menghasilkan output HTML/teks.
include("../koneksi.php");

// 2. Periksa status login dan ketersediaan session 'id_penulis'
// Ini harus dilakukan SEBELUM include file header yang mungkin menghasilkan output HTML.
if (!isset($_SESSION['id_penulis'])) {
    // Jika session 'id_penulis' tidak ada, arahkan ke halaman login
    header("Location: ../features/loginpage.php"); // Sesuaikan path ke halaman login Anda
    exit(); // Hentikan eksekusi skrip setelah redirect
}

// Jika lolos pengecekan di atas, berarti 'id_penulis' ada di session
$id_penulis_logged_in = $_SESSION['id_penulis'];

// 3. Sekarang baru include file header
// Diasumsikan headerPenulis.php mungkin menghasilkan output HTML.
include("../modular/headerPenulis.php");

// Inisialisasi variabel
$daftarKarya = [];
$errorMessage = "";

try {
    // Pastikan objek koneksi $conn ada dan tidak null (dari file koneksi.php)
    if ($conn) {
        // Menggunakan nama kolom yang benar yaitu 'tanggal_upload'
        $stmt = $conn->prepare("SELECT id_buku, judul, tanggal_upload FROM buku WHERE id_penulis = ? ORDER BY tanggal_upload DESC"); // Perubahan di sini
        
        if ($stmt) {
            $stmt->bind_param("s", $id_penulis_logged_in); // "s" karena id_penulis adalah char/varchar
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $daftarKarya[] = $row;
                }
            }
            $stmt->close();
        } else {
            // Gagal mempersiapkan statement
            $errorMessage = "Error: Gagal mempersiapkan query database. " . $conn->error;
        }
    } else {
        $errorMessage = "Error: Koneksi database tidak tersedia.";
    }
} catch (mysqli_sql_exception $e) {
    $errorMessage = "Error: Terjadi masalah saat mengakses database. " . $e->getMessage();
    // Untuk lingkungan produksi, catat error ini, jangan tampilkan detail ke pengguna
    // error_log("Database error in Karya.php: " . $e->getMessage());
} finally {
    // Pastikan koneksi ditutup jika sudah dibuka
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Karya Saya</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../style.css">
  <style>
  /* Tambahan style jika diperlukan */
  .aksi-button {
    margin-right: 5px;
  }

  .container {
    padding-top: 20px;
    /* Memberi sedikit ruang jika header fixed/absolute */
  }
  </style>
</head>

<body>

  <div class="container mt-5 pt-5">
    <h2 class="text-center text-success mb-4">Karya Saya</h2>

    <?php if (!empty($errorMessage)) : ?>
    <div class="alert alert-danger" role="alert">
      <?php echo htmlspecialchars($errorMessage); ?>
    </div>
    <?php endif; ?>

    <?php if (empty($daftarKarya) && empty($errorMessage)) : // Tampilkan hanya jika tidak ada error DAN daftar karya kosong ?>
    <p class="text-center">Anda belum mengunggah karya.</p>
    <?php elseif (!empty($daftarKarya)) : ?>
    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead class="bg-light">
          <tr>
            <th>Judul Buku</th>
            <th>Tanggal Upload</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($daftarKarya as $karya) : ?>
          <tr>
            <td><?php echo htmlspecialchars($karya['judul']); ?></td>
            <td><?php echo htmlspecialchars(isset($karya['tanggal_upload']) ? $karya['tanggal_upload'] : 'N/A'); ?></td>
            <td class="text-center">
              <a href="EditKarya.php?id=<?php echo htmlspecialchars($karya['id_buku']); ?>"
                class="btn btn-sm btn-primary aksi-button">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="Proses_Delete.php?id=<?php echo htmlspecialchars($karya['id_buku']); ?>"
                class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                <i class="fas fa-trash"></i> Hapus
              </a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>

    <div class="mt-3 text-center"> <a href="UnggahBuku.php" class="btn btn-success">
        <i class="fas fa-upload"></i> Unggah Buku Baru
      </a>
    </div>

  </div>

  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
  <br><br><br> <?php include("../modular/footerFitur.php"); ?>
</body>

</html>