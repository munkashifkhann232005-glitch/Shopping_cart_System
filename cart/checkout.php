<?php
session_start();
include("../includes/db.php");

// Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items
$query = mysqli_query($conn, "
SELECT
cart.*,
products.price,
products.stock
FROM cart
INNER JOIN products
ON cart.product_id = products.id
WHERE cart.user_id = '$user_id'
");

if (mysqli_num_rows($query) == 0) {
    header("Location: cart.php");
    exit();
}

$total = 0;

// Calculate total
while ($row = mysqli_fetch_assoc($query)) {

    // Prevent checkout if stock is insufficient
    if ($row['quantity'] > $row['stock']) {

        die("
        <h2 style='color:red;text-align:center;margin-top:50px;'>
        Product stock is insufficient for one or more items.
        </h2>
        ");
    }

    $total += $row['price'] * $row['quantity'];
}

// Create Order
mysqli_query($conn, "
INSERT INTO orders(user_id,total,status)
VALUES('$user_id','$total','Pending')
");

$order_id = mysqli_insert_id($conn);

// Fetch cart again
$query = mysqli_query($conn, "
SELECT
cart.*,
products.price,
products.stock
FROM cart
INNER JOIN products
ON cart.product_id = products.id
WHERE cart.user_id='$user_id'
");

while ($row = mysqli_fetch_assoc($query)) {

    $product_id = $row['product_id'];
    $quantity   = $row['quantity'];
    $price      = $row['price'];

    // Save order item
    mysqli_query($conn,"
    INSERT INTO order_items(order_id,product_id,quantity,price)
    VALUES('$order_id','$product_id','$quantity','$price')
    ");

    // Reduce stock
    mysqli_query($conn,"
    UPDATE products
    SET stock = stock - $quantity
    WHERE id='$product_id'
    ");
}

// Empty Cart
mysqli_query($conn,"
DELETE FROM cart
WHERE user_id='$user_id'
");

// Redirect
header("Location: order_success.php?order_id=".$order_id);
exit();
?>
