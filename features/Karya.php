<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karya Saya</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../style.css">
    <style>
        /* Tambahan style jika diperlukan */
        .aksi-button {
            margin-right: 5px;
        }
    </style>
</head> 

<body>

    <?php include("../modular/headerPenulis.php"); ?>

    <div class="container mt-5 pt-5">
        <h2 class="text-center text-success mb-4">Karya Saya</h2>

        <?php
        // Di sini nanti akan ada logika PHP untuk mengambil daftar buku penulis dari database
        // Contoh data (diganti dengan data dari database):
        $daftarKarya = [
            [
                'id' => 1,
                'judul' => 'Buku Pertama',
                'tanggal_unggah' => '2025-05-30'
            ],
            [
                'id' => 2,
                'judul' => 'Novel Kedua',
                'tanggal_unggah' => '2025-05-25'
            ],
            // ... buku lainnya
        ];
        ?>

        <?php if (empty($daftarKarya)) : ?>
            <p class="text-center">Anda belum mengunggah karya.</p>
        <?php else : ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="bg-light">
                        <tr>
                            <th>Judul Buku</th>
                            <th>Tanggal Unggah</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($daftarKarya as $karya) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($karya['judul']); ?></td>
                                <td><?php echo htmlspecialchars($karya['tanggal_unggah']); ?></td>
                                <td class="text-center">
                                    <a href="updateBuku.php?id=<?php echo $karya['id']; ?>" class="btn btn-sm btn-primary aksi-button">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="Proses_Delete.php?id=<?php echo $karya['id']; ?>" class="btn btn-sm btn-danger"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <div class="mt-3">
            <a href="unggahBuku.php" class="btn btn-success">
                <i class="fas fa-upload"></i> Unggah Buku Baru
            </a>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../script.js"></script>

    <?php include("../modular/footerFitur.php"); ?>
</body>

</html>