<?php
// Aktifkan pelaporan error untuk debugging selama development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); // WAJIB di paling atas
include("../koneksi.php"); // file koneksi ke database

// 1. Verifikasi apakah pengguna sudah login sebagai penulis
if (!isset($_SESSION['id_penulis']) || empty($_SESSION['id_penulis'])) {
    $_SESSION['message'] = "Anda harus login sebagai penulis untuk mengunggah buku.";
    $_SESSION['msg_type'] = "danger";
    header("Location: ../features/loginpage.php");
    exit();
}

$id_penulis_session = $_SESSION['id_penulis'];

// Default ID Operator (PASTIKAN ID INI ADA DI TABEL 'operator')
$id_operator_default = 'OP01'; // Ganti jika perlu, tapi pastikan valid

// Definisikan Base URL Anda (SESUAIKAN JIKA PERLU)
$base_url_host = "http://" . $_SERVER['HTTP_HOST']; // Misal: http://localhost
$project_folder_path = "/Web%20Buku%20Digital%20Online/BukuDigital_Tugas5"; // Sesuaikan dengan path folder proyek Anda dari htdocs

$base_url_covers = $base_url_host . $project_folder_path . "/covers/";
$base_url_files = $base_url_host . $project_folder_path . "/files/";


if (isset($_POST['upload'])) {
    // Ambil data dari form
    $judul = trim($_POST['judul']);
    $deskripsi = trim($_POST['deskripsi']);
    $kategori = $_POST['kategori'];
    // Di UnggahBuku.php, pastikan input tanggal memiliki name="tanggal_upload"
    $tanggal_upload_from_form = $_POST['tanggal_upload'];
    $harga_sewa_str = $_POST['harga_sewa'];

    // Validasi input dasar
    if (empty($judul) || empty($deskripsi) || empty($kategori) || empty($tanggal_upload_from_form) || !isset($_FILES['cover']) || $_FILES['cover']['error'] == UPLOAD_ERR_NO_FILE || !isset($_FILES['file_buku']) || $_FILES['file_buku']['error'] == UPLOAD_ERR_NO_FILE) {
        $_SESSION['message'] = "Semua kolom bertanda (*) dan file (Cover & PDF Buku) wajib diisi.";
        $_SESSION['msg_type'] = "danger";
        header("Location: UnggahBuku.php");
        exit();
    }

    if (!is_numeric($harga_sewa_str) || (float)$harga_sewa_str < 0) {
        $_SESSION['message'] = "Harga sewa harus berupa angka dan tidak boleh negatif.";
        $_SESSION['msg_type'] = "danger";
        header("Location: UnggahBuku.php");
        exit();
    }
    $harga_sewa = (float)$harga_sewa_str;

    $cover_url_to_db = null; // Akan menyimpan URL lengkap
    $file_buku_url_to_db = null; // Akan menyimpan URL lengkap
    $upload_cover_success = false;
    $upload_buku_success = false;
    $upload_path_cover_server = null; // Path fisik di server
    $upload_path_buku_server = null;  // Path fisik di server

    // Proses Upload Cover
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
        $cover_tmp = $_FILES['cover']['tmp_name'];
        $cover_filename_only = uniqid('cover_') . '.' . strtolower(pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION));
        $allowed_cover_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array(strtolower(pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION)), $allowed_cover_ext)) {
            $upload_path_cover_server = '../covers/' . $cover_filename_only;
            if (!is_dir('../covers/')) {
                mkdir('../covers/', 0775, true);
            }
            if (move_uploaded_file($cover_tmp, $upload_path_cover_server)) {
                $upload_cover_success = true;
                $cover_url_to_db = $base_url_covers . rawurlencode($cover_filename_only); // Buat URL lengkap
            } else {
                $_SESSION['message'] = "Gagal memindahkan file cover. Cek izin folder '../covers/'.";
                $_SESSION['msg_type'] = "danger";
            }
        } else {
            $_SESSION['message'] = "Format file cover tidak diizinkan (Hanya JPG, JPEG, PNG, GIF).";
            $_SESSION['msg_type'] = "danger";
        }
    } else if (isset($_FILES['cover']) && $_FILES['cover']['error'] !== UPLOAD_ERR_NO_FILE) {
        $_SESSION['message'] = "Error unggah cover (Code: " . $_FILES['cover']['error'] . ").";
        $_SESSION['msg_type'] = "danger";
    }

    if (!$upload_cover_success) {
        header("Location: UnggahBuku.php");
        exit();
    }

    // Proses Upload File Buku (PDF)
    if (isset($_FILES['file_buku']) && $_FILES['file_buku']['error'] === UPLOAD_ERR_OK) {
        $file_buku_tmp = $_FILES['file_buku']['tmp_name'];
        $file_buku_filename_only = uniqid('buku_') . '.' . strtolower(pathinfo($_FILES['file_buku']['name'], PATHINFO_EXTENSION));

        if (strtolower(pathinfo($_FILES['file_buku']['name'], PATHINFO_EXTENSION)) === 'pdf') {
            $upload_path_buku_server = '../files/' . $file_buku_filename_only;
            if (!is_dir('../files/')) {
                mkdir('../files/', 0775, true);
            }
            if (move_uploaded_file($file_buku_tmp, $upload_path_buku_server)) {
                $upload_buku_success = true;
                $file_buku_url_to_db = $file_buku_filename_only; // Hanya simpan nama file saja
            } else {
                $_SESSION['message'] = "Gagal memindahkan file buku PDF. Cek izin folder '../files/'.";
                $_SESSION['msg_type'] = "danger";
            }
        } else {
            $_SESSION['message'] = "Format file buku harus PDF.";
            $_SESSION['msg_type'] = "danger";
        }
    } else if (isset($_FILES['file_buku']) && $_FILES['file_buku']['error'] !== UPLOAD_ERR_NO_FILE) {
        $_SESSION['message'] = "Error unggah file buku (Code: " . $_FILES['file_buku']['error'] . ").";
        $_SESSION['msg_type'] = "danger";
    }
    
    if (!$upload_buku_success) {
        if ($upload_cover_success && $upload_path_cover_server && file_exists($upload_path_cover_server)) {
            unlink($upload_path_cover_server); // Hapus cover jika buku gagal
        }
        header("Location: UnggahBuku.php");
        exit();
    }

    if ($upload_cover_success && $upload_buku_success) {
        $result_id = $conn->query("SELECT MAX(SUBSTRING(id_buku, 4, 3)) AS max_id_num FROM buku WHERE id_buku LIKE 'BKU%'");
        $row_id = $result_id->fetch_assoc();
        $next_id_num = $row_id['max_id_num'] ? ((int)$row_id['max_id_num']) + 1 : 1;
        $next_id_padded = str_pad($next_id_num, 3, '0', STR_PAD_LEFT);
        $id_buku_generated = 'BKU' . $next_id_padded;

        $tanggal_upload_for_db = date('Y-m-d', strtotime($tanggal_upload_from_form));

        $stmt_insert = $conn->prepare("INSERT INTO buku
                    (id_buku, judul, deskripsi, cover_url, file_buku, kategori, tanggal_upload, harga_sewa, id_penulis, id_operator, status_verifikasi)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')"); // Status 'pending'
        
        if (!$stmt_insert) {
            $_SESSION['message'] = "Gagal mempersiapkan query insert: " . htmlspecialchars($conn->error);
            $_SESSION['msg_type'] = "danger";
            if ($upload_path_cover_server && file_exists($upload_path_cover_server)) unlink($upload_path_cover_server);
            if ($upload_path_buku_server && file_exists($upload_path_buku_server)) unlink($upload_path_buku_server);
        } else {
            $stmt_insert->bind_param("sssssssdss", 
                $id_buku_generated, $judul, $deskripsi, $cover_url_to_db, // Simpan URL lengkap
                $file_buku_url_to_db, // Simpan URL lengkap
                $kategori, $tanggal_upload_for_db, 
                $harga_sewa, $id_penulis_session, $id_operator_default
            );

            if ($stmt_insert->execute()) {
                $_SESSION['message'] = "Buku '" . htmlspecialchars($judul) . "' berhasil diunggah dan menunggu verifikasi.";
                $_SESSION['msg_type'] = "success";
                header("Location: Karya.php"); 
                exit();
            } else {
                $_SESSION['message'] = "Gagal menyimpan ke database: " . htmlspecialchars($stmt_insert->error);
                $_SESSION['msg_type'] = "danger";
                if ($upload_path_cover_server && file_exists($upload_path_cover_server)) unlink($upload_path_cover_server);
                if ($upload_path_buku_server && file_exists($upload_path_buku_server)) unlink($upload_path_buku_server);
            }
            $stmt_insert->close();
        }
    } else {
         if (empty($_SESSION['message'])) {
            $_SESSION['message'] = "Terjadi kesalahan pada proses unggah file.";
            $_SESSION['msg_type'] = "danger";
        }
    }

    if (!headers_sent()) { 
        header("Location: UnggahBuku.php");
        exit();
    }

    if ($conn) {
        $conn->close();
    }

} else {
    $_SESSION['message'] = "Akses tidak sah atau tidak ada data yang dikirim.";
    $_SESSION['msg_type'] = "warning";
    header("Location: UnggahBuku.php");
    exit();
}
?>