<?php
// Path relatif ke file koneksi.php dari folder Operator
include "../koneksi.php";
// Path relatif ke headerOperator.php dari folder Operator
include "../modular/headerOperator.php";

// Aktifkan pelaporan error penuh untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Pembayaran - Operator</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="../style.css" />
    <style>
        /* Margin top untuk main content agar tidak tertutup header */
        main.container {
            margin-top: 120px !important; /* Sesuaikan jika header Anda lebih tinggi */
        }

        /* Gaya umum tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 30px;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        /* Gaya tombol */
        .button {
            display: inline-block;
            padding: 8px 15px;
            margin-right: 8px;
            margin-bottom: 5px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            text-align: center;
            box-sizing: border-box;
            font-size: 0.9em;
        }

        .verifikasi {
            background-color: #28a745; /* Hijau */
        }

        .tolak {
            background-color: #dc3545; /* Merah */
        }

        /* Karena kolom bukti dihapus, tombol lihat-bukti juga tidak relevan */
        /* .lihat-bukti {
            background-color: #007bff;
        } */

        .button:hover {
            opacity: 0.9;
            text-decoration: none;
            color: white; /* Pastikan warna teks tetap putih saat hover */
        }

        /* Responsive table for smaller screens */
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

            /* Sesuaikan tombol aksi untuk layar kecil */
            td:last-child {
                text-align: left;
                padding-left: 6px; /* Reset padding untuk tombol aksi */
            }
        }
    </style>
</head>
<body>
    <main class="container">
        <h3>Daftar Pembayaran Menunggu Verifikasi</h3>
        <p>Halaman ini menampilkan semua pembayaran yang memerlukan tindakan verifikasi dari operator.</p>

        <?php
        // Periksa koneksi database
        if (!$conn) {
            echo '<div class="alert alert-danger" role="alert">Koneksi database gagal. Silakan periksa file koneksi.php Anda.</div>';
        } else {
            // SQL query untuk mengambil pembayaran dengan status 'pending'
            // Menggunakan `status_pembayaran` sesuai struktur DB Anda
            // Tidak menyertakan `p.bukti` karena kolom tersebut tidak ada di DB
            $sql = "SELECT
                        p.id_pembayaran,
                        p.jumlah,
                        p.tgl_pembayaran,
                        p.status_pembayaran,
                        pb.username AS nama_pengguna
                    FROM
                        pembayaran p
                    JOIN
                        sewa s ON p.id_sewa = s.id_sewa
                    JOIN
                        pembaca pb ON s.id_pembaca = pb.id_pembaca
                    WHERE
                        p.status_pembayaran = 'pending'
                    ORDER BY
                        p.tgl_pembayaran ASC";

            $result = $conn->query($sql);

            // Periksa apakah query berhasil dieksekusi
            if (!$result) {
                echo '<div class="alert alert-danger" role="alert">Error kueri: ' . $conn->error . '</div>';
            } elseif ($result->num_rows > 0) {
                // Tampilkan tabel jika ada data
                echo '<table class="table table-bordered">';
                echo '<thead class="table-dark">';
                echo '<tr>';
                echo '<th>ID Pembayaran</th>';
                echo '<th>Pengguna</th>';
                echo '<th>Jumlah</th>';
                echo '<th>Tanggal Pembayaran</th>';
                echo '<th>Status</th>';
                echo '<th>Aksi</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td data-label="ID Pembayaran">' . htmlspecialchars($row["id_pembayaran"]) . '</td>';
                    echo '<td data-label="Pengguna">' . htmlspecialchars($row["nama_pengguna"]) . '</td>';
                    echo '<td data-label="Jumlah">Rp ' . number_format($row["jumlah"], 0, ',', '.') . '</td>';
                    echo '<td data-label="Tanggal Pembayaran">' . htmlspecialchars($row["tgl_pembayaran"]) . '</td>';
                    echo '<td data-label="Status">' . htmlspecialchars(ucfirst($row['status_pembayaran'])) . '</td>';
                    echo '<td data-label="Aksi">';
                    // Tombol Verifikasi dan Tolak
                    // Mengarah ke prosesVerifikasiPembayaran.php
                    echo '<a href="prosesVerifikasiPembayaran.php?id=' . htmlspecialchars($row["id_pembayaran"]) . '&action=verify" class="button verifikasi">Verifikasi</a>';
                    echo '<a href="prosesVerifikasiPembayaran.php?id=' . htmlspecialchars($row["id_pembayaran"]) . '&action=reject" class="button tolak">Tolak</a>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
            } else {
                // Tampilkan pesan jika tidak ada data
                echo '<div class="alert alert-info" role="alert">Tidak ada pembayaran yang menunggu verifikasi saat ini.</div>';
            }

            // Tutup koneksi database setelah semua query selesai
            $conn->close();
        }
        ?>
    </main>

    <br><br><br><br>

    <?php
    // Include footer Anda
    include("../modular/footerFitur.php");
    ?>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../script.js"></script>
</body>
</html>