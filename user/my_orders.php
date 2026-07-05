<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn, "
SELECT *
FROM orders
WHERE user_id='$user_id'
ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>My Orders</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<?php include("../includes/header.php"); ?>

<div class="container py-5">

<h2 class="mb-4">

<i class="fa-solid fa-box"></i>

My Orders

</h2>

<?php if(mysqli_num_rows($query)>0){ ?>

<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead class="table-dark">

<tr>

<th>Order ID</th>
<th>Date</th>
<th>Total</th>
<th>Status</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($query)){ ?>

<tr>

<td>

#<?php echo $row['id']; ?>

</td>

<td>

<?php echo date("d M Y",strtotime($row['order_date'])); ?>

</td>

<td>

₹<?php echo number_format($row['total'],2); ?>

</td>

<td>

<?php

$status=$row['status'];

if($status=="Pending"){

echo "<span class='badge bg-warning text-dark'>$status</span>";

}elseif($status=="Processing"){

echo "<span class='badge bg-primary'>$status</span>";

}elseif($status=="Shipped"){

echo "<span class='badge bg-info'>$status</span>";

}elseif($status=="Delivered"){

echo "<span class='badge bg-success'>$status</span>";

}else{

echo "<span class='badge bg-danger'>$status</span>";

}

?>

</td>

<td>

<a
href="order_details.php?id=<?php echo $row['id']; ?>"
class="btn btn-primary btn-sm">

View Details

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<?php } else { ?>

<div class="alert alert-info text-center">

<h4>No Orders Yet</h4>

<p>Looks like you haven't placed any orders.</p>

<a href="../products/products.php"
class="btn btn-primary">

Start Shopping

</a>

</div>

<?php } ?>

</div>

<?php include("../includes/footer.php"); ?>

</body>

</html>