<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Calculate cart item count
$cart_count = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_count += $item['quantity'];
    }
}
?>

<header class="main-header">
    <a href="index.php" class="logo">Sugar Studio</a>
    <div class="header-right">
        <!-- Same navigation for all users -->
        <nav class="main-nav">
            <ul>
                <li><a href="home.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'home.php') ? 'active' : ''; ?>">Home</a></li>
                <li><a href="products.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'products.php') ? 'active' : ''; ?>">Gallery</a></li>
                <li><a href="about.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'active' : ''; ?>">About</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['role'] == 'admin'): ?>
                        <li><a href="admin_dashboard.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php' || basename($_SERVER['PHP_SELF']) == 'admin_products.php' || basename($_SERVER['PHP_SELF']) == 'admin_categories.php' || basename($_SERVER['PHP_SELF']) == 'admin_orders.php' || basename($_SERVER['PHP_SELF']) == 'admin_users.php' || basename($_SERVER['PHP_SELF']) == 'admin_order_details.php') ? 'active' : ''; ?>">Admin Panel</a></li>
                    <?php else: ?>
                        <li><a href="orders.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'orders.php' || basename($_SERVER['PHP_SELF']) == 'order_details.php') ? 'active' : ''; ?>">My Orders</a></li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </nav>
        
        <div class="header-icons">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="cart.php" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <?php if ($cart_count > 0): ?>
                        <span class="cart-count"><?php echo $cart_count; ?></span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="user-greeting">
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?>!</span>
                    <a href="logout.php" class="nav-button">Logout</a>
                </div>
            <?php else: ?>
                <a href="login.php" class="nav-button">Login</a>
            <?php endif; ?>
        </div>
    </div>
</header>