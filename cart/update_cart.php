<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

if (!isset($_GET['id']) || !isset($_GET['action'])) {
    header("Location: cart.php");
    exit();
}

$cart_id = (int)$_GET['id'];
$action = $_GET['action'];
$user_id = $_SESSION['user_id'];

// Get cart item with product stock
$result = mysqli_query($conn, "
SELECT cart.quantity, products.stock
FROM cart
INNER JOIN products
ON cart.product_id = products.id
WHERE cart.id='$cart_id'
AND cart.user_id='$user_id'
");

if (mysqli_num_rows($result) == 0) {
    header("Location: cart.php");
    exit();
}

$row = mysqli_fetch_assoc($result);

$quantity = $row['quantity'];
$stock = $row['stock'];

if ($action == "increase") {

    if ($quantity < $stock) {
        mysqli_query($conn, "
        UPDATE cart
        SET quantity = quantity + 1
        WHERE id='$cart_id'
        ");
    }

} elseif ($action == "decrease") {

    if ($quantity > 1) {

        mysqli_query($conn, "
        UPDATE cart
        SET quantity = quantity - 1
        WHERE id='$cart_id'
        ");

    } else {

        mysqli_query($conn, "
        DELETE FROM cart
        WHERE id='$cart_id'
        ");
    }
}

header("Location: cart.php");
exit();
?>
