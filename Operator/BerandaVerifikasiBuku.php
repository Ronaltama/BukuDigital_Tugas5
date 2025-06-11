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
  /* Tambahkan atau sesuaikan gaya CSS yang dibutuhkan di sini */
  .scroll-container {
    overflow-x: auto;
    /* Mengaktifkan scroll horizontal */
    white-space: nowrap;
    /* Mencegah item melompat ke baris baru */
    -webkit-overflow-scrolling: touch;
    /* Untuk scrolling yang lebih halus di iOS */
    padding-bottom: 10px;
    /* Ruang untuk scrollbar */
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
    /* Pastikan tombol terlihat */
    border: 1px solid #eee;
    /* Tambah border agar lebih jelas */
  }

  .scroll-btn.left {
    left: -20px;
    /* Sesuaikan posisi agar tombol terlihat */
  }

  .scroll-btn.right {
    right: -20px;
    /* Sesuaikan posisi agar tombol terlihat */
  }

  .book-card {
    width: 200px;
    /* Sesuaikan lebar kartu buku */
    flex-shrink: 0;
    /* Penting untuk mencegah item menyusut dalam flexbox */
  }

  .book-card .card-img-top {
    height: 250px;
    /* Tinggi gambar cover yang konsisten */
    object-fit: cover;
    /* Menjaga rasio aspek gambar */
  }

  h3 {
    margin-bottom: 10px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
    margin-bottom: 30px;
    /* Add some space before the footer */
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

  --- End of copied styles ---
  </style>
</head>

<body>

  <?php
    // Include the header for consistency
    include("../modular/headerOperator.php");

    // Sertakan file koneksi database
    // Make sure this file exists and handles the connection (e.g., $conn variable)
    include("../koneksi.php");
    ?>

  <main class="container mt-5" style="margin-top: 120px !important;">
    <h2>Dashboard Operator</h2>
    <p>Selamat datang, Operator <strong>[Nama Operator]</strong></p>

    <h3>Daftar Buku Menunggu Verifikasi</h3>

    <table>
      <tr>
        <th>Judul</th>
        <th>Deskripsi</th>
        <th>Penulis</th>
        <th>Aksi</th>
      </tr>

      <?php
            // SQL query to fetch books with 'pending' status
            $sql = "SELECT b.id_buku, b.judul, b.deskripsi, p.username AS id_penulis
                    FROM buku b
                    JOIN penulis p ON b.id_penulis = p.id_penulis
                    WHERE b.status_verifikasi = 'pending'"; // Changed to 'b.status_verifikasi' to be explicit
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) { // Check if query was successful and has rows
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["judul"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["deskripsi"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["id_penulis"]) . "</td>"; // Displaying username of penulis
                    echo "<td>";
                    // Buttons to verify or reject, passing the id_buku
                    echo "<a href='prosesVerifikasi.php?id=" . htmlspecialchars($row["id_buku"]) . "' class='button verifikasi'>Verifikasi</a>";
                    echo "<a href='reject_book.php?id=" . htmlspecialchars($row["id_buku"]) . "' class='button tolak'>Tolak</a>"; // Corrected folder name based on your provided HTML
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada buku yang menunggu verifikasi.</td></tr>";
            }

            // Close database connection
            $conn->close();
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