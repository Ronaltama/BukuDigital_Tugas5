<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <style>
        /* ... your existing styles ... */
    </style>
</head>

<body>

    <?php
    include("../modular/headerPenulis.php");

    // Di sini nanti akan ada logika PHP untuk mengambil data buku berdasarkan ID dari parameter GET
    // Contoh (perlu diganti dengan pengambilan data dari database):
    $id_buku = $_GET['id'] ?? null;
    $dataBuku = null;
    if ($id_buku) {
        // Misalnya, ambil dari array contoh:
        $daftarBukuContoh = [
            1 => [
                'judul' => 'Buku Pertama',
                'deskripsi' => 'Deskripsi buku pertama...',
                'kategori' => 'fiksi',
                'tanggal_terbit' => '2025-01-15',
                'harga_sewa' => 10000,
                // ... data lainnya
            ],
            2 => [
                'judul' => 'Novel Kedua',
                'deskripsi' => 'Deskripsi novel kedua...',
                'kategori' => 'non-fiksi',
                'tanggal_terbit' => '2024-11-20',
                'harga_sewa' => 15000,
                // ... data lainnya
            ],
        ];
        $dataBuku = $daftarBukuContoh[$id_buku] ?? null;

        if (!$dataBuku) {
            echo "<div class='container mt-5 pt-5'><p class='alert alert-danger text-center'>Data buku tidak ditemukan.</p></div>";
            exit;
        }
    } else {
        echo "<div class='container mt-5 pt-5'><p class='alert alert-danger text-center'>ID buku tidak valid.</p></div>";
        exit;
    }
    ?>

    <div class="container mt-5 pt-5">

        <h2 class="text-center text-primary mb-4">Edit Karya</h2>

        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Formulir Update Informasi Buku</h4>
            </div>
            <div class="card-body">

                <form action="Proses_Update.php" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="id_buku" value="<?php echo htmlspecialchars($id_buku); ?>">

                    <div class="mb-3">
                        <label for="cover" class="form-label">Cover Buku (Biarkan kosong jika tidak ingin diubah)</label>
                        <input type="file" class="form-control" id="cover" name="cover" accept="image/*">
                        <?php
                        // Tampilkan cover buku yang sudah ada di sini jika perlu
                        ?>
                    </div>

                    <div class="mb-3">
                        <label for="file_buku" class="form-label">File Buku (PDF) (Biarkan kosong jika tidak ingin diubah)</label>
                        <input class="form-control" type="file" id="file_buku" name="file_buku"
                            accept="application/pdf" />
                        <small class="text-muted">Hanya file PDF yang diizinkan.</small>
                        <?php
                        // Tampilkan nama file buku yang sudah ada di sini jika perlu
                        ?>
                    </div>

                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul"
                            value="<?php echo htmlspecialchars($dataBuku['judul'] ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5"
                            placeholder="Ketikan deskripsi singkat buku mu"><?php echo htmlspecialchars($dataBuku['deskripsi'] ?? ''); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="">Pilih Kategori</option>
                            <option value="fiksi" <?php if (isset($dataBuku['kategori']) && $dataBuku['kategori'] === 'fiksi') echo 'selected'; ?>>Fiksi</option>
                            <option value="non-fiksi" <?php if (isset($dataBuku['kategori']) && $dataBuku['kategori'] === 'non-fiksi') echo 'selected'; ?>>Non-Fiksi</option>
                            <option value="pendidikan" <?php if (isset($dataBuku['kategori']) && $dataBuku['kategori'] === 'pendidikan') echo 'selected'; ?>>Pendidikan</option>
                            <option value="komik" <?php if (isset($dataBuku['kategori']) && $dataBuku['kategori'] === 'komik') echo 'selected'; ?>>Komik</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
                        <input type="date" class="form-control" id="tanggal_terbit" name="tanggal_terbit"
                            value="<?php echo htmlspecialchars($dataBuku['tanggal_terbit'] ?? ''); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Harga Sewa</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="harga_sewa" class="form-control" placeholder="Harga sewa"
                                value="<?php echo htmlspecialchars($dataBuku['harga_sewa'] ?? ''); ?>" required />
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="persetujuan" required>
                        <label class="form-check-label" for="persetujuan">Informasi buku sudah sesuai</label>
                    </div>

                    <button type="submit" name="update" class="btn btn-primary w-100 fw-bold">Simpan Perubahan</button>
                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../script.js"></script>

    <?php include("../modular/footerFitur.php"); ?>
</body>

</html>