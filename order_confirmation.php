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
    <title>Order Confirmation - Sugar Studio</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <!-- Font Awesome for WhatsApp icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <?php include 'header.php'; ?>

    <main>
        <div class="order-confirmation-container">
            <div class="confirmation-header">
                <h1>Order Confirmation</h1>
            </div>
            
            <div class="confirmation-message">
                <h2>Thank You for Your Order!</h2>
                <p>Your order has been placed successfully.</p>
                <p><strong>Order ID: #<?php echo $order['id']; ?></strong></p>
                <p>We'll notify you when your order status changes.</p>
            </div>
            
            <div class="confirmation-details">
                <h3>Order Details</h3>
                <div class="order-info">
                    <div class="order-info-item">
                        <strong>Order Date</strong>
                        <span><?php echo date('F j, Y', strtotime($order['created_at'])); ?></span>
                    </div>
                    <div class="order-info-item">
                        <strong>Status</strong>
                        <span class="status-<?php echo $order['status']; ?>"><?php echo ucfirst(str_replace('_', ' ', $order['status'])); ?></span>
                    </div>
                    <div class="order-info-item">
                        <strong>Total Amount</strong>
                        <span>₹<?php echo number_format($order['total_amount']); ?></span>
                    </div>
                    <div class="order-info-item">
                        <strong>Email</strong>
                        <span><?php echo htmlspecialchars($order['email']); ?></span>
                    </div>
                </div>
                
                <h3>Items in this Order</h3>
                <table class="order-items-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($item = $order_items->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <div class="order-item">
                                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                        <span><?php echo htmlspecialchars($item['name']); ?></span>
                                    </div>
                                </td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td>₹<?php echo number_format($item['price']); ?></td>
                                <td>₹<?php echo number_format($item['price'] * $item['quantity']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="confirmation-actions">
                <a href="orders.php" class="cta-button">View All Orders</a>
                <a href="products.php" class="cta-button secondary">Continue Shopping</a>
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