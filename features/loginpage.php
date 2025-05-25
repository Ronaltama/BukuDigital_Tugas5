<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login</title>
  <link rel="stylesheet" href="/Tugas5/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/Tugas5/css/loginpagestyle.css" />

  <style>
  /* CSS untuk notifikasi error */
  .error-message {
    background-color: #f8d7da;
    /* Warna merah muda */
    color: #721c24;
    /* Warna teks merah gelap */
    border: 1px solid #f5c6cb;
    padding: 10px;
    margin-bottom: 20px;
    /* Jarak antara notif dan form */
    border-radius: 5px;
    text-align: center;
    font-weight: bold;
  }

  /* Tambahan style untuk center notifikasi di dalam login-container */
  .login-container {
    position: relative;
    /* Untuk positioning notifikasi */
    padding: 20px;
    /* Beri padding agar notif tidak terlalu mepet */
  }
  </style>
</head>

<body>
  <?php
    // Include headerBack.php. Path relatif ini seharusnya sudah benar
    // karena loginpage.php ada di 'features/' dan modular ada di 'Tugas5/'
    include("../modular/headerBack.php");
    ?>

  <div style="height: 100px"></div>

  <img class="background" src="/Tugas5/img/logo/rakbuku.jpg" alt="Background Rak Buku" />

  <div class="tempatlogin">
    <div class="loginbackground"></div>
    <div class="login-container">
      <?php
            // PHP untuk menampilkan notifikasi login gagal
            if (isset($_GET['login_failed']) && $_GET['login_failed'] == 1) {
                echo '<div class="error-message">Email atau password salah. Silakan coba lagi.</div>';
            }
            ?>
      <form action="proses_login.php" method="POST">
        <input type="email" placeholder="Email" name="email" required />
        <input class="password" type="password" placeholder="Password" name="password" required />
        <button class="button login-button" type="submit">Login</button>
      </form>
      <p class="signin" style="color: white">
        Belum punya akun?
        <a href="signuppage.php">
          <button class="button">Sign-Up</button>
        </a>
      </p>
    </div>

    <div class="opsilogin">
      <p style="color: white">Atau login dengan:</p>
      <div class="social-login">
        <button style="background-color: white">
          <img class="ikon" src="/Tugas5/img/logo/google.png" alt="Google Logo" /> Google
        </button>
        <button style="background-color: white">
          <img class="ikon" src="/Tugas5/img/logo/facebook logo.png" alt="Facebook Logo" />
          Facebook
        </button>
        <button style="background-color: white">
          <img class="ikon" src="/Tugas5/img/logo/whatsapp.jpg" alt="WhatsApp Logo" />
          WhatsApp
        </button>
      </div>
    </div>
  </div>

  <script src="/Tugas5/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>