<section class="categories">
    <h2 class="section-title">Shop by Category</h2>
    <div class="category-grid">
        <?php
        $stmnt = "SELECT * FROM categories";
        $result = mysqli_query($conn, $stmnt);

        while ($row = mysqli_fetch_assoc($result)) {
            $brand_title = $row['category_title'];
            $images = $row['image_path'];
            echo "
            <a href='pages/products.php' class='category-card'>
                <img src='images/categories/$images' alt='$brand_title'>
                <div class='overlay'>$brand_title</div>
             </a>
        ";
        }
        ?>
    </div>
</section>