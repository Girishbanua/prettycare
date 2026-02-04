<?php
include "../includes/db.php";

/* CREATE & UPDATE */
if (isset($_POST['save'])) {
    $name = $_POST['productname'];
    $price = $_POST['productRate'];
    $rating = $_POST['productRatings'];
    $description = $_POST['productDesc'];

    $imgName = $_FILES['productImg']['name'];
    $tmpName = $_FILES['productImg']['tmp_name'];

    $imgPath = "";

    if ($imgName != "") {
        $imgPath = "./images/" . $imgName;
        move_uploaded_file($tmpName, $imgPath);
    }

    if ($_POST['id'] == "") {
        // INSERT
        $sql = "INSERT INTO products 
        (productname, productRate, productRatings, productImg, productDesc)
        VALUES 
        ('$name', '$price', '$rating', '$imgPath', '$description')";
    } else {
        // UPDATE
        $id = $_POST['id'];
        $imgQuery = $imgName != "" ? ", productImg='$imgPath'" : "";

        $sql = "UPDATE products SET
            productname='$name',
            productRate='$price',
            productRatings='$rating',
            productDesc='$description'
            $imgQuery
            WHERE productID=$id";
    }

    mysqli_query($conn, $sql) or die(mysqli_error($conn));
    header("Location: admin.php");
}


/* DELETE */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE productID=$id");
    header("Location: admin.php");
}

/* EDIT */
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = mysqli_query($conn, "SELECT * FROM products WHERE productID=$id");

    if (!$res) {
        die("Query Failed: " . mysqli_error($conn));
    }

    $editData = mysqli_fetch_assoc($res);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>
    <nav class="admin-navbar">
        <div class="logo">
            Admin Panel
        </div>

        <ul class="nav-links">
            <li class="dropdown">
                <a href="#">Products</a>
                <ul class="dropdown-menu">
                    <li><a href="admin.php?insert_product">Insert Products</a></li>
                    <li><a href="admin.php?view_products">View Products</a></li>
                </ul>
            </li>

            <li class="dropdown"><a href="categories.php">Categories</a>
                <ul class="dropdown-menu">
                    <li><a href="insert_product.php">Insert Categories</a></li>
                    <li><a href="view_products.php">View Categories</a></li>
                </ul>
            </li>
            <li class="dropdown"><a href="brands.php">Brands</a>
                <ul class="dropdown-menu">
                    <li><a href="insert_product.php">Insert Brands</a></li>
                    <li><a href="view_products.php">View Brands</a></li>
                </ul>
            </li>
            <li><a href="orders.php">All Orders</a></li>
            <li><a href="payments.php">All Payments</a></li>
            <li><a href="users.php">List Users</a></li>
            <li><a href="logout.php" class="logout">Logout</a></li>
        </ul>
    </nav>

    <?php
    if (isset($_GET['insert_product'])) {
        include('insert_product.php');
        include('all_products.php');
    }
    ?>

    <hr>



</body>

</html>