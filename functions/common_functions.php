<?php

//products

function getProducts()
{
  global $conn;
  $result = mysqli_query($conn, "SELECT * FROM products");

  while ($row = mysqli_fetch_assoc($result)) {
    echo "
  <tr>
    <td><img src='../images/products/{$row['productImg']}'></td>
    <td>{$row['productname']}</td>
    <td>₹{$row['productRate']}</td>
    <td>{$row['productRatings']}/5</td>
    <td>{$row['productDesc']}</td>
    <td>
      <a class='btn edt' href='admin.php?insert_product&edit={$row['productID']}'>Edit</a>
      <a class='btn dlt' href='admin.php?insert_product&delete={$row['productID']}' onclick='return confirm(\"Delete?\")'>Delete</a>
    </td>
  </tr>";
  }
}

function showAllProducts()
{
  global $conn;
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
}
