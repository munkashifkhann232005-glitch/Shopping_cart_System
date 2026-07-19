<?php
include("header.php");

$message = "";

// Check Product ID
if (!isset($_GET['id'])) {
    header("Location: manage_products.php");
    exit();
}

$id = (int)$_GET['id'];

// Fetch Product
$productQuery = mysqli_query($conn, "SELECT * FROM products WHERE id='$id'");

if (mysqli_num_rows($productQuery) == 0) {
    header("Location: manage_products.php");
    exit();
}

$product = mysqli_fetch_assoc($productQuery);

// Update Product
if (isset($_POST['update_product'])) {

    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category_id = (int)$_POST['category_id'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $image = $product['image'];

    // Upload New Image
    if (!empty($_FILES['image']['name'])) {

        $allowed = ['jpg','jpeg','png','webp'];

        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (in_array($extension, $allowed)) {

            $newImage = time() . "_" . basename($_FILES['image']['name']);

            $target = "../assets/images/" . $newImage;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {

                // Delete old image
                if (!empty($image) && file_exists("../assets/images/" . $image)) {
                    unlink("../assets/images/" . $image);
                }

                $image = $newImage;
            }
        }
    }

    mysqli_query($conn,"
        UPDATE products SET
        category_id='$category_id',
        product_name='$product_name',
        description='$description',
        price='$price',
        stock='$stock',
        image='$image'
        WHERE id='$id'
    ");

    header("Location: manage_products.php?updated=1");
    exit();
}
?>

<h2 class="mb-4">Edit Product</h2>

<div class="card shadow">

<div class="card-body">

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">

<label class="form-label">Product Name</label>

<input
type="text"
name="product_name"
class="form-control"
value="<?php echo htmlspecialchars($product['product_name']); ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">Category</label>

<select
name="category_id"
class="form-select"
required>

<?php

$categories = mysqli_query($conn,"SELECT * FROM categories ORDER BY category_name");

while($cat = mysqli_fetch_assoc($categories)){

?>

<option
value="<?php echo $cat['id']; ?>"
<?php if($cat['id']==$product['category_id']) echo "selected"; ?>>

<?php echo htmlspecialchars($cat['category_name']); ?>

</option>

<?php } ?>

</select>

</div>

<div class="mb-3">

<label class="form-label">Description</label>

<textarea
name="description"
rows="5"
class="form-control"
required><?php echo htmlspecialchars($product['description']); ?></textarea>

</div>

<div class="row">

<div class="col-md-6">

<label class="form-label">Price</label>

<input
type="number"
step="0.01"
name="price"
class="form-control"
value="<?php echo $product['price']; ?>"
required>

</div>

<div class="col-md-6">

<label class="form-label">Stock</label>

<input
type="number"
name="stock"
class="form-control"
value="<?php echo $product['stock']; ?>"
required>

</div>

</div>

<br>

<div class="mb-3">

<label class="form-label">Current Image</label>

<br>

<?php
if(!empty($product['image']) && file_exists("../assets/images/".$product['image'])){
?>

<img
src="../assets/images/<?php echo $product['image']; ?>"
width="150"
class="img-thumbnail">

<?php
}else{
?>

<p class="text-danger">No Image Found</p>

<?php
}
?>

</div>

<div class="mb-3">

<label class="form-label">Change Image (Optional)</label>

<input
type="file"
name="image"
class="form-control"
accept=".jpg,.jpeg,.png,.webp">

</div>

<div class="d-flex gap-2">

<button
type="submit"
name="update_product"
class="btn btn-success">

Update Product

</button>

<a
href="manage_products.php"
class="btn btn-secondary">

Cancel

</a>

</div>

</form>

</div>

</div>

<?php include("footer.php"); ?>
