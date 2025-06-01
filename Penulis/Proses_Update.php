<?php
session_start();
include("../koneksi.php"); // Your database connection

if (!isset($_SESSION['id_penulis'])) {
    header("Location: ../features/loginpage.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id_buku = $_POST['id_buku'];
    $id_penulis_logged_in = $_SESSION['id_penulis'];

    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    // Mengambil dari 'tanggal_upload' jika nama input di form sudah diubah
    // Jika nama input di form EditKarya.php masih 'tanggal_terbit', biarkan ini
    // Namun, untuk konsistensi dengan database, sebaiknya nama input di form juga 'tanggal_upload'
    $tanggal_upload = $_POST['tanggal_upload']; // DIUBAH dari tanggal_terbit (ASUMSI NAMA INPUT FORM SUDAH DIUBAH)
    $harga_sewa = $_POST['harga_sewa'];

    // Input validation (basic)
    // Pastikan validasi tanggal_upload juga disertakan jika nama input sudah diubah
    if (empty($id_buku) || empty($judul) || empty($kategori) || empty($tanggal_upload) || $harga_sewa <= 0) {
        $_SESSION['message'] = "Semua kolom wajib diisi dan harga sewa harus lebih dari 0.";
        $_SESSION['msg_type'] = "danger";
        header("Location: EditKarya.php?id=" . $id_buku);
        exit();
    }

    $cover_url_db = null; // Nama variabel untuk nilai yang akan disimpan ke DB
    $file_buku_db = null; // Nama variabel untuk nilai yang akan disimpan ke DB

    // Get current book data to keep old file paths if not updated
    $stmt_fetch = $conn->prepare("SELECT cover_url, file_buku FROM buku WHERE id_buku = ? AND id_penulis = ?");
    if (!$stmt_fetch) {
        $_SESSION['message'] = "Gagal mempersiapkan query (fetch): " . $conn->error;
        $_SESSION['msg_type'] = "danger";
        header("Location: EditKarya.php?id=" . $id_buku);
        exit();
    }
    $stmt_fetch->bind_param("ss", $id_buku, $id_penulis_logged_in);
    $stmt_fetch->execute();
    $result_fetch = $stmt_fetch->get_result();
    $current_book_data = $result_fetch->fetch_assoc();
    $stmt_fetch->close();

    if (!$current_book_data) {
        $_SESSION['message'] = "Buku tidak ditemukan atau Anda tidak memiliki izin untuk mengeditnya.";
        $_SESSION['msg_type'] = "danger";
        header("Location: Karya.php");
        exit();
    }

    $cover_url_db = $current_book_data['cover_url']; // Ini adalah nama file lama di DB
    $file_buku_db = $current_book_data['file_buku']; // Ini adalah nama file lama di DB

    // Handle Cover Upload
    if (isset($_FILES['cover']) && $_FILES['cover']['error'] == UPLOAD_ERR_OK) {
        $uploadDirCover = '../covers/'; // Path untuk cover
        if (!is_dir($uploadDirCover)) {
            mkdir($uploadDirCover, 0777, true);
        }
        // Menggunakan uniqid untuk nama file yang unik, mencegah penimpaan dan masalah karakter aneh
        $coverFileName = uniqid('cover_', true) . '.' . strtolower(pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION));
        $targetFilePathCover = $uploadDirCover . $coverFileName;
        $fileTypeCover = strtolower(pathinfo($targetFilePathCover, PATHINFO_EXTENSION));

        $allowTypesCover = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileTypeCover, $allowTypesCover)) {
            if (move_uploaded_file($_FILES['cover']['tmp_name'], $targetFilePathCover)) {
                // Delete old cover if it exists and is different from the new one
                if ($cover_url_db && file_exists($uploadDirCover . $cover_url_db)) {
                    unlink($uploadDirCover . $cover_url_db);
                }
                $cover_url_db = $coverFileName; // Simpan nama file baru untuk DB
            } else {
                $_SESSION['message'] = "Gagal mengunggah cover buku.";
                $_SESSION['msg_type'] = "danger";
                header("Location: EditKarya.php?id=" . $id_buku);
                exit();
            }
        } else {
            $_SESSION['message'] = "Hanya file JPG, JPEG, PNG, & GIF yang diizinkan untuk cover.";
            $_SESSION['msg_type'] = "danger";
            header("Location: EditKarya.php?id=" . $id_buku); // DIUBAH dari updateBuku.php
            exit();
        }
    }

    // Handle File Buku (PDF) Upload
    if (isset($_FILES['file_buku']) && $_FILES['file_buku']['error'] == UPLOAD_ERR_OK) {
        $uploadDirFile = '../files/'; // Path untuk file PDF
        if (!is_dir($uploadDirFile)) {
            mkdir($uploadDirFile, 0777, true);
        }
        $fileBukuFileName = uniqid('book_', true) . '.' . strtolower(pathinfo($_FILES['file_buku']['name'], PATHINFO_EXTENSION));
        $targetFilePathBook = $uploadDirFile . $fileBukuFileName;
        $fileTypeBook = strtolower(pathinfo($targetFilePathBook, PATHINFO_EXTENSION));

        if ($fileTypeBook == 'pdf') {
            if (move_uploaded_file($_FILES['file_buku']['tmp_name'], $targetFilePathBook)) {
                // Delete old book file if it exists and is different
                if ($file_buku_db && file_exists($uploadDirFile . $file_buku_db)) {
                    unlink($uploadDirFile . $file_buku_db);
                }
                $file_buku_db = $fileBukuFileName; // Simpan nama file baru untuk DB
            } else {
                $_SESSION['message'] = "Gagal mengunggah file buku PDF.";
                $_SESSION['msg_type'] = "danger";
                header("Location: EditKarya.php?id=" . $id_buku);
                exit();
            }
        } else {
            $_SESSION['message'] = "Hanya file PDF yang diizinkan untuk buku.";
            $_SESSION['msg_type'] = "danger";
            header("Location: EditKarya.php?id=" . $id_buku);
            exit();
        }
    }

    try {
        // Update data in database
        // Menggunakan tanggal_upload di query UPDATE
        $stmt = $conn->prepare("UPDATE buku SET judul = ?, deskripsi = ?, cover_url = ?, file_buku = ?, kategori = ?, tanggal_upload = ?, harga_sewa = ?, status_verifikasi = 'pending' WHERE id_buku = ? AND id_penulis = ?");
        
        if (!$stmt) {
            $_SESSION['message'] = "Gagal mempersiapkan query (update): " . $conn->error;
            $_SESSION['msg_type'] = "danger";
            header("Location: EditKarya.php?id=" . $id_buku);
            exit();
        }
        
        // Sesuaikan tipe data jika harga_sewa adalah decimal/double, gunakan "d"
        $stmt->bind_param("ssssssdss", $judul, $deskripsi, $cover_url_db, $file_buku_db, $kategori, $tanggal_upload, $harga_sewa, $id_buku, $id_penulis_logged_in);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Buku berhasil diperbarui. Menunggu verifikasi ulang.";
            $_SESSION['msg_type'] = "success";
            header("Location: Karya.php");
            exit();
        } else {
            $_SESSION['message'] = "Gagal memperbarui buku: " . $stmt->error;
            $_SESSION['msg_type'] = "danger";
            header("Location: EditKarya.php?id=" . $id_buku);
            exit();
        }
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        $_SESSION['message'] = "Terjadi kesalahan database: " . $e->getMessage();
        $_SESSION['msg_type'] = "danger";
        header("Location: EditKarya.php?id=" . $id_buku);
        exit();
    } finally {
        if ($conn) {
            $conn->close();
        }
    }

} else {
    header("Location: Karya.php"); // Redirect if not a POST request or 'update' not set
    exit();
}
?>