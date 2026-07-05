<?php
session_start();
include("../includes/db.php");

$message = "";

if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = mysqli_query(
        $conn,
        "SELECT * FROM users WHERE email='$email' AND password='$password'"
    );

    if (mysqli_num_rows($query) > 0) {

        $user = mysqli_fetch_assoc($query);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == "admin") {
            header("Location: /shopping_cart/admin/dashboard.php");
        } else {
            header("Location: /shopping_cart/index.php");
        }

        exit();

        header("Location: ../index.php");
        exit();
    } else {
        $message = "<div class='alert alert-danger'>Invalid Email or Password</div>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>User Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-5">

                <div class="card mt-5 shadow">

                    <div class="card-header bg-primary text-white">

                        <h3>Login</h3>

                    </div>

                    <div class="card-body">

                        <?php echo $message; ?>

                        <form method="POST">

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <button class="btn btn-primary w-100" name="login">
                                Login
                            </button>

                        </form>

                        <br>

                        <a href="register.php">Create New Account</a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>