<?php
include("../includes/db.php");
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: ../user/login.php");
    exit();
}

$order_id = (int)$_POST['order_id'];
$status = mysqli_real_escape_string($conn, $_POST['status']);

mysqli_query($conn,"
UPDATE orders
SET status='$status'
WHERE id='$order_id'
");

header("Location: view_order.php?id=".$order_id);
exit();
?>