<?php
session_start();
include("../config/koneksi.php");  // file koneksi ke database

if (isset($_POST['upload'])) {
    $id_penulis = $_SESSION['id_penulis']; // pastikan session ini sudah diset
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    $tanggal_terbit = $_POST['tanggal_terbit'];
    $harga = $_POST['harga'];

    // Handle upload cover
    $cover_name = $_FILES['cover']['name'];
    $cover_tmp = $_FILES['cover']['tmp_name'];
    $cover_ext = pathinfo($cover_name, PATHINFO_EXTENSION);
    $cover_new = uniqid('cover_') . '.' . $cover_ext;
    $upload_path = 'uploads/' . $cover_new;

    if (move_uploaded_file($cover_tmp, $upload_path)) {
        // Generate ID buku (misalnya: BK0001)
        $result = mysqli_query($conn, "SELECT MAX(RIGHT(id_buku, 4)) AS max_id FROM buku");
        $row = mysqli_fetch_assoc($result);
        $next_id = str_pad(((int)$row['max_id']) + 1, 4, '0', STR_PAD_LEFT);
        $id_buku = 'BK' . $next_id;

        // Simpan ke database
        $query = "INSERT INTO buku 
                  (id_buku, judul, deskripsi, cover, kategori, tanggal_terbit, harga, id_penulis, status_verifikasi) 
                  VALUES 
                  ('$id_buku', '$judul', '$deskripsi', '$cover_new', '$kategori', '$tanggal_terbit', '$harga', '$id_penulis', 'pending')";

        if (mysqli_query($conn, $query)) {
            echo "Buku berhasil diunggah dan menunggu verifikasi.";
        } else {
            echo "Gagal menyimpan ke database: " . mysqli_error($conn);
        }
    } else {
        echo "Upload cover gagal.";
    }
}
?>
