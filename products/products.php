<?php
include("../includes/db.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$search = "";

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, trim($_GET['search']));
}

$query = mysqli_query($conn, "
SELECT products.*, categories.category_name
FROM products
INNER JOIN categories
ON products.category_id = categories.id
WHERE products.product_name LIKE '%$search%'
ORDER BY products.id DESC
");
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Products | SHOPCART</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include("../includes/header.php"); ?>

<div class="container py-5">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">

<h2 class="fw-bold">
<i class="fa-solid fa-box-open"></i> All Products
</h2>

<form class="d-flex mt-2 mt-md-0" method="GET">

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

<div class="row">

<?php

if (mysqli_num_rows($query) > 0) {

while ($row = mysqli_fetch_assoc($query)) {

$image = "../assets/images/" . $row['image'];

?>

<div class="col-lg-3 col-md-4 col-sm-6 mb-4">

<div class="card product-card h-100 shadow border-0">

<?php

if (!empty($row['image']) && file_exists($image)) {

?>

<img
src="<?php echo $image; ?>"
class="card-img-top product-image"
style="height:220px;object-fit:cover;">

<?php

} else {

?>

<img
src="https://via.placeholder.com/400x300?text=No+Image"
class="card-img-top product-image"
style="height:220px;object-fit:cover;">

<?php
}
?>

<div class="card-body d-flex flex-column">

<span class="badge bg-dark mb-2 align-self-start">

<?php echo htmlspecialchars($row['category_name']); ?>

</span>

<h5 class="fw-bold">

<?php echo htmlspecialchars($row['product_name']); ?>

</h5>

<h4 class="text-primary fw-bold">

₹<?php echo number_format($row['price'], 2); ?>

</h4>

<?php

if ($row['stock'] > 10) {

echo "<span class='badge bg-success mb-3'>In Stock ({$row['stock']})</span>";

} elseif ($row['stock'] > 0) {

echo "<span class='badge bg-warning text-dark mb-3'>Only {$row['stock']} Left</span>";

} else {

echo "<span class='badge bg-danger mb-3'>Out of Stock</span>";

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

<div class="alert alert-warning text-center">

<h4>No Products Found</h4>

<p>Try searching with another keyword.</p>

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