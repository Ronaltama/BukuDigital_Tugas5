<?php
include '../koneksi.php';
session_start();

// Anda bisa menambahkan validasi untuk memastikan hanya operator yang bisa mengakses
// if (!isset($_SESSION['id_operator'])) { die("Akses ditolak."); }

// Ambil id_pemesanan yang akan dikonfirmasi dari form di halaman admin
$id_pemesanan_dikonfirmasi = $_POST['id_pemesanan'] ?? '';

if (empty($id_pemesanan_dikonfirmasi)) {
    die("Error: ID Pemesanan tidak diterima.");
}

mysqli_begin_transaction($conn);

try {
    // 1. Ambil semua info yang dibutuhkan dari detail_pesanan
    $sql_get_info = "SELECT id_buku, id_pembaca, durasi_sewa FROM detail_pesanan WHERE id_pemesanan = ? AND status_pemesanan = 'menunggu'";
    $stmt_info = mysqli_prepare($conn, $sql_get_info);
    mysqli_stmt_bind_param($stmt_info, "s", $id_pemesanan_dikonfirmasi);
    mysqli_stmt_execute($stmt_info);
    $result_info = mysqli_stmt_get_result($stmt_info);
    $info_pesanan = mysqli_fetch_assoc($result_info);

    if (!$info_pesanan) {
        throw new Exception("Detail pesanan tidak ditemukan atau sudah diproses.");
    }

    // 2. Update status pembayaran menjadi 'berhasil'
    $stmt1 = mysqli_prepare($conn, "UPDATE pembayaran SET status_pembayaran = 'berhasil' WHERE id_pemesanan = ?");
    mysqli_stmt_bind_param($stmt1, "s", $id_pemesanan_dikonfirmasi);
    mysqli_stmt_execute($stmt1);

    // 3. Update status pesanan menjadi 'selesai'
    $stmt2 = mysqli_prepare($conn, "UPDATE detail_pesanan SET status_pemesanan = 'selesai' WHERE id_pemesanan = ?");
    mysqli_stmt_bind_param($stmt2, "s", $id_pemesanan_dikonfirmasi);
    mysqli_stmt_execute($stmt2);

    // 4. BUAT DATA SEWA BARU di tabel `sewa`
    $sql_max_sewa = "SELECT MAX(id_sewa) AS max_id FROM sewa";
    $result_max_sewa = $conn->query($sql_max_sewa);
    $row_max_sewa = $result_max_sewa->fetch_assoc();
    $new_sewa_id = str_pad(($row_max_sewa['max_id'] ? (int)$row_max_sewa['max_id'] + 1 : 1), 8, '0', STR_PAD_LEFT);
    
    $tgl_sewa = date('Y-m-d');
    $tgl_kembali = date('Y-m-d', strtotime($tgl_sewa . ' + ' . $info_pesanan['durasi_sewa'] . ' days'));
    $status_sewa = 'dipinjam';
    
    $sql_insert_sewa = "INSERT INTO sewa (id_sewa, id_pemesanan, tgl_sewa, tgl_kembali, durasi_sewa, status_sewa, id_pembaca, id_buku) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_sewa = mysqli_prepare($conn, $sql_insert_sewa);
    mysqli_stmt_bind_param(
        $stmt_sewa, 
        "ssssisss", 
        $new_sewa_id, 
        $id_pemesanan_dikonfirmasi,
        $tgl_sewa, 
        $tgl_kembali, 
        $info_pesanan['durasi_sewa'], 
        $status_sewa, 
        $info_pesanan['id_pembaca'], 
        $info_pesanan['id_buku']
    );
    mysqli_stmt_execute($stmt_sewa);

    mysqli_commit($conn);
    echo "Verifikasi pembayaran berhasil. Buku kini aktif untuk disewa oleh pengguna.";
    // Anda bisa redirect kembali ke halaman dashboard operator dengan pesan sukses
    // header("Location: dashboard_operator.php?status=sukses");

} catch (Exception $e) {
    mysqli_rollback($conn);
    die("Verifikasi Gagal: " . $e->getMessage());
}
?>