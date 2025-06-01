<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Buku Digital</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="style.css" />
  <style>
  /* Tambahkan atau sesuaikan gaya CSS yang dibutuhkan di sini */
  .scroll-container {
    overflow-x: auto;
    /* Mengaktifkan scroll horizontal */
    white-space: nowrap;
    /* Mencegah item melompat ke baris baru */
    -webkit-overflow-scrolling: touch;
    /* Untuk scrolling yang lebih halus di iOS */
    padding-bottom: 10px;
    /* Ruang untuk scrollbar */
  }

  .scroll-container::-webkit-scrollbar {
    height: 8px;
  }

  .scroll-container::-webkit-scrollbar-thumb {
    background-color: #ccc;
    border-radius: 4px;
  }

  .scroll-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    background-color: #fff;
    /* Pastikan tombol terlihat */
    border: 1px solid #eee;
    /* Tambah border agar lebih jelas */
  }

  .scroll-btn.left {
    left: -20px;
    /* Sesuaikan posisi agar tombol terlihat */
  }

  .scroll-btn.right {
    right: -20px;
    /* Sesuaikan posisi agar tombol terlihat */
  }

  .book-card {
    width: 200px;
    /* Sesuaikan lebar kartu buku */
    flex-shrink: 0;
    /* Penting untuk mencegah item menyusut dalam flexbox */
  }

  .book-card .card-img-top {
    height: 250px;
    /* Tinggi gambar cover yang konsisten */
    object-fit: cover;
    /* Menjaga rasio aspek gambar */
  }
  </style>
</head>

<body>
  <?php
    include("modular/headerPembaca.php");
    // Sertakan file koneksi database
    include("koneksi.php");

    // Fungsi untuk menampilkan kartu buku
    function displayBookCards($result, $badge_class) {
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $formatted_date = date("j F Y", strtotime($row['tanggal_upload']));
                $full_stars = floor($row['rating']);
                $half_star = ($row['rating'] - $full_stars >= 0.5) ? true : false;
                $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);
    ?>
  <div class="col">
    <div class="card book-card shadow-sm h-100">
      <a href="detail_buku.php?id=<?php echo $row['id_buku']; ?>">
        <img src="<?php echo $row['cover_url']; ?>" class="card-img-top" alt="Book Cover" />
      </a>
      <div class="card-body d-flex flex-column">
        <h5 class="card-title text-truncate"><?php echo $row['judul']; ?></h5>
        <p class="card-text text-muted small text-truncate"><?php echo $row['nama_penulis']; ?></p>
        <div class="d-flex justify-content-between align-items-center mb-2">
          <span
            class="badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($row['kategori'] ?? 'Umum'); ?></span>
          <small class="text-muted"><?php echo $formatted_date; ?></small>
        </div>
        <div class="rating-stars mb-2">
          <?php
                                for ($i = 0; $i < $full_stars; $i++) {
                                    echo '<i class="fas fa-star text-warning"></i>';
                                }
                                if ($half_star) {
                                    echo '<i class="fas fa-star-half-alt text-warning"></i>';
                                }
                                for ($i = 0; $i < $empty_stars; $i++) {
                                    echo '<i class="far fa-star text-warning"></i>'; // Bintang kosong
                                }
                                ?>
          <span>(<?php echo number_format($row['rating'], 1); ?>)</span>
        </div>
        <div class="mt-auto">
  <div class="d-flex justify-content-between align-items-center">
    <span class="text-success fw-bold">Rp
      <?php echo number_format($row['harga_sewa'], 0, ',', '.'); ?></span>
  <a href="features/detailBuku.php?id=<?php echo $row['id_buku']; ?>" class="btn btn-sm btn-info" title="Lihat Detail">
  Detail
</a>
</a>
      <input type="hidden" name="id_buku" value="<?php echo $row['id_buku']; ?>">
  </div>
