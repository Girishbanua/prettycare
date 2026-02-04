<?php
require_once "../includes/db.php";
require_once "../includes/auth_check.php";

$data = json_decode($_COOKIE['cart'] ?? "[]", true);
$userId = $_SESSION["user_id"];
$total = 0;

foreach ($data as $item) {
    $total += $item["price"] * $item["qty"];
}

mysqli_begin_transaction($conn);

$orderQuery = "INSERT INTO orders (user_id, total, status) VALUES (?, ?, 'Placed')";
$stmt = mysqli_prepare($conn, $orderQuery);
mysqli_stmt_bind_param($stmt, "id", $userId, $total);
mysqli_stmt_execute($stmt);

$orderId = mysqli_insert_id($conn);

$itemQuery = "INSERT INTO order_items (order_id, product_id, quantity, price)
              VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $itemQuery);

foreach ($data as $item) {
    mysqli_stmt_bind_param(
        $stmt,
        "iiid",
        $orderId,
        $item["id"],
        $item["qty"],
        $item["price"]
    );
    mysqli_stmt_execute($stmt);
}

mysqli_commit($conn);

echo "<script>
localStorage.removeItem('cart');
alert('Order placed successfully');
window.location='orders.php';
</script>";
