<?php
include("header.php");

// Check Order ID
if (!isset($_GET['id'])) {
    header("Location: manage_orders.php");
    exit();
}

$order_id = (int)$_GET['id'];

// Fetch Order + Customer
$orderQuery = mysqli_query($conn, "
SELECT
orders.*,
users.fullname,
users.email
FROM orders
INNER JOIN users
ON orders.user_id = users.id
WHERE orders.id='$order_id'
");

if (mysqli_num_rows($orderQuery) == 0) {
    header("Location: manage_orders.php");
    exit();
}

$order = mysqli_fetch_assoc($orderQuery);

// Fetch Products
$itemQuery = mysqli_query($conn, "
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

<div class="container-fluid">

<div class="row">

<div class="col-md-8">

<div class="card shadow mb-4">

<div class="card-header bg-primary text-white">

<h4>
Order #<?php echo $order['id']; ?>
</h4>

</div>

<div class="card-body">

<p>

<strong>Customer :</strong>

<?php echo htmlspecialchars($order['fullname']); ?>

</p>

<p>

<strong>Email :</strong>

<?php echo htmlspecialchars($order['email']); ?>

</p>

<p>

<strong>Order Date :</strong>

<?php echo date("d M Y", strtotime($order['order_date'])); ?>

</p>

<p>

<strong>Status :</strong>

<?php echo $order['status']; ?>

</p>

<hr>

<table class="table table-bordered align-middle">

<thead class="table-dark">

<tr>

<th>Image</th>
<th>Product</th>
<th>Price</th>
<th>Qty</th>
<th>Subtotal</th>

</tr>

</thead>

<tbody>

<?php while($item=mysqli_fetch_assoc($itemQuery)){ ?>

<tr>

<td width="100">

<img
src="../assets/images/<?php echo $item['image']; ?>"
width="70"
height="70"
style="object-fit:cover;">

</td>

<td>

<?php echo htmlspecialchars($item['product_name']); ?>

</td>

<td>

₹<?php echo number_format($item['price'],2); ?>

</td>

<td>

<?php echo $item['quantity']; ?>

</td>

<td>

₹<?php echo number_format($item['price']*$item['quantity'],2); ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

<h3 class="text-end">

Grand Total :
₹<?php echo number_format($order['total'],2); ?>

</h3>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h4>

Update Status

</h4>

</div>

<div class="card-body">

<form action="update_order.php" method="POST">

<input
type="hidden"
name="order_id"
value="<?php echo $order['id']; ?>">

<select
name="status"
class="form-select mb-3">

<option
<?php if($order['status']=="Pending") echo "selected"; ?>>

Pending

</option>

<option
<?php if($order['status']=="Processing") echo "selected"; ?>>

Processing

</option>

<option
<?php if($order['status']=="Shipped") echo "selected"; ?>>

Shipped

</option>

<option
<?php if($order['status']=="Delivered") echo "selected"; ?>>

Delivered

</option>

<option
<?php if($order['status']=="Cancelled") echo "selected"; ?>>

Cancelled

</option>

</select>

<button
class="btn btn-success w-100">

Update Order

</button>

</form>

</div>

</div>

</div>

</div>

</div>

<?php include("footer.php"); ?>