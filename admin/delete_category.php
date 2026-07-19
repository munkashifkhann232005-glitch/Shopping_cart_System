<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: ../user/login.php");
    exit();
}

if(isset($_GET['id'])){

    $id = (int)$_GET['id'];

    mysqli_query($conn,"DELETE FROM categories WHERE id=$id");
}

header("Location: categories.php?deleted=1");
exit();
