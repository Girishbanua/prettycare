<?php
require_once "../includes/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $address = trim($_POST["address"]);
    $password = $_POST["password"];

    if (empty($name) || empty($email) || empty($password) || empty($address)) {
        $message = "All fields are required";
    } else {
        // Check if email exists
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $message = "Email already registered";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = mysqli_prepare(
                $conn,
                "INSERT INTO users (name, email, password, address) VALUES (?, ?, ?, ?)"
            );
            mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hashedPassword, $address);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: login.php");
                exit;
            } else {
                $message = "Signup failed";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Signup</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>

<div class="auth-container">
    <h2>Create Account</h2>

    <?php if (!empty($message)) : ?>
        <p class="error"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Signup</button>
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>
</div>

</body>

</html>