<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Input Produk</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
  </head>
  <body>
    <header class="bg-dark py-2 fixed-top">
      <div class="container d-flex justify-content-between align-items-center">
        <h3 class="text-light">Input Produk</h3>
        <a href="index.php" class="btn btn-warning">Beranda</a>
      </div>
    </header>

    <div class="container mt-5 pt-5">
      <div class="card">
        <div class="card-header bg-primary text-white">Form Input Produk</div>
        <div class="card-body">
          <form action="output.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label class="form-label">Nama Produk</label>
              <input
                type="text"
                name="nama_produk"
                class="form-control"
                required
              />
            </div>
            <div class="mb-3">
              <label class="form-label">Harga</label>
              <input type="number" name="harga" class="form-control" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Deskripsi</label>
              <textarea
                name="deskripsi"
                class="form-control"
                rows="3"
              ></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Gambar Produk</label>
              <input
                type="file"
                name="gambar"
                class="form-control"
                accept="image/*"
                required
              />
            </div>
            <a href="outputProduk.php">
              <button type="submit" class="btn btn-success">Submit</button></a>
            
          </form>
        </div>
      </div>
    </div>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
