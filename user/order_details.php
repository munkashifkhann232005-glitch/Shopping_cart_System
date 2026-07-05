<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: my_orders.php");
    exit();
}

$order_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

// Verify order belongs to user
$order = mysqli_query($conn,"
SELECT *
FROM orders
WHERE id='$order_id'
AND user_id='$user_id'
");

if(mysqli_num_rows($order)==0){
    header("Location: my_orders.php");
    exit();
}

$order = mysqli_fetch_assoc($order);

// Fetch products
$items = mysqli_query($conn,"
SELECT
order_items.*,
products.product_name,
products.image
FROM order_items
INNER JOIN products
ON order_items.product_id = products.id
WHERE order_items.order_id='$order_id'
");
?>

<!DOCTYPE html>
<html>

<head>

<title>Order Details</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<?php include("../includes/header.php"); ?>

<div class="container py-5">

<div class="card shadow">

<div class="card-body">

<h2>

Order #<?php echo $order['id']; ?>

</h2>

<p>

<b>Status :</b>

<span class="badge bg-warning">

<?php echo $order['status']; ?>

</span>

</p>

<p>

<b>Date :</b>

<?php echo date("d M Y",strtotime($order['order_date'])); ?>

</p>

<hr>

<table class="table table-bordered">

<tr>

<th>Image</th>
<th>Product</th>
<th>Price</th>
<th>Qty</th>
<th>Subtotal</th>

</tr>

<?php while($row=mysqli_fetch_assoc($items)){ ?>

<tr>

<td>

<?php

$image="../assets/images/".$row['image'];

if(file_exists($image)){

?>

<img
src="<?php echo $image; ?>"
width="70"
height="70"
style="object-fit:cover;">

<?php } ?>

</td>

<td>

<?php echo htmlspecialchars($row['product_name']); ?>

</td>

<td>

₹<?php echo number_format($row['price'],2); ?>

</td>

<td>

<?php echo $row['quantity']; ?>

</td>

<td>

₹<?php echo number_format($row['price']*$row['quantity'],2); ?>

</td>

</tr>

<?php } ?>

</table>

<div class="text-end">

<h3>

Grand Total :

₹<?php echo number_format($order['total'],2); ?>

</h3>

</div>

<a
href="my_orders.php"
class="btn btn-secondary">

Back

</a>

<a
href="../products/products.php"
class="btn btn-primary">

Continue Shopping

</a>

</div>

</div>

</div>

<?php include("../includes/footer.php"); ?>

</body>

</html>