 <?php
    // session_start();
    // require_once "../includes/db.php";

    // if (!isset($_SESSION['user_id'])) {
    //     header("Location: ../pages/login.php");
    //     exit;
    // }

    // if (empty($_SESSION['cart'])) {
    //     die("Cart is empty");
    // }

    // $user_id = $_SESSION['user_id'];
    // $total = 0;

    /* 1️⃣ Calculate total 
foreach ($_SESSION['cart'] as $product_id => $qty) {
    $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $total += $result['price'] * $qty;
}

 2️⃣ Insert into orders table 
$stmt = $conn->prepare(
    "INSERT INTO orders (user_id, total_amount) VALUES (?, ?)"
);
$stmt->bind_param("ii", $user_id, $total);
$stmt->execute();

$order_id = $stmt->insert_id;

/* 3️⃣ Insert each product into order_items 
foreach ($_SESSION['cart'] as $product_id => $qty) {
    $stmt = $conn->prepare(
        "INSERT INTO order_items (order_id, product_id, quantity, price)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param("iiii", $order_id, $product_id, $qty, $price);

    // get product price again
    $priceStmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $priceStmt->bind_param("i", $product_id);
    $priceStmt->execute();
    $price = $priceStmt->get_result()->fetch_assoc()['price'];

    $stmt->execute();
}

/* 4️⃣ Clear cart 
unset($_SESSION['cart']);

header("Location: ../pages/order_success.php");
exit;
*/
    ?>

 <?php
    require_once "../includes/db.php";
    $_SESSION['redirect_url'] = "pages/checkout.php";

    require_once "../includes/auth_check.php";

    $cart = $_SESSION['cart'] ?? [];

    if (empty($cart)) {
        echo "Cart is empty!";
        exit();
    }
    ?>
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Checkout</title>
     <link rel="stylesheet" href="../assets/css/checkout.css">
     <link rel="stylesheet" href="../assets/css/index.css">
 </head>

 <body>
     <div class="checkout-container">
         <h2>Checkout</h2>

         <form action="place_order.php" method="POST" class="checkout-form">
             <input type="text" name="name" placeholder="Your Name" required>

             <input type="text" name="phone" placeholder="Phone" required>

             <textarea name="address" placeholder="Address" required></textarea>

             <button type="submit">Place Order</button>
         </form>
     </div>
 </body>

 </html>