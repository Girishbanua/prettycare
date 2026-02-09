<?php
require_once "../includes/db.php";

if (isset($_POST['insert_brand'])) {
    $brand_name = $_POST['product_brand'];

    //select from database
    $select = "SELECT * from brands where brand_name ='$brand_name'";
    $result_select = mysqli_query($conn, $select);
    $num_rows = mysqli_num_rows($result_select);
    if ($num_rows > 0) {
        echo "<script> alert('This brand alreadi exists') </script>";
    } else {

        $stmnt = "INSERT into brands(brand_name) values ('$brand_name')";
        $result = mysqli_query($conn, $stmnt);
        echo "<script> alert('Ur brand has been inserted successfulli') </script>";
    }
}

?>

<form action="" method="post">
    <input type="text" placeholder="enter a new brand" name="product_brand">
    <button type="submit" name="insert_brand">submit</button>
</form>