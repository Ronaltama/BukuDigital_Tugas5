<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pastikan path ke koneksi sudah benar (naik satu level)
include("../koneksi.php");

// -----------------------------------------------------------------------------
// TAHAP 1: VALIDASI INPUT DAN PENGGUNA (Tidak berubah)
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
// TAHAP 2: VERIFIKASI HAK AKSES SEWA (Tidak berubah)
// -----------------------------------------------------------------------------

// Query untuk memastikan pengguna punya sewa AKTIF untuk buku ini
$sql_cek_akses = "SELECT id_sewa FROM sewa 
                  WHERE id_pembaca = ? AND id_buku = ? AND status_sewa = 'dipinjam' AND tgl_kembali >= CURDATE()
                  LIMIT 1";
                  
$stmt_cek = $conn->prepare($sql_cek_akses);
$stmt_cek->bind_param("ss", $id_pembaca, $id_buku);
$stmt_cek->execute();
$result_cek = $stmt_cek->get_result();

if ($result_cek->num_rows === 0) {
    // Jika tidak ada hasil, sewa sudah berakhir atau tidak sah. Tolak akses.
    http_response_code(403); // Forbidden
    die("<h2>Akses Ditolak</h2><p>Masa sewa Anda untuk buku ini telah berakhir atau Anda tidak memiliki hak akses. Anda tidak diizinkan mengakses konten ini.</p><a href='perpus.php'>Kembali ke Daftar Buku Sewaan</a>");
}
$stmt_cek->close();

// -----------------------------------------------------------------------------
// TAHAP 3: AMBIL INFORMASI BUKU (Tidak berubah)
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

// Buat path yang benar ke file PDF
$file_path = "../files/" . $buku['file_buku'];

// -----------------------------------------------------------------------------
// TAHAP BARU: STREAMING FILE PDF JIKA DIMINTA
// Ini adalah logika baru untuk menyajikan file secara aman
// -----------------------------------------------------------------------------
if (isset($_GET['stream']) && $_GET['stream'] === 'true') {
    if (file_exists($file_path)) {
        // Set header agar browser menampilkan PDF (inline) bukan mengunduh (attachment)
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($file_path) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        
        // Nonaktifkan caching untuk keamanan
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        
        // Baca file dan kirimkan isinya ke browser
        @readfile($file_path);
        
        // Hentikan eksekusi skrip setelah file dikirim
        exit();
    } else {
        http_response_code(404);
        die("File tidak ditemukan di server.");
    }
}

// Jika tidak sedang streaming, tampilkan halaman HTML seperti biasa
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
  /* CSS Anda tidak perlu diubah */
  html,
  body {
    height: 100%;
    margin: 0;
    overflow: hidden;
  }

  .page-wrapper {
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  .viewer-container {
    flex-grow: 1;
    border: none;
  }

  /* Wrapper sekarang menjadi item yang mengisi ruang */
  .viewer-wrapper {
    position: relative;
    flex-grow: 1;
  }

  /* iframe (viewer-container) harus mengisi 100% dari wrapper-nya */
  .viewer-container {
    width: 100%;
    height: 100%;
    border: none;
  }

  /* Overlay untuk membantu menonaktifkan klik kanan */
  .viewer-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
    background-color: transparent;
    pointer-events: none;
    /* <-- TAMBAHKAN BARIS INI */
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

    <div class="viewer-wrapper" oncontextmenu="return false;">
      <iframe class="viewer-container" src="?id=<?php echo htmlspecialchars($id_buku); ?>&stream=true#toolbar=0"
        title="PDF Viewer untuk <?php echo htmlspecialchars($buku['judul']); ?>">
        Browser Anda tidak mendukung tampilan PDF secara langsung.
      </iframe>
      <div class="viewer-overlay"></div>
    </div>

  </div>

  <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>