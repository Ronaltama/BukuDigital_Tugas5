<?php
$servername = "localhost"; // Atau host database Anda
$username = "root"; // Sesuaikan dengan username MySQL Anda
$password = "maharani"; // Sesuaikan dengan password MySQL Anda (biasanya kosong untuk root di XAMPP/WAMP)
$dbname = "buku_digital"; // Nama database Anda seperti di phpMyAdmin

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

?>