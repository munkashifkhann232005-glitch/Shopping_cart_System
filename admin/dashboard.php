<?php
include("header.php");

// Dashboard Counts
$totalProducts = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM products"));
$totalCategories = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM categories"));
$totalUsers = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role='user'"));
$totalOrders = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders"));
?>

<h2 class="mb-4">
    Welcome,
    <?php echo htmlspecialchars($_SESSION['fullname']); ?>
</h2>

<div class="row">

    <div class="col-md-3 mb-4">

        <div class="card bg-primary text-white shadow">

            <div class="card-body text-center">

                <h5>Total Products</h5>

                <h2><?php echo $totalProducts; ?></h2>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-4">

        <div class="card bg-success text-white shadow">

            <div class="card-body text-center">

                <h5>Total Categories</h5>

                <h2><?php echo $totalCategories; ?></h2>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-4">

        <div class="card bg-warning text-dark shadow">

            <div class="card-body text-center">

                <h5>Total Users</h5>

                <h2><?php echo $totalUsers; ?></h2>

            </div>

        </div>

    </div>

    <div class="col-md-3 mb-4">

        <div class="card bg-danger text-white shadow">

            <div class="card-body text-center">

                <h5>Total Orders</h5>

                <h2><?php echo $totalOrders; ?></h2>

            </div>

        </div>

    </div>

</div>

<div class="card shadow">

    <div class="card-body">

        <h4>Welcome to SHOPCART Admin Panel</h4>

        <p>
            Use the sidebar to manage products, categories, users, and orders.
        </p>

    </div>

</div>

<?php include("footer.php"); ?>