</div>

      </div>
    </div>
  </div>
  <?php
            }
        } else {
            echo "<p>Tidak ada buku dalam kategori ini.</p>";
        }
    }
    ?>

  <main class="container mt-5" style="margin-top: 120px !important;">
    <section class="mb-5 text-center fade-in">
      <h1 class="display-4">Selamat Datang di Digital Book Store</h1>
      <p class="lead">
        Temukan ribuan buku digital berkualitas untuk kebutuhan Sewa Anda
      </p>
    </section>

    <section class="mb-5">
      <div class="col-12 position-relative">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Buku Terbaru</h4>
          <a href="#" class="btn btn-link text-decoration-none">
            Lihat Semua <i class="fas fa-chevron-right ms-1"></i>
          </a>
        </div>
        <div class="position-relative">
          <button class="btn btn-light shadow scroll-btn left new-releases-scroll-left">
            <i class="fas fa-chevron-left"></i>
          </button>
          <button class="btn btn-light shadow scroll-btn right new-releases-scroll-right">
            <i class="fas fa-chevron-right"></i>
          </button>

          <div class="scroll-container" id="new-releases-books">
            <div class="d-flex flex-nowrap gap-3 py-2">
              <?php
                            // Ambil buku terbaru (6 terakhir berdasarkan tanggal upload)
                            $sql_new_releases = "SELECT
                                b.id_buku,
                                b.judul,
                                p.username AS nama_penulis,
                                b.cover_url,
                                b.tanggal_upload,
                                b.rating,
                                b.harga_sewa,
                                b.kategori -- Kolom kategori sudah ada di tabel buku
                            FROM
                                buku b
                            JOIN
                                penulis p ON b.id_penulis = p.id_penulis
                            ORDER BY
                                b.tanggal_upload DESC
                            LIMIT 6";
                            $result_new_releases = $conn->query($sql_new_releases);
                            displayBookCards($result_new_releases, 'bg-info'); // Warna badge untuk terbaru
                            ?>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="mb-5">
      <div class="col-12 position-relative">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Buku Populer</h4>
          <a href="#" class="btn btn-link text-decoration-none">
            Lihat Semua <i class="fas fa-chevron-right ms-1"></i>
          </a>
        </div>
        <div class="position-relative">
          <button class="btn btn-light shadow scroll-btn left popular-scroll-left">
            <i class="fas fa-chevron-left"></i>
          </button>
          <button class="btn btn-light shadow scroll-btn right popular-scroll-right">
            <i class="fas fa-chevron-right"></i>
          </button>
          <div class="scroll-container" id="popular-books">
            <div class="d-flex flex-nowrap gap-3 py-2">
              <?php
                            // Ambil buku terpopuler (6 terakhir berdasarkan rating)
                            $sql_popular = "SELECT
                                b.id_buku,
                                b.judul,
                                p.username AS nama_penulis,
                                b.cover_url,
                                b.tanggal_upload,
                                b.rating,
                                b.harga_sewa,
                                b.kategori -- Kolom kategori sudah ada di tabel buku
                            FROM
                                buku b
                            JOIN
                                penulis p ON b.id_penulis = p.id_penulis
                            ORDER BY
                                b.rating DESC, b.tanggal_upload DESC -- Tambahkan tanggal_upload sebagai tie-breaker
                            LIMIT 6";
                            $result_popular = $conn->query($sql_popular);
                            displayBookCards($result_popular, 'bg-danger'); // Warna badge untuk populer
                            ?>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="mb-5">
      <div class="col-12 position-relative">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Buku Termurah</h4>
          <a href="#" class="btn btn-link text-decoration-none">
            Lihat Semua <i class="fas fa-chevron-right ms-1"></i>
          </a>
        </div>
        <div class="position-relative">
          <button class="btn btn-light shadow scroll-btn left cheapest-scroll-left">
            <i class="fas fa-chevron-left"></i>
          </button>
          <button class="btn btn-light shadow scroll-btn right cheapest-scroll-right">
            <i class="fas fa-chevron-right"></i>
          </button>
          <div class="scroll-container" id="cheapest-books">
            <div class="d-flex flex-nowrap gap-3 py-2">
              <?php
                            // Ambil 6 buku dengan harga sewa termurah
                            $sql_cheapest = "SELECT
                                b.id_buku,
                                b.judul,
                                p.username AS nama_penulis,
                                b.cover_url,
                                b.tanggal_upload,
                                b.rating,
                                b.harga_sewa,
                                b.kategori
                            FROM
                                buku b
                            JOIN
                                penulis p ON b.id_penulis = p.id_penulis
                            ORDER BY
                                b.harga_sewa ASC, b.tanggal_upload DESC
                            LIMIT 6";
                            $result_cheapest = $conn->query($sql_cheapest);
                            displayBookCards($result_cheapest, 'bg-success'); // Warna badge untuk termurah
                            ?>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="mb-5">
      <div class="col-12 position-relative">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Buku Termahal</h4>
          <a href="#" class="btn btn-link text-decoration-none">
            Lihat Semua <i class="fas fa-chevron-right ms-1"></i>
          </a>
        </div>
        <div class="position-relative">
          <button class="btn btn-light shadow scroll-btn left most-expensive-scroll-left">
            <i class="fas fa-chevron-left"></i>
          </button>
          <button class="btn btn-light shadow scroll-btn right most-expensive-scroll-right">
            <i class="fas fa-chevron-right"></i>
          </button>
          <div class="scroll-container" id="most-expensive-books">
            <div class="d-flex flex-nowrap gap-3 py-2">
              <?php
                            // Ambil 6 buku dengan harga sewa termahal
                            $sql_most_expensive = "SELECT
                                b.id_buku,
                                b.judul,
                                p.username AS nama_penulis,
                                b.cover_url,
                                b.tanggal_upload,
                                b.rating,
                                b.harga_sewa,
                                b.kategori
                            FROM
                                buku b
                            JOIN
                                penulis p ON b.id_penulis = p.id_penulis
                            ORDER BY
                                b.harga_sewa DESC, b.tanggal_upload DESC
                            LIMIT 6";
                            $result_most_expensive = $conn->query($sql_most_expensive);
                            displayBookCards($result_most_expensive, 'bg-warning text-dark'); // Warna badge untuk termahal
                            ?>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="mb-5">
      <div class="col-12 position-relative">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4>Rekomendasi Pilihan</h4>
          <a href="#" class="btn btn-link text-decoration-none">
            Lihat Semua <i class="fas fa-chevron-right ms-1"></i>
          </a>
        </div>
        <div class="position-relative">
          <button class="btn btn-light shadow scroll-btn left recommendation-scroll-left">
            <i class="fas fa-chevron-left"></i>
          </button>
          <button class="btn btn-light shadow scroll-btn right recommendation-scroll-right">
            <i class="fas fa-chevron-right"></i>
          </button>

          <div class="scroll-container" id="recommendation-books">
            <div class="d-flex flex-nowrap gap-3 py-2">
              <?php
                            // Menggabungkan buku populer dan termurah, lalu mengambil 6 unik secara acak
                            $sql_recommendation = "
                            (SELECT
                                b.id_buku,
                                b.judul,
                                p.username AS nama_penulis,
                                b.cover_url,
                                b.tanggal_upload,
                                b.rating,
                                b.harga_sewa,
                                b.kategori
                            FROM
                                buku b
                            JOIN
                                penulis p ON b.id_penulis = p.id_penulis
                            ORDER BY
                                b.rating DESC
                            LIMIT 6)
                            UNION
                            (SELECT
                                b.id_buku,
                                b.judul,
                                p.username AS nama_penulis,
                                b.cover_url,
                                b.tanggal_upload,
                                b.rating,
                                b.harga_sewa,
                                b.kategori
                            FROM
                                buku b
                            JOIN
                                penulis p ON b.id_penulis = p.id_penulis
                            ORDER BY
                                b.harga_sewa ASC
                            LIMIT 6)
                            ORDER BY RAND() -- Mengacak hasil gabungan
                            LIMIT 6"; // Ambil 6 buku unik dari hasil gabungan
                            $result_recommendation = $conn->query($sql_recommendation);
                            displayBookCards($result_recommendation, 'bg-primary'); // Warna badge untuk rekomendasi
                            ?>
            </div>
          </div>
        </div>
      </div>
    </section>


    <div class="text-center mb-5">
      <button class="btn btn-primary btn-lg">Lihat Buku Lainnya</button>
    </div>
  </main>

  <?php
    include("modular/footer.php");
    ?>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>
  <script>
  // JavaScript untuk fungsionalitas scroll horizontal
  document.addEventListener('DOMContentLoaded', function() {
    function setupScroll(containerId, leftBtnClass, rightBtnClass) {
      const scrollContainer = document.getElementById(containerId);
      const leftBtn = document.querySelector(`.${leftBtnClass}`);
      const rightBtn = document.querySelector(`.${rightBtnClass}`);

      if (scrollContainer && leftBtn && rightBtn) {
        leftBtn.addEventListener('click', () => {
          scrollContainer.scrollBy({
            left: -220, // Lebar card + gap
            behavior: 'smooth'
          });
        });

        rightBtn.addEventListener('click', () => {
          scrollContainer.scrollBy({
            left: 220, // Lebar card + gap
            behavior: 'smooth'
          });
        });

        // Sembunyikan/tampilkan tombol scroll berdasarkan posisi scroll
        const toggleScrollButtons = () => {
          if (scrollContainer.scrollWidth > scrollContainer.clientWidth) {
            if (scrollContainer.scrollLeft === 0) {
              leftBtn.style.display = 'none';
              rightBtn.style.display = 'flex'; // Tampilkan tombol kanan
            } else if (scrollContainer.scrollLeft + scrollContainer.clientWidth >= scrollContainer.scrollWidth) {
              rightBtn.style.display = 'none';
              leftBtn.style.display = 'flex'; // Tampilkan tombol kiri
            } else {
              leftBtn.style.display = 'flex';
              rightBtn.style.display = 'flex';
            }
          } else {
            leftBtn.style.display = 'none';
            rightBtn.style.display = 'none';
          }
        };

        scrollContainer.addEventListener('scroll', toggleScrollButtons);
        // Panggil saat halaman dimuat untuk mengatur tampilan awal tombol
        toggleScrollButtons();
        // Juga panggil jika ada perubahan ukuran window (misal: resize)
        window.addEventListener('resize', toggleScrollButtons);
      }
    }

    setupScroll('new-releases-books', 'new-releases-scroll-left', 'new-releases-scroll-right');
    setupScroll('popular-books', 'popular-scroll-left', 'popular-scroll-right');
    setupScroll('cheapest-books', 'cheapest-scroll-left', 'cheapest-scroll-right');
    setupScroll('most-expensive-books', 'most-expensive-scroll-left', 'most-expensive-scroll-right');
    setupScroll('recommendation-books', 'recommendation-scroll-left', 'recommendation-scroll-right');
  });
  </script>
</body>

</html>