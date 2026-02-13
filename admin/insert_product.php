<head>
    <link rel="stylesheet" href="./stile.css">
</head>
<h2>Insert Products</h2>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $editData['productID'] ?? '' ?>">

    <label for="">Product Name</label>
    <input type="text" name="productname" placeholder="Enter the Product Name"
        value="<?= $editData['productname'] ?? '' ?>" required>

    <div>
        <label for="">Product Category</label>
        <select name="productcategory" id="">
            <option value="">Select</option>
            <?php
            $stmnt = "SELECT * FROM categories";
            $result = mysqli_query($conn, $stmnt);
            while ($row = mysqli_fetch_assoc($result)) {
                $title = $row['category_title'];
                $id = $row['category_id'];
                echo "
                    <option value='$id'>$title</option>    
                ";
            }
            ?>

        </select>
    </div>
    <div>
        <label for="">Product brand</label>
        <select name="productbrand" id="">
            <option value="">Select</option>
            <?php
            $stmnt = "SELECT * FROM brands";
            $result = mysqli_query($conn, $stmnt);
            while ($row = mysqli_fetch_assoc($result)) {
                $title = $row['brand_name'];
                $id = $row['brand_id'];
                echo "
                    <option value='$id'>$title</option>    
                ";
            }
            ?>

        </select>
    </div>

    <label for="">Product price</label>
    <input type="number" name="productRate" placeholder="Enter the Price"
        value="<?= $editData['productRate'] ?? '' ?>" required>

    <label for="">Product ratings</label>
    <input type="number" name="productRatings" placeholder="Enter the Rating (1–5)"
        value="<?= $editData['productRatings'] ?? '' ?>" min="1" max="5" required>

    <label for="">Product image</label>
    <input type="file" name="productImg">

    <label for="">Product Description</label>
    <input type="text" name="productDesc" placeholder="Enter the description for the product"
        value="<?= $editData['productDesc'] ?? '' ?>">

    <button type="submit" name="save">
        <?= isset($editData) ? "Update Product" : "Add Product" ?>
    </button>
</form>