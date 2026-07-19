<?php
include("../includes/db.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, trim($_GET['search']));
}

$category_id = 0;
if (isset($_GET['category']) && is_numeric($_GET['category'])) {
    $category_id = (int) $_GET['category'];
}

$where = "WHERE products.product_name LIKE '%$search%'";
if ($category_id > 0) {
    $where .= " AND products.category_id = $category_id";
}

$query = mysqli_query($conn, "
SELECT products.*, categories.category_name
FROM products
INNER JOIN categories
ON products.category_id = categories.id
$where
ORDER BY products.id DESC
");

$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY category_name");
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Products | SHOPCART</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include("../includes/header.php"); ?>

<div class="container py-5">

<nav class="breadcrumb">
    <a href="../index.php">Home</a>
    <span class="mx-2">/</span>
    <span class="breadcrumb-item active">Products</span>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

<div>
    <h2 class="section-title mb-0">
        <i class="fa-solid fa-box-open"></i> All Products
    </h2>
    <p class="section-sub mb-0">
        <?php echo mysqli_num_rows($query); ?> product<?php echo mysqli_num_rows($query) == 1 ? '' : 's'; ?> found
    </p>
</div>

<form class="d-flex mt-2 mt-md-0" method="GET">
<?php if ($category_id > 0) { ?>
    <input type="hidden" name="category" value="<?php echo $category_id; ?>">
<?php } ?>
<div class="input-group">
<input
type="text"
name="search"
class="form-control"
placeholder="Search products..."
value="<?php echo htmlspecialchars($search); ?>">
<button class="btn btn-primary">
<i class="fa-solid fa-magnifying-glass"></i>
</button>
</div>
</form>

</div>

<!-- Category filter pills -->
<div class="d-flex gap-2 flex-wrap mb-4">

    <a href="products.php<?php echo $search ? '?search=' . urlencode($search) : ''; ?>"
       class="filter-pill <?php echo $category_id == 0 ? 'active' : ''; ?>">
        All
    </a>

    <?php while ($c = mysqli_fetch_assoc($categories)) {
        $qs = ['category' => $c['id']];
        if ($search) $qs['search'] = $search;
    ?>
        <a href="products.php?<?php echo http_build_query($qs); ?>"
           class="filter-pill <?php echo $category_id == $c['id'] ? 'active' : ''; ?>">
            <?php echo htmlspecialchars($c['category_name']); ?>
        </a>
    <?php } ?>

</div>

<div class="row g-4">

<?php

if (mysqli_num_rows($query) > 0) {

while ($row = mysqli_fetch_assoc($query)) {

$image = "../assets/images/" . $row['image'];

?>

<div class="col-lg-3 col-md-4 col-sm-6">

<div class="card product-card h-100">

<div class="product-image-wrap">
<?php

if (!empty($row['image']) && file_exists($image)) {

?>

<img
src="<?php echo $image; ?>"
class="product-image"
alt="<?php echo htmlspecialchars($row['product_name']); ?>">

<?php

} else {

?>

<img
src="https://via.placeholder.com/400x300?text=No+Image"
class="product-image"
alt="No image available">

<?php
}
?>
</div>

<div class="card-body d-flex flex-column">

<span class="cat-badge align-self-start">

<?php echo htmlspecialchars($row['category_name']); ?>

</span>

<h5 class="product-title">

<?php echo htmlspecialchars($row['product_name']); ?>

</h5>

<div class="product-price mb-2">

₹<?php echo number_format($row['price'], 2); ?>

</div>

<?php

if ($row['stock'] > 10) {

echo "<span class='badge bg-success mb-3 align-self-start'>In Stock</span>";

} elseif ($row['stock'] > 0) {

echo "<span class='badge bg-warning text-dark mb-3 align-self-start'>Only {$row['stock']} Left</span>";

} else {

echo "<span class='badge bg-danger mb-3 align-self-start'>Out of Stock</span>";

}

?>

<div class="mt-auto">

<a
href="product.php?id=<?php echo $row['id']; ?>"
class="btn btn-outline-primary w-100 mb-2">

<i class="fa-solid fa-eye"></i>
View Details

</a>

<?php if ($row['stock'] > 0) { ?>

<a
href="../cart/add_to_cart.php?id=<?php echo $row['id']; ?>"
class="btn btn-primary w-100">

<i class="fa-solid fa-cart-shopping"></i>
Add To Cart

</a>

<?php } else { ?>

<button
class="btn btn-secondary w-100"
disabled>

<i class="fa-solid fa-ban"></i>
Out of Stock

</button>

<?php } ?>

</div>

</div>

</div>

</div>

<?php

}

} else {

?>

<div class="col-12">

<div class="empty-state">
    <div class="empty-icon">
        <i class="fa-solid fa-box-open"></i>
    </div>
    <h4>No Products Found</h4>
    <p class="text-muted">Try a different search term or browse another category.</p>
    <a href="products.php" class="btn btn-primary mt-2">View All Products</a>
</div>

</div>

<?php
}
?>

</div>

</div>

<?php include("../includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
