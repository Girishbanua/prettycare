<h2>Admin – Add / Update Product</h2>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $editData['productID'] ?? '' ?>">

    <label for="">Product Name</label>
    <input type="text" name="productname" placeholder="Enter the Product Name"
        value="<?= $editData['productname'] ?? '' ?>" required>

    <label for="">Product price</label>
    <input type="number" name="productRate" placeholder="Enter the Price"
        value="<?= $editData['productRate'] ?? '' ?>" required>

    <label for="">Product ratings</label>
    <input type="number" name="productRatings" placeholder="Enter the Rating (1–5)"
        value="<?= $editData['productRatings'] ?? '' ?>" min="1" max="5" required>

    <label for="">Product image</label>
    <input type="file" name="productImg">

    <label for="">Product Description</label>
    <input type="text" name="productDesc" placeholder="Enter the description for the product">

    <button type="submit" name="save">
        <?= isset($editData) ? "Update Product" : "Add Product" ?>
    </button>
</form>