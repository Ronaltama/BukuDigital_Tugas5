<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Daftar harga buku
$bookPrices = [
    "Bulan" => 10000,
    "Cantik itu Luka" => 15000,
    "Amba" => 15000,
    "Laskar Pelangi" => 15000,
    "Hujan" => 10000,
    "Luka Cita" => 20000,
    "Filosofi Teras" => 34000,
    "Sisi Tergelap Surga" => 50000,
    "You do You" => 30000,
    "Gadis Kretek" => 25000,
];

// Diskon berdasarkan paket sewa (durasi)
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

$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $durasi = (int)$_POST['durasi'];
    $jumlahBuku = (int)$_POST['jumlah_buku'];
    $bukuDipilih = $_POST['buku'];
    $voucher = strtoupper(trim($_POST['voucher']));
    $metodePembayaran = $_POST['metode_pembayaran'];

    // Hitung subtotal (harga buku x jumlah x durasi)
    $subtotal = 0;
    foreach ($bukuDipilih as $buku) {
        if (isset($bookPrices[$buku])) {
            $subtotal += $bookPrices[$buku];
        }
    }

    // Diskon berdasarkan durasi
    $diskonDurasi = isset($durationDiscounts[$durasi]) ? $subtotal * $durationDiscounts[$durasi] : 0;

    // Diskon voucher
    $diskonVoucher = isset($voucherDiscounts[$voucher]) ? $subtotal * $voucherDiscounts[$voucher] : 0;

    // Biaya admin
    $adminFee = isset($adminFees[$metodePembayaran]) ? $adminFees[$metodePembayaran] : 0;

    // Total akhir
    $total = $subtotal - $diskonDurasi - $diskonVoucher + $adminFee;

    $result = [
        'nama' => $nama,
        'durasi' => $durasi,
        'jumlah_buku' => $jumlahBuku,
        'buku' => $bukuDipilih,
        'subtotal' => $subtotal,
        'diskon_durasi' => $diskonDurasi,
        'diskon_voucher' => $diskonVoucher,
        'admin_fee' => $adminFee,
        'total' => $total,
    ];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Form Sewa Buku</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/loginpagestyle.css">
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
  <?php include("../modular/headerBack.php"); ?>

  <div class="container mt-4">
    <h2 class="text-center text-success mb-4">Sewa Buku Digital Online</h2>

    <form method="POST" class="mb-4">
      <div class="mb-3">
        <label for="nama" class="form-label">Nama Penyewa</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
      </div>

      <div class="mb-3">
        <label for="jumlah_buku" class="form-label">Jumlah Buku</label>
        <input type="number" class="form-control" id="jumlah_buku" name="jumlah_buku" min="1" required
          onchange="generateBookInputs()">
      </div>
      <div id="bookInputsContainer"></div>
      <div class="mb-3">
        <label for="durasi" class="form-label">Paket Langganan</label>
        <select class="form-select" name="durasi" id="durasi" required>
          <option value="">Pilih Paket</option>
          <option value="3">3 Hari</option>
          <option value="7">7 Hari (1 Minggu)</option>
          <option value="14">14 Hari (2 Minggu)</option>
          <option value="30">30 Hari (1 Bulan)</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="voucher" class="form-label">Kode Voucher</label>
        <input type="text" class="form-control" name="voucher" id="voucher">
      </div>
      <div class="mb-3">
        <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
        <select class="form-select" name="metode_pembayaran" required>
          <option value="">Pilih Metode</option>
          <option value="transfer">Transfer Bank</option>
          <option value="ewallet">E-Wallet</option>
        </select>
      </div>
      <button type="submit" class="buttonberanda">Sewa</button>
    </form>

    <?php if ($result): ?>
    <div class="table-container mb-5">
      <h3 class="text-center text-success">Hasil Sewa</h3>
      <table class="table table-bordered result-table table-striped">
        <thead class="table-dark">
          <tr>
            <th>Nama</th>
            <th>Jumlah Buku</th>
            <th>Paket (Hari)</th>
            <th>Judul Buku</th>
            <th>Subtotal</th>
            <th>Diskon Paket</th>
            <th>Diskon Voucher</th>
            <th>Biaya Admin</th>
            <th>Total Bayar</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?= htmlspecialchars($result['nama']) ?></td>
            <td><?= $result['jumlah_buku'] ?></td>
            <td><?= $result['durasi'] ?></td>
            <td><?= implode(', ', $result['buku']) ?></td>
            <td>Rp<?= number_format($result['subtotal'], 0, ',', '.') ?></td>
            <td>Rp<?= number_format($result['diskon_durasi'], 0, ',', '.') ?></td>
            <td>Rp<?= number_format($result['diskon_voucher'], 0, ',', '.') ?></td>
            <td>Rp<?= number_format($result['admin_fee'], 0, ',', '.') ?></td>
            <td><strong>Rp<?= number_format($result['total'], 0, ',', '.') ?></strong></td>
          </tr>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>

  <script>
  function generateBookInputs() {
    const jumlahBuku = document.getElementById('jumlah_buku').value;
    const container = document.getElementById('bookInputsContainer');
    container.innerHTML = '';

    for (let i = 1; i <= jumlahBuku; i++) {
      const div = document.createElement('div');
      div.className = 'mb-3';
      div.innerHTML = `
          <label class="form-label">Pilih Buku ${i}</label>
          <select class="form-select" name="buku[]" required>
            <option value="">-- Pilih Buku --</option>
            <?php foreach ($bookPrices as $judul => $harga) : ?>
              <option value="<?= htmlspecialchars($judul); ?>"><?= htmlspecialchars($judul); ?></option>
            <?php endforeach; ?>
          </select>
        `;
      container.appendChild(div);
    }
  }
  </script>
</body>

</html>