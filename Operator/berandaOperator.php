<?php
// Include necessary header and database connection
include("../modular/headerOperator.php");

// Sertakan file koneksi database
include("../koneksi.php"); // Ensure this file establishes $conn

// Aktifkan pelaporan error penuh untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize counts
$pendingBooksCount = 0;
$pendingPaymentsCount = 0;
$rejectedBooksCount = 0;

// Fetch counts from database if connection is successful
if ($conn) {
    // Count for Pending Books (status_verifikasi di tabel buku sudah benar)
    $sqlBooksCount = "SELECT COUNT(*) AS total FROM buku WHERE status_verifikasi = 'pending'";
    $resultBooksCount = $conn->query($sqlBooksCount);
    if ($resultBooksCount && $resultBooksCount->num_rows > 0) {
        $rowBooksCount = $resultBooksCount->fetch_assoc();
        $pendingBooksCount = $rowBooksCount['total'];
    }

    // Count for Pending Payments (MENGGUNAKAN `status_pembayaran`)
    $sqlPaymentsCount = "SELECT COUNT(*) AS total FROM pembayaran WHERE status_pembayaran = 'pending'";
    $resultPaymentsCount = $conn->query($sqlPaymentsCount);
    if ($resultPaymentsCount && $resultPaymentsCount->num_rows > 0) {
        $rowPaymentsCount = $resultPaymentsCount->fetch_assoc();
        $pendingPaymentsCount = $rowPaymentsCount['total'];
    }

    // Count for Rejected Books
    $sqlRejectedBooksCount = "SELECT COUNT(*) AS total FROM buku WHERE status_verifikasi = 'ditolak'";
    $resultRejectedBooksCount = $conn->query($sqlRejectedBooksCount);
    if ($resultRejectedBooksCount && $resultRejectedBooksCount->num_rows > 0) {
        $rowRejectedBooksCount = $resultRejectedBooksCount->fetch_assoc();
        $rejectedBooksCount = $rowRejectedBooksCount['total'];
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard Operator</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="../style.css" />
    <style>
        /* ... (CSS Anda tidak berubah) ... */

        /* Tambahkan atau sesuaikan gaya CSS yang dibutuhkan di sini */
        .scroll-container {
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 10px;
        }

        .scroll-container::-webkit-scrollbar {
            height: 8px;
        }

        .scroll-container::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 4px;
        }

        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            background-color: #fff;
            border: 1px solid #eee;
        }

        .scroll-btn.left {
            left: -20px;
        }

        .scroll-btn.right {
            right: -20px;
        }

        .book-card {
            width: 200px;
            flex-shrink: 0;
        }

        .book-card .card-img-top {
            height: 250px;
            object-fit: cover;
        }

        h3 {
            margin-top: 30px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 30px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #999;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
        }

        .button {
            display: inline-block;
            width: 90px;
            text-align: center;
            padding: 6px 12px;
            margin-right: 5px;
            margin-bottom: 5px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            box-sizing: border-box;
        }

        .verifikasi {
            background-color: green;
        }

        .tolak {
            background-color: red;
        }

        /* --- Dashboard Card Styles --- */
        .dashboard-overview {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 40px;
        }

        .dashboard-card {
            background-color: #f8f9fa;
            border: 1px solid #e2e6ea;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            width: 30%;
            min-width: 250px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-card h4 {
            margin-top: 0;
            color: #343a40;
            font-size: 1.2em;
        }

        .dashboard-card .count {
            font-size: 2.5em;
            font-weight: bold;
            color: #007bff;
            margin: 10px 0;
        }

        .dashboard-card .card-link {
            display: block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }

        .card-link.inactive {
            color: #6c757d;
            pointer-events: none;
            cursor: default;
        }


        .dashboard-card .card-link:hover {
            text-decoration: underline;
        }

        /* Responsive table for mobile views */
        @media screen and (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }

            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tr {
                border: 1px solid #ccc;
                margin-bottom: 10px;
            }

            td {
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
                text-align: right;
            }

            td:before {
                position: absolute;
                top: 6px;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                content: attr(data-label);
                font-weight: bold;
                text-align: left;
            }

            /* Adjust action buttons for smaller screens */
            td:last-child {
                text-align: left;
                padding-left: 6px;
            }
        }
    </style>
</head>

