<?php
include("../includes/db.php");

$message = "";

if (isset($_POST['register'])) {

    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($check) > 0) {

        $message = "<div class='alert alert-danger'>Email already exists!</div>";
    } else {
        mysqli_query($conn, "INSERT INTO users(fullname,email,phone,password,role)
        VALUES('$fullname','$email','$phone','$password','user')");

        $message = "<div class='alert alert-success'>Registration Successful!</div>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>User Registration</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card mt-5 shadow">

                    <div class="card-header bg-primary text-white">

                        <h3>Create Account</h3>

                    </div>

                    <div class="card-body">

                        <?php echo $message; ?>

                        <form method="POST">

                            <div class="mb-3">

                                <label>Full Name</label>

                                <input
                                    type="text"
                                    name="fullname"
                                    class="form-control"
                                    required>

                            </div>

                            <div class="mb-3">

                                <label>Email</label>

                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    required>

                            </div>

                            <div class="mb-3">

                                <label>Phone</label>

                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control"
                                    required>

                            </div>

                            <div class="mb-3">

                                <label>Password</label>

                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    required>

                            </div>

                            <button
                                class="btn btn-primary w-100"
                                name="register">

                                Register

                            </button>

                        </form>

                        <br>

                        <a href="../index.php">← Back to Home</a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>