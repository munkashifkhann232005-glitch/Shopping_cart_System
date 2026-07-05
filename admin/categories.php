<?php
session_start();
include("../includes/db.php");

// Allow only admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: ../user/login.php");
    exit();
}

$message = "";

// Add Category
if (isset($_POST['add_category'])) {

    $category = trim(mysqli_real_escape_string($conn, $_POST['category_name']));

    if (!empty($category)) {

        $check = mysqli_query($conn, "SELECT * FROM categories WHERE category_name='$category'");

        if (mysqli_num_rows($check) > 0) {

            $message = "<div class='alert alert-danger'>Category already exists!</div>";

        } else {

            mysqli_query($conn, "INSERT INTO categories(category_name) VALUES('$category')");

            $message = "<div class='alert alert-success'>Category Added Successfully.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Manage Categories</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-dark text-white">

<h3 class="mb-0">
Manage Categories
</h3>

</div>

<div class="card-body">

<?php
echo $message;

if(isset($_GET['updated'])){
    echo "<div class='alert alert-success'>Category Updated Successfully.</div>";
}

if(isset($_GET['deleted'])){
    echo "<div class='alert alert-danger'>Category Deleted Successfully.</div>";
}
?>

<form method="POST">

<div class="row">

<div class="col-md-9">

<input
type="text"
name="category_name"
class="form-control"
placeholder="Enter Category Name"
required>

</div>

<div class="col-md-3">

<button
type="submit"
name="add_category"
class="btn btn-primary w-100">

Add Category

</button>

</div>

</div>

</form>

<hr>

<h4 class="mb-3">
All Categories
</h4>

<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead class="table-dark">

<tr>

<th width="80">#</th>

<th>Category Name</th>

<th width="220">Action</th>

</tr>

</thead>

<tbody>

<?php

$result = mysqli_query($conn,"SELECT * FROM categories ORDER BY id DESC");

$count = 1;

while($row = mysqli_fetch_assoc($result))
{
?>

<tr>

<td><?php echo $count++; ?></td>

<td><?php echo htmlspecialchars($row['category_name']); ?></td>

<td>

<a
href="edit_category.php?id=<?php echo $row['id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="delete_category.php?id=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Are you sure you want to delete this category?')">

Delete

</a>

</td>

</tr>

<?php
}
?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</body>

</html>