<?php
session_start();
require_once 'config.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Get order ID from URL
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($order_id > 0) {
    // Handle status update
    if (isset($_POST['update_status'])) {
        $new_status = $_POST['status'];
        
        // Update order status
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $order_id);
        
        if ($stmt->execute()) {
            $success = "Order status updated successfully.";
        } else {
            $error = "Error updating order status.";
        }
        $stmt->close();
        
        // Refresh order data after update
        $stmt = $conn->prepare("SELECT o.*, u.fullname, u.email FROM orders o JOIN users u ON o.user_id = u.id WHERE o.id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $order = $result->fetch_assoc();
        }
        $stmt->close();
    } else {
        // Fetch order details
        $stmt = $conn->prepare("SELECT o.*, u.fullname, u.email FROM orders o JOIN users u ON o.user_id = u.id WHERE o.id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $order = $result->fetch_assoc();
        } else {
            // Order not found
            header("Location: admin_orders.php");
            exit();
        }
        $stmt->close();
    }
    
    // Fetch order items
    $stmt = $conn->prepare("SELECT oi.*, p.name, p.image FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order_items = $stmt->get_result();
    $stmt->close();
} else {
    // Invalid order ID
    header("Location: admin_orders.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Sugar Studio</title>
    <link rel="stylesheet" href="admin-style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>
<body>

    <header class="main-header">
        <a href="index.php" class="logo">Sugar Studio</a>
        <nav class="main-nav">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="products.php">Gallery</a></li>
                <li><a href="admin.php">Admin Panel</a></li>
                <li><a href="admin_orders.php" class="active">Orders</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="admin-container">
            <div class="admin-header">
                <h1>Order Details</h1>
                <a href="admin_orders.php" class="cta-button secondary">Back to Orders</a>
            </div>
            
            <?php if (isset($success)): ?>
                <div class="success-message"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="order-details-container">
                <!-- Order Header -->
                <div class="order-header-card">
                    <div>
                        <h2>Order #<?php echo $order['id']; ?></h2>
                        <p class="order-date">Placed on <?php echo date('F j, Y g:i A', strtotime($order['created_at'])); ?></p>
                    </div>
                    <span class="status-badge status-<?php echo $order['status']; ?>"><?php echo ucfirst(str_replace('_', ' ', $order['status'])); ?></span>
                </div>
                
                <div class="order-details-grid">
                    <!-- Order Summary -->
                    <div class="order-summary-card">
                        <h3>Order Summary</h3>
                        <div class="summary-item">
                            <span>Status</span>
                            <span class="status-<?php echo $order['status']; ?>"><?php echo ucfirst(str_replace('_', ' ', $order['status'])); ?></span>
                        </div>
                        <div class="summary-item">
                            <span>Order Date</span>
                            <span><?php echo date('F j, Y g:i A', strtotime($order['created_at'])); ?></span>
                        </div>
                        <div class="summary-item">
                            <span>Last Updated</span>
                            <span><?php echo date('F j, Y g:i A', strtotime($order['updated_at'])); ?></span>
                        </div>
                        <div class="summary-item total">
                            <span>Total Amount</span>
                            <span class="price">₹<?php echo number_format($order['total_amount']); ?></span>
                        </div>
                    </div>
                    
                    <!-- Customer Information -->
                    <div class="customer-info-card">
                        <h3>Customer Information</h3>
                        <div class="info-item">
                            <span>Name</span>
                            <span><?php echo htmlspecialchars($order['fullname']); ?></span>
                        </div>
                        <div class="info-item">
                            <span>Email</span>
                            <span><?php echo htmlspecialchars($order['email']); ?></span>
                        </div>
                    </div>
                    
                    <!-- Update Status Form -->
                    <div class="update-status-card">
                        <h3>Update Order Status</h3>
                        <form action="admin_order_details.php?order_id=<?php echo $order_id; ?>" method="POST">
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select id="status" name="status" class="status-select">
                                    <option value="pending" <?php echo ($order['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                    <option value="confirmed" <?php echo ($order['status'] == 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                                    <option value="baking" <?php echo ($order['status'] == 'baking') ? 'selected' : ''; ?>>Baking</option>
                                    <option value="baked" <?php echo ($order['status'] == 'baked') ? 'selected' : ''; ?>>Baked</option>
                                    <option value="delivery_pending" <?php echo ($order['status'] == 'delivery_pending') ? 'selected' : ''; ?>>Delivery Pending</option>
                                    <option value="out_for_delivery" <?php echo ($order['status'] == 'out_for_delivery') ? 'selected' : ''; ?>>Out for Delivery</option>
                                    <option value="delivered" <?php echo ($order['status'] == 'delivered') ? 'selected' : ''; ?>>Delivered</option>
                                    <option value="cancelled" <?php echo ($order['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                            </div>
                            <button type="submit" name="update_status" class="cta-button full-width">Update Status</button>
                        </form>
                    </div>
                </div>
                
                <!-- Order Items -->
                <div class="order-items-card">
                    <h3>Items in this Order</h3>
                    <div class="items-container">
                        <?php while ($item = $order_items->fetch_assoc()): ?>
                            <div class="order-item-row">
                                <div class="item-image">
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                </div>
                                <div class="item-details">
                                    <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                                    <p>Quantity: <?php echo $item['quantity']; ?></p>
                                </div>
                                <div class="item-price">
                                    <span>₹<?php echo number_format($item['price']); ?> × <?php echo $item['quantity']; ?></span>
                                    <span class="total-price">₹<?php echo number_format($item['price'] * $item['quantity']); ?></span>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                
                <!-- Order Status Timeline -->
                <div class="status-timeline-card">
                    <h3>Order Status Timeline</h3>
                    <div class="status-timeline">
                        <div class="status-step <?php echo ($order['status'] == 'pending' || $order['status'] == 'confirmed' || $order['status'] == 'baking' || $order['status'] == 'baked' || $order['status'] == 'delivery_pending' || $order['status'] == 'out_for_delivery' || $order['status'] == 'delivered') ? 'completed' : ''; ?>">
                            <div class="status-icon">1</div>
                            <div class="status-content">
                                <div class="status-label">Pending</div>
                                <div class="status-date"><?php echo ($order['status'] == 'pending' || $order['status'] == 'confirmed' || $order['status'] == 'baking' || $order['status'] == 'baked' || $order['status'] == 'delivery_pending' || $order['status'] == 'out_for_delivery' || $order['status'] == 'delivered') ? date('M j, Y', strtotime($order['created_at'])) : ''; ?></div>
                            </div>
                        </div>
                        <div class="status-step <?php echo ($order['status'] == 'confirmed' || $order['status'] == 'baking' || $order['status'] == 'baked' || $order['status'] == 'delivery_pending' || $order['status'] == 'out_for_delivery' || $order['status'] == 'delivered') ? 'completed' : ''; ?>">
                            <div class="status-icon">2</div>
                            <div class="status-content">
                                <div class="status-label">Confirmed</div>
                                <div class="status-date"></div>
                            </div>
                        </div>
                        <div class="status-step <?php echo ($order['status'] == 'baking' || $order['status'] == 'baked' || $order['status'] == 'delivery_pending' || $order['status'] == 'out_for_delivery' || $order['status'] == 'delivered') ? 'completed' : ''; ?>">
                            <div class="status-icon">3</div>
                            <div class="status-content">
                                <div class="status-label">Baking</div>
                                <div class="status-date"></div>
                            </div>
                        </div>
                        <div class="status-step <?php echo ($order['status'] == 'baked' || $order['status'] == 'delivery_pending' || $order['status'] == 'out_for_delivery' || $order['status'] == 'delivered') ? 'completed' : ''; ?>">
                            <div class="status-icon">4</div>
                            <div class="status-content">
                                <div class="status-label">Baked</div>
                                <div class="status-date"></div>
                            </div>
                        </div>
                        <div class="status-step <?php echo ($order['status'] == 'delivery_pending' || $order['status'] == 'out_for_delivery' || $order['status'] == 'delivered') ? 'completed' : ''; ?>">
                            <div class="status-icon">5</div>
                            <div class="status-content">
                                <div class="status-label">Delivery Pending</div>
                                <div class="status-date"></div>
                            </div>
                        </div>
                        <div class="status-step <?php echo ($order['status'] == 'out_for_delivery' || $order['status'] == 'delivered') ? 'completed' : ''; ?>">
                            <div class="status-icon">6</div>
                            <div class="status-content">
                                <div class="status-label">Out for Delivery</div>
                                <div class="status-date"></div>
                            </div>
                        </div>
                        <div class="status-step <?php echo ($order['status'] == 'delivered') ? 'completed' : ''; ?>">
                            <div class="status-icon">7</div>
                            <div class="status-content">
                                <div class="status-label">Delivered</div>
                                <div class="status-date"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="main-footer">
        <p>© 2025 Sugar Studio. All Rights Reserved. Kochi, Kerala.</p>
        <div class="social-links">
            <a href="#">Instagram</a>
            <a href="#">Pinterest</a>
        </div>
    </footer>

</body>
</html>