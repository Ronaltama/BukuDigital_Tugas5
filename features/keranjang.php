<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Your Cart</title>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../css/loginpagestyle.css" />
  <style>
  body {
    background-color: #f8f9fa;
    padding-top: 70px;
    /* Sesuaikan dengan tinggi header dan navbar */
  }
  </style>

</head>

<body class="bg-light">
  <?php
    include("../modular/headerBack.php");
    ?>

  <main class="container py-5">
    <h1 class="text-center mb-4">Your Cart</h1>
    <div class="row">
      <!-- Cart Items -->
      <div class="col-md-8">
        <div class="card shadow-sm">
          <div class="card-body">
            <table class="table table-bordered text-center align-middle">
              <thead class="table-dark">
                <tr>
                  <th>Product</th>
                  <th>Sewa/Beli</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Total</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="cart-items"></tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- Order Summary -->
      <div class="col-md-4">
        <div class="card shadow-sm p-3">
          <h2 class="text-center">Order Summary</h2>
          <p>Subtotal: <span id="subtotal">Rp 0</span></p>
          <div class="mb-3">
            <input type="text" id="voucher-code" class="form-control" placeholder="Masukkan kode voucher" />
            <button class="btn btn-primary w-100 mt-2" onclick="applyVoucher()">
              Gunakan
            </button>
          </div>
          <p>Diskon: <span id="discount">Rp 0</span></p>
          <p>
            <strong>Total: <span id="total">Rp 0</span></strong>
          </p>
          <button id="checkout-btn" class="btn btn-success w-100">
            CHECKOUT
          </button>
        </div>
      </div>
    </div>
  </main>
  <!-- Bootstrap JS -->
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
  document.addEventListener("DOMContentLoaded", function() {
    let cartItems = [{
        name: "Buku 1",
        priceBeli: 120000,
        priceSewa: 60000,
        quantity: 2,
        type: "Beli",
        image: "img1.jpg",
      },
      {
        name: "Buku 2",
        priceBeli: 132000,
        priceSewa: 66000,
        quantity: 1,
        type: "Sewa",
        image: "img2.jpg",
      },
      {
        name: "Buku 3",
        priceBeli: 23000,
        priceSewa: 12000,
        quantity: 2,
        type: "Beli",
        image: "img3.jpg",
      },
    ];
    let discountValue = 0;

    function updateCart() {
      const cartTable = document.getElementById("cart-items");
      cartTable.innerHTML = "";
      let subtotal = 0;
      cartItems.forEach((item, index) => {
        let harga = item.type === "Beli" ? item.priceBeli : item.priceSewa;
        let totalHarga = harga * item.quantity;
        subtotal += totalHarga;
        let row = `<tr>
              <td><img src="${item.image}" width="50"> ${item.name}</td>
              <td>
                <select class="form-select" onchange="updateType(${index}, this.value)">
                  <option value="Sewa" ${
                    item.type === "Sewa" ? "selected" : ""
                  }>Sewa</option>
                  <option value="Beli" ${
                    item.type === "Beli" ? "selected" : ""
                  }>Beli</option>
                </select>
              </td>
              <td>Rp ${harga.toLocaleString()}</td>
              <td>
                <button class="btn btn-sm btn-danger" onclick="updateQuantity(${index}, -1)">-</button>
                ${item.quantity}
                <button class="btn btn-sm btn-success" onclick="updateQuantity(${index}, 1)">+</button>
              </td>
              <td>Rp ${totalHarga.toLocaleString()}</td>
              <td><button class="btn btn-sm btn-outline-danger" onclick="removeItem(${index})">X</button></td>
            </tr>`;
        cartTable.innerHTML += row;
      });
      let total = subtotal - discountValue;
      document.getElementById(
        "subtotal"
      ).innerText = `Rp ${subtotal.toLocaleString()}`;
      document.getElementById(
        "discount"
      ).innerText = `Rp ${discountValue.toLocaleString()}`;
      document.getElementById(
        "total"
      ).innerText = `Rp ${total.toLocaleString()}`;
    }

    window.updateQuantity = function(index, change) {
      if (cartItems[index].quantity + change > 0) {
        cartItems[index].quantity += change;
        updateCart();
      }
    };

    window.updateType = function(index, type) {
      cartItems[index].type = type;
      updateCart();
    };

    window.removeItem = function(index) {
      cartItems.splice(index, 1);
      updateCart();
    };

    window.applyVoucher = function() {
      let voucherInput = document
        .getElementById("voucher-code")
        .value.trim()
        .toUpperCase();
      let subtotal = cartItems.reduce((sum, item) => {
        let harga = item.type === "Beli" ? item.priceBeli : item.priceSewa;
        return sum + harga * item.quantity;
      }, 0);
      if (voucherInput === "DIGI20") {
        discountValue = subtotal * 0.2;
      } else if (voucherInput === "GEMARMEMBACA") {
        discountValue = subtotal * 0.1;
      } else {
        discountValue = 0;
        alert("Kode voucher tidak valid!");
      }
      updateCart();
    };

    updateCart();
  });
  </script>
  <br>
  <?php
    include("../modular/footerFitur.php");
    ?>
</body>

</html>