<body>

    <main class="container mt-5" style="margin-top: 120px !important;">
        <h2>Dashboard Operator</h2>
        <p>Selamat datang, Operator <strong>[Nama Operator]</strong></p>
        <div class="dashboard-overview">
            <div class="dashboard-card">
                <h4>Pembayaran Menunggu Verifikasi</h4>
                <div class="count"><?php echo $pendingPaymentsCount; ?></div>
                <a href="verifikasipemayaran.php" class="card-link <?php echo ($pendingPaymentsCount == 0) ? 'inactive' : ''; ?>">Lihat Detail Pembayaran</a>
            </div>
            <div class="dashboard-card">
                <h4>Buku Menunggu Verifikasi</h4>
                <div class="count"><?php echo $pendingBooksCount; ?></div>
                <a href="prosesVerifikasi.php" class="card-link <?php echo ($pendingBooksCount == 0) ? 'inactive' : ''; ?>">Lihat Detail Buku</a>
            </div>
            <div class="dashboard-card">
                <h4>Buku Ditolak</h4>
                <div class="count"><?php echo $rejectedBooksCount; ?></div>
                <a href="reject_book.php" class="card-link <?php echo ($rejectedBooksCount == 0) ? 'inactive' : ''; ?>">Lihat Detail Buku Ditolak</a>
            </div>
        </div>

        <h3>Daftar Pembayaran Menunggu Verifikasi</h3>
        <table>
            <tr>
                <th>ID Pembayaran</th>
                <th>Pengguna</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Status</th> <th>Aksi</th>
            </tr>

            <?php
            if ($conn) {
                // SQL query to fetch payments with 'pending' status, joining 'sewa' and 'pembaca' tables
                // MENGGUNAKAN `status_pembayaran` dan MENGHAPUS `p.bukti`
                $sqlPayments = "SELECT
                                    p.id_pembayaran,
                                    p.jumlah,
                                    p.tgl_pembayaran,
                                    p.status_pembayaran, -- Menggunakan kolom yang ada di DB Anda
                                    pb.username AS nama_pengguna
                                FROM
                                    pembayaran p
                                JOIN
                                    sewa s ON p.id_sewa = s.id_sewa
                                JOIN
                                    pembaca pb ON s.id_pembaca = pb.id_pembaca
                                WHERE
                                    p.status_pembayaran = 'pending' -- Menggunakan status yang ada di DB Anda
                                ORDER BY
                                    p.tgl_pembayaran ASC";
                $resultPayments = $conn->query($sqlPayments);

                if (!$resultPayments) {
                    echo "<tr><td colspan='6'>Error kueri: " . $conn->error . "</td></tr>"; // colspan disesuaikan
                } elseif ($resultPayments->num_rows > 0) {
                    while ($rowPayment = $resultPayments->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td data-label='ID Pembayaran'>" . htmlspecialchars($rowPayment["id_pembayaran"]) . "</td>";
                        echo "<td data-label='Pengguna'>" . htmlspecialchars($rowPayment["nama_pengguna"]) . "</td>";
                        echo "<td data-label='Jumlah'>Rp " . number_format($rowPayment["jumlah"], 0, ',', '.') . "</td>";
                        echo "<td data-label='Tanggal'>" . htmlspecialchars($rowPayment["tgl_pembayaran"]) . "</td>";
                        echo "<td data-label='Status'>" . htmlspecialchars(ucfirst($rowPayment["status_pembayaran"])) . "</td>"; // Menampilkan status
                        echo "<td data-label='Aksi'>";
                        // Link ke prosesVerifikasiPembayaran.php
                        echo "<a href='prosesVerifikasiPembayaran.php?id=" . htmlspecialchars($rowPayment["id_pembayaran"]) . "&action=verify' class='button verifikasi'>Verifikasi</a>";
                        echo "<a href='prosesVerifikasiPembayaran.php?id=" . htmlspecialchars($rowPayment["id_pembayaran"]) . "&action=reject' class='button tolak'>Tolak</a>";
                        // Karena kolom 'bukti' tidak ada, tombol 'Lihat Bukti' juga tidak relevan di sini
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Tidak ada pembayaran yang menunggu verifikasi saat ini.</td></tr>"; // colspan disesuaikan
                }
            } else {
                 echo "<tr><td colspan='6'>Koneksi database gagal.</td></tr>"; // colspan disesuaikan
            }
            ?>
        </table>

        <h3>Daftar Buku Menunggu Verifikasi</h3>
        <table>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Penulis</th>
                <th>Aksi</th>
            </tr>

            <?php
            // Logic verifikasi buku yang sudah ada
            if ($conn) {
                // Pastikan status_verifikasi untuk buku sudah benar
                $sqlBooks = "SELECT b.id_buku, b.judul, b.deskripsi, p.username AS nama_penulis
                             FROM buku b
                             JOIN penulis p ON b.id_penulis = p.id_penulis
                             WHERE b.status_verifikasi = 'pending'
                             ORDER BY b.tanggal_upload ASC";
                $resultBooks = $conn->query($sqlBooks);

                if (!$resultBooks) {
                     echo "<tr><td colspan='4'>Error kueri buku: " . $conn->error . "</td></tr>";
                } elseif ($resultBooks->num_rows > 0) {
                    while ($rowBook = $resultBooks->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td data-label='Judul'>" . htmlspecialchars($rowBook["judul"]) . "</td>";
                        echo "<td data-label='Deskripsi'>" . htmlspecialchars($rowBook["deskripsi"]) . "</td>";
                        echo "<td data-label='Penulis'>" . htmlspecialchars($rowBook["nama_penulis"]) . "</td>";
                        echo "<td data-label='Aksi'>";
                        // Link ke prosesVerifikasi.php (pastikan file ini ada)
                        echo "<a href='prosesVerifikasi.php?id=" . htmlspecialchars($rowBook["id_buku"]) . "&action=verify' class='button verifikasi'>Verifikasi</a>";
                        // Link ke reject_book.php (pastikan file ini ada)
                        echo "<a href='reject_book.php?id=" . htmlspecialchars($rowBook["id_buku"]) . "&action=reject' class='button tolak'>Tolak</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ada buku yang menunggu verifikasi.</td></tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Koneksi database gagal.</td></tr>";
            }
            // Tutup koneksi database setelah semua query selesai
            if ($conn) {
                $conn->close();
            }
            ?>
        </table>
    </main>

    <br><br><br><br>

    <?php
    // Include the footer
    include("../modular/footerFitur.php");
    ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../script.js"></script>
</body>

</html>