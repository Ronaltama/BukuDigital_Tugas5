<?php
session_start(); // Pastikan ini di baris paling atas
error_reporting(E_ALL);
ini_set('display_errors', 1);



include '../koneksi.php';

// Ambil id_pembaca dari session
if (!isset($_SESSION['id_pembaca']) || empty($_SESSION['id_pembaca'])) { // Tambahkan empty() check
    error_log("Pengguna belum login atau session id_pembaca kosong. Redirect ke login."); // Debugging
    header("Location: ../loginpage.php"); // Pastikan ini mengarah ke halaman login Anda
    exit;
}
$id_pembaca_logged_in = $_SESSION['id_pembaca'];
error_log("sewaBuku.php - id_pembaca yang digunakan: " . $id_pembaca_logged_in); // Debugging

$buku = null;
$idBuku = $_GET['id'] ?? '';

if ($idBuku) {
    $sql_buku = "SELECT id_buku, judul, harga_sewa FROM buku WHERE id_buku = ?";
    $stmt_buku = mysqli_prepare($conn, $sql_buku);
    mysqli_stmt_bind_param($stmt_buku, "s", $idBuku);
    mysqli_stmt_execute($stmt_buku);
    $result_buku = mysqli_stmt_get_result($stmt_buku);
    $buku = mysqli_fetch_assoc($result_buku);

    if (!$buku) {
        echo "<div class='container mt-5'><div class='alert alert-danger'>Buku tidak ditemukan.</div></div>";
        exit;
    }
} else {
    echo "<div class='container mt-5'><div class='alert alert-danger'>ID Buku tidak ditemukan.</div></div>";
    exit;
}

// AMBIL HARGA SEWA BULANAN DARI DATABASE
$harga_sewa_bulanan_dari_db = $buku['harga_sewa'];

// Definisikan harga paket berdasarkan harga bulanan dari DB
// Anda bisa menyesuaikan persentase atau nilai tetap di sini
$packagePrices = [
    3 => $harga_sewa_bulanan_dari_db * 0.20,   // Misal 20% dari harga bulanan untuk 3 hari
    7 => $harga_sewa_bulanan_dari_db * 0.35,   // Misal 35% dari harga bulanan untuk 7 hari
    14 => $harga_sewa_bulanan_dari_db * 0.60,  // Misal 60% dari harga bulanan untuk 14 hari
    30 => $harga_sewa_bulanan_dari_db * 1.00,  // 100% dari harga bulanan untuk 30 hari
];

// Diskon berdasarkan paket sewa (durasi) - ini tetap berlaku setelah harga paket ditentukan
$durationDiscounts = [
    3 => 0,      // 3 hari -> 0% diskon
    7 => 0.05,   // 7 hari -> 5%
    14 => 0.1,   // 14 hari -> 10%
    30 => 0.15,  // 30 hari -> 15%
];

// Biaya admin
$adminFees = [
    "transfer" => 2000,
    "ewallet" => 2500,
];

// Diskon voucher
$voucherDiscounts = [
    "DIGI20" => 0.2,
    "GEMARMEMBACA" => 0.1,
];

