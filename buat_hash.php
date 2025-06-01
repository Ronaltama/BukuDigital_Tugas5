<?php
// Ganti "PASSWORD_PLAIN_TEXT_DISINI" dengan password asli pengguna
$passwordAsli = "ZayN#33"; // Contoh untuk PEN0002
$hashPassword = password_hash($passwordAsli, PASSWORD_DEFAULT);
echo "Password Asli: " . $passwordAsli . "<br>";
echo "Hasil Hash: " . $hashPassword;

// Ulangi untuk password lain jika perlu
// $passwordAsli2 = "LaksmiP@321"; // Contoh untuk PEN0003
// $hashPassword2 = password_hash($passwordAsli2, PASSWORD_DEFAULT);
// echo "<hr>Password Asli: " . $passwordAsli2 . "<br>";
// echo "Hasil Hash: " . $hashPassword2;
?>