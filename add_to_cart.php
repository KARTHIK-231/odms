<?php
// Include database connection
include 'db_connection.php';

// Start the session
session_start();

// Check if product_id is provided in the POST request
if(isset($_POST['product_id'])) {
    // Check if a buyer is logged in
    if(isset($_SESSION['buyer_id'])) {
        $product_id = $_POST['product_id'];
        $buyer_id = $_SESSION['buyer_id'];

        // Check if the product is already in the cart
        if(isset($_SESSION['cart'][$product_id])) {
            // If the product is already in the cart, increment its quantity by 1
            $_SESSION['cart'][$product_id]++;
        } else {
            // If the product is not in the cart, add it with quantity 1
            $_SESSION['cart'][$product_id] = 1;
        }

        // Update or insert the cart information into the database
        $quantity = $_SESSION['cart'][$product_id];
        $query = "INSERT INTO cart (buyer_id, product_id, quantity) VALUES ('$buyer_id', '$product_id', '$quantity')
                  ON DUPLICATE KEY UPDATE quantity = quantity + 1"; // Increment quantity if the row already exists
        $result = mysqli_query($conn, $query);

        if($result) {
            // Return success response
            http_response_code(200);
            echo "Product added to cart successfully!";
        } else {
            // Return error response
            http_response_code(500);
            echo "Error adding product to cart: " . mysqli_error($conn);
        }
    } else {
        // If buyer is not logged in, return error response
        http_response_code(401);
        echo "Unauthorized access. Please log in to add products to cart.";
    }
} else {
    // If product_id is not provided, return error response
    http_response_code(400);
    echo "Product ID not provided";
}
?>
