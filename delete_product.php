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

    // Delete product from the database
    $sql = "DELETE FROM products WHERE product_id = ?";
    if($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $product_id);
        if($stmt->execute()) {
            // Product deleted successfully, redirect to manage products page
            header("location: manage_products.php");
            exit;
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
