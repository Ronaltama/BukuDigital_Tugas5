<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Header dengan Sidebar Profil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
  /* Sidebar Navigasi Kiri */
  .sidebar {
    position: fixed;
    top: 0;
    left: -250px;
    width: 250px;
    height: 100%;
    background-color: rgb(23, 24, 26);
    color: white;
    z-index: 1050;
    padding: 1rem;
    transition: left 0.3s ease;
  }

  .sidebar.show {
    left: 0;
  }

  /* Sidebar Profil Kanan */
  .sidebar-profile {
    position: fixed;
    top: 0;
    right: -300px;
    width: 300px;
    height: 100%;
    background-color: rgb(25, 26, 27);
    color: white;
    z-index: 1060;
    padding: 1rem;
    transition: right 0.3s ease;
  }

  .sidebar-profile.show {
    right: 0;
  }

  .sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1040;
    display: none;
  }

  .sidebar-overlay.show {
    display: block;
  }

  .btn-close-white {
    filter: invert(1);
  }
  </style>
</head>

<body>

  <!-- Header -->
  <header class="bg-dark py-2 fixed-top">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
        <!-- Logo dan Toggle Sidebar -->
        <div class="d-flex align-items-center">
          <button id="sidebar-toggle" class="btn btn-dark me-3">
            <i class="fas fa-bars text-white"></i>
          </button>
          <a href="BerandaPembaca.php" class="d-block">
            <img src="../img/logo/logo3.png" alt="Logo" class="logo" width="150" />
          </a>
        </div>

        <!-- Search Form -->
        <div class="flex-grow-1" style="max-width: 600px">
          <form action="../Pembaca/hasil_pencarian.php" method="GET" class="input-group">
            <input type="search" name="query" class="form-control" placeholder="Cari buku atau penulis..." required />
            <button type="submit" class="btn btn-warning">Cari</button>
          </form>
        </div>

        <!-- Tombol Profil -->
        <div class="d-flex gap-2">
          <button id="profile-toggle" class="btn btn-outline-light">
            <i class="bi bi-person-circle"></i>
          </button>
        </div>
      </div>
    </div>
  </header>

  <!-- Navbar bawah -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom mt-5 pt-4">
    <div class="container">
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="BerandaPembaca.php">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="kategori.php">Kategori</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="perpus.php">Library</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Sidebar Navigasi -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header d-flex justify-content-between align-items-center">
      <span>Menu Navigasi</span>
      <button type="button" class="btn-close btn-close-white" id="close-sidebar" aria-label="Close"></button>
    </div>
    <div class="nav flex-column mt-3">
      <a href="BerandaPembaca.php" class="nav-link text-white">
        <i class="bi bi-house-door me-2"></i> Beranda
      </a>
      <a href="kategori.php" class="nav-link text-white">
        <i class="bi bi-grid me-2"></i> Kategori
      </a>
      <!-- <a href="keranjang.php" class="nav-link text-white">
        <i class="bi bi-cart me-2"></i> Keranjang Belanja
      </a> -->
      <a href="perpus.php" class="nav-link text-white">
        <i class="bi bi-book me-2"></i> Library
      </a>
    </div>
  </div>

  <!-- Sidebar Profil -->
  <div class="sidebar-profile" id="sidebar-profile">
    <div class="d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Profil</h5>
      <button type="button" class="btn-close btn-close-white" id="close-profile" aria-label="Close"></button>
    </div>
    <hr class="bg-light mt-3">
    <p><i class="bi bi-person-circle me-2"></i> Nama Pengguna</p>
    <p><i class="bi bi-envelope me-2"></i> user@email.com</p>
    <a href="../index.php" class="btn btn-outline-light btn-sm">Logout</a>
  </div>

  <!-- Overlay -->
  <div class="sidebar-overlay" id="sidebar-overlay"></div>

  <!-- Script -->
  <script>
  const sidebar = document.getElementById('sidebar');
  const sidebarProfile = document.getElementById('sidebar-profile');
  const overlay = document.getElementById('sidebar-overlay');

  document.getElementById('sidebar-toggle').addEventListener('click', () => {
    sidebar.classList.add('show');
    overlay.classList.add('show');
  });

  document.getElementById('close-sidebar').addEventListener('click', () => {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
  });

  document.getElementById('profile-toggle').addEventListener('click', () => {
    sidebarProfile.classList.add('show');
    overlay.classList.add('show');
  });

  document.getElementById('close-profile').addEventListener('click', () => {
    sidebarProfile.classList.remove('show');
    overlay.classList.remove('show');
  });

  overlay.addEventListener('click', () => {
    sidebar.classList.remove('show');
    sidebarProfile.classList.remove('show');
    overlay.classList.remove('show');
  });
  </script>

</body>

</html>