<?php
// verify_book.php

include '../koneksi.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_buku = $_GET['id'];

    // Prepare an update statement
    $stmt = $conn->prepare("UPDATE buku SET status_verifikasi = 'terverifikasi', id_operator = ? WHERE id_buku = ?");

    // Assuming you have a way to get the current operator's ID (e.g., from a session)
    // For now, let's use a placeholder. In a real application, replace 'OP01' with dynamic data.
    $operator_id = "OP01"; // Replace with actual operator ID

    $stmt->bind_param("ss", $operator_id, $id_buku); // 'ss' means two string parameters

    if ($stmt->execute()) {
        echo "<script>alert('Buku berhasil diverifikasi!'); window.location.href='BerandaVerifikasiBuku.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='BerandaVerifikasiBuku.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('ID buku tidak ditemukan.'); window.location.href='berandaOperator.php';</script>";
}

$conn->close();
?>