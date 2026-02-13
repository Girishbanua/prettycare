<head>
    <style>
        .category-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .categories {
            width: 320px;
            margin-top: 30px;
            background: #ffffff;
            padding: 30px 35px;
            border-radius: 14px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
            animation: fadeIn 0.5s ease-in-out;
            text-align: center;
        }

        img {
            height: 200px;
            width: 200px;
            object-fit: cover;
        }

        p {
            font-size: 20px;
        }
    </style>
</head>

<div class="category-container">
    <?php
    $stmnt = "SELECT * FROM categories";
    $result = mysqli_query($conn, $stmnt);

    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['category_title'];
        $image = $row['image_path'];

        echo "<div class='categories'>
        <img src='../images/categories/$image' alt='$image'>
                  <p>$title</p> 
                  </div>";
    }
    ?>
</div>