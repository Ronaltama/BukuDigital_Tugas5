<?php
// proses_login.php

// 1. Mulai session di PALING AWAL file. TIDAK ADA SPASI, BARIS KOSONG DI ATAS INI.
session_start();

// 2. Baru include file koneksi setelah session dimulai.
// Pastikan path ini benar dan koneksi.php TIDAK menghasilkan output apapun (misalnya spasi kosong).
include("../koneksi.php");

// notifikasi status user
if (isset($_SESSION['pesan'])) {
    echo '<div class="alert alert-'.$_SESSION['pesan_type'].' alert-dismissible fade show" role="alert">
        '.$_SESSION['pesan'].'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    unset($_SESSION['pesan']);
    unset($_SESSION['pesan_type']);
}

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
    $user_status = '';       // Akan menyimpan status pengguna ('aktif' atau 'nonaktif')

    // --- Coba login sebagai PEMBACA ---
    $stmt_pembaca = $conn->prepare("SELECT id_pembaca AS id, username, email, password, status FROM pembaca WHERE email = ?");
    if ($stmt_pembaca) {
        $stmt_pembaca->bind_param("s", $email);
        $stmt_pembaca->execute();
        $result_pembaca = $stmt_pembaca->get_result();

        if ($result_pembaca->num_rows == 1) {
            $temp_user_data = $result_pembaca->fetch_assoc();
            if (password_verify($password, $temp_user_data['password'])) {
                $found_user_data = $temp_user_data;
                $found_user_role = 'pembaca';
                $user_status = $temp_user_data['status'];
            }
        }
        $stmt_pembaca->close();
    } else {
        error_log("Gagal mempersiapkan statement untuk pembaca: " . $conn->error);
    }

    // --- Jika belum ditemukan, coba login sebagai PENULIS ---
    if ($found_user_data === null) {
        $stmt_penulis = $conn->prepare("SELECT id_penulis AS id, username, email, password, status FROM penulis WHERE email = ?");
        if ($stmt_penulis) {
            $stmt_penulis->bind_param("s", $email);
            $stmt_penulis->execute();
            $result_penulis = $stmt_penulis->get_result();

            if ($result_penulis->num_rows == 1) {
                $temp_user_data = $result_penulis->fetch_assoc();
                if (password_verify($password, $temp_user_data['password'])) {
                    $found_user_data = $temp_user_data;
                    $found_user_role = 'penulis';
                    $user_status = $temp_user_data['status'];
                }
            }
            $stmt_penulis->close();
        } else {
            error_log("Gagal mempersiapkan statement untuk penulis: " . $conn->error);
        }
    }

    // --- Jika belum ditemukan, coba login sebagai OPERATOR ---
    if ($found_user_data === null) {
        $stmt_operator = $conn->prepare("SELECT id_operator AS id, username, email, password, status FROM operator WHERE email = ?");
        if ($stmt_operator) {
            $stmt_operator->bind_param("s", $email);
            $stmt_operator->execute();
            $result_operator = $stmt_operator->get_result();

            if ($result_operator->num_rows == 1) {
                $temp_user_data = $result_operator->fetch_assoc();
                if (password_verify($password, $temp_user_data['password'])) {
                    $found_user_data = $temp_user_data;
                    $found_user_role = 'operator';
                    $user_status = $temp_user_data['status'];
                }
            }
            $stmt_operator->close();
        } else {
            error_log("Gagal mempersiapkan statement untuk operator: " . $conn->error);
        }
    }

    $conn->close();

    // --- Verifikasi Hasil Pencarian dan Redirect ---
    if ($found_user_data !== null) {
        // Cek status akun sebelum membuat session
        if ($user_status == 'nonaktif') {
            $_SESSION['pesan'] = "Akun Anda telah dinonaktifkan. Silakan hubungi administrator.";
            $_SESSION['pesan_type'] = "danger";
            header("Location: loginpage.php");
            exit();
        }

        // Jika akun aktif, buat session
        $_SESSION['user_id'] = $found_user_data['id'];
        $_SESSION['username'] = $found_user_data['username'];
        $_SESSION['email'] = $found_user_data['email'];
        $_SESSION['role'] = $found_user_role;

        // PASTIKAN BARIS INI BENAR: Menyimpan id_pembaca ke session jika peran adalah pembaca
        if ($found_user_role === 'pembaca') {
            $_SESSION['id_pembaca'] = $found_user_data['id']; // Ini adalah baris yang KRUSIAL.
            // Aktifkan baris di bawah ini untuk debugging ke log server:
            error_log("Login berhasil! id_pembaca disimpan di session: " . $_SESSION['id_pembaca']);
        } elseif ($found_user_role === 'penulis') {
            $_SESSION['id_penulis'] = $found_user_data['id'];
        } elseif ($found_user_role === 'operator') {
            $_SESSION['id_operator'] = $found_user_data['id'];
        }

        session_regenerate_id(true);

        if ($found_user_role === 'pembaca') {
            header("Location: ../Pembaca/BerandaPembaca.php");
        } elseif ($found_user_role === 'penulis') {
            header("Location: ../Penulis/berandaPenulis.php");
        } elseif ($found_user_role === 'operator') {
            header("Location: ../Operator/berandaOperator.php");
        }
        exit();
    } else {
        header("Location: ../features/loginpage.php?login_failed=1");
        exit();
    }
} else {
    header("Location: ../features/loginpage.php");
    exit();
}
?>