<?php
// proses_login.php

// 1. Mulai session di PALING AWAL file
session_start(); 

// 2. Baru include file koneksi setelah session dimulai
// Pastikan path ini benar dan koneksi.php TIDAK menghasilkan output apapun (misalnya spasi kosong).
include("../koneksi.php"); 

// Pastikan koneksi $conn berhasil dibuat dari koneksi.php
if (!$conn) {
    // Log error ke file log server atau tampilkan pesan error yang aman
    error_log("Koneksi database gagal dalam proses_login.php: " . mysqli_connect_error());
    header("Location: loginpage.php?login_failed=1&error=db_connection");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $found_user_data = null; // Akan menyimpan data pengguna jika ditemukan
    $found_user_role = '';   // Akan menyimpan peran pengguna ('pembaca', 'penulis', 'operator')

    // --- Coba login sebagai PEMBACA ---
    $stmt_pembaca = $conn->prepare("SELECT id_pembaca AS id, username, email, password FROM pembaca WHERE email = ?");
    if ($stmt_pembaca) {
        $stmt_pembaca->bind_param("s", $email);
        $stmt_pembaca->execute();
        $result_pembaca = $stmt_pembaca->get_result();

        if ($result_pembaca->num_rows == 1) {
            $temp_user_data = $result_pembaca->fetch_assoc();
            if (password_verify($password, $temp_user_data['password'])) {
                $found_user_data = $temp_user_data;
                $found_user_role = 'pembaca';
            }
        }
        $stmt_pembaca->close();
    } else {
        error_log("Gagal mempersiapkan statement untuk pembaca: " . $conn->error);
        // Tetap lanjutkan, karena mungkin error hanya pada prepare statement ini
    }
    
    // --- Jika belum ditemukan, coba login sebagai PENULIS ---
    if ($found_user_data === null) { // Hanya jika belum ditemukan
        $stmt_penulis = $conn->prepare("SELECT id_penulis AS id, username, email, password, tanggal_daftar FROM penulis WHERE email = ?");
        if ($stmt_penulis) {
            $stmt_penulis->bind_param("s", $email);
            $stmt_penulis->execute();
            $result_penulis = $stmt_penulis->get_result();

            if ($result_penulis->num_rows == 1) {
                $temp_user_data = $result_penulis->fetch_assoc();
                if (password_verify($password, $temp_user_data['password'])) {
                    $found_user_data = $temp_user_data;
                    $found_user_role = 'penulis';
                }
            }
            $stmt_penulis->close();
        } else {
            error_log("Gagal mempersiapkan statement untuk penulis: " . $conn->error);
            // Tetap lanjutkan
        }
    }

    // --- Jika belum ditemukan, coba login sebagai OPERATOR ---
    if ($found_user_data === null) { // Hanya jika belum ditemukan
        // Asumsi nama tabel untuk operator adalah 'operator' dan memiliki kolom 'id_operator', 'username', 'email', 'password'
        $stmt_operator = $conn->prepare("SELECT id_operator AS id, username, email, password FROM operator WHERE email = ?");
        if ($stmt_operator) {
            $stmt_operator->bind_param("s", $email);
            $stmt_operator->execute();
            $result_operator = $stmt_operator->get_result();

            if ($result_operator->num_rows == 1) {
                $temp_user_data = $result_operator->fetch_assoc();
                if (password_verify($password, $temp_user_data['password'])) {
                    $found_user_data = $temp_user_data;
                    $found_user_role = 'operator'; // Set peran sebagai 'operator'
                }
            }
            $stmt_operator->close();
        } else {
            error_log("Gagal mempersiapkan statement untuk operator: " . $conn->error);
            // Tetap lanjutkan
        }
    }

    // Tutup koneksi database lebih awal jika sudah selesai dengan semua query
    $conn->close();

    // --- Verifikasi Hasil Pencarian dan Redirect ---
    if ($found_user_data !== null) {
        // Login berhasil
        $_SESSION['user_id'] = $found_user_data['id'];
        $_SESSION['username'] = $found_user_data['username'];
        $_SESSION['email'] = $found_user_data['email'];
        $_SESSION['role'] = $found_user_role; 

        // Jika ingin menyimpan id_penulis, id_pembaca, atau id_operator secara spesifik
        if ($found_user_role === 'penulis') {
            $_SESSION['id_penulis'] = $found_user_data['id'];
            // $_SESSION['tanggal_daftar_penulis'] = $found_user_data['tanggal_daftar']; // Aktifkan jika diperlukan
        } elseif ($found_user_role === 'pembaca') {
            $_SESSION['id_pembaca'] = $found_user_data['id'];
        } elseif ($found_user_role === 'operator') {
            $_SESSION['id_operator'] = $found_user_data['id'];
        }
        
        // Regenerate session ID untuk keamanan setelah login
        session_regenerate_id(true);

        // Redirect ke halaman dashboard atau halaman utama setelah login
        if ($found_user_role === 'pembaca') {
            header("Location: ../BerandaPembaca.php"); 
        } elseif ($found_user_role === 'penulis') {
            header("Location: ../Penulis/berandaPenulis.php"); 
        } elseif ($found_user_role === 'operator') {
            header("Location: ../Operator/berandaOperator.php"); // PASTIKAN PATH INI BENAR
        }
        exit(); // Penting: selalu exit setelah header() redirect
    } else {
        // Login gagal: Email tidak ditemukan di semua tabel atau password salah
        header("Location: loginpage.php?login_failed=1"); 
        exit(); 
    }
} else {
    // Jika diakses langsung tanpa submit form POST
    header("Location: loginpage.php");
    exit();
}
?>