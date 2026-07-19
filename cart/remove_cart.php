<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: cart.php");
    exit();
}

$cart_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

// Delete only the logged-in user's cart item
mysqli_query($conn, "
DELETE FROM cart
WHERE id='$cart_id'
AND user_id='$user_id'
");

header("Location: cart.php");
exit();
