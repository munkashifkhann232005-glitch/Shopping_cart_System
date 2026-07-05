<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn, "
SELECT
cart.id AS cart_id,
cart.quantity,
products.*
FROM cart
INNER JOIN products
ON cart.product_id = products.id
WHERE cart.user_id='$user_id'
");

$total = 0;
?>

<!DOCTYPE html>
<html>

<head>

    <title>My Cart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

    <?php include("../includes/header.php"); ?>

    <div class="container py-5">

        <h2 class="mb-4">
            <i class="fa-solid fa-cart-shopping"></i>
            My Shopping Cart
        </h2>

        <?php

        if (mysqli_num_rows($query) > 0) {

        ?>

            <div class="table-responsive">

                <table class="table table-bordered align-middle">

                    <thead class="table-dark">

                        <tr>

                            <th>Image</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php

                        while ($row = mysqli_fetch_assoc($query)) {

                            $subtotal = $row['price'] * $row['quantity'];

                            $total += $subtotal;

                        ?>

                            <tr>

                                <td width="120">

                                    <img
                                        src="../assets/images/<?php echo $row['image']; ?>"
                                        width="90"
                                        height="90"
                                        style="object-fit:cover;">

                                </td>

                                <td>

                                    <h5>

                                        <?php echo htmlspecialchars($row['product_name']); ?>

                                    </h5>

                                </td>

                                <td>

                                    ₹<?php echo number_format($row['price'], 2); ?>

                                </td>
                                <td>

                                    <div class="d-flex align-items-center">

                                        <a
                                            href="update_cart.php?id=<?php echo $row['cart_id']; ?>&action=decrease"
                                            class="btn btn-outline-danger btn-sm">

                                            <i class="fa fa-minus"></i>

                                        </a>

                                        <span class="mx-3 fw-bold">

                                            <?php echo $row['quantity']; ?>

                                        </span>

                                        <a
                                            href="update_cart.php?id=<?php echo $row['cart_id']; ?>&action=increase"
                                            class="btn btn-outline-success btn-sm">

                                            <i class="fa fa-plus"></i>

                                        </a>

                                    </div>

                                </td>

                                <td>

                                    ₹<?php echo number_format($subtotal, 2); ?>

                                </td>

                                <td>

                                    <a
                                        href="remove_cart.php?id=<?php echo $row['cart_id']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Remove this product?')">

                                        <i class="fa-solid fa-trash"></i>

                                        Remove

                                    </a>

                                </td>

                            </tr>

                        <?php

                        }

                        ?>

                    </tbody>

                </table>

            </div>

            <div class="row justify-content-end">

                <div class="col-md-4">

                    <div class="card shadow">

                        <div class="card-body">

                            <h4>

                                Grand Total

                            </h4>

                            <hr>

                            <h2 class="text-success">

                                ₹<?php echo number_format($total, 2); ?>

                            </h2>

                            <a
                                href="../products/products.php"
                                class="btn btn-outline-primary w-100 mt-3">

                                Continue Shopping

                            </a>
                            
                            <a href="checkout.php" class="btn btn-success">
                                Proceed to Checkout
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        <?php

        } else {

        ?>

            <div class="alert alert-warning text-center">

                <h4>Your Cart is Empty</h4>

                <p>Add some amazing products.</p>

                <a
                    href="../products/products.php"
                    class="btn btn-primary">

                    Shop Now

                </a>

            </div>

        <?php

        }

        ?>

    </div>

    <?php include("../includes/footer.php"); ?>

</body>

</html>