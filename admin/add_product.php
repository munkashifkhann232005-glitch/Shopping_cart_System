<?php
include("header.php");

$message = "";

// Add Product
if(isset($_POST['add_product'])){

    $product_name = mysqli_real_escape_string($conn,$_POST['product_name']);
    $category_id = (int)$_POST['category_id'];
    $description = mysqli_real_escape_string($conn,$_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Image Upload
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    if($image!=""){

        $extension = strtolower(pathinfo($image, PATHINFO_EXTENSION));

        $allowed = ['jpg','jpeg','png','webp'];

        if(!in_array($extension,$allowed)){

            $message = "<div class='alert alert-danger'>
                        Only JPG, JPEG, PNG and WEBP images are allowed.
                        </div>";

        }else{

            // Check duplicate product
            $check = mysqli_query($conn,
            "SELECT * FROM products WHERE product_name='$product_name'");

            if(mysqli_num_rows($check)>0){

                $message = "<div class='alert alert-danger'>
                            Product already exists.
                            </div>";

            }else{

                $newImage = time()."_".$image;

                move_uploaded_file(
                    $tmp,
                    "../assets/images/".$newImage
                );

                mysqli_query($conn,
                "INSERT INTO products
                (category_id,product_name,description,price,stock,image)
                VALUES
                ('$category_id',
                '$product_name',
                '$description',
                '$price',
                '$stock',
                '$newImage')");

                $message = "<div class='alert alert-success'>
                            Product Added Successfully.
                            </div>";
            }

        }

    }else{

        $message = "<div class='alert alert-danger'>
                    Please select an image.
                    </div>";

    }

}
?>

<h2 class="mb-4">Add Product</h2>

<?php echo $message; ?>

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
required>

</div>

<div class="mb-3">

<label class="form-label">
Category
</label>

<select
name="category_id"
class="form-select"
required>

<option value="">Select Category</option>

<?php

$cat = mysqli_query($conn,
"SELECT * FROM categories ORDER BY category_name");

while($row=mysqli_fetch_assoc($cat))
{

?>

<option value="<?php echo $row['id']; ?>">

<?php echo $row['category_name']; ?>

</option>

<?php
}
?>

</select>

</div>

<div class="mb-3">

<label class="form-label">
Description
</label>

<textarea
name="description"
class="form-control"
rows="5"
required></textarea>

</div>

<div class="row">

<div class="col-md-6">

<label class="form-label">
Price
</label>

<input
type="number"
step="0.01"
name="price"
class="form-control"
required>

</div>

<div class="col-md-6">

<label class="form-label">
Stock
</label>

<input
type="number"
name="stock"
class="form-control"
required>

</div>

</div>

<br>

<div class="mb-3">

<label class="form-label">
Product Image
</label>

<input
type="file"
name="image"
class="form-control"
accept=".jpg,.jpeg,.png,.webp"
required>

</div>

<button
type="submit"
name="add_product"
class="btn btn-primary">

Add Product

</button>

<a href="products.php"
class="btn btn-secondary">

Manage Products

</a>

</form>

</div>

</div>

<?php include("footer.php"); ?>
