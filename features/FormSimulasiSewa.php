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
    3  => 0,      // 3 hari -> 0% diskon
    7  => 0.05,   // 7 hari -> 5%
    14 => 0.1,    // 14 hari -> 10%
    30 => 0.15,   // 30 hari -> 15%
];

// Biaya admin
$adminFees = [
    "transfer" => 2000,
    "ewallet"  => 2500,
];

// Diskon voucher
$voucherDiscounts = [
    "DIGI20"       => 0.2,
    "GEMARMEMBACA" => 0.1,
];

$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama             = $_POST['nama'];
    $jumlahBuku       = (int) $_POST['jumlah_buku'];
    $bukuDipilih      = $_POST['buku'];
    $durasiDipilih    = $_POST['durasi_per_buku'];
    $voucher          = strtoupper(trim($_POST['voucher']));
    $metodePembayaran = $_POST['metode_pembayaran'];
    $tanggalMulai     = $_POST['tanggal_sewa']; // yyyy-mm-dd

    $subtotal   = 0;
    $detailBuku = [];

    // Proses tiap buku menggunakan for
    for ($i = 0; $i < $jumlahBuku; $i++) { 
        $judul = $bukuDipilih[$i];
        if (! isset($bookPrices[$judul])) { 
            continue;
        }
        $hargaAsli = $bookPrices[$judul];
        $durasi    = (int) $durasiDipilih[$i];

        // diskon durasi
        $diskonDurasi = isset($durationDiscounts[$durasi])
            ? $hargaAsli * $durationDiscounts[$durasi]
            : 0;
        $hargaAkhir = $hargaAsli - $diskonDurasi;
        $subtotal  += $hargaAkhir;

        // hitung tanggal berakhir
        $tsMulai   = strtotime($tanggalMulai);
        $tsAkhir   = strtotime("+{$durasi} days", $tsMulai);
        $tglMulai  = date('d-m-Y', $tsMulai);
        $tglAkhir  = date('d-m-Y', $tsAkhir);

        $detailBuku[] = [
            'judul'              => $judul,
            'harga_asli'         => $hargaAsli,
            'durasi'             => $durasi,
            'diskon_durasi'      => $diskonDurasi,
            'harga_setelah_diskon' => $hargaAkhir,
            'tgl_mulai'          => $tglMulai,
            'tgl_berakhir'       => $tglAkhir,
        ];
    }

    // voucher & admin
    $diskonVoucher = isset($voucherDiscounts[$voucher])
        ? $subtotal * $voucherDiscounts[$voucher]
        : 0;
    $adminFee = isset($adminFees[$metodePembayaran])
        ? $adminFees[$metodePembayaran]
        : 0;

    $total = $subtotal - $diskonVoucher + $adminFee;

    $result = [
        'nama'            => $nama,
        'jumlah_buku'     => $jumlahBuku,
        'tanggal_mulai'   => date('d-m-Y', strtotime($tanggalMulai)),
        'buku'            => $detailBuku,
        'subtotal'        => $subtotal,
        'diskon_voucher'  => $diskonVoucher,
        'admin_fee'       => $adminFee,
        'total'           => $total,
    ];
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Form Sewa Buku</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <style>
  body {
    background: #f9f9f9;
  }

  .buttonberanda {
    background: #ffc107;
    border-radius: 5px;
    width: 100px;
    height: 40px;
    border: none;
    color: #000;
  }
  </style>
</head>

