<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cart item count for the badge (only when logged in and $conn is available)
$cart_count = 0;
if (isset($_SESSION['user_id']) && isset($conn)) {
    $uid = (int) $_SESSION['user_id'];
    $count_query = mysqli_query($conn, "SELECT SUM(quantity) AS total_qty FROM cart WHERE user_id='$uid'");
    if ($count_query) {
        $count_row = mysqli_fetch_assoc($count_query);
        $cart_count = $count_row['total_qty'] ? (int) $count_row['total_qty'] : 0;
    }
}
?>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm">

    <div class="container">

        <a class="navbar-brand" href="/shopping_cart/index.php">
            <i class="fa-solid fa-bag-shopping"></i>
            SHOP<span class="brand-dot">CART</span>
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link" href="/shopping_cart/index.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/shopping_cart/products/products.php">Products</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link cart-link" href="/shopping_cart/cart/cart.php">
                        <i class="fa-solid fa-cart-shopping"></i>
                        Cart
                        <?php if ($cart_count > 0) { ?>
                            <span class="cart-badge"><?php echo $cart_count; ?></span>
                        <?php } ?>
                    </a>
                </li>

                <?php if (isset($_SESSION['user_id'])) { ?>

                    <li class="nav-item">
                        <a class="nav-link" href="/shopping_cart/user/my_orders.php">
                            <i class="fa-solid fa-receipt"></i>
                            My Orders
                        </a>
                    </li>

                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "admin") { ?>
                        <li class="nav-item">
                            <a class="nav-link text-info" href="/shopping_cart/admin/dashboard.php">
                                <i class="fa-solid fa-gauge"></i>
                                Admin Panel
                            </a>
                        </li>
                    <?php } ?>

                    <li class="nav-item ms-lg-2 my-2 my-lg-0">
                        <span class="nav-link welcome-chip">
                            <i class="fa-regular fa-circle-user"></i>
                            <?php echo htmlspecialchars($_SESSION['fullname']); ?>
                        </span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-danger" href="/shopping_cart/user/logout.php">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Logout
                        </a>
                    </li>

                <?php } else { ?>

                    <li class="nav-item">
                        <a class="nav-link" href="/shopping_cart/user/login.php">
                            Login
                        </a>
                    </li>

                    <li class="nav-item ms-lg-2 my-2 my-lg-0">
                        <a class="btn btn-primary btn-sm" href="/shopping_cart/user/register.php">
                            Sign Up
                        </a>
                    </li>

                <?php } ?>

            </ul>

        </div>

    </div>

</nav>
