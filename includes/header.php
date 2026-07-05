<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">

    <div class="container">

        <a class="navbar-brand fw-bold" href="/shopping_cart/index.php">
            SHOPCART
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="/shopping_cart/index.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/shopping_cart/products/products.php">Products</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/shopping_cart/cart/cart.php">Cart</a>
                </li>

                <?php if (isset($_SESSION['user_id'])) { ?>

                    <li class="nav-item">
                        <span class="nav-link">
                            Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="/shopping_cart/user/my_orders.php">
                            My Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="/shopping_cart/user/logout.php">
                            Logout
                        </a>
                    </li>

                <?php } else { ?>

                    <li class="nav-item">
                        <a class="nav-link" href="/shopping_cart/user/login.php">
                            Login
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/shopping_cart/user/register.php">
                            Register
                        </a>
                    </li>

                <?php } ?>

            </ul>

        </div>

    </div>

</nav>