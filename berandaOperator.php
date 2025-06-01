<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Operator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        h2, h3 {
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #999;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
        }
        .button {
            display: inline-block; /* Changed to inline-block for side-by-side */
            width: 90px; /* Adjusted width */
            text-align: center;
            padding: 6px 12px;
            margin-right: 5px; /* Added margin for separation */
            margin-bottom: 5px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            box-sizing: border-box; /* Include padding and border in the element's total width and height */
        }
        .verifikasi {
            background-color: green;
        }
        .tolak {
            background-color: red;
        }
    </style>
</head>
<body>

<h2>Dashboard Operator</h2>
<p>Selamat datang, Operator <strong>[Nama Operator]</strong></p> <h3>Daftar Buku Menunggu Verifikasi</h3>

<table>
    <tr>
        <th>Judul</th>
        <th>Deskripsi</th>
        <th>Penulis</th>
        <th>Aksi</th>
    </tr>

    <?php
    // Include the database connection file
    include 'koneksi.php';

    // SQL query to fetch books with 'pending' status
    $sql = "SELECT id_buku, judul, deskripsi, id_penulis FROM buku WHERE status_verifikasi = 'pending'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["judul"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["deskripsi"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["id_penulis"]) . "</td>";
            echo "<td>";
            // Buttons to verify or reject, passing the id_buku
            echo "<a href='features/verify_buku.php?id=" . htmlspecialchars($row["id_buku"]) . "' class='button verifikasi'>Verifikasi</a>";
            echo "<a href='featured/reject_book.php?id=" . htmlspecialchars($row["id_buku"]) . "' class='button tolak'>Tolak</a>";
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

</body>
</html>