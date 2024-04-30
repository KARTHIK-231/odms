<?php
session_start();

// Check if seller is not logged in, redirect to login page
if (!isset($_SESSION["seller_id"])) {
    header("location: seller_login.php");
    exit;
}

// Include database connection
require_once "db_connection.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate product ID
    if (isset($_POST["product_id"])) {
        $product_id = $_POST["product_id"];

        // Sanitize and validate form inputs
        $name = trim($_POST["name"]);
        $description = trim($_POST["description"]);
        $price = floatval($_POST["price"]);
        $quantity_available = intval($_POST["quantity_available"]);

        // Update product details in the database
        $sql = "UPDATE products SET name = ?, description = ?, price = ?, quantity_available = ? WHERE product_id = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssdii", $name, $description, $price, $quantity_available, $product_id);
            if ($stmt->execute()) {
                // Product updated successfully, redirect to manage products page
                header("location: manage_products.php");
                exit;
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    } else {
        // If product ID is not provided, redirect to manage products page
        header("location: manage_products.php");
        exit;
    }
} else {
    // If form is not submitted, redirect to manage products page
    header("location: manage_products.php");
    exit;
}

// Close connection
$conn->close();
?>
