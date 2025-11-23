<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get order ID from URL
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

if ($order_id > 0) {
    // Fetch order details
    $stmt = $conn->prepare("SELECT o.*, u.fullname, u.email FROM orders o JOIN users u ON o.user_id = u.id WHERE o.id = ? AND o.user_id = ?");
    $stmt->bind_param("ii", $order_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $order = $result->fetch_assoc();
    } else {
        // Order not found or doesn't belong to user
        header("Location: orders.php");
        exit();
    }
    $stmt->close();
    
    // Fetch order items
    $stmt = $conn->prepare("SELECT oi.*, p.name, p.image FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order_items = $stmt->get_result();
    $stmt->close();
} else {
    // Invalid order ID
    header("Location: orders.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Sugar Studio</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <!-- Font Awesome for WhatsApp icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <header class="main-header">
        <a href="index.php" class="logo">Sugar Studio</a>
        <nav class="main-nav">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="products.php">Gallery</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="orders.php" class="active">My Orders</a></li>
                <li><a href="about.php">About</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['role'] == 'admin'): ?>
                        <li><a href="admin.php">Admin Panel</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <div class="content-section" id="order-details">
            <div class="order-details-header">
                <div>
                    <h1>Order Details</h1>
                    <p class="order-id">Order #<?php echo $order['id']; ?> &bull; Placed on <?php echo date('F j, Y', strtotime($order['created_at'])); ?></p>
                </div>
                <span class="status-badge status-<?php echo $order['status']; ?>"><?php echo ucfirst(str_replace('_', ' ', $order['status'])); ?></span>
            </div>
            
            <div class="order-details-container">
                <!-- Order Summary Card -->
                <div class="order-summary-card">
                    <h2>Order Summary</h2>
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
                
                <!-- Customer Information Card -->
                <div class="customer-info-card">
                    <h2>Customer Information</h2>
                    <div class="info-item">
                        <span>Name</span>
                        <span><?php echo htmlspecialchars($order['fullname']); ?></span>
                    </div>
                    <div class="info-item">
                        <span>Email</span>
                        <span><?php echo htmlspecialchars($order['email']); ?></span>
                    </div>
                </div>
                
                <!-- Order Items Card -->
                <div class="order-items-card">
                    <h2>Items in this Order</h2>
                    <div class="items-container">
                        <?php while ($item = $order_items->fetch_assoc()): ?>
                            <div class="order-item-row">
                                <div class="item-image">
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                </div>
                                <div class="item-details">
                                    <h3><?php echo htmlspecialchars($item['name']); ?></h3>
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
                    <h2>Order Status Timeline</h2>
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
            
            <div class="order-actions">
                <a href="orders.php" class="cta-button">← Back to Orders</a>
                <a href="#" class="cta-button secondary">Need Help?</a>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
    
    <!-- WhatsApp Chat Icon -->
    <a href="https://wa.me/919876543210" class="whatsapp-chat" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

</body>
</html>