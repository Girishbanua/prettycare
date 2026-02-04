<?php
include "../includes/db.php";

$product_id = (int) $_POST['product_id'];
$user_name = trim($_POST['user_name']);
$rating = (int) $_POST['rating'];
$comment = trim($_POST['comment']);

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO reviews (product_id, user_name, rating, comment)
     VALUES (?, ?, ?, ?)"
);

mysqli_stmt_bind_param(
    $stmt,
    "isis",
    $product_id,
    $user_name,
    $rating,
    $comment
);

mysqli_stmt_execute($stmt);

header("Location: product_description.php?id=" . $product_id);
exit;
