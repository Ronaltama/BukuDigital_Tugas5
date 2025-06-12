<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../koneksi.php';

if (!isset($_SESSION['id_pembaca']) || empty($_SESSION['id_pembaca'])) {
    header("Location: ../loginpage.php");
    exit;
}
$id_pembaca_logged_in = $_SESSION['id_pembaca'];
$buku = null;
$idBuku = $_GET['id'] ?? '';

if ($idBuku) {
    $sql_buku = "SELECT id_buku, judul, harga_sewa FROM buku WHERE id_buku = ?";
    $stmt_buku = mysqli_prepare($conn, $sql_buku);
    mysqli_stmt_bind_param($stmt_buku, "s", $idBuku);
    mysqli_stmt_execute($stmt_buku);
    $result_buku = mysqli_stmt_get_result($stmt_buku);
    $buku = mysqli_fetch_assoc($result_buku);
    if (!$buku) { die("Buku tidak ditemukan."); }
} else {
    die("ID Buku tidak ditemukan.");
}

$harga_sewa_bulanan_dari_db = $buku['harga_sewa'];
$packagePrices = [ 3 => $harga_sewa_bulanan_dari_db * 0.20, 7 => $harga_sewa_bulanan_dari_db * 0.35, 14 => $harga_sewa_bulanan_dari_db * 0.60, 30 => $harga_sewa_bulanan_dari_db * 1.00, ];
$durationDiscounts = [ 3 => 0, 7 => 0.05, 14 => 0.1, 30 => 0.15, ];
$adminFees = [ "transfer" => 2000, "ewallet" => 2500, ];
$voucherDiscounts = [ "DIGI20" => 0.2, "GEMARMEMBACA" => 0.1, ];
$result_calculation = null;
$transaction_status = null;
$action = $_POST['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $durasi = (int)$_POST['durasi'];
    $voucher = strtoupper(trim($_POST['voucher']));
    $metodePembayaran = $_POST['metode_pembayaran'];
    $subtotal_sewa = isset($packagePrices[$durasi]) ? $packagePrices[$durasi] : 0;
    $diskonDurasi = isset($durationDiscounts[$durasi]) ? $subtotal_sewa * $durationDiscounts[$durasi] : 0;
    $diskonVoucher = 0;
    if (isset($voucherDiscounts[$voucher])) { $diskonVoucher = $subtotal_sewa * $voucherDiscounts[$voucher]; } else if (!empty($voucher)) { $transaction_status = "<div class='alert alert-warning'>Kode voucher tidak valid.</div>"; }
    $adminFee = isset($adminFees[$metodePembayaran]) ? $adminFees[$metodePembayaran] : 0;
    $total_bayar = $subtotal_sewa - $diskonDurasi - $diskonVoucher + $adminFee;
    
    // Variabel ini akan digunakan oleh HTML asli Anda untuk menampilkan hasil kalkulasi
    $result_calculation = [ 'durasi' => $durasi, 'judul_buku' => $buku['judul'], 'harga_per_hari_base' => $buku['harga_sewa'], 'harga_paket_dasar' => $subtotal_sewa, 'subtotal_sewa' => $subtotal_sewa, 'diskon_durasi' => $diskonDurasi, 'diskon_voucher' => $diskonVoucher, 'admin_fee' => $adminFee, 'total_bayar' => $total_bayar, 'metode_pembayaran' => $metodePembayaran ];
    
    if ($action === 'rent') {
        if (empty($id_pembaca_logged_in)) {
            $transaction_status = "<div class='alert alert-danger'>ID Pembaca tidak valid. Silakan login ulang.</div>";
        } else {
            mysqli_begin_transaction($conn);
            try {
                $sql_max_pesanan_id = "SELECT MAX(id_pemesanan) AS max_id FROM detail_pesanan";
                $result_max_pesanan_id = $conn->query($sql_max_pesanan_id);
                $row_max_pesanan_id = $result_max_pesanan_id->fetch_assoc();
                $last_pemesanan_id_num = $row_max_pesanan_id['max_id'] ? (int)substr($row_max_pesanan_id['max_id'], 2) : 0;
                $new_pemesanan_id = 'DP' . str_pad($last_pemesanan_id_num + 1, 6, '0', STR_PAD_LEFT);
                $tanggal_pesanan = date('Y-m-d');
                $status_pemesanan = 'menunggu';

                $sql_insert_pesanan = "INSERT INTO detail_pesanan (id_pemesanan, id_pembaca, id_buku, durasi_sewa, total_harga, status_pemesanan, tanggal_pesanan) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt_pesanan = mysqli_prepare($conn, $sql_insert_pesanan);
                mysqli_stmt_bind_param($stmt_pesanan, "sssidss", $new_pemesanan_id, $id_pembaca_logged_in, $idBuku, $durasi, $total_bayar, $status_pemesanan, $tanggal_pesanan);
                mysqli_stmt_execute($stmt_pesanan);

                $sql_max_pembayaran_id = "SELECT MAX(CAST(id_pembayaran AS UNSIGNED)) AS max_id FROM pembayaran";
                $result_max_pembayaran_id = $conn->query($sql_max_pembayaran_id);
                $row_max_pembayaran_id = $result_max_pembayaran_id->fetch_assoc();
                $new_pembayaran_id = ($row_max_pembayaran_id['max_id'] ?? 0) + 1;
                $status_pembayaran = 'pending';

                // Kolom di pembayaran harus id_pemesanan, bukan id_sewa
                $sql_insert_pembayaran = "INSERT INTO pembayaran (id_pembayaran, id_pemesanan, jumlah, tgl_pembayaran, status_pembayaran) VALUES (?, ?, ?, ?, ?)";
                $stmt_pembayaran = mysqli_prepare($conn, $sql_insert_pembayaran);
                mysqli_stmt_bind_param($stmt_pembayaran, "ssdss", $new_pembayaran_id, $new_pemesanan_id, $total_bayar, $tanggal_pesanan, $status_pembayaran);
                mysqli_stmt_execute($stmt_pembayaran);

                mysqli_commit($conn);
                
                // Variabel session ini diisi sesuai kebutuhan HTML asli di notaPembayaran.php
                $_SESSION['transaction_details'] = [
                    'id_pemesanan' => $new_pemesanan_id, // Ganti id_sewa jadi id_pemesanan
                    'judul_buku' => $buku['judul'],
                    'durasi' => $durasi,
                    'tgl_pesan' => $tanggal_pesanan, // Ganti tgl_sewa jadi tgl_pesan
                    'total_bayar' => $total_bayar,
                    'metode_pembayaran' => $metodePembayaran,
                    'status_pembayaran' => $status_pembayaran,
                    'harga_per_hari_base' => $buku['harga_sewa'], // Ini untuk mencocokkan nota lama
                    'harga_paket_dasar' => $subtotal_sewa // Ini untuk mencocokkan nota lama
                ];
                header("Location: notaPembayaran.php");
                exit();

            } catch (mysqli_sql_exception $exception) {
                mysqli_rollback($conn);
                $transaction_status = "<div class='alert alert-danger'>Gagal memproses pesanan: " . $exception->getMessage() . "</div>";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Sewa Buku</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../style.css" />
  <style>
  body {
    background-color: #f9f9f9;
  }

  .buttonberanda {
    background-color: #ffc107;
    border-radius: 5px;
    width: 100px;
    height: 40px;
    border: none;
    color: #000;
  }

  .result-table {
    width: 100%;
  }

  .table-container {
    overflow-x: auto;
  }
  </style>
</head>

<body>
  <?php include("../modular/headerPembaca.php"); ?>

  <div class="container mt-4">
    <h2 class="text-center text-success mb-4">Form Sewa Buku</h2>

    <?php if ($transaction_status): ?>
    <?= $transaction_status ?>
    <?php endif; ?>

    <form method="POST" class="mb-4">
      <div class="mb-3">
        <label for="judul_buku" class="form-label">Judul Buku</label>
        <input type="text" class="form-control" id="judul_buku" name="judul_buku"
          value="<?= htmlspecialchars($buku['judul']) ?>" readonly>
        <input type="hidden" name="id_buku" value="<?= htmlspecialchars($buku['id_buku']) ?>">
      </div>

      <div class="mb-3">
        <label for="harga_sewa_bulanan" class="form-label">Harga Sewa Bulanan (dari DB)</label>
        <input type="text" class="form-control" id="harga_sewa_bulanan" name="harga_sewa_bulanan"
          value="Rp<?= number_format($harga_sewa_bulanan_dari_db, 0, ',', '.') ?>" readonly>
      </div>

      <div class="mb-3">
        <label for="durasi" class="form-label">Pilih Paket Langganan</label>
        <select class="form-select" name="durasi" id="durasi" required>
          <option value="">Pilih Paket</option>
          <option value="3" <?= (isset($_POST['durasi']) && $_POST['durasi'] == 3) ? 'selected' : '' ?>>3 Hari</option>
          <option value="7" <?= (isset($_POST['durasi']) && $_POST['durasi'] == 7) ? 'selected' : '' ?>>7 Hari</option>
          <option value="14" <?= (isset($_POST['durasi']) && $_POST['durasi'] == 14) ? 'selected' : '' ?>>14 Hari
          </option>
          <option value="30" <?= (isset($_POST['durasi']) && $_POST['durasi'] == 30) ? 'selected' : '' ?>>30 Hari (1
            Bulan)</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="voucher" class="form-label">Kode Voucher</label>
        <input type="text" class="form-control" name="voucher" id="voucher"
          value="<?= htmlspecialchars($_POST['voucher'] ?? '') ?>">
      </div>

      <div class="mb-3">
        <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
        <select class="form-select" name="metode_pembayaran" id="metode_pembayaran" required>
          <option value="">Pilih Metode</option>
          <option value="transfer"
            <?= (isset($_POST['metode_pembayaran']) && $_POST['metode_pembayaran'] == 'transfer') ? 'selected' : '' ?>>
            Transfer Bank</option>
          <option value="ewallet"
            <?= (isset($_POST['metode_pembayaran']) && $_POST['metode_pembayaran'] == 'ewallet') ? 'selected' : '' ?>>
            E-Wallet</option>
        </select>
      </div>
      <button type="submit" name="action" value="calculate" class="btn btn-primary me-2">Hitung</button>
      <button type="submit" name="action" value="rent" class="btn btn-success">Sewa</button>
    </form>

    <?php if ($result_calculation && ($action === 'calculate' || ($action === 'rent' && !$transaction_status))): ?>
    <div class="table-container mb-5">
      <h3 class="text-center text-success">Detail Perhitungan Sewa</h3>
      <table class="table table-bordered result-table table-striped">
        <thead class="table-dark">
          <tr>
            <th>Judul Buku</th>
            <th>Harga Bulanan (dari DB)</th>
            <th>Paket Dipilih</th>
            <th>Harga Paket Dasar</th>
            <th>Diskon Paket</th>
            <th>Diskon Voucher</th>
            <th>Biaya Admin</th>
            <th>Total Bayar</th>
            <th>Metode Pembayaran</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?= htmlspecialchars($result_calculation['judul_buku']) ?></td>
            <td>Rp<?= number_format($result_calculation['harga_per_hari_base'], 0, ',', '.') ?></td>
            <td><?= $result_calculation['durasi'] ?> Hari</td>
            <td>Rp<?= number_format($result_calculation['harga_paket_dasar'], 0, ',', '.') ?></td>
            <td>Rp<?= number_format($result_calculation['diskon_durasi'], 0, ',', '.') ?></td>
            <td>Rp<?= number_format($result_calculation['diskon_voucher'], 0, ',', '.') ?></td>
            <td>Rp<?= number_format($result_calculation['admin_fee'], 0, ',', '.') ?></td>
            <td><strong>Rp<?= number_format($result_calculation['total_bayar'], 0, ',', '.') ?></strong></td>
            <td><?= htmlspecialchars($result_calculation['metode_pembayaran']) ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>
  <br><br><br><br>
  <?php include("../modular/footerFitur.php"); ?>

</body>

</html>