<body>
  <?php include("../modular/header.php"); ?>
  <br>
  <div class="container mt-4">
    <h2 class="text-center text-success mb-4">Sewa Buku Digital Online</h2>
    <form method="post">
      <div class="mb-3">
        <label class="form-label">Nama Penyewa</label>
        <input type="text" name="nama" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Jumlah Buku</label>
        <input type="number" id="jumlah_buku" name="jumlah_buku" class="form-control" min="1" required
          onchange="generateBookInputs()">
      </div>
      <div id="bookInputsContainer"></div>
      <div class="mb-3">
        <label class="form-label">Tanggal Mulai Sewa</label>
        <input type="date" name="tanggal_sewa" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Voucher (Opsional)</label>
        <input type="text" name="voucher" class="form-control">
      </div>
      <div class="mb-3">
        <label class="form-label">Metode Pembayaran</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" id="transfer" name="metode_pembayaran" value="transfer" required>
          <label class="form-check-label" for="transfer">Transfer Bank</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" id="ewallet" name="metode_pembayaran" value="ewallet">
          <label class="form-check-label" for="ewallet">E-Wallet</label>
        </div>
      </div>

      <button type="submit" class="buttonberanda">Sewa</button>
    </form>

    <?php if ($result): ?>
    <div class="card mt-4">
      <div class="card-header text-center">
        <h3>HASIL TRANSAKSI</h3>
        <p>Perpustakaan Digital</p>
      </div>
      <div class="card-body">
        <div class="row mb-3">
          <div class="col-md-6">
            <p><strong>Nama:</strong> <?= htmlspecialchars($result['nama']) ?></p>
            <p><strong>Jumlah Buku:</strong> <?= $result['jumlah_buku'] ?></p>
            <p><strong>Tgl. Mulai Sewa:</strong> <?= $result['tanggal_mulai'] ?></p>
          </div>
          <div class="col-md-6 text-end">
            <p><strong>Tgl. Cetak:</strong> <?= date('d-m-Y') ?></p>
            <p><strong>No. Transaksi:</strong> INV-<?= date('Ymd') ?>-<?= rand(1000,9999) ?></p>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered">
            <thead class="table-dark">
              <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Durasi</th>
                <th>Tgl. Berakhir</th>
                <th>Harga Asli</th>
                <th>Diskon</th>
                <th>Harga Akhir</th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i=0; $i < count($result['buku']); $i++): 
                $b = $result['buku'][$i]; ?>
              <tr>
                <td><?= $i+1 ?></td>
                <td><?= htmlspecialchars($b['judul']) ?></td>
                <td class="text-center"><?= $b['durasi'] ?> hari</td>
                <td class="text-center"><?= $b['tgl_berakhir'] ?></td>
                <td class="text-end">Rp<?= number_format($b['harga_asli'],0,',','.') ?></td>
                <td class="text-end">Rp<?= number_format($b['diskon_durasi'],0,',','.') ?></td>
                <td class="text-end">Rp<?= number_format($b['harga_setelah_diskon'],0,',','.') ?></td>
              </tr>
              <?php endfor; ?>
            </tbody>
          </table>
        </div>

        <div class="row mt-3">
          <div class="col-md-6">
            <div class="alert alert-info">
              <p class="mb-0"><strong>Catatan:</strong></p>
              <p class="mb-0">– Periode pinjam sesuai paket</p>
              <p class="mb-0">– Akses buku hanya via website</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between">
                  <span>Subtotal:</span><span>Rp<?= number_format($result['subtotal'],0,',','.') ?></span>
                </div>
                <div class="d-flex justify-content-between"><span>Diskon
                    Voucher:</span><span>Rp<?= number_format($result['diskon_voucher'],0,',','.') ?></span></div>
                <div class="d-flex justify-content-between"><span>Biaya
                    Admin:</span><span>Rp<?= number_format($result['admin_fee'],0,',','.') ?></span></div>
                <hr>
                <div class="d-flex justify-content-between fw-bold"><span>Total
                    Bayar:</span><span>Rp<?= number_format($result['total'],0,',','.') ?></span></div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="card-footer text-center">
        <small>Cetak: <?= date('d/m/Y H:i:s') ?></small>
      </div>
    </div>
    <?php endif; ?>
  </div>

  <script>
  function generateBookInputs() {
    const n = document.getElementById('jumlah_buku').value;
    const c = document.getElementById('bookInputsContainer');
    c.innerHTML = '';
    for (let i = 1; i <= n; i++) {
      const div = document.createElement('div');
      div.className = 'mb-3';
      div.innerHTML = `
          <label class="form-label">Buku ${i}</label>
          <select name="buku[]" class="form-select mb-2" required>
            <option value="">-- Pilih Buku --</option>
            <?php foreach($bookPrices as $j=>$h): ?>
              <option value="<?= htmlspecialchars($j) ?>"><?= htmlspecialchars($j) ?></option>
            <?php endforeach; ?>
          </select>
          <label class="form-label">Durasi ${i}</label>
          <select name="durasi_per_buku[]" class="form-select" required>
            <option value="">-- Pilih Paket --</option>
            <option value="3">3 Hari</option>
            <option value="7">7 Hari</option>
            <option value="14">14 Hari</option>
            <option value="30">30 Hari</option>
          </select>
        `;
      c.appendChild(div);
    }
  }
  </script>
</body>

</html>