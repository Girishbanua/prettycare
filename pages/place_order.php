<?php
require_once "../includes/db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = (int)$_SESSION["user_id"];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $cart = $_SESSION['cart'] ?? [];

    if (empty($cart)) {
        die("Cart is empty");
    }

    $total = 0;

    // calculate total
    foreach ($cart as $product_id => $qty) {
        $res = mysqli_query($conn, "SELECT productRate FROM products WHERE productID = $product_id");
        $row = mysqli_fetch_assoc($res);

        $total += $row['productRate'] * $qty;
    }

    // insert into orders
    $stmt = $conn->prepare("INSERT INTO orders (user_id, customer_name, phone, address, total_amount) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssd", $userId, $name, $phone, $address, $total);
    $stmt->execute();

    $order_id = $stmt->insert_id;

    // insert order items
    foreach ($cart as $product_id => $qty) {

        $res = mysqli_query($conn, "SELECT productRate FROM products WHERE productID = $product_id");
        $row = mysqli_fetch_assoc($res);

        $price = $row['productRate'];

        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $order_id, $product_id, $qty, $price);
        $stmt->execute();
    }

    // clear cart
    unset($_SESSION['cart']);

    // redirect
    header("Location: success.php");
    exit();
}