$result_calculation = null;
$transaction_status = null;
$action = $_POST['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $durasi = (int)$_POST['durasi'];
    $voucher = strtoupper(trim($_POST['voucher']));
    $metodePembayaran = $_POST['metode_pembayaran'];

    // Subtotal sewa diambil langsung dari harga paket yang telah ditentukan
    $subtotal_sewa = isset($packagePrices[$durasi]) ? $packagePrices[$durasi] : 0;
    // Jika durasi yang dipilih tidak ada di packagePrices, $subtotal_sewa akan 0.
    // Anda bisa menambahkan validasi di sini jika durasi tidak valid.

    $diskonDurasi = isset($durationDiscounts[$durasi]) ? $subtotal_sewa * $durationDiscounts[$durasi] : 0;

    $diskonVoucher = 0;
    if (isset($voucherDiscounts[$voucher])) {
        $diskonVoucher = $subtotal_sewa * $voucherDiscounts[$voucher];
    } else if (!empty($voucher)) {
        $transaction_status = "<div class='alert alert-warning'>Kode voucher tidak valid.</div>";
    }

    $adminFee = isset($adminFees[$metodePembayaran]) ? $adminFees[$metodePembayaran] : 0;

    $total_bayar = $subtotal_sewa - $diskonDurasi - $diskonVoucher + $adminFee;

    $result_calculation = [
        'durasi' => $durasi,
        'judul_buku' => $buku['judul'],
        'harga_per_hari_base' => $buku['harga_sewa'], // Ini adalah harga bulanan dari DB
        'harga_paket_dasar' => $subtotal_sewa, // Ini adalah harga paket sebelum diskon/biaya
        'subtotal_sewa' => $subtotal_sewa,
        'diskon_durasi' => $diskonDurasi,
        'diskon_voucher' => $diskonVoucher,
        'admin_fee' => $adminFee,
        'total_bayar' => $total_bayar,
        'metode_pembayaran' => $metodePembayaran
    ];

    if ($action === 'rent') {
        // --- Database Insertion ---
        // Pastikan id_pembaca_logged_in tidak kosong sebelum mencoba insert
        if (empty($id_pembaca_logged_in)) {
            $transaction_status = "<div class='alert alert-danger'>ID Pembaca tidak valid. Silakan login ulang.</div>";
            error_log("Error: id_pembaca_logged_in kosong saat mencoba insert sewa!"); // Debugging
        } else {
            // Generate new id_sewa
            $sql_max_sewa_id = "SELECT MAX(id_sewa) AS max_id FROM sewa";
            $result_max_sewa_id = $conn->query($sql_max_sewa_id);

            if ($result_max_sewa_id === false) {
                $transaction_status = "<div class='alert alert-danger'>Error getting max sewa ID: " . $conn->error . "</div>";
            } else {
                $row_max_sewa_id = $result_max_sewa_id->fetch_assoc();
                $last_sewa_id = $row_max_sewa_id['max_id'];
                $new_sewa_id_num = 1;
                if ($last_sewa_id !== null && preg_match('/^\d{8}$/', $last_sewa_id)) { // Regex lebih ketat untuk 8 digit
                    $new_sewa_id_num = (int)$last_sewa_id + 1; // Jika murni angka, langsung konversi
                }
                $new_sewa_id = str_pad($new_sewa_id_num, 8, '0', STR_PAD_LEFT);

                $tgl_sewa = date('Y-m-d');
                $tgl_kembali = date('Y-m-d', strtotime("+$durasi days"));
                $status_sewa = 'dipinjam';

                $sql_insert_sewa = "INSERT INTO sewa (id_sewa, tgl_sewa, tgl_kembali, durasi_sewa, status_sewa, id_pembaca, id_buku) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt_insert_sewa = mysqli_prepare($conn, $sql_insert_sewa);
                // Pastikan 's' untuk id_pembaca karena char(7)
                mysqli_stmt_bind_param($stmt_insert_sewa, "sssisis", $new_sewa_id, $tgl_sewa, $tgl_kembali, $durasi, $status_sewa, $id_pembaca_logged_in, $idBuku);

                if (mysqli_stmt_execute($stmt_insert_sewa)) {
                    // Generate new id_pembayaran
                    $sql_max_pembayaran_id = "SELECT MAX(CAST(id_pembayaran AS UNSIGNED)) AS max_id FROM pembayaran";
                    $result_max_pembayaran_id = $conn->query($sql_max_pembayaran_id);

                    if ($result_max_pembayaran_id === false) {
                        $transaction_status = "<div class='alert alert-danger'>Error getting max pembayaran ID: " . $conn->error . "</div>";
                        $sql_delete_sewa = "DELETE FROM sewa WHERE id_sewa = ?";
                        $stmt_delete_sewa = mysqli_prepare($conn, $sql_delete_sewa);
                        mysqli_stmt_bind_param($stmt_delete_sewa, "s", $new_sewa_id);
                        mysqli_stmt_execute($stmt_delete_sewa);
                    } else {
                        $row_max_pembayaran_id = $result_max_pembayaran_id->fetch_assoc();
                        $last_pembayaran_id = $row_max_pembayaran_id['max_id'];
                        $new_pembayaran_id = $last_pembayaran_id ? (int)$last_pembayaran_id + 1 : 1;

                        $tgl_pembayaran = date('Y-m-d');
                        $status_pembayaran = 'pending';

                        $sql_insert_pembayaran = "INSERT INTO pembayaran (id_pembayaran, jumlah, tgl_pembayaran, status_pembayaran, id_sewa) VALUES (?, ?, ?, ?, ?)";
                        $stmt_insert_pembayaran = mysqli_prepare($conn, $sql_insert_pembayaran);
                        mysqli_stmt_bind_param($stmt_insert_pembayaran, "sdsss", $new_pembayaran_id, $total_bayar, $tgl_pembayaran, $status_pembayaran, $new_sewa_id);

                        if (mysqli_stmt_execute($stmt_insert_pembayaran)) {
                            // Redirect to nota page with transaction details
                            $_SESSION['transaction_details'] = [
                                'id_sewa' => $new_sewa_id,
                                'id_buku' => $idBuku,
                                'judul_buku' => $buku['judul'],
                                'harga_per_hari_base' => $buku['harga_sewa'], // Harga bulanan dari DB
                                'harga_paket_dasar' => $subtotal_sewa, // Harga paket sebelum diskon
                                'durasi' => $durasi,
                                'tgl_sewa' => $tgl_sewa,
                                'tgl_kembali' => $tgl_kembali,
                                'metode_pembayaran' => $metodePembayaran,
                                'total_bayar' => $total_bayar,
                                'id_pembayaran' => $new_pembayaran_id,
                                'status_pembayaran' => $status_pembayaran
                            ];
                            header("Location: notaPembayaran.php");
                            exit();
                        } else {
                            $transaction_status = "<div class='alert alert-danger'>Gagal menyimpan data pembayaran: " . mysqli_error($conn) . "</div>";
                            $sql_delete_sewa = "DELETE FROM sewa WHERE id_sewa = ?";
                            $stmt_delete_sewa = mysqli_prepare($conn, $sql_delete_sewa);
                            mysqli_stmt_bind_param($stmt_delete_sewa, "s", $new_sewa_id);
                            mysqli_stmt_execute($stmt_delete_sewa);
                        }
                    }
                } else {
                    $transaction_status = "<div class='alert alert-danger'>Gagal menyimpan data sewa: " . mysqli_error($conn) . "</div>";
                }
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