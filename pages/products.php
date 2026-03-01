<?php
require_once "../includes/db.php";
// if (isset($_GET['added'])) {
//     echo "<p class='alert success' style='color:green;'>Item added to cart successfully!</p>";
// }
$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    $cart_items = 0;
} else
    $cart_items = array_sum($_SESSION['cart']);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blush | Products</title>
    <!-- <script src="../assets/js/cart.js" defer></script> -->
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/products.css">
    <style>
        body {
            padding: 0;
        }

        .sale-banner {
            overflow: hidden;
            background: linear-gradient(90deg, #ff4d6d, #ff8fa3);
            color: white;
            padding: 10px 0;
            white-space: nowrap;
        }

        .marquee-text {
            display: inline-block;
            padding-left: 100%;
            animation: scrollText 15s linear infinite;
            font-weight: bold;
            font-size: 18px;
        }

        @keyframes scrollText {
            0% {
                transform: translateX(0%);
            }

            100% {
                transform: translateX(-100%);
            }
        }
    </style>
</head>

<body>
    <div id="msg"></div>
    <!-- if empty -->
    <div class="sale-banner">
        <div class="marquee-text">
            🎉 Big Sale! Get up to 50% OFF on all products 💄 | Free Delivery on orders above ₹499 🚚 | Limited Time Offer ⏰
        </div>
    </div>
    <div class="products-header" style="padding: 0 20px;">
        <a href="../index.php">
            <h1 style="font-family: French Script MT;">Blush</h1>
        </a>
        <div class="cartbtn">
            <a href="cart.php">🛒 Pretty Cart </a>
            <p id="cart_count"><?= $cart_items ?></p>
        </div>
    </div>
    <main style="padding: 0 20px;">
        <aside>
            <section>
                <h1>Brands</h1>
                <?php
                $stmnt = "SELECT * from brands";
                $result = mysqli_query($conn, $stmnt);
                while ($row = mysqli_fetch_assoc($result)) {
                    $brand = $row['brand_id'];
                    echo "<a href='?brand=$brand'> {$row['brand_name']}</a> <br>";
                }
                ?>
            </section>
            <section>
                <h1>Categories</h1>
                <?php
                $stmnt = "SELECT * from categories";
                $result = mysqli_query($conn, $stmnt);
                while ($row = mysqli_fetch_assoc($result)) {
                    $category = $row['category_title'];
                    $cid = $row['category_id'];

                    echo "<a href='?category=$cid'> $category</a> <br>";
                }
                ?>
            </section>
        </aside>
        <!-- visible on mobile devices -->
        <div class="searchBar">
            <div>
                <label for="categories_Dropbox">Categories</label>
                <select name="" id="categories_Dropbox">
                    <option value="">Categories</option>
                    <?php
                    $stmnt = "SELECT * from categories";
                    $result = mysqli_query($conn, $stmnt);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $category = $row['category_title'];
                        $cid = $row['category_id'];

                        echo "<a href='?category=$cid'>
                    <option value='$cid'>$category</option>
                     </a> <br>";
                    }
                    ?>

                </select>
            </div>
            <div>
                <label for="brands_Dropbox">Brands</label>
                <select name="" id="brands_Dropbox">
                    <option value="">Brands</option>
                    <?php
                    $stmnt = "SELECT * from brands";
                    $result = mysqli_query($conn, $stmnt);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $brand = $row['brand_id'];
                        echo "<a href='?brand=$brand'> <option value='$brand'>{$row['brand_name']}</option></a> <br>";
                    }
                    ?>

                </select>
            </div>
        </div>
        <div class="products-container">

            <?php

            $category = $_GET['category'] ?? null;
            $brand_id = $_GET['brand'] ?? null;

            if ($category) {
                $sql = "SELECT * FROM products WHERE Category = '$category'";
            } else if ($brand_id) {
                $sql = "SELECT * FROM products WHERE brand = '$brand_id'";
            } else {
                $sql = "SELECT * FROM products"; // show all products
            }

            $result = mysqli_query($conn, $sql);

            $rate = 5;

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $rating = (int)$row['productRatings']; // rating from DB
                    $id = (int)$row['productID'];
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
                                    <form method="post">
                                        <!-- <input type="hidden" name="product_id" value="<?php echo $id; ?>">-->
                                        <button name="add_to_cart" class="addToCartBtn" id="addBtn" onclick="addToCart(<?= $row['productID'] ?>)">Add to cart</button>
                                    </form>
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
    </main>

    <footer class="footer">
        <div class="footer-container">

            <!-- Brand -->
            <div class="footer-box">
                <h2 class="brand-name">Blush</h2>
                <p>Glow naturally with premium beauty products crafted with care and love.</p>
            </div>

            <!-- Quick Links -->
            <div class="footer-box">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Shop</a></li>
                    <li><a href="#">Categories</a></li>
                    <li><a href="#">My Account</a></li>
                </ul>
            </div>

            <!-- Customer Care -->
            <div class="footer-box">
                <h3>Customer Care</h3>
                <ul>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Shipping & Returns</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="footer-box">
                <h3>Stay Connected</h3>
                <p>Subscribe for beauty tips & exclusive offers</p>
                <form class="newsletter">
                    <input type="email" placeholder="Enter your email" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>

        </div>

        <div class="footer-bottom">
            <p>© 2026 Blush. All rights reserved.</p>
        </div>
    </footer>
</body>
<script>
    function addToCart(productId) {

        fetch('../user/add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'product_id=' + productId
            })
            .then(response => response.text())
            .then(data => {

                if (data.trim() === 'success') {

                    // update cart count AFTER success
                    let cartCount = document.getElementById("cart_count");
                    let count = parseInt(cartCount.innerText);
                    cartCount.innerText = count + 1;

                    // show message
                    let msg = document.getElementById("msg");
                    if (msg) {
                        msg.innerText = "✔ Item added!";
                    }

                } else {
                    alert("Error adding item");
                }
            })
            .catch(error => console.error(error));
    }
</script>


</html>