<?php
require_once "../includes/db.php";
require_once "../includes/auth_check.php";
?>

<!DOCTYPE html>
<html>

<head>
    <title>Cart</title>
    <script src="../assets/js/cart.js" defer></script>
</head>

<body>

    <h2>Your Cart</h2>
    <a href="products.php">← Continue Shopping</a>
    <hr>

    <div id="cart"></div>

    <a href="checkout.php"><button>Proceed to Checkout</button></a>

    <script>
        let cart = getCart();
        let html = "";
        let total = 0;

        if (cart.length === 0) {
            html = "<p>Cart is empty</p>";
        } else {
            cart.forEach(item => {
                total += item.price * item.qty;
                html += `
            <p>
                ${item.name} - ₹${item.price} × 
                <input type="number" value="${item.qty}" min="1"
                onchange="updateQty(${item.id}, this.value)">
                <button onclick="removeFromCart(${item.id})">Remove</button>
            </p>
        `;
            });
            html += `<h3>Total: ₹${total}</h3>`;
        }

        document.getElementById("cart").innerHTML = html;
    </script>

</body>

</html>