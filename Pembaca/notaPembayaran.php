<?php
session_start();

// Ambil id_pembaca dari session untuk ditampilkan di nota
$id_pembaca_logged_in = $_SESSION['id_pembaca'] ?? 'Tidak Diketahui'; // Ambil dari session atau fallback

if (!isset($_SESSION['transaction_details'])) {
    header("Location: sewaBuku.php");
    exit();
}

$details = $_SESSION['transaction_details'];
unset($_SESSION['transaction_details']);

$qr_data = "ID Transaksi: " . $details['id_sewa'] . "\n";
$qr_data .= "Total Bayar: Rp" . number_format($details['total_bayar'], 0, ',', '.') . "\n";
$qr_data .= "Metode: " . $details['metode_pembayaran'] . "\n";
$qr_data .= "Tanggal: " . $details['tgl_sewa'];

$qr_code_url = "https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=" . urlencode($qr_data);

?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Nota Pembayaran Sewa Buku</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../style.css" />
  <style>
  body {
    background-color: #e9ecef;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .invoice-box {
    max-width: 800px;
    margin: auto;
    padding: 30px;
    border: 1px solid #eee;
    box-shadow: 0 0 10px rgba(0, 0, 0, .15);
    font-size: 16px;
    line-height: 24px;
    font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    color: #555;
    background-color: #fff;
    border-radius: 8px;
  }

  .invoice-box table {
    width: 100%;
    line-height: inherit;
    text-align: left;
  }

  .invoice-box table td {
    padding: 5px;
    vertical-align: top;
  }

  .invoice-box table tr td:nth-child(2) {
    text-align: right;
  }

  .invoice-box table tr.top table td {
    padding-bottom: 20px;
  }

  .invoice-box table tr.top table td.title {
    font-size: 45px;
    line-height: 45px;
    color: #333;
  }

  .invoice-box table tr.information table td {
    padding-bottom: 40px;
  }

  .invoice-box table tr.heading td {
    background: #eee;
    border-bottom: 1px solid #ddd;
    font-weight: bold;
  }

  .invoice-box table tr.details td {
    padding-bottom: 20px;
  }

  .invoice-box table tr.item td {
    border-bottom: 1px solid #eee;
  }

  .invoice-box table tr.item.last td {
    border-bottom: none;
  }

  .invoice-box table tr.total td:nth-child(2) {
    border-top: 2px solid #eee;
    font-weight: bold;
  }

  @media only screen and (max-width: 600px) {
    .invoice-box table tr.top table td {
      width: 100%;
      display: block;
      text-align: center;
    }

    .invoice-box table tr.information table td {
      width: 100%;
      display: block;
      text-align: center;
    }
  }

  .qr-code {
    text-align: center;
    margin-top: 20px;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
    box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.05);
  }

  .qr-code img {
    border: 1px solid #ddd;
    padding: 5px;
    background-color: #fff;
  }

  .btn-print {
    margin-top: 20px;
  }
  </style>
</head>

<body>
  <?php include("../modular/headerPembaca.php"); ?>

  <div class="container mt-5">
    <div class="invoice-box">
      <table cellpadding="0" cellspacing="0">
        <tr class="top">
          <td colspan="2">
            <table>
              <tr>
                <td class="title">
                  Digital Book
                </td>
                <td>
                  Nota #<?= htmlspecialchars($details['id_sewa']) ?><br>
                  Tanggal Sewa: <?= date('d F Y', strtotime($details['tgl_sewa'])) ?><br>
                  Tanggal Kembali: <?= date('d F Y', strtotime($details['tgl_kembali'])) ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <tr class="information">
          <td colspan="2">
            <table>
              <tr>
                <td>
                  Pelanggan:<br>
                  <?= htmlspecialchars($id_pembaca_logged_in) ?>
                </td>
                <td>
                  Metode Pembayaran:<br>
                  <?= htmlspecialchars(ucwords($details['metode_pembayaran'])) ?><br>
                  Status: <?= htmlspecialchars(ucwords($details['status_pembayaran'])) ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <tr class="heading">
          <td>Deskripsi</td>
          <td>Harga</td>
        </tr>

        <tr class="item">
          <td>Sewa Buku: <?= htmlspecialchars($details['judul_buku']) ?></td>
          <td>Harga Bulanan (dari DB): Rp<?= number_format($details['harga_per_hari_base'], 0, ',', '.') ?></td>
        </tr>
        <tr class="item last">
          <td>Harga Paket <?= htmlspecialchars($details['durasi']) ?> Hari</td>
          <td>Rp<?= number_format($details['harga_paket_dasar'], 0, ',', '.') ?></td>
        </tr>

        <tr class="total">
          <td></td>
          <td>Total Bayar: Rp<?= number_format($details['total_bayar'], 0, ',', '.') ?></td>
        </tr>
      </table>

      <div class="qr-code">
        <h4>Scan untuk Pembayaran</h4>
        <p>Silakan lakukan pembayaran sesuai total yang tertera. Scan QR Code di bawah ini untuk instruksi pembayaran.
        </p>
        <img src="<?= $qr_code_url ?>" alt="QR Code Pembayaran">
        <p class="small text-muted mt-2">
          (Ini adalah contoh QR Code. Untuk pembayaran nyata, integrasikan dengan Payment Gateway.)
        </p>
      </div>

      <div class="text-center mt-4">
        <button onclick="window.print()" class="btn btn-info btn-print me-2"><i class="fas fa-print"></i> Cetak
          Nota</button>
        <a href="BerandaPembaca.php" class="btn btn-secondary"><i class="fas fa-home"></i> Kembali ke Beranda</a>
      </div>
    </div>
  </div>
  <br><br><br><br>
  <?php include("../modular/footerFitur.php"); ?>
</body>

</html>