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
SELECT products.*, categories.category_name
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

<title><?php echo htmlspecialchars($product['product_name']); ?></title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<?php include("../includes/header.php"); ?>

<div class="container py-5">

<div class="row g-5">

<div class="col-lg-5">

<?php

$image="../assets/images/".$product['image'];

if(!empty($product['image']) && file_exists($image)){
?>

<img
src="<?php echo $image; ?>"
class="img-fluid rounded shadow w-100 product-detail-image">

<?php
}else{
?>

<img
src="https://via.placeholder.com/500x500?text=No+Image"
class="img-fluid rounded shadow w-100">

<?php
}
?>

</div>

<div class="col-lg-7">

<span class="badge bg-dark mb-3">

<?php echo htmlspecialchars($product['category_name']); ?>

</span>

<h2 class="fw-bold">

<?php echo htmlspecialchars($product['product_name']); ?>

</h2>

<h3 class="text-primary fw-bold my-3">

₹<?php echo number_format($product['price']); ?>

</h3>

<?php

if($product['stock']>10){

echo "<span class='badge bg-success'>In Stock ({$product['stock']})</span>";

}elseif($product['stock']>0){

echo "<span class='badge bg-warning text-dark'>Only {$product['stock']} Left</span>";

}else{

echo "<span class='badge bg-danger'>Out Of Stock</span>";

}

?>

<hr>

<h5>Description</h5>

<p>

<?php echo nl2br(htmlspecialchars($product['description'])); ?>

</p>

<form action="../cart/add_to_cart.php" method="GET">

<input
type="hidden"
name="id"
value="<?php echo $product['id']; ?>">

<div class="mb-3">

<label class="form-label fw-bold">

Quantity

</label>

<input
type="number"
name="qty"
value="1"
min="1"
max="<?php echo $product['stock']; ?>"
class="form-control"
style="width:120px;">

</div>

<div class="d-grid gap-2 d-md-flex">

<button
class="btn btn-primary btn-lg">

<i class="fa-solid fa-cart-shopping"></i>

Add To Cart

</button>

<a
href="products.php"
class="btn btn-outline-secondary btn-lg">

Back

</a>

</div>

</form>

</div>

</div>

</div>

<?php include("../includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>