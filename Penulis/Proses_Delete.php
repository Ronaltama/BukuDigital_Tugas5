<?php
session_start();
include("../koneksi.php"); // Your database connection

if (!isset($_SESSION['id_penulis'])) {
    header("Location: ../features/loginpage.php");
    exit();
}

if (isset($_GET['id'])) {
    $id_buku_to_delete = $_GET['id'];
    $id_penulis_logged_in = $_SESSION['id_penulis'];

    try {
        // First, get the file paths before deleting the record
        $stmt_fetch = $conn->prepare("SELECT cover_url, file_buku FROM buku WHERE id_buku = ? AND id_penulis = ?");
        $stmt_fetch->bind_param("ss", $id_buku_to_delete, $id_penulis_logged_in);
        $stmt_fetch->execute();
        $result_fetch = $stmt_fetch->get_result();
        $book_files = $result_fetch->fetch_assoc();
        $stmt_fetch->close();

        if ($book_files) {
            // Prepare and execute delete query
            $stmt_delete = $conn->prepare("DELETE FROM buku WHERE id_buku = ? AND id_penulis = ?");
            $stmt_delete->bind_param("ss", $id_buku_to_delete, $id_penulis_logged_in);

            if ($stmt_delete->execute()) {
                // If deletion from DB is successful, delete the actual files
                $uploadDirCovers = '../covers/';
                $uploadDirBooks = '../files/';

                if ($book_files['cover_url'] && file_exists($uploadDirCovers . $book_files['cover_url'])) {
                    unlink($uploadDirCovers . $book_files['cover_url']);
                }
                if ($book_files['file_buku'] && file_exists($uploadDirBooks . $book_files['file_buku'])) {
                    unlink($uploadDirBooks . $book_files['file_buku']);
                }

                $_SESSION['message'] = "Buku berhasil dihapus.";
                $_SESSION['msg_type'] = "success";
            } else {
                $_SESSION['message'] = "Gagal menghapus buku dari database: " . $stmt_delete->error;
                $_SESSION['msg_type'] = "danger";
            }
            $stmt_delete->close();
        } else {
            $_SESSION['message'] = "Buku tidak ditemukan atau Anda tidak memiliki izin untuk menghapusnya.";
            $_SESSION['msg_type'] = "danger";
        }
    } catch (mysqli_sql_exception $e) {
        $_SESSION['message'] = "Terjadi kesalahan database: " . $e->getMessage();
        $_SESSION['msg_type'] = "danger";
    } finally {
        $conn->close();
    }
} else {
    $_SESSION['message'] = "ID buku tidak diberikan.";
    $_SESSION['msg_type'] = "danger";
}

header("Location: Karya.php"); // Redirect back to Karya page
exit();
?>