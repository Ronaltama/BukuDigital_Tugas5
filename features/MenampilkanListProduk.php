<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>List Buku</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../style.css" />
</head>
<body>
<?php
    include("../modular/headerBack.php");
    ?>

    <!-- Hasil Pencarian -->
    <div class="container mt-5 pt-4">
        <h2 class="text-center mb-4">Hasil Pencarian</h2>
        <div class="text-center mb-4">
            <input type="text" id="searchInput" class="form-control w-50 mx-auto" placeholder="Cari buku...">
        </div>

        <!-- Grid List Produk -->
        <div class="row" id="bukuList">
            <?php
            // Data Buku
            $buku = [
                ["judul" => "Belajar Pemrograman", "harga" => "Rp 100.000"],
                ["judul" => "Bisnis Digital", "harga" => "Rp 150.000"],
                ["judul" => "Dompet Ayah Sepatu Ibu", "harga" => "Rp 70.000"],
                ["judul" => "Laskar Pelangi", "harga" => "Rp 190.000"],
                ["judul" => "Ronggeng Dukuh Paruk", "harga" => "Rp 165.000"],
                ["judul" => "Sisi Tergelap Surga", "harga" => "Rp 180.000"],
                ["judul" => "Insecurity is my Middle Name", "harga" => "Rp 195.000"],
            ];

            // Looping untuk menampilkan buku
            foreach ($buku as $item) {
                echo '
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 buku-item">
                    <div class="card shadow-sm">
                        <img src="https://via.placeholder.com/150x200" class="card-img-top" alt="Cover Buku">
                        <div class="card-body text-center">
                            <h6 class="card-title">'. $item["judul"] .'</h6>
                            <p class="card-text fw-bold text-primary">'. $item["harga"] .'</p>
                        </div>
                    </div>
                </div>';
            }
            ?>
        </div>
    </div>

    <!-- Script Filter Pencarian -->
    <script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let items = document.querySelectorAll(".buku-item");

        items.forEach(function(item) {
            let title = item.querySelector(".card-title").textContent.toLowerCase();
            if (title.includes(filter)) {
                item.style.display = "";
            } else {
                item.style.display = "none";
            }
        });
    });
    </script>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-3">
        <div class="container">
            <div class="row">
                <!-- Info Toko -->
                <div class="col-md-4 mb-4">
                    <img src="img/logo3.png" alt="Logo" width="150" class="mb-3" />
                    <p>
                        Jl. Buku Digital No. 123<br />
                        Jakarta, Indonesia<br />
                        Telp: (021) 1234-5678
                    </p>
                </div>

                <!-- Tentang Kami -->
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold">Tentang Kami</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white text-decoration-none">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Syarat &amp; Ketentuan</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Bantuan</a></li>
                    </ul>
                </div>

                <!-- Ikuti Kami -->
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold">Ikuti Kami</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white"><i class="fab fa-facebook fa-2x"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-twitter fa-2x"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram fa-2x"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-youtube fa-2x"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin fa-2x"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-pinterest fa-2x"></i></a>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="text-center mt-4 pt-3 border-top border-secondary">
                <p class="mb-0">&copy; 2025 Digital Book Store. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Script Filter Pencarian -->
    <script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        let filter = this.value.toLowerCase();
        let items = document.querySelectorAll(".buku-item");

        items.forEach(function(item) {
            let title = item.querySelector(".card-title").textContent.toLowerCase();
            if (title.includes(filter)) {
                item.style.display = "";
            } else {
                item.style.display = "none";
            }
        });
    });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../script.js"></script>

    <?php
    include("../modular/footer.php");
    ?>
</body>
</html>
