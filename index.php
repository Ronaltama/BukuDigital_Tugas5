<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Buku Digital</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css" />
  <style>
  </style>
</head>

<body>
  <?php
    include("modular/header.php");
    ?>

  <main class="container mt-5" style="margin-top: 120px !important;">
    <!-- Welcome Section -->
    <section class="mb-5 text-center fade-in">
      <h1 class="display-4">Selamat Datang di Digital Book Store</h1>
      <p class="lead">
        Temukan ribuan buku digital berkualitas untuk kebutuhan Anda
      </p>
    </section>

    <!-- Book Categories -->
    <section class="mb-5">
      <div class="col-12 position-relative">
        <!-- Recommendation -->
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Rekomendasi Untuk Anda</h4>
          <a href="#" class="btn btn-link text-decoration-none">
            Lihat Semua <i class="fas fa-chevron-right ms-1"></i>
          </a>
        </div>
        <!-- Container scroll dengan tombol navigasi -->
        <div class="position-relative">
          <button class="btn btn-light shadow scroll-btn left">
            <i class="fas fa-chevron-left"></i>
          </button>
          <button class="btn btn-light shadow scroll-btn right">
            <i class="fas fa-chevron-right"></i>
          </button>

          <!-- Container untuk scroll horizontal -->
          <div class="scroll-container">
            <div class="d-flex flex-nowrap gap-3 py-2">
              <!-- Book Item -->
              <div class="col">
                <div class="card book-card shadow-sm h-100">
                  <img src="img/Buku cover jdul/fiksi/Amba_Laksmi Pamunjak.jpg" class="card-img-top" alt="Book Cover" />
                  </a>
                  <div class="card-body">
                    <h5 class="card-title">Amba</h5>
                    <p class="card-text text-muted small">Laksmi Pamunjak</p>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="badge bg-info">Baru</span>
                      <small class="text-muted">5 Maret 2025</small>
                    </div>

                    <div class="rating-stars mb-2">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                      <span>(5.0)</span>
                    </div>

                    <!-- Harga & ikon shopping cart dalam satu baris -->
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="text-success fw-bold">Rp 75.000</span>
                      <a href="#" class="text-success">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                      </a>
                      </a>
                    </div>
                  </div>


                </div>
              </div>

              <div class="col">
                <div class="card book-card shadow-sm h-100">
                  <img src="img/Buku cover jdul/fiksi/Sisi Tergelap Surga_Brian Krisna.jpg" class="card-img-top"
                    alt="Book Cover" />
                  <div class="card-body">
                    <h5 class="card-title">Sisi Tergelap Surga</h5>
                    <p class="card-text text-muted small">Brian Krisna</p>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="badge bg-info">Baru</span>
                      <small class="text-muted">10 Maret 2025</small>
                    </div>

                    <div class="rating-stars mb-2">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                      <span>(4.7)</span>
                    </div>

                    <!-- Harga dan ikon keranjang sejajar -->
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="text-success fw-bold">Rp 70.000</span>
                      <a href="#" class="text-success">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                      </a>
                      </a>
                    </div>
                  </div>

                </div>
              </div>

              <div class="col">
                <div class="card book-card shadow-sm h-100">
                  <img src="img/Buku cover jdul/fiksi/Bulan_Tere Liye.jpg" class="card-img-top" alt="Book Cover" />
                  <div class="card-body">
                    <h5 class="card-title">Bulan</h5>
                    <p class="card-text text-muted small">Tere Liye</p>

                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="badge bg-info">Baru</span>
                      <small class="text-muted">5 Maret 2025</small>
                    </div>

                    <div class="rating-stars mb-2">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                      <span>(4.7)</span>
                    </div>

                    <!-- Harga dan ikon shopping cart sejajar -->
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="text-success fw-bold">Rp 50.000</span>
                      <a href="#" class="text-success">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                      </a>
                    </div>
                  </div>

                </div>
              </div>
              <div class="col">
                <div class="card book-card shadow-sm h-100">
                  <img src="img/Buku cover jdul/fiksi/Cantik itu Luka_Eka Kurniawan.jpg" class="card-img-top"
                    alt="Book Cover" />
                  <div class="card-body">
                    <h5 class="card-title">Cantik Itu Luka</h5>
                    <p class="card-text text-muted small">Eka Kurniawan</p>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="badge bg-info">Baru</span>
                      <small class="text-muted">1 Maret 2025</small>
                    </div>
                    <div class="rating-stars mb-2">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                      <span>(4.5)</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="text-success fw-bold">Rp 60.000</span>
                      <a href="#" class="text-success">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card book-card shadow-sm h-100">
                  <img src="img/Buku cover jdul/fiksi/Dompet Ayah Sepatu Ibu_JS. Khairen.jpg" class="card-img-top"
                    alt="Book Cover" />
                  <div class="card-body">
                    <h5 class="card-title">Dompet Ayah Sepatu</h5>
                    <p class="card-text text-muted small">JS. Khairen</p>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="badge bg-info">Baru</span>
                      <small class="text-muted">10 Maret 2025</small>
                    </div>
                    <div class="rating-stars mb-2">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                      <span>(4.7)</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="text-success fw-bold">Rp 80.000</span>
                      <a href="#" class="text-success">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card book-card shadow-sm h-100">
                  <img src="img/Buku cover jdul/fiksi/Gadis Kretek-Ratih Kumala.jpg" class="card-img-top"
                    alt="Book Cover" />
                  <div class="card-body">
                    <h5 class="card-title">Gadis Kretek</h5>
                    <p class="card-text text-muted small">Ratih Kumala</p>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="badge bg-info">Baru</span>
                      <small class="text-muted">15 Maret 2025</small>
                    </div>
                    <div class="rating-stars mb-2">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                      <span>(4.8)</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="text-success fw-bold">Rp 85.000</span>
                      <a href="#" class="text-success">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="card book-card shadow-sm h-100">
                  <img src="img/Buku cover jdul/fiksi/Ronggeng Dukuh Paruk_Ahmad Tohari.jpg" class="card-img-top"
                    alt="Book Cover" />
                  <div class="card-body">
                    <h5 class="card-title">Ronggeng Dukuh Paruk</h5>
                    <p class="card-text text-muted small">Ahmad Tohari</p>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="badge bg-info">Baru</span>
                      <small class="text-muted">15 Maret 2025</small>
                    </div>
                    <div class="rating-stars mb-2">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                      <span>(4.6)</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="text-success fw-bold">Rp 60.000</span>
                      <a href="#" class="text-success">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>


              <div class="col">
                <div class="card book-card shadow-sm h-100">
                  <img src="img/Buku cover jdul/non-fiksi/You do You_Fellexandro Ruby.jpg" class="card-img-top"
                    alt="Book Cover" />
                  <div class="card-body">
                    <h5 class="card-title">You do You</h5>
                    <p class="card-text text-muted small">Fellexandro Ruby</p>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="badge bg-info">Baru</span>
                      <small class="text-muted">10 Maret 2025</small>
                    </div>
                    <div class="rating-stars mb-2">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                      <span>(4.8)</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="text-success fw-bold">Rp 80.000</span>
                      <a href="#" class="text-success">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>


              <div class="col">
                <div class="card book-card shadow-sm h-100">
                  <img src="img/Buku cover jdul/fiksi/Gadis Kretek-Ratih Kumala.jpg" class="card-img-top"
                    alt="Book Cover" />
                  <div class="card-body">
                    <h5 class="card-title">Gadis Kretek</h5>
                    <p class="card-text text-muted small">Ratih Kumala</p>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="badge bg-info">Baru</span>
                      <small class="text-muted">15 Maret 2025</small>
                    </div>
                    <div class="rating-stars mb-2">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star-half-alt"></i>
                      <span>(4.8)</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="text-success fw-bold">Rp 85.000</span>
                      <a href="#" class="text-success">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Tambahkan buku lainnya -->
            </div>
          </div>

          <!-- Popular Books -->
          <div class="col-12 mt-5">
            <h4 class="mb-3">Buku Populer</h4>
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
              <!-- Book Item -->
              <div class="col">
                <div class="card book-card shadow-sm h-100">
                  <img src="img/Buku cover jdul/fiksi/Hujan_Tere Liye.jpg" class="card-img-top" alt="Book Cover" />
                  <div class="card-body">
                    <h5 class="card-title">Hujan</h5>
                    <p class="card-text text-muted small">Tere Liya</p>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="badge bg-danger">Terlaris</span>
                      <small class="text-muted">20 Desember 2024</small>
                    </div>
                    <div class="rating-stars mb-2">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <span>(4.8)</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="text-success fw-bold">Rp 50.000</span>
                      <a href="#" class="text-success">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card book-card shadow-sm h-100">
                  <img src="img/Buku cover jdul/fiksi/Laskar Pelangi_Andrea Hirata.jpg" class="card-img-top"
                    alt="Book Cover" />
                  <div class="card-body">
                    <h5 class="card-title">Laskar Pelangi</h5>
                    <p class="card-text text-muted small">Andrea Hirata</p>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="badge bg-danger">Terlaris</span>
                      <small class="text-muted">5 Januari 2025</small>
                    </div>
                    <div class="rating-stars mb-2">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <span>(4.6)</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="text-success fw-bold">Rp 60.000</span>
                      <a href="#" class="text-success">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="card book-card shadow-sm h-100">
                  <img src="img/Buku cover jdul/fiksi/Luka Cita_Valerie Patkar.jpg" class="card-img-top"
                    alt="Book Cover" />
                  <div class="card-body">
                    <h5 class="card-title">Luka Cita</h5>
                    <p class="card-text text-muted small">Valerie Patkar</p>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="badge bg-danger">Terlaris</span>
                      <small class="text-muted">25 Januari 2025</small>
                    </div>
                    <div class="rating-stars mb-2">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <span>(4.8)</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="text-success fw-bold">Rp 75.000</span>
                      <a href="#" class="text-success">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="card book-card shadow-sm h-100">
                  <img src="img/Buku cover jdul/fiksi/Retrocession_Ayunita Kuraisy.jpg" class="card-img-top"
                    alt="Book Cover" />
                  <div class="card-body">
                    <h5 class="card-title">Retrocession</h5>
                    <p class="card-text text-muted small">Ayunita Kuraisy</p>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="badge bg-danger">Terlaris</span>
                      <small class="text-muted">15 Februari 2025</small>
                    </div>
                    <div class="rating-stars mb-2">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <span>(4.9)</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="text-success fw-bold">Rp 90.000</span>
                      <a href="#" class="text-success">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Tambahkan buku lainnya -->
            </div>
          </div>

          <!-- New Releases -->
          <div class="col-12 mt-5">
            <h4 class="mb-3">Baru Dirilis</h4>
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
              <!-- Book Item -->
              <div class="col">
                <div class="card book-card shadow-sm h-100">
                  <img src="img/Buku cover jdul/non-fiksi/Filosofi Teras_Henry Manampiring.jpg" class="card-img-top"
                    alt="Book Cover" />
                  <div class="card-body">
                    <h5 class="card-title">Filosofi Teras</h5>
                    <p class="card-text text-muted small">Henry Manampiring</p>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="badge bg-warning text-dark">Pre-Order</span>
                      <small class="text-muted">1 Mei 2025</small>
                    </div>
                    <div class="rating-stars mb-2">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="far fa-star"></i>
                      <span>(4.5)</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="text-success fw-bold">Rp 100.000</span>
                      <form method="post" action="features/add_to_cart.php" class="d-inline">
                        <input type="hidden" name="id" value="1"> <!-- ID buku -->
                        <button type="submit" class="btn p-0 border-0 bg-transparent text-success">
                          <i class="fas fa-shopping-cart fa-lg"></i>
                        </button>
                      </form>

                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="card book-card shadow-sm h-100">
                  <img src="img/Buku cover jdul/non-fiksi/Insecurity is my Middle Name_Alvi Syahrin.jpg"
                    class="card-img-top" alt="Book Cover" />
                  <div class="card-body">
                    <h5 class="card-title">Insecurity is my Middle Name</h5>
                    <p class="card-text text-muted small">Alvi Syahrin</p>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="badge bg-warning text-dark">Pre-Order</span>
                      <small class="text-muted">2 Mei 2025</small>
                    </div>
                    <div class="rating-stars mb-2">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="far fa-star"></i>
                      <span>(4.7)</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="text-success fw-bold">Rp 150.000</span>
                      <a href="#" class="text-success">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="card book-card shadow-sm h-100">
                  <img src="img/Buku cover jdul/fiksi/Sisi Tergelap Surga_Brian Krisna.jpg" class="card-img-top"
                    alt="Book Cover" />
                  <div class="card-body">
                    <h5 class="card-title">Sisi Tergelap Surga</h5>
                    <p class="card-text text-muted small">Brian Krisna</p>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="badge bg-warning text-dark">Pre-Order</span>
                      <small class="text-muted">5 Mei 2025</small>
                    </div>
                    <div class="rating-stars mb-2">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="far fa-star"></i>
                      <span>(4.8)</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <span class="text-success fw-bold">Rp 200.000</span>
                      <a href="#" class="text-success">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="card book-card shadow-sm h-100">
                  <img src="img/Buku cover jdul/non-fiksi/You do You_Fellexandro Ruby.jpg" class="card-img-top"
                    alt="Book Cover" />
                  <div class="card-body">
                    <h5 class="card-title">You do You/h5>
                      <p class="card-text text-muted small">Fellexandro Ruby</p>
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-warning text-dark">Pre-Order</span>
                        <small class="text-muted">10 Mei 2025</small>
                      </div>
                      <div class="rating-stars mb-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <span>(4.9)</span>
                      </div>
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-success fw-bold">Rp 120.000</span>
                        <a href="#" class="text-success">
                          <i class="fas fa-shopping-cart fa-lg"></i>
                        </a>
                      </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
    </section>

    <!-- See More Button -->
    <div class="text-center mb-5">
      <button class="btn btn-primary btn-lg">Lihat Buku Lainnya</button>
    </div>
  </main>

  <?php
    include("modular/footer.php");
    ?>


  <!-- Bootstrap & FontAwesome (Tambahkan di <head> jika belum ada) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />


  <!-- Bootstrap JS -->
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Custom JS -->
  <script src="script.js"></script>
</body>

</html>