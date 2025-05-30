<?php
session_start();
include("../koneksi.php"); // file koneksi ke database
if (isset($_POST['upload'])) {
    // Sementara hardcode id_penulis untuk testing tanpa session
    $id_penulis = 'PEN0001'; // Ganti dengan ID penulis yang valid untuk testing

    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    $tanggal_terbit_from_form = $_POST['tanggal_terbit'];
    $harga_sewa = $_POST['harga_sewa'];

    $upload_cover_success = false;
    $cover_new = '';
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
        $cover_name = $_FILES['cover']['name'];
        $cover_tmp = $_FILES['cover']['tmp_name'];
        $cover_ext = pathinfo($cover_name, PATHINFO_EXTENSION);
        $cover_new = uniqid('cover_') . '.' . $cover_ext;
        $upload_path_cover = '../covers' . $cover_new; // Save cover in uploads/cover/
        $upload_cover_success = move_uploaded_file($cover_tmp, $upload_path_cover);
    } else {
        echo "Error mengunggah cover.";
    }

    $upload_buku_success = false;
    $file_buku_new = '';
    if (isset($_FILES['file_buku']) && $_FILES['file_buku']['error'] === UPLOAD_ERR_OK) {
        $file_buku_name = $_FILES['file_buku']['name'];
        $file_buku_tmp = $_FILES['file_buku']['tmp_name'];
        $file_buku_ext = strtolower(pathinfo($file_buku_name, PATHINFO_EXTENSION));
        $file_buku_new = uniqid('buku_') . '.' . $file_buku_ext;
        $upload_path_buku = '../files/' . $file_buku_new; // Save book file in the 'files' directory
        $upload_buku_success = move_uploaded_file($file_buku_tmp, $upload_path_buku);
    } else {
        echo "Error mengunggah file buku.";
    }

    if ($upload_cover_success && $upload_buku_success) {
        // Generate ID buku (misalnya: BK0001)
        $result = mysqli_query($conn, "SELECT MAX(RIGHT(id_buku, 4)) AS max_id FROM buku");
        $row = mysqli_fetch_assoc($result);
        $next_id = str_pad(((int)$row['max_id']) + 1, 4, '0', STR_PAD_LEFT);
        $id_buku = 'BK' . $next_id;

        // Simpan ke database (hanya nama file)
        $query = "INSERT INTO buku
                    (id_buku, judul, deskripsi, cover_url, file_buku, kategori, tanggal_upload, harga_sewa, id_penulis, status_verifikasi)
                    VALUES
                    ('$id_buku', '$judul', '$deskripsi', '$cover_new', '$file_buku_new', '$kategori', NOW(), '$harga_sewa', '$id_penulis', 'pending')";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Buku berhasil diunggah dan menunggu verifikasi.'); window.location.href='../halaman_penulis.php';</script>";
        } else {
            echo "Gagal menyimpan ke database: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal mengunggah cover atau file buku.";
    }
}
?>