<?php
require_once "../includes/db.php";

if (isset($_POST['insert_cat'])) {
    $categori_title = $_POST['product_categories'];
    $img_name = $_FILES['category_image']['name'];
    $tempName = $_FILES['category_image']['tmp_name'];
    $img_path = "../images/categories/" . $img_name;
    move_uploaded_file($tempName, $img_path);

    //select from database
    $select = "SELECT * from categories where category_title='$categori_title'";
    $result_select = mysqli_query($conn, $select);
    $num_rows = mysqli_num_rows($result_select);
    if ($num_rows > 0) {
        echo "<script> alert('Categori is aleradi present') </script>";
    } else {
        $stmnt = "INSERT into `categories`(category_title, image_path) values ('$categori_title', '$img_name')";
        $result = mysqli_query($conn, $stmnt);
        echo "<script> alert('Categori has been inserted successfulli') </script>";
    }
}

?>
<h2>Insert Categories</h2>
<form action="" method="post" enctype="multipart/form-data">
    <label for=""> Enter category</label>
    <input type="text" placeholder="enter the categori" name="product_categories">
    <label for=""> Upload Image</label>
    <input type="file" name="category_image">
    <button type="submit" name="insert_cat">submit</button>
</form>