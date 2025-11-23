<?php
session_start();
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if cart is not empty
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Calculate cart total
$cart_total = 0;
foreach ($_SESSION['cart'] as $item) {
    $cart_total += $item['price'] * $item['quantity'];
}

// Handle order placement
if (isset($_POST['place_order'])) {
    // Insert order into database
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
    $stmt->bind_param("id", $_SESSION['user_id'], $cart_total);
    
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;
        
        // Insert order items
        foreach ($_SESSION['cart'] as $product_id => $item) {
            $stmt2 = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt2->bind_param("iiid", $order_id, $product_id, $item['quantity'], $item['price']);
            $stmt2->execute();
            $stmt2->close();
        }
        
        // Clear cart
        $_SESSION['cart'] = array();
        
        // Redirect to order confirmation
        header("Location: order_confirmation.php?order_id=" . $order_id);
        exit();
    } else {
        $error = "Error placing order. Please try again.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Sugar Studio</title>
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
        <div class="checkout-container">
            <div class="checkout-header">
                <h1>Complete Your Order</h1>
                <p>Review your order details and provide your billing information to complete your purchase.</p>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="checkout-layout">
                <div class="checkout-section">
                    <h2>Order Summary</h2>
                    <table class="order-summary-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $product_id => $item): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td>₹<?php echo number_format($item['price']); ?></td>
                                    <td>₹<?php echo number_format($item['price'] * $item['quantity']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Order Total:</strong></td>
                                <td><strong>₹<?php echo number_format($cart_total); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="checkout-section">
                    <h2>Billing Information</h2>
                    <form action="checkout.php" method="POST" class="checkout-form">
                        <div class="form-group">
                            <label for="fullname">Full Name</label>
                            <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($_SESSION['fullname']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Delivery Address</label>
                            <textarea id="address" name="address" required placeholder="Enter your complete delivery address"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" required placeholder="Enter your phone number">
                        </div>
                        
                        <div class="payment-methods">
                            <h3>Payment Method</h3>
                            <div class="payment-option">
                                <label>
                                    <input type="radio" name="payment_method" value="cod" checked> 
                                    Cash on Delivery
                                </label>
                            </div>
                            <div class="payment-option">
                                <label>
                                    <input type="radio" name="payment_method" value="online"> 
                                    Online Payment
                                </label>
                            </div>
                        </div>
                        
                        <div class="checkout-actions">
                            <button type="submit" name="place_order" class="cta-button full-width">Place Order</button>
                        </div>
                    </form>
                </div>
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