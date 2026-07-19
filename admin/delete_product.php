<?php
session_start();
include("../includes/db.php");

// Admin Authentication
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: ../user/login.php");
    exit();
}

// Check Product ID
if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$id = (int)$_GET['id'];

// Fetch Product
$query = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");

if (mysqli_num_rows($query) == 0) {
    header("Location: products.php");
    exit();
}

$product = mysqli_fetch_assoc($query);

// Delete Product Image
$imagePath = "../assets/images/" . $product['image'];

if (!empty($product['image']) && file_exists($imagePath)) {
    unlink($imagePath);
}

// Delete Product From Database
mysqli_query($conn, "DELETE FROM products WHERE id='$id'");

// Redirect
header("Location: products.php?deleted=1");
exit();
?>
