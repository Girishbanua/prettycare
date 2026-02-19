<?php

require_once "../includes/db.php";
$_SESSION['redirect_url'] = "user/dashboard.php";
require_once "../includes/auth_check.php";

$user_id = $_SESSION['user_id'];


// Fetch user info
$userQuery = mysqli_query($conn, "SELECT name, email FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($userQuery);

// Fetch total orders
$orderCountQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM orders WHERE user_id = $user_id");
$orderCount = mysqli_fetch_assoc($orderCountQuery);

// Fetch recent orders
$recentOrders = mysqli_query(
    $conn,
    "SELECT order_id, total_amount, order_status, created_at 
     FROM orders 
     WHERE user_id = $user_id 
     ORDER BY created_at DESC 
     LIMIT 5"
);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/index.css">

</head>

<body>

    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>My Account</h2>
            <a href="../pages/products.php">Shop</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="orders.php">My Orders</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php" class="logout" onclick="return confirm('do u want to log out ?')">Logout</a>
        </aside>

        <!-- Main Content -->
        <main class="content">
            <h1>Welcome, <?php echo $user['name']; ?> 👋</h1>
            <!-- Stats -->
            <div class="stats">
                <div class="card">
                    <h3>Total Orders</h3>
                    <p><?php echo $orderCount['total']; ?></p>
                </div>
                <div class="card">
                    <h3>Account Status</h3>
                    <p>Active</p>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="orders">
                <h2>Recent Orders</h2>

                <?php if (mysqli_num_rows($recentOrders) > 0) { ?>
                    <table>
                        <tr>
                            <th>Order ID</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>

                        <?php while ($row = mysqli_fetch_assoc($recentOrders)) { ?>
                            <tr>
                                <td>#<?php echo $row['order_id']; ?></td>
                                <td>₹<?php echo $row['total_amount']; ?></td>
                                <td class="status <?php echo strtolower($row['order_status']); ?>">
                                    <?php echo $row['order_status']; ?>
                                </td>
                                <td><?php echo date("d M Y", strtotime($row['created_at'])); ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } else { ?>
                    <p>No orders yet.</p>
                <?php } ?>
            </div>
        </main>
    </div>

</body>

</html>