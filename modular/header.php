  <header class="bg-dark py-2 fixed-top">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <!-- Logo dan Toggle Sidebar -->
        <div class="d-flex align-items-center">
          <!-- Tombol garis tiga untuk menampilkan sidebar -->
          <button id="sidebar-toggle" class="btn btn-dark me-3">
            <i class="fas fa-bars"></i>
          </button>
          <!-- Logo mengarah ke beranda -->
          <a href="index.php" class="d-block">
            <img src="img/logo/logo3.png" alt="Logo" class="logo" width="150" />
          </a>
        </div>

        <div class="flex-grow-1" style="max-width: 600px">
          <form action="hasil_pencarian.php" method="GET" class="input-group">
            <input type="search" name="query" class="form-control" placeholder="Cari buku atau penulis..." required />
            required />
            <button type="submit" class="btn btn-warning">Cari</button>
          </form>
        </div>

        <!-- Login/Signup -->
        <div class="d-flex gap-2">
          <a href="features/loginpage.php">
            <button class="btn btn-outline-light">Login</button>
          </a>
          <a href="features/signuppage.php">
            <button class="btn btn-warning">Daftar</button>
          </a>
        </div>
      </div>
    </div>
  </header>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container">
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="features/kategori.php">Kategori</a>
        </ul>
      </div>
    </div>
  </nav>


  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <span>Menu Navigasi</span>
      <button type="button" class="btn-close btn-close-white" id="close-sidebar" aria-label="Close"></button>
    </div>
    <div class="nav flex-column">
      <a href="BerandaPembaca.php" class="nav-link text-white">
        <i class="bi bi-house-door me-2"></i> Beranda
      </a>
      <a href="features/kategori.php" class="nav-link text-white">
        <i class="bi bi-grid me-2"></i> Kategori Buku
      </a>
    </div>
  </div>

  <!-- Sidebar Overlay -->
  <div class="sidebar-overlay" id="sidebar-overlay"></div>