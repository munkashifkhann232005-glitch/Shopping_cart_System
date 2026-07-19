<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

if (!isset($_GET['order_id'])) {
    header("Location: ../index.php");
    exit();
}

$order_id = (int)$_GET['order_id'];
?>

<!DOCTYPE html>
<html>

<head>

<title>Order Successful</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-md-7">

<div class="card shadow text-center">

<div class="card-body p-5">

<h1 class="text-success">
✅
</h1>

<h2 class="mt-3">
Order Placed Successfully
</h2>

<p class="lead">
Thank you for shopping with us.
</p>

<h4 class="text-primary">
Order ID :
#<?php echo $order_id; ?>
</h4>

<hr>

<a href="../products/products.php"
class="btn btn-primary">

Continue Shopping

</a>

<a href="../user/my_orders.php"
class="btn btn-success">

My Orders

</a>

</div>

</div>

</div>

</div>

</div>

</body>

</html>
