<?php
session_start();

// Check if seller is not logged in, redirect to login page
if(!isset($_SESSION["seller_id"])) {
    header("location: seller_login.php");
    exit;
}

// Include database connection
require_once "db_connection.php";

// Check if product ID is provided in the URL
if(isset($_GET["id"])) {
    $product_id = $_GET["id"];

    // Fetch product details from the database
    $sql = "SELECT * FROM products WHERE product_id = ?";
    if($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $product_id);
        if($stmt->execute()) {
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        $stmt->close();
    }

    // Close connection
    $conn->close();
} else {
    // If product ID is not provided, redirect to manage products page
    header("location: manage_products.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="edit-product-form">
        <h2>Edit Product</h2>
        <form action="update_product.php" method="post">
            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>">
            <label for="description">Description:</label>
            <textarea id="description" name="description"><?php echo $product['description']; ?></textarea>
            <label for="price">Price:</label>
            <input type="text" id="price" name="price" value="<?php echo $product['price']; ?>">
            <label for="quantity_available">Quantity Available:</label>
            <input type="text" id="quantity_available" name="quantity_available" value="<?php echo $product['quantity_available']; ?>">
            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
