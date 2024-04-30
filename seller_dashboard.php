<?php
session_start();

// Check if seller is not logged in, redirect to login page
if(!isset($_SESSION["seller_id"])) {
    header("location: seller_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <div class="navigation">
            <ul>
                <li><a href="add_product.php">Add Product</a></li>
                <li><a href="manage_products.php">Manage Products</a></li>
                <li><a href="view_orders.php">View Orders</a></li>
                <li><a href="seller_logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
