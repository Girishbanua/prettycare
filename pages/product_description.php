<?php
include "../includes/db.php";

if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit;
}

$product_id = intval($_GET['id']);

$query = mysqli_query(
    $conn,
    "SELECT * FROM products WHERE productID = $product_id"
);

$product = mysqli_fetch_assoc($query);

if (!$product) {
    echo "Product not found";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo $product['productname']; ?></title>
    <style>
        .product-container {
            display: flex;
            gap: 40px;
            max-width: 900px;
            margin: 50px auto;
        }

        .product-image img {
            width: 350px;
            border: 1px solid #ddd;
        }

        .product-details {
            flex: 1;
        }

        .price {
            font-size: 22px;
            color: green;
            margin: 15px 0;
        }

        button {
            padding: 10px 20px;
            background: black;
            color: white;
            border: none;
            cursor: pointer;
        }

        .features {
            margin-top: 10px;
            padding-left: 20px;
        }

        .features li {
            margin-bottom: 6px;
            color: #333;
        }

        .review-form {
            margin-top: 20px;
        }

        .review-form input,
        .review-form select,
        .review-form textarea {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
        }

        .review {
            border-top: 1px solid #ddd;
            padding: 10px 0;
        }

        .stars {
            color: gold;
            margin-left: 10px;
        }
    </style>
</head>

<body>

    <div class="product-container">
        <div class="product-image">
            <img src="../images/products/<?= $product['productImg'] ?>" alt="<?= $product['productname'] ?> ">
        </div>

        <div class="product-details">
            <h1><?php echo $product['productname']; ?></h1>
            <p class="price">₹<?php echo $product['productRate']; ?></p>

            <p><?php echo nl2br($product['productDesc']); ?></p>

            <br>

            <form action="../user/add_to_cart.php" method="post">
                <input type="hidden" name="product_id" value="<? $product['productID']; ?>">
                <button type="submit">Add to Cart</button>
            </form>
        </div>
    </div>
    <?php if (!empty($product['features'])) { ?>
        <h3>Key Features</h3>
        <ul class="features">
            <?php
            $features = explode(",", $product['features']);
            foreach ($features as $feature) {
                echo "<li>" . htmlspecialchars(trim($feature)) . "</li>";
            }
            ?>
        </ul>
    <?php } ?>
    <h3>Customer Reviews</h3>


    <?php
    $review_query = mysqli_query(
        $conn,
        "SELECT * FROM reviews WHERE product_id = $product_id ORDER BY created_at DESC"
    );
    ?>

    <?php if (mysqli_num_rows($review_query) > 0) { ?>
        <div class="reviews">
            <?php while ($review = mysqli_fetch_assoc($review_query)) { ?>
                <div class="review">
                    <strong><?php echo htmlspecialchars($review['user_name']); ?></strong>
                    <span class="stars">
                        <?php echo str_repeat("★", $review['rating']); ?>
                    </span>
                    <p><?php echo htmlspecialchars($review['comment']); ?></p>
                    <small><?php echo $review['created_at']; ?></small>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p>No reviews yet. Be the first!</p>
    <?php } ?>

    <?php include "./products.php" ?>
    <form action="submit_review.php" method="post" class="review-form">
        <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>">

        <input type="text" name="user_name" placeholder="Your Name" required>

        <select name="rating" required>
            <option value="">Rating</option>
            <option value="5">★★★★★ (5)</option>
            <option value="4">★★★★☆ (4)</option>
            <option value="3">★★★☆☆ (3)</option>
            <option value="2">★★☆☆☆ (2)</option>
            <option value="1">★☆☆☆☆ (1)</option>
        </select>

        <textarea name="comment" placeholder="Write a review" required></textarea>

        <button type="submit">Submit Review</button>
    </form>


</body>

</html>