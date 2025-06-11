<?php
// Pastikan file ini ada di folder `Operator/`
include "../koneksi.php"; // Path relatif ke file koneksi.php

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id_pembayaran = $_GET['id'];
    $action = $_GET['action'];

    // Tentukan status yang akan diperbarui
    $new_status = '';
    $message_status = '';
    if ($action == 'verify') {
        $new_status = 'verified';
        $message_status = 'Diterima';
    } elseif ($action == 'reject') {
        $new_status = 'rejected';
        $message_status = 'Ditolak';
    } else {
        echo "<script>alert('Aksi tidak valid.'); window.location.href='verifikasipemayaran.php';</script>";
        exit();
    }

    if (!empty($new_status)) {
        // Gunakan prepared statements untuk mencegah SQL Injection
        $stmt = $conn->prepare("UPDATE pembayaran SET status_pembayaran = ? WHERE id_pembayaran = ?");
        if ($stmt) {
            $stmt->bind_param("ss", $new_status, $id_pembayaran); // 'ss' karena kedua parameter adalah string
            if ($stmt->execute()) {
                // Opsional: Perbarui status_sewa di tabel 'sewa' berdasarkan status pembayaran
                // Jika pembayaran diverifikasi, ubah status sewa menjadi 'aktif'
                // Jika pembayaran ditolak, ubah status sewa menjadi 'dibatalkan'
                if ($new_status == 'verified') {
                    $stmt_sewa = $conn->prepare("UPDATE sewa s JOIN pembayaran p ON s.id_sewa = p.id_sewa SET s.status_sewa = 'aktif' WHERE p.id_pembayaran = ?");
                    if ($stmt_sewa) {
                        $stmt_sewa->bind_param("s", $id_pembayaran);
                        $stmt_sewa->execute();
                        $stmt_sewa->close();
                    } else {
                        // Handle error if prepared statement fails
                        error_log("Error preparing sewa update statement: " . $conn->error);
                    }
                } else if ($new_status == 'rejected') {
                    $stmt_sewa = $conn->prepare("UPDATE sewa s JOIN pembayaran p ON s.id_sewa = p.id_sewa SET s.status_sewa = 'dibatalkan' WHERE p.id_pembayaran = ?");
                    if ($stmt_sewa) {
                        $stmt_sewa->bind_param("s", $id_pembayaran);
                        $stmt_sewa->execute();
                        $stmt_sewa->close();
                    } else {
                        error_log("Error preparing sewa update statement: " . $conn->error);
                    }
                }

                echo "<script>alert('Status pembayaran berhasil diperbarui menjadi " . $message_status . ".'); window.location.href='verifikasipemayaran.php';</script>";
            } else {
                echo "<script>alert('Gagal memperbarui status pembayaran: " . $stmt->error . "'); window.location.href='verifikasipemayaran.php';</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error preparing statement: " . $conn->error . "'); window.location.href='verifikasipemayaran.php';</script>";
        }
    }
} else {
    echo "<script>alert('Parameter tidak lengkap.'); window.location.href='verifikasipemayaran.php';</script>";
}

$conn->close();
?>