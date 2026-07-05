<?php
session_start();
include("../includes/db.php");

// User must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: ../products/products.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = (int)$_GET['id'];

// Check product exists
$product = mysqli_query($conn, "SELECT * FROM products WHERE id='$product_id'");

if (mysqli_num_rows($product) == 0) {
    header("Location: ../products/products.php");
    exit();
}

// Check if already in cart
$check = mysqli_query(
    $conn,
    "SELECT * FROM cart
     WHERE user_id='$user_id'
     AND product_id='$product_id'"
);

if (mysqli_num_rows($check) > 0) {

    mysqli_query(
        $conn,
        "UPDATE cart
         SET quantity = quantity + 1
         WHERE user_id='$user_id'
         AND product_id='$product_id'"
    );

} else {

    mysqli_query(
        $conn,
        "INSERT INTO cart(user_id, product_id, quantity)
         VALUES('$user_id','$product_id',1)"
    );
}

header("Location: cart.php");
exit();
?>