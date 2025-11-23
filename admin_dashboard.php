<?php
session_start();
require_once 'config.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch dashboard statistics
$product_count = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];
$category_count = $conn->query("SELECT COUNT(*) as count FROM categories")->fetch_assoc()['count'];
$order_count = $conn->query("SELECT COUNT(*) as count FROM orders")->fetch_assoc()['count'];
$user_count = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];

// Fetch recent orders
$order_sql = "SELECT o.*, u.fullname FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC LIMIT 5";
$order_result = $conn->query($order_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Sugar Studio</title>
    <link rel="stylesheet" href="admin-style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <!-- Font Awesome for WhatsApp icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Admin Header with Navigation -->
    <header class="admin-header">
        <div class="admin-header-content">
            <a href="index.php" class="logo">Sugar Studio</a>
            <div class="admin-nav">
                <nav>
                    <ul>
                        <li><a href="admin_dashboard.php" class="active">Dashboard</a></li>
                        <li><a href="admin_products.php">Manage Products</a></li>
                        <li><a href="admin_categories.php">Manage Categories</a></li>
                        <li><a href="admin_orders.php">Manage Orders</a></li>
                        <li><a href="admin_users.php">Manage Users</a></li>
                    </ul>
                </nav>
            </div>
            <div class="user-info">
                <span class="user-greeting">Welcome, <?php echo htmlspecialchars($_SESSION['fullname']); ?>!</span>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </header>

    <main>
        <div class="admin-container" style="padding-top: 20px;">
            <div class="page-header">
                <h1>Admin Dashboard</h1>
                <p class="intro-text">Welcome to your Sugar Studio administration panel. Manage your products, orders, and users from here.</p>
            </div>
            
            <!-- Dashboard Stats -->
            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-icon">🍰</div>
                    <h3>Total Products</h3>
                    <div class="stat-number"><?php echo $product_count; ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📂</div>
                    <h3>Total Categories</h3>
                    <div class="stat-number"><?php echo $category_count; ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📦</div>
                    <h3>Total Orders</h3>
                    <div class="stat-number"><?php echo $order_count; ?></div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <h3>Total Users</h3>
                    <div class="stat-number"><?php echo $user_count; ?></div>
                </div>
            </div>
            
            <!-- Recent Orders -->
            <div class="admin-section">
                <div class="section-header">
                    <h2>Recent Orders</h2>
                    <p>Latest orders from your customers</p>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($order_result->num_rows > 0): ?>
                            <?php while($order = $order_result->fetch_assoc()): ?>
                                <tr>
                                    <td>#<?php echo $order['id']; ?></td>
                                    <td><?php echo htmlspecialchars($order['fullname']); ?></td>
                                    <td><?php echo date('M j, Y', strtotime($order['created_at'])); ?></td>
                                    <td>₹<?php echo number_format($order['total_amount']); ?></td>
                                    <td>
                                        <span class="status-<?php echo $order['status']; ?>">
                                            <?php echo ucfirst(str_replace('_', ' ', $order['status'])); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="admin_order_details.php?order_id=<?php echo $order['id']; ?>" class="btn-edit">View</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No orders found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="admin-actions">
                    <a href="admin_orders.php" class="cta-button secondary">View All Orders</a>
                </div>
            </div>
        </div>
    </main>
    
    <!-- WhatsApp Chat Icon -->
    <a href="https://wa.me/919778238064" class="whatsapp-chat" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

</body>
</html>