<?php
// require_once "../includes/db.php";
// require_once "../includes/auth_check.php";

// $data = json_decode($_COOKIE['cart'] ?? "[]", true);
// $userId = $_SESSION["user_id"];
// $total = 0;

// foreach ($data as $item) {
//     $total += $item["price"] * $item["qty"];
// }

// mysqli_begin_transaction($conn);

// $orderQuery = "INSERT INTO orders (user_id, total, status) VALUES (?, ?, 'Placed')";
// $stmt = mysqli_prepare($conn, $orderQuery);
// mysqli_stmt_bind_param($stmt, "id", $userId, $total);
// mysqli_stmt_execute($stmt);

// $orderId = mysqli_insert_id($conn);

// $itemQuery = "INSERT INTO order_items (order_id, product_id, quantity, price)
//               VALUES (?, ?, ?, ?)";
// $stmt = mysqli_prepare($conn, $itemQuery);

// foreach ($data as $item) {
//     mysqli_stmt_bind_param(
//         $stmt,
//         "iiid",
//         $orderId,
//         $item["id"],
//         $item["qty"],
//         $item["price"]
//     );
//     mysqli_stmt_execute($stmt);
// }

// mysqli_commit($conn);

// echo "<script>
// localStorage.removeItem('cart');
// alert('Order placed successfully');
// window.location='orders.php';
// </script>";

session_start();
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
