<?php
include("includes/db.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<!-- Dynamic Navbar -->
<?php include("includes/navbar.php"); ?>

<!-- Hero Section -->

<section class="hero">

    <div class="container text-center">

        <h1 class="display-3 fw-bold">
            Welcome to SHOPCART
        </h1>

        <p class="lead mt-3">
            Buy Electronics, Fashion, Books, Shoes and Much More.
        </p>

        <a href="products/products.php" class="btn btn-light btn-lg mt-3">
            Shop Now
        </a>

    </div>

</section>

<!-- Categories -->

<div class="container mt-5">

    <h2 class="text-center mb-4">
        Featured Categories
    </h2>

    <div class="row">

        <?php

        $category = mysqli_query($conn, "SELECT * FROM categories");

        while ($row = mysqli_fetch_assoc($category)) {

        ?>

        <div class="col-md-3 mb-4">

            <div class="card shadow category-card">

                <div class="card-body text-center">

                    <h4><?php echo $row['category_name']; ?></h4>

                </div>

            </div>

        </div>

        <?php } ?>

    </div>

</div>

<!-- Latest Products -->

<div class="container mt-5">

    <h2 class="text-center mb-4">
        Latest Products
    </h2>

    <div class="row">

        <?php

        $product = mysqli_query($conn, "SELECT * FROM products LIMIT 4");

        while ($p = mysqli_fetch_assoc($product)) {

        ?>

        <div class="col-md-3 mb-4">

            <div class="card shadow product-card">

                <?php
                if (!empty($p['image'])) {
                ?>
                    <img src="assets/images/<?php echo $p['image']; ?>" class="card-img-top" height="220">
                <?php
                } else {
                ?>
                    <img src="https://via.placeholder.com/300x220" class="card-img-top">
                <?php
                }
                ?>

                <div class="card-body">

                    <h5><?php echo $p['product_name']; ?></h5>

                    <p class="text-muted">
                        <?php echo substr($p['description'], 0, 60); ?>...
                    </p>

                    <h4 class="text-primary">
                        ₹<?php echo $p['price']; ?>
                    </h4>

                    <a href="cart/cart.php?id=<?php echo $p['id']; ?>" class="btn btn-primary w-100">
                        Add To Cart
                    </a>

                </div>

            </div>

        </div>

        <?php } ?>

    </div>

</div>

<footer class="bg-dark text-white text-center mt-5 p-4">

    <p class="mb-0">
        © 2026 Shopping Cart System
    </p>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>