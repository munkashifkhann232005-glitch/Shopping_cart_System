<?php
include("header.php");

// Fetch all orders with customer details
$query = mysqli_query($conn, "
SELECT
orders.*,
users.fullname,
users.email
FROM orders
INNER JOIN users
ON orders.user_id = users.id
ORDER BY orders.id DESC
");
?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>
        <i class="fa-solid fa-box"></i>
        Manage Orders
    </h2>

</div>

<div class="card shadow">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                <?php while($row=mysqli_fetch_assoc($query)){ ?>

                    <tr>

                        <td>

                            #<?php echo $row['id']; ?>

                        </td>

                        <td>

                            <?php echo htmlspecialchars($row['fullname']); ?>

                        </td>

                        <td>

                            <?php echo htmlspecialchars($row['email']); ?>

                        </td>

                        <td>

                            ₹<?php echo number_format($row['total'],2); ?>

                        </td>

                        <td>

                            <?php

                            switch($row['status']){

                                case "Pending":
                                    echo "<span class='badge bg-warning text-dark'>Pending</span>";
                                    break;

                                case "Processing":
                                    echo "<span class='badge bg-primary'>Processing</span>";
                                    break;

                                case "Shipped":
                                    echo "<span class='badge bg-info'>Shipped</span>";
                                    break;

                                case "Delivered":
                                    echo "<span class='badge bg-success'>Delivered</span>";
                                    break;

                                case "Cancelled":
                                    echo "<span class='badge bg-danger'>Cancelled</span>";
                                    break;

                                default:
                                    echo "<span class='badge bg-secondary'>".$row['status']."</span>";
                            }

                            ?>

                        </td>

                        <td>

                            <?php echo date("d M Y",strtotime($row['order_date'])); ?>

                        </td>

                        <td>

                            <a
                            href="view_order.php?id=<?php echo $row['id']; ?>"
                            class="btn btn-primary btn-sm">

                                View

                            </a>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php include("footer.php"); ?>
