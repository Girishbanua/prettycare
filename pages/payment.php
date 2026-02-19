<?php
session_start();
$total = $_SESSION['total'] ?? 0;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $_SESSION['checkout'] = [
        'name' => $_POST['name'],
        'lname' => $_POST['lname'],
        'phone' => $_POST['phone'],
        'address' => $_POST['address'],
        'city' => $_POST['city'],
        'state' => $_POST['state'],
        'pincode' => $_POST['pincode'],
        'total' => $total
    ];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/pament.css">
</head>

<body>
    <div class="payment-container">
        <h2>Payment Page</h2>

        <div class="amount">
            Total: <?php echo $total; ?>
        </div>
        <p><strong>Total Amount: ₹<?php echo $total; ?></strong></p>
        <div class="card-preview">
            <p>**** **** **** 1234</p>
        </div>

        <form action="process_payment.php" method="post">

            <div class="payment-methods">
                <label><input type="radio" name="method" value="Card" required> Card</label>
                <label><input type="radio" name="method" value="UPI"> UPI</label>
                <label><input type="radio" name="method" value="COD"> COD</label>
            </div>

            <div class="card-details">
                <input type="text" placeholder="Card Number">
                <div class="row">
                    <input type="text" placeholder="MM/YY">
                    <input type="text" placeholder="CVV">
                </div>
            </div>

            <button type="submit">Pay Now</button>

        </form>

        <p class="note">*This is a demo payment page. No real transaction.</p>

    </div>
</body>

</html>