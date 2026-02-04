<?php
require_once "../includes/db.php";
require_once "../includes/auth_check.php";

$userId = $_SESSION["user_id"];

$result = mysqli_query(
    $conn,
    "SELECT id, total, status, created_at 
     FROM orders 
     WHERE user_id = $userId 
     ORDER BY created_at DESC"
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
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
            <h1>My Orders</h1>

            <?php if (mysqli_num_rows($result) > 0) { ?>
                <table class="orders-table">
                    <tr>
                        <th>Order ID</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>

                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td>#<?= $row["id"] ?></td>
                            <td>₹<?= $row["total"] ?></td>
                            <td class="status <?= strtolower($row["status"]) ?>">
                                <?= $row["status"] ?>
                            </td>
                            <td><?= date("d M Y", strtotime($row["created_at"])) ?></td>
                            <td>
                                <a href="order_details.php?id=<?= $row["id"] ?>" class="btn">
                                    View
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <p class="empty-msg">You have not placed any orders yet.</p>
            <?php } ?>
        </main>
    </div>

</body>

</html>