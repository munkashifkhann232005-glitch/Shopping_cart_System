<?php
include("header.php");

if(isset($_GET['deleted'])){
    echo "<div class='alert alert-success'>
            Product deleted successfully.
          </div>";
}

if(isset($_GET['updated'])){
    echo "<div class='alert alert-success'>
            Product updated successfully.
          </div>";
}

// Fetch all products with category names
$query = mysqli_query($conn, "
    SELECT products.*, categories.category_name
    FROM products
    INNER JOIN categories
    ON products.category_id = categories.id
    ORDER BY products.id DESC
");
?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>Manage Products</h2>

    <a href="add_product.php" class="btn btn-primary">
        + Add Product
    </a>

</div>

<div class="card shadow">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th>ID</th>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Created</th>
                        <th width="180">Action</th>

                    </tr>

                </thead>

                <tbody>

                <?php while($row = mysqli_fetch_assoc($query)){ ?>

                    <tr>

                        <td><?php echo $row['id']; ?></td>

                        <td>

                            <img
                                src="../assets/images/<?php echo $row['image']; ?>"
                                width="70"
                                height="70"
                                style="object-fit:cover;border-radius:8px;">

                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['product_name']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($row['category_name']); ?>
                        </td>

                        <td>
                            ₹<?php echo number_format($row['price'],2); ?>
                        </td>

                        <td>

                            <?php

                            if($row['stock']>10){

                                echo "<span class='badge bg-success'>{$row['stock']}</span>";

                            }elseif($row['stock']>0){

                                echo "<span class='badge bg-warning text-dark'>{$row['stock']}</span>";

                            }else{

                                echo "<span class='badge bg-danger'>Out of Stock</span>";

                            }

                            ?>

                        </td>

                        <td>

                            <?php

                            echo date(
                                "d M Y",
                                strtotime($row['created_at'])
                            );

                            ?>

                        </td>

                        <td>

                            <a
                                href="edit_product.php?id=<?php echo $row['id']; ?>"
                                class="btn btn-warning btn-sm">

                                Edit

                            </a>

                            <a
                                href="delete_product.php?id=<?php echo $row['id']; ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this product?')">

                                Delete

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
