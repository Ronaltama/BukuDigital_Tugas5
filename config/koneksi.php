<?php
$servername = "localhost"; // Karena masih lokal
$username = "root"; // Username default XAMPP, tanpa password
$password = ""; // Password default XAMPP, kosong
$dbname = "buku_digital"; // Ganti dengan nama database yang kamu buat di phpMyAdmin

// Membuat koneksi    ;,
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>