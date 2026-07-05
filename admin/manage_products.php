<?php
include("header.php");

// Admin Authentication
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: ../user/login.php");
    exit();
}

$message = "";

// Check Product ID
if(!isset($_GET['id'])){
    header("Location: products.php");
    exit();
}

$id = (int)$_GET['id'];

// Fetch Product
$product = mysqli_query($conn,"
SELECT * FROM products
WHERE id='$id'
");

if(mysqli_num_rows($product)==0){
    header("Location: products.php");
    exit();
}

$row = mysqli_fetch_assoc($product);


// Update Product
if(isset($_POST['update_product'])){

    $product_name = mysqli_real_escape_string($conn,$_POST['product_name']);
    $category_id = $_POST['category_id'];
    $description = mysqli_real_escape_string($conn,$_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $image = $row['image'];

    // Upload New Image (Optional)

    if($_FILES['image']['name']!=""){

        $newImage = time()."_".$_FILES['image']['name'];

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../assets/images/".$newImage
        );

        // Delete old image

        if(file_exists("../assets/images/".$image)){
            unlink("../assets/images/".$image);
        }

        $image = $newImage;
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

    header("Location: products.php");
    exit();

}
?>

<div class="container-fluid">

<h2 class="mb-4">

Edit Product

</h2>

<div class="card shadow">

<div class="card-body">

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">

<label class="form-label">

Product Name

</label>

<input
type="text"
name="product_name"
class="form-control"
value="<?php echo htmlspecialchars($row['product_name']); ?>"
required>

</div>


<div class="mb-3">

<label>

Category

</label>

<select
name="category_id"
class="form-select"
required>

<?php

$category=mysqli_query($conn,"
SELECT * FROM categories
ORDER BY category_name
");

while($cat=mysqli_fetch_assoc($category))
{

?>

<option
value="<?php echo $cat['id']; ?>"

<?php

if($cat['id']==$row['category_id'])
echo "selected";

?>

>

<?php echo $cat['category_name']; ?>

</option>

<?php
}
?>

</select>

</div>


<div class="mb-3">

<label>

Description

</label>

<textarea
name="description"
class="form-control"
rows="5"><?php echo htmlspecialchars($row['description']); ?></textarea>

</div>


<div class="row">

<div class="col-md-6">

<label>

Price

</label>

<input
type="number"
step="0.01"
name="price"
class="form-control"
value="<?php echo $row['price']; ?>"
required>

</div>

<div class="col-md-6">

<label>

Stock

</label>

<input
type="number"
name="stock"
class="form-control"
value="<?php echo $row['stock']; ?>"
required>

</div>

</div>

<br>

<div class="mb-3">

<label>

Current Image

</label>

<br>

<img
src="../assets/images/<?php echo $row['image']; ?>"
width="150"
class="img-thumbnail">

</div>


<div class="mb-3">

<label>

Change Image (Optional)

</label>

<input
type="file"
name="image"
class="form-control">

</div>

<button
class="btn btn-success"
name="update_product">

Update Product

</button>

<a
href="products.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

<?php include("footer.php"); ?>