<!-- Header untuk Operator -->
<header class="bg-dark py-2 fixed-top">
  <div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
      <!-- Logo dan Toggle Sidebar -->
      <div class="d-flex align-items-center">
        <!-- Tombol garis tiga untuk menampilkan sidebar -->
        <button id="sidebar-toggle" class="btn btn-dark me-3">
          <i class="fas fa-bars"></i>
        </button>
        <!-- Logo mengarah ke beranda operator -->
        <a href="indexOperator.php" class="d-block">
          <img src="img/logo/logo3.png" alt="Logo" class="logo" width="150" />
        </a>
      </div>

      <!-- Search Form -->
      <div class="flex-grow-1" style="max-width: 600px">
        <div class="input-group">
          <input type="search" class="form-control" placeholder="Cari pengguna, buku, atau laporan..." />
          <button type="submit" class="btn btn-warning">Cari</button>
        </div>
      </div>

      <!-- Tombol Profil -->
      <div class="d-flex gap-2">
        <a href="features/profile.php" class="btn btn-outline-light">
          <i class="bi bi-person-circle">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
              fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
              <path
                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
            </svg>
          </i>
        </a>
      </div>
    </div>
  </div>
</header>

<!-- Navigation untuk Operator -->
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
  <div class="container">
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="indexOperator.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="features/verifikasi.php">Verifikasi Buku</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="features/kelolaUser.php">Kelola Pengguna</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="features/laporan.php">Laporan</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Sidebar untuk Operator -->
<div class="sidebar" id="sidebar">
  <div class="sidebar-header">
    <span>Menu Operator</span>
    <button type="button" class="btn-close btn-close-white" id="close-sidebar" aria-label="Close"></button>
  </div>
  <div class="nav flex-column">
    <a href="indexOperator.php" class="nav-link">
      <i class="bi bi-speedometer2 me-2"></i> Dashboard
    </a>
    <a href="features/verifikasi.php" class="nav-link">
      <i class="bi bi-check-circle me-2"></i> Verifikasi Buku
    </a>
    <a href="features/kelolaUser.php" class="nav-link">
      <i class="bi bi-people me-2"></i> Kelola Pengguna
    </a>
    <a href="features/laporan.php" class="nav-link">
      <i class="bi bi-bar-chart me-2"></i> Laporan & Statistik
    </a>
    <a href="features/profile.php" class="nav-link">
      <i class="bi bi-person me-2"></i> Profil Saya
    </a>
  </div>
</div>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebar-overlay"></div>
