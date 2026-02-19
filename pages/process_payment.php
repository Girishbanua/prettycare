<?php
session_start();
include("../includes/db.php");
echo "<pre>";
print_r($_SESSION);
print_r($_POST);



// Get checkout data
$checkout = $_SESSION['checkout'] ?? [];

$cname = $checkout['name'] . ' ' . $checkout['lname'];
$phone = $checkout['phone'];
$address = $checkout['address'] . ', ' . $checkout['city'] . ', ' . $checkout['state'] . ' - ' . $checkout['pincode'];

$method = $_POST['method'];
$user_id = $_SESSION['user_id'] ?? 1;
$total = $_SESSION['total'] ?? 0;
$cart = $_SESSION['cart'] ?? [];

// SQL query
$query = "INSERT INTO orders (
    user_id, 
    customer_name, 
    payment_method,
    phone, 
    address, 
    total_amount
) VALUES (
    '$user_id', 
    '$cname',
    '$method', 
    '$phone', 
    '$address', 
    '$total'
)";

$result = mysqli_query($conn, $query);

if ($result) {

    // Clear cart & checkout
    unset($_SESSION['cart']);
    unset($_SESSION['total']);
    unset($_SESSION['checkout']);

    header("Location: success.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
exit();
