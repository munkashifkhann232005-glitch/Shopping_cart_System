<?php
include("../includes/db.php");

if(session_status() == PHP_SESSION_NONE){
    session_start();
}

if(!isset($_GET['id'])){
    header("Location: products.php");
    exit();
}

$id = (int)$_GET['id'];

$query = mysqli_query($conn,"
SELECT products.*, categories.category_name, categories.id AS category_id
FROM products
INNER JOIN categories
ON products.category_id = categories.id
WHERE products.id='$id'
");

if(mysqli_num_rows($query)==0){
    header("Location: products.php");
    exit();
}

$product = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>

<head>

<title><?php echo htmlspecialchars($product['product_name']); ?> | SHOPCART</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

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
    <a href="products.php">Products</a>
    <span class="mx-2">/</span>
    <a href="products.php?category=<?php echo $product['category_id']; ?>"><?php echo htmlspecialchars($product['category_name']); ?></a>
    <span class="mx-2">/</span>
    <span class="breadcrumb-item active"><?php echo htmlspecialchars($product['product_name']); ?></span>
</nav>

<div class="row g-5">

<div class="col-lg-5">

<?php

$image="../assets/images/".$product['image'];

if(!empty($product['image']) && file_exists($image)){
?>

<img
src="<?php echo $image; ?>"
class="product-detail-image"
alt="<?php echo htmlspecialchars($product['product_name']); ?>">

<?php
}else{
?>

<img
src="https://via.placeholder.com/500x500?text=No+Image"
class="product-detail-image"
alt="No image available">

<?php
}
?>

</div>

<div class="col-lg-7">

<span class="cat-badge mb-3">

<?php echo htmlspecialchars($product['category_name']); ?>

</span>

<h2 class="fw-bold mt-3">

<?php echo htmlspecialchars($product['product_name']); ?>

</h2>

<div class="product-price my-3" style="font-size:2rem;">

₹<?php echo number_format($product['price'], 2); ?>

</div>

<?php

if($product['stock']>10){

echo "<span class='badge bg-success'>In Stock &mdash; {$product['stock']} available</span>";

}elseif($product['stock']>0){

echo "<span class='badge bg-warning text-dark'>Only {$product['stock']} Left</span>";

}else{

echo "<span class='badge bg-danger'>Out Of Stock</span>";

}

?>

<hr class="my-4">

<h5>Description</h5>

<p class="text-muted">

<?php echo nl2br(htmlspecialchars($product['description'])); ?>

</p>

<?php if ($product['stock'] > 0) { ?>

<form action="../cart/add_to_cart.php" method="GET" class="mt-4">

<input
type="hidden"
name="id"
value="<?php echo $product['id']; ?>">

<div class="mb-4">

<label class="form-label fw-bold d-block">
Quantity
</label>

<div class="qty-stepper">
    <button type="button" class="btn" onclick="stepQty(-1)"><i class="fa-solid fa-minus"></i></button>
    <input
        type="number"
        name="qty"
        id="qtyInput"
        value="1"
        min="1"
        max="<?php echo (int) $product['stock']; ?>"
        readonly>
    <button type="button" class="btn" onclick="stepQty(1)"><i class="fa-solid fa-plus"></i></button>
</div>

</div>

<div class="d-grid gap-2 d-md-flex">

<button
class="btn btn-primary btn-lg px-4">

<i class="fa-solid fa-cart-shopping"></i>
Add To Cart

</button>

<a
href="products.php"
class="btn btn-outline-secondary btn-lg">

Back to Products

</a>

</div>

</form>

<?php } else { ?>

<div class="d-grid gap-2 d-md-flex mt-4">
    <button class="btn btn-secondary btn-lg px-4" disabled>
        <i class="fa-solid fa-ban"></i> Out of Stock
    </button>
    <a href="products.php" class="btn btn-outline-secondary btn-lg">
        Back to Products
    </a>
</div>

<?php } ?>

</div>

</div>

</div>

<?php include("../includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script>
function stepQty(delta) {
    const input = document.getElementById('qtyInput');
    const max = parseInt(input.max || 999, 10);
    const min = parseInt(input.min || 1, 10);
    let value = parseInt(input.value || 1, 10) + delta;
    if (value < min) value = min;
    if (value > max) value = max;
    input.value = value;
}
</script>

</body>

</html>
