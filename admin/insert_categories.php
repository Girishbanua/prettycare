<?php
require_once "../includes/db.php";

if (isset($_POST['insert_cat'])) {
    $categori_title = $_POST['product_categories'];

    //select from database
    $select = "SELECT * from categories where category_title='$categori_title'";
    $result_select = mysqli_query($conn, $select);
    $num_rows = mysqli_num_rows($result_select);
    if ($num_rows > 0) {
        echo "<script> alert('Categori is aleradi present') </script>";
    } else {
        $stmnt = "INSERT into `categories`(category_title) values ('$categori_title')";
        $result = mysqli_query($conn, $stmnt);
        echo "<script> alert('Categori has been inserted successfulli') </script>";
    }
}

?>
<h2>Insert Categories</h2>
<form action="" method="post">
    <input type="text" placeholder="enter the categori" name="product_categories">
    <button type="submit" name="insert_cat">submit</button>
</form>