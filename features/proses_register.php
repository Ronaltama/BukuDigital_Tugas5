<?php
// proses_register.php

// Pastikan file koneksi.php berada di lokasi yang benar relatif terhadap proses_register.php
include("../config/koneksi.php"); // Path diubah sesuai struktur C:\xampp\htdocs\Tugas5\features\config\koneksi.php

// Fungsi untuk menghasilkan ID unik berbasis string
// Fungsi ini akan mencari ID terakhir dengan prefix tertentu
// dan menginkrementasikan bagian numeriknya.
// PERHATIAN: Fungsi ini TIDAK sepenuhnya aman dari race condition
// jika ada banyak registrasi bersamaan dalam milidetik.
// Untuk aplikasi skala besar, pertimbangkan menggunakan transaksi database
// atau sistem UUID yang lebih robust.
function generateUniqueId($conn, $table_name, $id_column_name, $prefix, $length = 4) {
    $new_id = '';
    $max_attempts = 10; // Batasi percobaan untuk menghindari infinite loop

    for ($i = 0; $i < $max_attempts; $i++) {
        // Ambil ID tertinggi yang ada untuk prefix yang sama
        $stmt_max_id = $conn->prepare("SELECT $id_column_name FROM $table_name WHERE $id_column_name LIKE ? ORDER BY $id_column_name DESC LIMIT 1");
        $search_pattern = $prefix . '%';
        $stmt_max_id->bind_param("s", $search_pattern);
        $stmt_max_id->execute();
        $result_max_id = $stmt_max_id->get_result();
        $last_id_str = '';

        if ($result_max_id->num_rows > 0) {
            $row_max_id = $result_max_id->fetch_assoc();
            $last_id_str = $row_max_id[$id_column_name];
        }
        $stmt_max_id->close();

        $last_numeric_part = 0;
        if (!empty($last_id_str) && strpos($last_id_str, $prefix) === 0) {
            $numeric_substring = substr($last_id_str, strlen($prefix));
            if (ctype_digit($numeric_substring)) { // Pastikan bagian setelah prefix adalah digit
                $last_numeric_part = (int)$numeric_substring;
            }
        }

        $next_numeric_part = $last_numeric_part + 1;
        $formatted_numeric_part = sprintf("%0" . $length . "d", $next_numeric_part); // Format dengan leading zeros
        $new_id = $prefix . $formatted_numeric_part;

        // Cek keunikan ID yang baru dihasilkan secara langsung (penting!)
        $stmt_check_unique = $conn->prepare("SELECT $id_column_name FROM $table_name WHERE $id_column_name = ?");
        $stmt_check_unique->bind_param("s", $new_id);
        $stmt_check_unique->execute();
        $result_check_unique = $stmt_check_unique->get_result();

        if ($result_check_unique->num_rows == 0) {
            // ID unik ditemukan, keluar dari loop
            $stmt_check_unique->close();
            return $new_id;
        }
        $stmt_check_unique->close();
    }
    // Jika semua percobaan gagal menemukan ID unik
    die("Gagal menghasilkan ID unik setelah beberapa percobaan. Silakan coba lagi.");
}


// Cek apakah data dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];
    $agree_terms = isset($_POST['agree_terms']) ? true : false;

    // --- 1. Validasi Input ---
    if (empty($email) || empty($username) || empty($password) || empty($confirm_password) || empty($role)) {
        die("Semua field harus diisi, termasuk pilihan role.");
    }

    if ($password !== $confirm_password) {
        die("Konfirmasi password tidak cocok. Silakan coba lagi.");
    }

    if (!$agree_terms) {
        die("Anda harus menyetujui persyaratan untuk melanjutkan.");
    }

    // Hash password sebelum disimpan ke database (SANGAT PENTING!)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // --- 2. Cek Duplikasi Email atau Username di Kedua Tabel ---
    // Cek di tabel 'pembaca'
    $stmt_check_pembaca = $conn->prepare("SELECT id_pembaca FROM pembaca WHERE email = ? OR username = ?");
    $stmt_check_pembaca->bind_param("ss", $email, $username);
    $stmt_check_pembaca->execute();
    $result_check_pembaca = $stmt_check_pembaca->get_result();
    if ($result_check_pembaca->num_rows > 0) {
        $stmt_check_pembaca->close();
        die("Email atau Username sudah terdaftar sebagai pembaca. Coba email/username lain.");
    }
    $stmt_check_pembaca->close();

    // Cek di tabel 'penulis'
    $stmt_check_penulis = $conn->prepare("SELECT id_penulis FROM penulis WHERE email = ? OR username = ?");
    $stmt_check_penulis->bind_param("ss", $email, $username);
    $stmt_check_penulis->execute();
    $result_check_penulis = $stmt_check_penulis->get_result();
    if ($result_check_penulis->num_rows > 0) {
        $stmt_check_penulis->close();
        die("Email atau Username sudah terdaftar sebagai penulis. Coba email/username lain.");
    }
    $stmt_check_penulis->close();


    // --- 3. Masukkan Data ke Database Sesuai Role ---
    $new_user_id = ''; // Variabel untuk menyimpan ID yang akan di-generate
// Definisikan variabel untuk status
    $status_default = 'aktif';

    if ($role === 'pembaca') {
        $new_user_id = generateUniqueId($conn, 'pembaca', 'id_pembaca', 'PBC');
        $stmt_insert = $conn->prepare("INSERT INTO pembaca (id_pembaca, email, username, password, status) VALUES (?, ?, ?, ?, ?)");
        $stmt_insert->bind_param("sssss", $new_user_id, $email, $username, $hashed_password, $status_default); // <-- Ubah di sini

    } elseif ($role === 'penulis') {
        $new_user_id = generateUniqueId($conn, 'penulis', 'id_penulis', 'PEN');
        $stmt_insert = $conn->prepare("INSERT INTO penulis (id_penulis, email, username, password, status) VALUES (?, ?, ?, ?, ?)");
        $stmt_insert->bind_param("sssss", $new_user_id, $email, $username, $hashed_password, $status_default); // <-- Ubah di sini

    } else {
        die("Pilihan role tidak valid.");
    }

if ($stmt_insert->execute()) {
        echo "<script>alert('Registrasi berhasil sebagai $role! ID: $new_user_id');windwow.location='loginpage.php'; 
        </script>";
        // Opsional: Redirect ke halaman login setelah berhasil
        // header("Location: loginpage.php?reg_success=" . $role); // Uncomment this line
        exit(); // Uncomment this line
    } else {
        echo "Error registrasi: " . $stmt_insert->error;
    }
    $stmt_insert->close();
    // Tutup koneksi database
    $conn->close();

} else {
    // Jika diakses langsung tanpa submit form
    echo "Akses tidak diizinkan. Silakan isi form pendaftaran.";
}
?>