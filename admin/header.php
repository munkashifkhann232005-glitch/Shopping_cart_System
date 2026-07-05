<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

include("../includes/db.php");

// Admin Authentication
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin"){
    header("Location: ../user/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Panel</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body class="bg-light">

<div class="d-flex">

<?php include("sidebar.php"); ?>

<div class="container-fluid p-4">