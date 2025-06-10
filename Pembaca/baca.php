<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pastikan path ke koneksi sudah benar (naik satu level)
include("../koneksi.php");

// -----------------------------------------------------------------------------
// TAHAP 1: VALIDASI INPUT DAN PENGGUNA (Sama seperti detail.php)
// -----------------------------------------------------------------------------

$id_buku = $_GET['id'] ?? null;
if (!$id_buku) {
    die("Error: ID Buku tidak ditemukan.");
}

$id_pembaca = $_SESSION['id_pembaca'] ?? null;
if (!$id_pembaca) {
    header("Location: ../login.php?redirect=Pembaca/baca.php?id=" . urlencode($id_buku));
    exit();
}

// -----------------------------------------------------------------------------
// TAHAP 2: VERIFIKASI HAK AKSES SEWA (WAJIB ADA!)
// -----------------------------------------------------------------------------

// Query untuk memastikan pengguna punya sewa AKTIF untuk buku ini
$sql_cek_akses = "SELECT id_sewa FROM sewa 
                  WHERE id_pembaca = ? AND id_buku = ? AND status_sewa = 'dipinjam' 
                  LIMIT 1";

$stmt_cek = $conn->prepare($sql_cek_akses);
$stmt_cek->bind_param("ss", $id_pembaca, $id_buku);
$stmt_cek->execute();
$result_cek = $stmt_cek->get_result();

if ($result_cek->num_rows === 0) {
    // Jika tidak ada hasil, sewa sudah berakhir atau tidak sah. Tolak akses.
    http_response_code(403); // Forbidden
    die("<h2>Akses Ditolak</h2><p>Masa sewa Anda untuk buku ini telah berakhir. Anda tidak diizinkan mengakses halaman ini.</p><a href='perpus.php'>Kembali ke Daftar Buku Sewaan</a>");
}
$stmt_cek->close();

// -----------------------------------------------------------------------------
// TAHAP 3: AMBIL INFORMASI BUKU (JUDUL DAN NAMA FILE)
// -----------------------------------------------------------------------------

$sql_buku = "SELECT judul, file_buku FROM buku WHERE id_buku = ?";
$stmt_buku = $conn->prepare($sql_buku);
$stmt_buku->bind_param("s", $id_buku);
$stmt_buku->execute();
$result_buku = $stmt_buku->get_result();
$buku = $result_buku->fetch_assoc();

if (!$buku) {
    http_response_code(404); // Not Found
    die("<h2>404 - Not Found</h2><p>Data buku tidak dapat ditemukan.</p>");
}
$stmt_buku->close();
$conn->close();

// Buat path yang benar ke file PDF (naik satu level, lalu masuk folder files)
$file_path = "../files/" . $buku['file_buku'];
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Membaca: <?php echo htmlspecialchars($buku['judul']); ?></title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
  /* Membuat body dan html memenuhi tinggi layar */
  html,
  body {
    height: 100%;
    margin: 0;
    overflow: hidden;
    /* Mencegah scroll di body utama */
  }

  /* Membuat wrapper utama menjadi flexbox dengan arah kolom */
  .page-wrapper {
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  /* Konten utama (viewer) akan mengisi sisa ruang */
  .viewer-container {
    flex-grow: 1;
    border: none;
    /* Menghilangkan border pada iframe */
  }
  </style>
</head>

<body>
  <div class="page-wrapper">
    <header class="p-3 bg-dark text-white shadow-sm">
      <div class="container-fluid d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
          <i class="fas fa-book-reader me-2"></i>
          <?php echo htmlspecialchars($buku['judul']); ?>
        </h5>
        <a href="detail.php?id=<?php echo htmlspecialchars($id_buku); ?>" class="btn btn-light btn-sm">
          <i class="fas fa-arrow-left me-2"></i>Kembali ke Detail
        </a>
      </div>
    </header>

    <iframe class="viewer-container" src="<?php echo htmlspecialchars($file_path); ?>"
      title="PDF Viewer untuk <?php echo htmlspecialchars($buku['judul']); ?>">
      Browser Anda tidak mendukung iframe, silakan unduh PDF <a href="<?php echo htmlspecialchars($file_path); ?>">di
        sini</a>.
    </iframe>
  </div>

  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>