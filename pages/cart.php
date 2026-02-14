<?php

require_once '../includes/db.php';

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "Cart is empty";
    exit();
}

// 🔴 REMOVE ITEM
if (isset($_POST['remove_item'])) {

    $product_id = (int) $_POST['product_id'];

    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }

    header("Location: cart.php");
    exit();
}
$cart = $_SESSION['cart'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>Your Cart</h2>
    <a href="../pages/products.php">Continue Shopping</a>
    <hr>

    <?php
    $total = 0;

    foreach ($cart as $product_id => $quantity) {

        $result = mysqli_query($conn, "SELECT * FROM products WHERE productID = $product_id");
        $product = mysqli_fetch_assoc($result);

        $subtotal = $product['productRate'] * $quantity;
        $total += $subtotal;
    ?>

        <div style="border:1px solid #ccc; padding:10px; margin:10px;">
            <h3><?php echo $product['productname']; ?></h3>
            <p>Quantity: <?php echo $quantity; ?></p>
            <p>Subtotal: ₹<?php echo $subtotal; ?></p>
            <form method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <button type="submit" name="remove_item">Remove</button>
            </form>
        </div>

    <?php } ?>

    <h2>Total: ₹<?php echo $total; ?></h2>

</body>

</html>