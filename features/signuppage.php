<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign-up</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/loginpagestyle.css" />
</head>

<body>
  <?php
    // Asumsi file headerBack.php ada di '../modular/headerBack.php'
    include("../modular/headerBack.php");
    ?>
  <div style="margin-top: 100px"></div>
  <img class="background" src="../img/logo/rakbuku.jpg" alt="Rak Buku" />
  <div class="tempatlogin">
    <div class="loginbackground"></div>
    <div class="login-container">
      <?php
    // Notifikasi gagal signup
    if (isset($_GET['signup_failed']) && $_GET['signup_failed'] == 1) {
        $msg = "Registrasi gagal. ";
        if (isset($_GET['error']) && $_GET['error'] == "duplikat") {
            $msg .= "Email atau Username sudah terdaftar. Silakan gunakan yang lain.";
        } else {
            $msg .= "Terjadi kesalahan. Silakan coba lagi.";
        }
        echo '<div class="alert alert-danger text-center" role="alert">' . $msg . '</div>';
    }

    // Notifikasi berhasil signup & redirect otomatis ke login
    if (isset($_GET['signup_success']) && $_GET['signup_success'] == 1) {
        $role = isset($_GET['role']) ? $_GET['role'] : '';
        echo '<div class="alert alert-success text-center" role="alert">Registrasi berhasil sebagai <b>' . htmlspecialchars($role) . '</b>! Anda akan diarahkan ke halaman login...</div>';
        echo "<script>
            setTimeout(function() {
                window.location.href = 'loginpage.php';
            }, 2000);
        </script>";
    }
  ?>
      <form action="proses_register.php" method="POST">
        <input type="email" placeholder="Alamat Email" name="email" required />
        <br /><br />
        <input type="text" placeholder="Username" name="username" required />
        <br /><br />
        <input type="password" placeholder="Password" name="password" required />
        <br /><br />
        <input type="password" placeholder="Konfirmasi Password" name="confirm_password" required />
        <br /><br />

        <div class="form-group" style="color: white; margin-bottom: 15px;">
          <label>Daftar sebagai:</label><br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="role" id="rolePembaca" value="pembaca" checked>
            <label class="form-check-label" for="rolePembaca">Pembaca</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="role" id="rolePenulis" value="penulis">
            <label class="form-check-label" for="rolePenulis">Penulis</label>
          </div>
        </div>
        <br>

        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" id="agree" name="agree_terms" required />
          <label class="form-check-label" for="agree" style="color: white;">
            Saya setuju dengan semua persyaratan yang telah disebutkan
          </label>
        </div>
        <br>
        <button class="button login-button" type="submit">Sign-up</button>
      </form>
    </div>
  </div>

  <script src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>