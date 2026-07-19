<?php
include("includes/db.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOPCART — Shop Electronics, Fashion, Books & More</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<?php include("includes/navbar.php"); ?>

<!-- Hero -->
<section class="hero">
    <div class="container text-center">

        <h1 class="fw-bold">
            Everything you need, <br class="d-none d-md-block">
            one cart away.
        </h1>

        <p class="lead mt-3">
            Electronics, fashion, books, shoes and much more — with fast checkout.
        </p>

        <form class="hero-search" action="products/products.php" method="GET">
            <div class="input-group">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search for products...">
                <button class="btn btn-accent" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </form>

        <a href="products/products.php" class="btn btn-light btn-lg mt-4 fw-bold">
            Shop Now <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>

    </div>
</section>

<!-- Categories -->
<div class="container mt-5 pt-3">

    <h2 class="section-title text-center">Featured Categories</h2>
    <p class="section-sub text-center">Browse by what you're looking for</p>

    <div class="row g-4">

        <?php
        $catIcons = [
            'electronics' => 'fa-mobile-screen-button',
            'fashion'     => 'fa-shirt',
            'books'       => 'fa-book',
            'shoes'       => 'fa-shoe-prints',
            'home'        => 'fa-house',
            'beauty'      => 'fa-spray-can-sparkles',
            'sports'      => 'fa-basketball',
            'toys'        => 'fa-puzzle-piece',
        ];

        $category = mysqli_query($conn, "SELECT * FROM categories");

        while ($row = mysqli_fetch_assoc($category)) {

            $catKey = strtolower($row['category_name']);
            $icon = 'fa-tags';
            foreach ($catIcons as $key => $iconClass) {
                if (strpos($catKey, $key) !== false) {
                    $icon = $iconClass;
                    break;
                }
            }

            $count_q = mysqli_query($conn, "SELECT COUNT(*) AS c FROM products WHERE category_id='{$row['id']}'");
            $count_row = mysqli_fetch_assoc($count_q);
        ?>

        <div class="col-lg-3 col-md-4 col-6">
            <a href="products/products.php?category=<?php echo $row['id']; ?>" class="text-decoration-none">
                <div class="card category-card text-center py-4">
                    <div class="card-body">
                        <div class="category-icon">
                            <i class="fa-solid <?php echo $icon; ?>"></i>
                        </div>
                        <h5 class="mb-1" style="color:var(--ink);"><?php echo htmlspecialchars($row['category_name']); ?></h5>
                        <span class="cat-count"><?php echo $count_row['c']; ?> items</span>
                    </div>
                </div>
            </a>
        </div>

        <?php } ?>

    </div>

</div>

<!-- Latest Products -->
<div class="container mt-5 pt-3">

    <div class="d-flex justify-content-between align-items-end mb-2 flex-wrap">
        <div>
            <h2 class="section-title mb-0">Latest Products</h2>
            <p class="section-sub mb-0">Fresh arrivals, picked for you</p>
        </div>
        <a href="products/products.php" class="btn btn-outline-primary">
            View All <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="row g-4 mt-2">

        <?php

        $product = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC LIMIT 4");

        while ($p = mysqli_fetch_assoc($product)) {

            $image = "assets/images/" . $p['image'];
        ?>

        <div class="col-lg-3 col-md-6">

            <div class="card product-card h-100">

                <div class="product-image-wrap">
                <?php if (!empty($p['image']) && file_exists($image)) { ?>
                    <img src="<?php echo $image; ?>" class="product-image" alt="<?php echo htmlspecialchars($p['product_name']); ?>">
                <?php } else { ?>
                    <img src="https://via.placeholder.com/400x300?text=No+Image" class="product-image" alt="No image available">
                <?php } ?>
                </div>

                <div class="card-body d-flex flex-column">

                    <span class="cat-badge">Featured</span>

                    <h5 class="product-title"><?php echo htmlspecialchars($p['product_name']); ?></h5>

                    <div class="product-price mb-3">
                        ₹<?php echo number_format($p['price'], 2); ?>
                    </div>

                    <div class="mt-auto">
                        <a href="products/product.php?id=<?php echo $p['id']; ?>" class="btn btn-primary w-100">
                            <i class="fa-solid fa-cart-shopping me-1"></i> View & Add
                        </a>
                    </div>

                </div>

            </div>

        </div>

        <?php } ?>

    </div>

</div>

<?php include("includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
