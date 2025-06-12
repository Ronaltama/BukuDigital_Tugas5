<?php
include '../koneksi.php';
session_start();

// Validasi Operator bisa ditambahkan di sini
// if (!isset($_SESSION['id_operator'])) { die("Akses ditolak."); }

// Ambil data yang dikirim dari form
$id_pemesanan = $_POST['id_pemesanan'] ?? '';
$action = $_POST['action'] ?? '';

if (empty($id_pemesanan) || empty($action)) {
    die("Error: Parameter tidak lengkap.");
}

// Mulai transaksi database untuk keamanan data
mysqli_begin_transaction($conn);

try {
    // Cek apakah pesanan valid dan masih menunggu
    $sql_check = "SELECT id_pemesanan FROM detail_pesanan WHERE id_pemesanan = ? AND status_pemesanan = 'menunggu'";
    $stmt_check = mysqli_prepare($conn, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "s", $id_pemesanan);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);
    if ($result_check->num_rows == 0) {
        throw new Exception("Pesanan tidak ditemukan atau sudah diproses sebelumnya.");
    }

    // ===============================================
    // LOGIKA PERCABANGAN UNTUK VERIFIKASI ATAU TOLAK
    // ===============================================
    if ($action === 'verify') {
        // --- PROSES VERIFIKASI ---

        // 1. Ambil info pesanan untuk membuat data sewa
        $sql_get_info = "SELECT id_buku, id_pembaca, durasi_sewa FROM detail_pesanan WHERE id_pemesanan = ?";
        $stmt_info = mysqli_prepare($conn, $sql_get_info);
        mysqli_stmt_bind_param($stmt_info, "s", $id_pemesanan);
        mysqli_stmt_execute($stmt_info);
        $info_pesanan = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_info));

        // 2. Update status pembayaran -> berhasil
        $stmt_pembayaran = mysqli_prepare($conn, "UPDATE pembayaran SET status_pembayaran = 'berhasil' WHERE id_pemesanan = ?");
        mysqli_stmt_bind_param($stmt_pembayaran, "s", $id_pemesanan);
        mysqli_stmt_execute($stmt_pembayaran);

        // 3. Update status pesanan -> selesai
        $stmt_pesanan = mysqli_prepare($conn, "UPDATE detail_pesanan SET status_pemesanan = 'selesai' WHERE id_pemesanan = ?");
        mysqli_stmt_bind_param($stmt_pesanan, "s", $id_pemesanan);
        mysqli_stmt_execute($stmt_pesanan);

        // 4. BUAT DATA SEWA BARU di tabel `sewa`
        $sql_max_sewa = "SELECT MAX(id_sewa) AS max_id FROM sewa";
        $row_max_sewa = mysqli_fetch_assoc($conn->query($sql_max_sewa));
        $new_sewa_id = str_pad(($row_max_sewa['max_id'] ? (int)$row_max_sewa['max_id'] + 1 : 1), 8, '0', STR_PAD_LEFT);
        
        $tgl_sewa = date('Y-m-d');
        $tgl_kembali = date('Y-m-d', strtotime($tgl_sewa . ' + ' . $info_pesanan['durasi_sewa'] . ' days'));
        
        $sql_insert_sewa = "INSERT INTO sewa (id_sewa, id_pemesanan, tgl_sewa, tgl_kembali, durasi_sewa, status_sewa, id_pembaca, id_buku) VALUES (?, ?, ?, ?, ?, 'dipinjam', ?, ?)";
        $stmt_sewa = mysqli_prepare($conn, $sql_insert_sewa);
        mysqli_stmt_bind_param($stmt_sewa, "ssssiss", $new_sewa_id, $id_pemesanan, $tgl_sewa, $tgl_kembali, $info_pesanan['durasi_sewa'], $info_pesanan['id_pembaca'], $info_pesanan['id_buku']);
        mysqli_stmt_execute($stmt_sewa);

        $pesan_sukses = "Verifikasi pembayaran berhasil. Buku kini aktif untuk disewa.";

    } elseif ($action === 'reject') {
        // --- PROSES PENOLAKAN ---

        // 1. Update status pembayaran -> gagal
        $stmt_pembayaran = mysqli_prepare($conn, "UPDATE pembayaran SET status_pembayaran = 'gagal' WHERE id_pemesanan = ?");
        mysqli_stmt_bind_param($stmt_pembayaran, "s", $id_pemesanan);
        mysqli_stmt_execute($stmt_pembayaran);

        // 2. Update status pesanan -> dibatalkan
        $stmt_pesanan = mysqli_prepare($conn, "UPDATE detail_pesanan SET status_pemesanan = 'dibatalkan' WHERE id_pemesanan = ?");
        mysqli_stmt_bind_param($stmt_pesanan, "s", $id_pemesanan);
        mysqli_stmt_execute($stmt_pesanan);
        
        // TIDAK ADA PEMBUATAN DATA SEWA
        $pesan_sukses = "Pesanan berhasil ditolak.";

    }

    // Jika semua proses di atas berhasil, simpan perubahan
    mysqli_commit($conn);
    echo "<script>alert('" . $pesan_sukses . "'); window.location.href='berandaOperator.php';</script>";

} catch (Exception $e) {
    // Jika ada error, batalkan semua perubahan
    mysqli_rollback($conn);
    die("Proses Gagal: " . $e->getMessage());
}
?>