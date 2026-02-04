<?php
require_once "../includes/db.php";

$result = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Products</title>
    <!-- <script src="../assets/js/cart.js" defer></script> -->
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/products.css">
</head>

<body>

    <div class="products-header">
        <h2>Products</h2>
        <a href="cart.php">🛒 View Cart</a>
    </div>
    <div class="products-container">

        <?php
        $sql = "select * from products";
        $result = mysqli_query($conn, $sql);
        $rate = 5;

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $rating = (int)$row['productRatings']; // rating from DB
                $maxStars = 5;
                $stars = "";

                // Full stars
                for ($i = 1; $i <= $rating; $i++) {
                    $stars .= "⭐";
                }

                // Empty stars
                for ($i = $rating + 1; $i <= $maxStars; $i++) {
                    $stars .= "☆";
                }
                $markPrice = $row['productRate'] + ($row['productRate'] * 0.15); ?>

                <div class='product-container'>
                    <div class='product-card'>
                        <div class='img-div'>
                            <a href="product_description.php?id=<?= $row['productID'] ?>">
                                <img src="../images/products/<?= $row['productImg'] ?>" class='product-image'>
                            </a>
                            <!-- <img src='../images/products/<?= $row["productImg"] ?>' alt='<?= $row["productname"] ?>' class='product-image' /> -->
                        </div>
                        <div class="product-desc">
                            <div class='prdctHeading'>
                                <div class='productTitle'>
                                    <h2><?= $row['productname'] ?></h2>
                                    <p><?= $rating ?>/5 <?= $stars ?></p>
                                </div>
                                <div class='price'>
                                    <p>In stock</p>
                                    <h3>₹<?= $row['productRate'] ?> <span>(₹<?= $markPrice ?>)</span></h3>
                                </div>
                                <!-- <button onclick='addToCart(
                    <?= $row["productID"] ?>,
                    "<?= $row["productname"] ?>",
                    <?= $row["productRate"] ?>
                     )'>Add to cart</button> -->
                                <a href="../user/add_to_cart.php" class="addToCartBtn"><button>Add to cart</button></a>
                            </div>
                        </div>
                    </div>
                </div>
        <?php }
        } else {
            echo "
        <h1>No data found</h1>
        ";
        }
        ?>
    </div>
</body>

</html>