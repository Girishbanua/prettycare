<?php
session_start();
require_once "../includes/db.php";

$product_id = (int) $_POST['product_id'];

if (isset($_SESSION['user_id'])) {
    // ✅ Logged-in user → store in DB
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare(
        "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?"
    );
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $conn->query(
            "UPDATE cart SET quantity = quantity + 1
             WHERE user_id = $user_id AND product_id = $product_id"
        );
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO cart (user_id, product_id, quantity)
             VALUES (?, ?, 1)"
        );
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
    }
} else {
    // ❌ Guest user → store in session
    $_SESSION['cart'][$product_id] =
        ($_SESSION['cart'][$product_id] ?? 0) + 1;
}

header("Location: ../pages/cart.php");
exit;
