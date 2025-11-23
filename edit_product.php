<?php
session_start();
require_once 'config.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id > 0) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Update product
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];
        
        // Handle file upload if a new image is provided
        if (!empty($_FILES["image"]["name"])) {
            $target_dir = "image/";
            $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
            $target_file = $target_dir . uniqid() . '.' . $imageFileType;
            
            // Check if image file is actual image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    // Update product with new image
                    $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, image=?, category_id=? WHERE id=?");
                    $stmt->bind_param("ssdsii", $name, $description, $price, $target_file, $category_id, $product_id);
                } else {
                    $error = "Sorry, there was an error uploading your file.";
                }
            } else {
                $error = "File is not an image.";
            }
        } else {
            // Update product without changing image
            $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, category_id=? WHERE id=?");
            $stmt->bind_param("ssdii", $name, $description, $price, $category_id, $product_id);
        }
        
        if (isset($stmt) && $stmt->execute()) {
            header("Location: admin_products.php?updated=1");
            exit();
        } elseif (!isset($error)) {
            $error = "Error updating product.";
        }
        if (isset($stmt)) $stmt->close();
    }
    
    // Fetch product details
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $product = $result->fetch_assoc();
    } else {
        // Product not found
        header("Location: admin_products.php");
        exit();
    }
    $stmt->close();
    
    // Fetch categories for the form
    $category_sql = "SELECT * FROM categories";
    $category_result = $conn->query($category_sql);
} else {
    // Invalid product ID
    header("Location: admin_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Sugar Studio</title>
    <link rel="stylesheet" href="admin-style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>
<body>

    <?php include 'header.php'; ?>

    <main>
        <div class="admin-container">
            <h1>Edit Product</h1>
            
            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="admin-section">
                <form action="edit_product.php?id=<?php echo $product_id; ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" id="price" name="price" step="0.01" value="<?php echo $product['price']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category" name="category_id" required>
                            <?php if ($category_result->num_rows > 0): ?>
                                <?php while($category = $category_result->fetch_assoc()): ?>
                                    <option value="<?php echo $category['id']; ?>" <?php echo ($category['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image">Product Image (Leave blank to keep current image)</label>
                        <input type="file" id="image" name="image" accept="image/*">
                        <p>Current image: <?php echo htmlspecialchars($product['image']); ?></p>
                    </div>
                    <button type="submit" class="cta-button">Update Product</button>
                    <a href="admin_products.php" class="cta-button secondary">Cancel</a>
                </form>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>