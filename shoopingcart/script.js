document.addEventListener("DOMContentLoaded", function () {
    let cartItems = [
        { name: "Buku 1", priceBeli: 120000, priceSewa: 60000, quantity: 2, type: "Beli", image: "img1.jpg" },
        { name: "Buku 2", priceBeli: 132000, priceSewa: 66000, quantity: 1, type: "Sewa", image: "img2.jpg" },
        { name: "Buku 3", priceBeli: 23000, priceSewa: 12000, quantity: 2, type: "Beli", image: "img3.jpg" }
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

            let row = document.createElement("tr");
            row.innerHTML = `
                <td><img src="${item.image}" width="50"> ${item.name}</td>
                <td>
                    <select class="sewa-beli" onchange="updateType(${index}, this.value)">
                        <option value="Sewa" ${item.type === "Sewa" ? "selected" : ""}>Sewa</option>
                        <option value="Beli" ${item.type === "Beli" ? "selected" : ""}>Beli</option>
                    </select>
                </td>
                <td>Rp ${harga.toLocaleString()}</td>
                <td>
                    <button class="quantity-btn" onclick="updateQuantity(${index}, -1)">-</button>
                    ${item.quantity}
                    <button class="quantity-btn" onclick="updateQuantity(${index}, 1)">+</button>
                </td>
                <td>Rp ${totalHarga.toLocaleString()}</td>
                <td><button onclick="removeItem(${index})">X</button></td>
            `;

            cartTable.appendChild(row);
        });

        let total = subtotal - discountValue;
        document.getElementById("subtotal").innerText = `Rp ${subtotal.toLocaleString()}`;
        document.getElementById("discount").innerText = `Rp ${discountValue.toLocaleString()}`;
        document.getElementById("total").innerText = `Rp ${total.toLocaleString()}`;
    }

    window.updateQuantity = function (index, change) {
        if (cartItems[index].quantity + change > 0) {
            cartItems[index].quantity += change;
            updateCart();
        }
    };

    window.updateType = function (index, type) {
        cartItems[index].type = type;
        updateCart();
    };

    window.removeItem = function (index) {
        cartItems.splice(index, 1);
        updateCart();
    };

    window.applyVoucher = function () {
        let voucherInput = document.getElementById("voucher-code").value.trim().toUpperCase();
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
