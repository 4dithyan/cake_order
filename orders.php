<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user's orders
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$orders_result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - Sugar Studio</title>
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
        <div class="content-section" id="my-orders">
            <h1>My Orders</h1>
            
            <?php if ($orders_result->num_rows == 0): ?>
                <p>You haven't placed any orders yet. <a href="products.php">Start shopping</a></p>
            <?php else: ?>
                <div class="orders-list">
                    <?php while ($order = $orders_result->fetch_assoc()): ?>
                        <div class="order-card">
                            <div class="order-header">
                                <h3>Order #<?php echo $order['id']; ?></h3>
                                <span class="status-<?php echo $order['status']; ?>"><?php echo ucfirst(str_replace('_', ' ', $order['status'])); ?></span>
                            </div>
                            <div class="order-details">
                                <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($order['created_at'])); ?></p>
                                <p><strong>Total:</strong> ₹<?php echo number_format($order['total_amount']); ?></p>
                            </div>
                            <div class="order-actions">
                                <a href="order_details.php?order_id=<?php echo $order['id']; ?>" class="cta-button-small">View Details</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'footer.php'; ?>
    
    <!-- WhatsApp Chat Icon -->
    <a href="https://wa.me/919876543210" class="whatsapp-chat" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

</body>
</html>