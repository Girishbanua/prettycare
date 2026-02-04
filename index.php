<?php require_once "./includes/db.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <title>Ecommerce</title>
  <link rel="stylesheet" href="./assets/css/index.css" />
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

        <a href="pages/signup.php" class="btn">Get Started</a>
        <a href="pages/products.php" class="btn">Browse Products</a>
      </div>
    </div>
    <section class="latest">
      <h1>Latest Releases</h1>
    </section>
    <div class="productList">
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
          $markPrice = $row['productRate'] + ($row['productRate'] * 0.15);
          echo "
             <div class='product'>
             <img src='./images/products/{$row["productImg"]}' alt='{$row["productname"]}' />
             <div>
               <div class='prdctHeading'>
                 <div class='productTitle'>
                   <h2>{$row['productname']}</h2>
                   <p>{$rating}/5 {$stars}</p>
                 </div>
                 <div class='price'>
                   <p>In stock</p>
                   <h3>₹{$row['productRate']} <span>(₹{$markPrice})</span></h3>                   
                 </div>
                 <a href='./pages/products.php'><button>View</button></a>
               </div>
             </div>
            </div> ";
        }
      } else {
        echo "
        <h1>No data found</h1>
        ";
      }
      ?>
    </div>
  </main>
</body>

</html>

<?php
// require_once "./includes/db.php";

// // If user already logged in, redirect to products
// if (isset($_SESSION["user_id"])) {
//   header("Location: pages/products.php");
//   exit;
// }
// 
?>

<!-- <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Beauty Store | Glow Naturally</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Montserrat';
      background: #f5f9ff;
      color: #1a1a1a;
    }

    :root {
      --secondari-btn: #292929ff;
    }

    header {
      padding: 0px 50px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #ffffff8c;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    header h1 {
      color: #e24a6b;
      font-size: 24px;
      font-weight: 300;
    }

    nav a {
      margin-left: 20px;
      text-decoration: none;
      color: #e24a6b;
    }

    .hero {
      height: 400px;
      padding: 100px 60px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-image: url('images/bgimage.png');
      background-position: 35% 25%;

    }

    .hero-text {
      max-width: 500px;
    }

    .hero-text h2 {
      font-size: 48px;
      color: #e24a6b;
    }

    .hero-text p {
      font-size: 18px;
      margin: 20px 0;
    }

    .btn {
      padding: 14px 30px;
      border-radius: 30px;
      background: #e24a6b;
      color: #fff;
      text-decoration: none;
      margin-right: 10px;
      display: inline-block;
    }

    .hero-image {
      width: 420px;
      height: 420px;
      background: #dbeafe;
      border-radius: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      color: #e24a6b;
    }

    footer {
      text-align: center;
      padding: 20px;
      background: #e24a6b;
      color: white;
    }

    @media (max-width: 900px) {
      .hero {
        flex-direction: column;
        text-align: center;
      }

      .hero-image {
        margin-top: 40px;
      }
    }
  </style>
</head>

<body>

  <header>
    <h1>BeautyStore</h1>
    <nav>
      <a href="pages/login.php">Login</a>
      <a href="pages/signup.php">Signup</a>
      <a href="pages/products.php">Shop</a>
    </nav>
  </header>

  <section class="hero">
    <div class="hero-text">
      <h2>Glow Naturally ✨</h2>
      <p>
        Discover premium beauty and skincare products crafted
        to enhance your natural glow — simple, safe, and effective.
      </p>

      <a href="signup.php" class="btn">Get Started</a>
      <a href="products.php" class="btn" style="background: var(--secondari-btn);">Browse Products</a>
    </div>

    <div class="hero-image">
      Beauty Product Image
    </div>
  </section>

  <footer>
    © <?php echo date("Y"); ?> BeautyStore. All rights reserved.
  </footer>

</body>

</html> -->