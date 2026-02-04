<?php
require_once "../includes/db.php";
require_once "../includes/auth_check.php";

$userId = $_SESSION["user_id"];

$query = mysqli_query(
    $conn,
    "SELECT name, email, address 
     FROM users 
     WHERE id = $userId"
);

$user = mysqli_fetch_assoc($query);

// Update profile
if (isset($_POST["update"])) {
    $name = $_POST["name"];
    // $phone   = $_POST["phone"];
    $address = $_POST["address"];

    mysqli_query(
        $conn,
        "UPDATE users 
         SET name='$name', address='$address' 
         WHERE id=$userId"
    );

    $success = "Profile updated successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>

<body>

    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>My Account</h2>
            <a href="../index.php">Home</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="orders.php">My Orders</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php" class="logout" onclick="return confirm('do u want to log out ?')">Logout</a>
        </aside>

        <!-- Content -->
        <main class="content">
            <h1>My Profile</h1>

            <?php if (isset($success)) { ?>
                <div class="success-msg"><?= $success ?></div>
            <?php } ?>

            <form method="post" class="profile-form">
                <label>Name</label>
                <input type="text" name="name" value="<?= $user['name'] ?>" required>

                <label>Email (readonly)</label>
                <input type="email" value="<?= $user['email'] ?>" readonly>

                <!-- <label>Phone</label>
                <input type="text" name="phone" value="<?= $user['phone'] ?>"> -->

                <label>Address</label>
                <textarea name="address"><?= $user['address'] ?></textarea>

                <button type="submit" name="update">Update Profile</button>
            </form>
        </main>
    </div>

</body>

</html>