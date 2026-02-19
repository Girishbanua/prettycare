<?php
require_once "./includes/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $message = "All fields are required";
    } else {
        $stmt = mysqli_prepare(
            $conn,
            "SELECT id, name, password, role FROM users WHERE email = ?"
        );
        // mysqli_stmt_bind_param($stmt, "s", $email);
        $stmt->bind_param('s', $email);
        // mysqli_stmt_execute($stmt);
        $stmt->execute();
        // $result = mysqli_stmt_get_result($stmt);
        $result = $stmt->get_result();

        if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["name"];
                $_SESSION["role"] = $user["role"];
                if ($_SESSION["role"] === "admin") {
                    header("Location: ./admin/admin.php");
                    exit;
                } else {
                    $redirect = $_SESSION['redirect_url'];
                    header("Location: $redirect");
                    unset($_SESSION['redirect_url']);
                    exit;
                }
            } else {
                $message = "Invalid credentials";
            }
        } else {
            $message = "Invalid credentials";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="./assets/css/auth.css">
</head>

<body>

    <div class="auth-container">
        <h2>Login</h2>

        <?php if (!empty($message)) : ?>
            <p class="error"><?php echo $message; ?></p>
        <?php endif; ?>

        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <p>No account? <a href="./pages/signup.php">Signup</a></p>
    </div>

</body>

</html>