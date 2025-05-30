<?php
header('Content-Type: application/json'); // Beri tahu browser bahwa respons adalah JSON

// Konfigurasi Database
$servername = "localhost";
$username = "root"; // Ganti dengan username database kamu
$password = "";     // Ganti dengan password database kamu
$dbname = "nama_database_kamu"; // Ganti dengan nama database kamu

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die(json_encode(["error" => "Koneksi database gagal: " . $conn->connect_error]));
}

// Ambil query pencarian dari parameter URL (GET)
$search_query = isset($_GET['query']) ? $_GET['query'] : '';

$results = [];

if (!empty($search_query)) {
    // Sanitize input untuk mencegah SQL Injection
    $search_query = $conn->real_escape_string($search_query);

    // Bangun query SQL dengan JOIN ke tabel 'penulis'
    // Alias 'b' untuk tabel 'buku' dan 'p' untuk tabel 'penulis'
    $sql = "SELECT 
                b.id_buku, 
                b.judul, 
                p.nama_penulis, -- Mengambil nama penulis dari tabel 'penulis'
                b.deskripsi,
                b.cover_url,
                b.rating,
                b.harga_sewa,
                b.file_buku,
                b.kategori,
                b.status_verifikasi,
                b.tanggal_upload,
                b.id_operator
            FROM 
                buku AS b
            JOIN 
                penulis AS p ON b.id_penulis = p.id_penulis
            WHERE 
                b.judul LIKE '%$search_query%' 
                OR p.nama_penulis LIKE '%$search_query%'"; // Mencari di kolom nama_penulis

    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $results[] = $row;
            }
        }
    } else {
        // Tangani error query
        echo json_encode(["error" => "Error dalam query: " . $conn->error]);
        $conn->close();
        exit();
    }
}

// Kembalikan hasil dalam format JSON
echo json_encode($results);

// Tutup koneksi database
$conn->close();
?>