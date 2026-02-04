<h2>All Products</h2>

<table>
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Price</th>
        <th>Rating</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>

    <?php
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
      <a class='btn' href='admin.php?edit={$row['productID']}'>Edit</a>
      <a class='btn' href='admin.php?delete={$row['productID']}' onclick='return confirm(\"Delete?\")'>Delete</a>
    </td>
  </tr>";
    }
    ?>
</table>