<?php
session_start();
include("../includes/db.php");

// Allow only admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: ../user/login.php");
    exit();
}

$message = "";

// Check Category ID
if (!isset($_GET['id'])) {
    header("Location: categories.php");
    exit();
}

$id = (int)$_GET['id'];

// Fetch Category
$result = mysqli_query($conn, "SELECT * FROM categories WHERE id='$id'");

if (mysqli_num_rows($result) == 0) {
    header("Location: categories.php");
    exit();
}

$category = mysqli_fetch_assoc($result);

// Update Category
if (isset($_POST['update_category'])) {

    $category_name = trim(mysqli_real_escape_string($conn, $_POST['category_name']));

    if ($category_name == "") {

        $message = "<div class='alert alert-danger'>Category name cannot be empty.</div>";

    } else {

        // Check duplicate category
        $check = mysqli_query($conn,
        "SELECT * FROM categories
        WHERE category_name='$category_name'
        AND id!='$id'");

        if(mysqli_num_rows($check)>0){

            $message = "<div class='alert alert-danger'>
            Category already exists.
            </div>";

        }else{

            mysqli_query($conn,
            "UPDATE categories
            SET category_name='$category_name'
            WHERE id='$id'");

            header("Location: categories.php?updated=1");
            exit();
        }

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Edit Category</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-6">

<div class="card shadow">

<div class="card-header bg-warning">

<h3 class="mb-0">
Edit Category
</h3>

</div>

<div class="card-body">

<?php echo $message; ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">
Category Name
</label>

<input
type="text"
name="category_name"
class="form-control"
value="<?php echo htmlspecialchars($category['category_name']); ?>"
required>

</div>

<div class="d-flex justify-content-between">

<button
type="submit"
name="update_category"
class="btn btn-success">

Update Category

</button>

<a
href="categories.php"
class="btn btn-secondary">

Back

</a>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>