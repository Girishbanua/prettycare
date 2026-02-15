<?php
require_once "./includes/db.php";
include "./functions/common_functions.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" /> -->
  <!-- <script src="bootstrap/js/bootstrap.bundle.min.js"></script> -->
  <title>Ecommerce</title>
  <link rel="stylesheet" href="./assets/css/index.css" />
  <link rel="stylesheet" href="./assets/css/categories.css">

</head>

<body>
  <nav>
    <div id="logo">
      <h1 id="logo">Blush</h1>
    </div>
    <div id="menus">
      <ul>
        <li><a href="">Home</a></li>
        <li><a href="">About Us</a></li>
        <li><a href="pages/products.php">Shop</a></li>
        <li><a href="">Categories</a></li>
        <li><a href="">Order</a></li>
      </ul>
    </div>
    <div id="icons">
      <a href="pages/signup.php">Signup</a>
      <a href="pages/cart.php"><img src="./icons/shopping-cart.png" alt="Add to cart" width="25px" /></a>
      <a href="user/dashboard.php"><img src="./icons/user.png" alt="Profile" width="25px" /></a>

    </div>
  </nav>
  <main>
    <div class="hero">
      <div class="hero-text">
        <h2>Glow Naturally</h2>
        <p>
          Discover premium beauty and skincare products crafted
          to enhance your natural glow — simple, safe, and effective.
        </p>
        <br>
        <a href="pages/signup.php" class="btn">Get Started</a>
        <a href="pages/products.php" class="btn">Browse Products</a>
      </div>
    </div>
    <?php include "./pages/categories.php" ?>
    <section class="latest">
      <h1>Latest Releases</h1>
    </section>
    <div class="productList">
      <?php
      showAllProducts();
      ?>
    </div>
  </main>
</body>
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

</html>