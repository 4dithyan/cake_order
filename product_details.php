<?php
session_start();
require_once 'config.php';

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id > 0) {
    // Fetch product details from database
    $stmt = $conn->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $product = $result->fetch_assoc();
    } else {
        // Product not found
        header("Location: products.php");
        exit();
    }
    $stmt->close();
} else {
    // Invalid product ID
    header("Location: products.php");
    exit();
}

// Handle adding to cart
if (isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    
    $quantity = intval($_POST['quantity']);
    
    // Check if product already in cart
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = array(
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image'],
            'quantity' => $quantity
        );
    }
    
    // Redirect to cart page
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> - Sugar Studio</title>
    <link rel="stylesheet" href="style.css"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <main>
        <div class="product-detail-container">
            <div class="product-detail-layout">
                <div class="product-detail-image">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
                
                <div class="product-detail-info">
                    <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                    <p class="product-price">₹<?php echo number_format($product['price']); ?></p>
                    
                    <div class="product-description">
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                    </div>
                    
                    <form action="product_details.php?id=<?php echo $product_id; ?>" method="POST" class="add-to-cart-form-minimal">
                        <div class="quantity-selector">
                            <label for="quantity">Quantity:</label>
                            <select id="quantity" name="quantity">
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?php echo $i; ?>"<?php echo $i == 1 ? ' selected' : ''; ?>><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        
                        <button type="submit" name="add_to_cart" class="minimal-add-to-cart">Add to Cart</button>
                    </form>
                    
                    <div class="product-meta">
                        <p class="product-category">Category: <?php echo htmlspecialchars($product['category_name']); ?></p>
                        <a href="products.php" class="back-to-gallery">← Back to Gallery</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <?php include 'footer.php'; ?>
</body>
</html>