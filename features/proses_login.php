<?php
// proses_login.php

// MENGGUNAKAN PATH ABSOLUT UNTUK KONEKSI.PHP (SANGAT DIREKOMENDASIKAN)
// Ini akan menghasilkan: C:\xampp\htdocs\Tugas5\features\config\koneksi.php
// Berdasarkan struktur folder yang kamu lampirkan: Tugas5/features/config/koneksi.php
include("../config/koneksi.php"); 

session_start(); // Mulai session di awal

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user_found = false;
    $user_data = [];
    $user_role = ''; // Untuk menyimpan 'pembaca' atau 'penulis'

    // 1. Coba login sebagai PEMBACA
    $stmt_pembaca = $conn->prepare("SELECT id_pembaca AS id, username, email, password FROM pembaca WHERE email = ?");
    $stmt_pembaca->bind_param("s", $email);
    $stmt_pembaca->execute();
    $result_pembaca = $stmt_pembaca->get_result();

    if ($result_pembaca->num_rows == 1) {
        $user_data = $result_pembaca->fetch_assoc();
        if (password_verify($password, $user_data['password'])) {
            $user_found = true;
            $user_role = 'pembaca';
        }
    }
    $stmt_pembaca->close();

    // 2. Jika tidak ditemukan sebagai pembaca atau password salah, coba login sebagai PENULIS
    if (!$user_found) {
        $stmt_penulis = $conn->prepare("SELECT id_penulis AS id, username, email, password FROM penulis WHERE email = ?");
        $stmt_penulis->bind_param("s", $email);
        $stmt_penulis->execute();
        $result_penulis = $stmt_penulis->get_result();

        if ($result_penulis->num_rows == 1) {
            $user_data = $result_penulis->fetch_assoc();
            if (password_verify($password, $user_data['password'])) {
                $user_found = true;
                $user_role = 'penulis';
            }
        }
        $stmt_penulis->close();
    }


    if ($user_found) {
        // Login berhasil
        $_SESSION['user_id'] = $user_data['id'];
        $_SESSION['username'] = $user_data['username'];
        $_SESSION['email'] = $user_data['email'];
        $_SESSION['role'] = $user_role; // Simpan role di session

        // Redirect ke halaman dashboard atau halaman utama setelah login
        if ($user_role === 'pembaca') {
            header("Location: ../index.php"); // Contoh redirect pembaca (ke root project)
        } else {
            header("Location: ../index.php"); // Contoh redirect penulis (misal ada dashboard terpisah)
        }
        exit(); // Penting: selalu exit setelah header() redirect
    } else {
        // Login gagal: Email tidak ditemukan di kedua tabel atau password salah
        // Redirect kembali ke halaman login dengan pesan error
        header("Location: loginpage.php?login_failed=1"); // <--- INI PENTING: Redirect ke halaman login dengan parameter
        exit(); // Penting: selalu exit setelah header() redirect
    }
  $conn->close();
} else {
    // Jika diakses langsung tanpa submit form (misal: user langsung ketik URL proses_login.php)
    // Redirect ke halaman login
    header("Location: loginpage.php");
    exit();
}
?>