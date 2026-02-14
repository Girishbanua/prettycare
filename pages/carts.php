<?php
// require_once "../includes/auth_check.php";
include "../includes/db.php";

// Handle cart updates
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        $quantity = intval($quantity);
        if ($quantity > 0) {
            $_SESSION['cart'][$product_id] = $quantity;
        } else {
            unset($_SESSION['cart'][$product_id]);
        }
    }
    header('Location: cart.php?updated=1');
    exit;
}

// Handle remove item
if (isset($_GET['remove'])) {
    $product_id = intval($_GET['remove']);
    unset($_SESSION['cart'][$product_id]);
    header('Location: cart.php?removed=1');
    exit;
}

// Fetch cart items
$cart_items = [];
$total = 0;

if (!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $ids_string = implode(',', array_map('intval', $ids));

    $result = $conn->query("SELECT * FROM products WHERE productID IN ($ids_string)");

    while ($product = $result->fetch_assoc()) {
        $product['quantity'] = $_SESSION['cart'][$product['id']];
        $product['subtotal'] = $product['price'] * $product['quantity'];
        $total += $product['subtotal'];
        $cart_items[] = $product;
    }
}

$cart_count = array_sum($_SESSION['cart']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Lumière Beauty</title>
    <link rel="stylesheet" href="../assets/css/index.css">
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-content">
                <a href="index.php" class="logo">Lumière</a>
                <div class="nav-links">
                    <a href="index.php">Shop</a>
                    <a href="cart.php" class="cart-link">
                        Cart
                        <?php if ($cart_count > 0): ?>
                            <span class="cart-badge"><?php echo $cart_count; ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Messages -->
    <?php if (isset($_GET['updated'])): ?>
        <div class="alert alert-success">Cart updated successfully!</div>
    <?php endif; ?>
    <?php if (isset($_GET['removed'])): ?>
        <div class="alert alert-success">Item removed from cart!</div>
    <?php endif; ?>

    <!-- Cart Section -->
    <section class="cart-section">
        <div class="container">
            <h1 class="page-title">Shopping Cart</h1>

            <?php if (empty($cart_items)): ?>
                <div class="empty-cart">
                    <h2>Your cart is empty</h2>
                    <p>Add some beautiful products to your cart!</p>
                    <a href="index.php" class="btn btn-primary">Continue Shopping</a>
                </div>
            <?php else: ?>
                <form method="POST" class="cart-form">
                    <div class="cart-table">
                        <div class="cart-header">
                            <div class="cart-col-product">Product</div>
                            <div class="cart-col-price">Price</div>
                            <div class="cart-col-quantity">Quantity</div>
                            <div class="cart-col-total">Total</div>
                            <div class="cart-col-remove"></div>
                        </div>

                        <?php foreach ($cart_items as $item): ?>
                            <div class="cart-row">
                                <div class="cart-col-product">
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>"
                                        alt="<?php echo htmlspecialchars($item['name']); ?>"
                                        class="cart-item-image">
                                    <div class="cart-item-info">
                                        <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                                        <span class="cart-item-category"><?php echo htmlspecialchars($item['category']); ?></span>
                                    </div>
                                </div>
                                <div class="cart-col-price">$<?php echo number_format($item['price'], 2); ?></div>
                                <div class="cart-col-quantity">
                                    <input type="number"
                                        name="quantity[<?php echo $item['id']; ?>]"
                                        value="<?php echo $item['quantity']; ?>"
                                        min="0"
                                        max="<?php echo $item['stock']; ?>"
                                        class="quantity-input">
                                </div>
                                <div class="cart-col-total">$<?php echo number_format($item['subtotal'], 2); ?></div>
                                <div class="cart-col-remove">
                                    <a href="cart.php?remove=<?php echo $item['id']; ?>"
                                        class="remove-btn"
                                        onclick="return confirm('Remove this item from cart?')">×</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="cart-actions">
                        <button type="submit" name="update_cart" class="btn btn-secondary">Update Cart</button>
                        <a href="index.php" class="btn btn-secondary">Continue Shopping</a>
                    </div>
                </form>

                <div class="cart-summary">
                    <h2>Order Summary</h2>
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>$<?php echo number_format($total, 2); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping:</span>
                        <span><?php echo $total >= 50 ? 'FREE' : '$5.99'; ?></span>
                    </div>
                    <div class="summary-row summary-total">
                        <span>Total:</span>
                        <span>$<?php echo number_format($total + ($total >= 50 ? 0 : 5.99), 2); ?></span>
                    </div>
                    <a href="checkout.php" class="btn btn-primary btn-large">Proceed to Checkout</a>
                    <p class="free-shipping-notice">
                        <?php if ($total < 50): ?>
                            Add $<?php echo number_format(50 - $total, 2); ?> more for free shipping!
                        <?php else: ?>
                            You qualify for free shipping!
                        <?php endif; ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3 class="footer-logo">Lumière</h3>
                    <p>Luxury beauty products for the discerning woman</p>
                </div>
                <div class="footer-section">
                    <h4>Customer Service</h4>
                    <ul>
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Shipping Info</a></li>
                        <li><a href="#">Returns</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>About</h4>
                    <ul>
                        <li><a href="#">Our Story</a></li>
                        <li><a href="#">Sustainability</a></li>
                        <li><a href="#">Careers</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Lumière Beauty. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
</body>

</html>