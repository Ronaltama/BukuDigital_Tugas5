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