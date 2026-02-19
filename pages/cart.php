<?php

require_once '../includes/db.php';
$_SESSION['redirect_url'] = "pages/checkout.php";

if (isset($_SESSION['success'])) {
    echo "<div class='alert success'>" . $_SESSION['success'] . "</div>";

    // Remove message after showing once
    unset($_SESSION['success']);
}

$cart = $_SESSION['cart'] ?? [];


// 🔴 REMOVE ITEM
if (isset($_POST['remove_item'])) {

    $product_id = (int) $_POST['product_id'];

    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }

    header("Location: cart.php");
    exit();
}
$cart = $_SESSION['cart'] ?? [];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <style>
        body {
            background: #f5f5f7;
        }

        /* Container */
        .cart-container {
            width: 80%;
            margin: 40px auto;
            animation: fadeIn 0.7s ease-in-out;
        }

        /* Heading */
        .cart-container h2 {
            color: #e35d5b;
            margin-bottom: 15px;
        }

        /* Continue button */
        .continue-btn {
            display: inline-block;
            margin-bottom: 20px;
            color: #e35d5b;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .continue-btn:hover {
            text-decoration: underline;
        }

        /* Cart items layout */
        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Cart card */
        .cart-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        .cart-card:hover {
            transform: translateY(-3px);
        }

        /* Details */
        .cart-details h3 {
            margin: 0;
            color: #333;
        }

        .cart-details p {
            margin: 5px 0;
            color: #666;
        }

        /* Price */
        .price {
            font-weight: bold;
            color: #e35d5b;
            font-size: 18px;
        }

        /* Remove button */
        .remove-btn {
            background: transparent;
            border: 1px solid #e35d5b;
            color: #e35d5b;
            padding: 8px 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .remove-btn:hover {
            background: #e35d5b;
            color: white;
        }

        /* Summary */
        .cart-summary {
            margin-top: 30px;
            padding: 20px;
            background: white;
            border-radius: 15px;
            text-align: right;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        /* Checkout button */
        .checkout-btn {
            background: #e35d5b;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .checkout-btn:hover {
            background: #d94b48;
            transform: translateY(-2px);
        }

        .checkout-btn:active {
            transform: scale(0.97);
        }

        /* Continue Shopping */
        .continue-btn {
            display: inline-block;
            margin-bottom: 25px;
            color: #e35d5b;
            text-decoration: none;
            font-weight: 500;
        }

        /* Card Style */
        .empty-cart-card {
            background: #fff;
            border-radius: 20px;
            padding: 60px 30px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        /* Icon */
        .empty-icon {
            font-size: 60px;
            margin-bottom: 20px;
        }

        /* Text */
        .empty-cart-card h3 {
            font-size: 22px;
            margin-bottom: 10px;
            color: #333;
        }

        .empty-cart-card p {
            color: #777;
            margin-bottom: 25px;
        }

        /* Button */
        .shop-btn {
            display: inline-block;
            background: #e35d5b;
            color: #fff;
            padding: 12px 28px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .shop-btn:hover {
            background: #ff5e5bff;
            color: #fff;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="cart-container">
        <?php
        if (empty($cart)) {
            echo "
            <h2>Your Cart</h2>

              <a href='../pages/products.php' class='continue-btn'>
                  ← Continue Shopping
                </a>

                <!-- Empty Cart Card -->
                <div class='empty-cart-card'>
                    <div class='empty-icon'>🛒</div>
                    <h3>Your cart is empty</h3>
                    <p>Looks like you haven’t added anything yet.</p>

                     <a href='../pages/products.php' class='shop-btn'>
                      Start Shopping
                      </a>
                </div>
             ";
            exit();
        }

        ?>
        <div class="cart-items">
            <h2>Your Cart</h2>
            <a href='../pages/products.php' class='continue-btn'>
                ← Continue Shopping
            </a>
            <?php
            $total = 0;

            foreach ($cart as $product_id => $quantity) {

                $result = mysqli_query($conn, "SELECT * FROM products WHERE productID = $product_id");
                $product = mysqli_fetch_assoc($result);

                $subtotal = $product['productRate'] * $quantity;
                $total += $subtotal;
            ?>
                <?php $_SESSION['total'] = $total; ?>

                <div class="cart-card">
                    <div class="cart-details">
                        <h3><?php echo $product['productname']; ?></h3>
                        <p>Quantity: <?php echo $quantity; ?></p>
                        <p class="price">₹<?php echo $subtotal; ?></p>
                    </div>

                    <form method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <button type="submit" name="remove_item" class="remove-btn">Remove</button>
                    </form>
                </div>

            <?php } ?>

        </div>

        <div class="cart-summary">
            <h2>Total: ₹<?php echo $total; ?></h2>

            <a href="checkout.php">
                <button class="checkout-btn">Proceed to Checkout</button>
            </a>
        </div>
    </div>


</body>


</html>