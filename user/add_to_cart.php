<?php
require_once "../includes/db.php";

// $product_id = (int) $_POST['product_id'];

// if (isset($_POST['add_to_cart'])) {

//     $product_id = (int) $_POST['product_id'];

//     if (isset($_SESSION['cart'][$product_id])) {
//         $_SESSION['cart'][$product_id]++;
//     } else {
//         $_SESSION['cart'][$product_id] = 1;
//     }

//     // Set flash message
//     $_SESSION['success'] = "Item added to cart successfully!";

//     // header("Location: ../pages/products.php");
//     exit();
// }

if (isset($_POST['product_id'])) {

    $product_id = (int) $_POST['product_id'];

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }

    // return success to JS
    echo "success";
    exit();
}


header("Location: ../pages/products.php");
exit;
