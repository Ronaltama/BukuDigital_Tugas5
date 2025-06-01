<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Operator</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="style.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            /* Adjust top margin to account for fixed header, if headerPenulis.php creates one */
            margin-top: 80px; /* Example, adjust as needed based on header height */
            margin-left: 30px;
            margin-right: 30px;
            margin-bottom: 30px;
        }
        h2, h3 {
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 30px; /* Add some space before the footer */
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

        /* --- Styles copied from your main page for consistency, though some might not be directly used here --- */
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
        /* --- End of copied styles --- */
    </style>
</head>
<body>

    <?php
    // Include the header for consistency
    include("modular/headerPenulis.php");

    // Sertakan file koneksi database
    // Make sure this file exists and handles the connection (e.g., $conn variable)
    include("koneksi.php");
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
                    echo "<a href='features/verify_buku.php?id=" . htmlspecialchars($row["id_buku"]) . "' class='button verifikasi'>Verifikasi</a>";
                    echo "<a href='features/reject_book.php?id=" . htmlspecialchars($row["id_buku"]) . "' class='button tolak'>Tolak</a>"; // Corrected folder name based on your provided HTML
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

    <?php
    // Include the footer
    include("modular/footer.php");
    ?>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    </body>
</html>