<?php
// Include database connection file
require_once 'config/db.php';

// Fetch products from the database
$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AetherBox Shop</title>
    <link rel="stylesheet" href="css/shopstyle.css">
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
</head>
<body>
    <header>
        <h1>AetherBox Shop</h1>
        <nav>
            <div class="logo">
                <img src="images/logo.png" alt="AetherBox Logo">
            </div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>
    
    <main>
        <h2>Available Products</h2>
        <div class="product-list">
            <?php 
            // Check if there are products
            if ($stmt->rowCount() > 0): 
                // Loop through each product
                while ($product = $stmt->fetch(PDO::FETCH_ASSOC)): 
            ?>
                <div class="product-item">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p>Price: $<?php echo htmlspecialchars($product['price']); ?></p>
                    <button>Add to Cart</button>
                </div>
            <?php 
                endwhile; 
            else: 
            ?>
                <p>No products available at the moment.</p>
            <?php endif; ?>
        </div>
    </main>
    
    <footer>
        <p>&copy; 2023 AetherBox. All rights reserved.</p>
    </footer>
</body>
</html>