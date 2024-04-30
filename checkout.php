<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in
if (!isset($_SESSION['buyer_id'])) {
    // If the user is not logged in, redirect them to the login page
    header("Location: login.php");
    exit(); // Stop further execution
}

// Include the database connection file
include('db_connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="styles.css"> <!-- Assuming you have a separate CSS file named styles.css -->
</head>
<body>
    <h2>Checkout</h2>
    
    <!-- Display the list of items in the cart with their details -->
    <div class="cart-items">
        <?php
        

        // Check if the cart is not empty
        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            // Loop through each item in the cart and display its details
            foreach($_SESSION['cart'] as $product_id => $quantity) {
                // Query to fetch product details based on product_id
                $query = "SELECT * FROM Products WHERE product_id = ?";
                $product_statement = $conn->prepare($query);
                $product_statement->bind_param("i", $product_id);
                $product_statement->execute();
                $result = $product_statement->get_result();
                
                // Check if product exists
                if($result->num_rows > 0) {
                    $product = $result->fetch_assoc();
                    
                    // Display product details
                    echo '<div class="cart-item">';
                    echo '<h3>' . $product['name'] . '</h3>';
                    echo '<p>Price: $' . $product['price'] . '</p>';
                    echo '<p>Quantity: ' . $quantity . '</p>';
                    echo '</div>';
                }
            }
        } else {
            // If the cart is empty, display a message
            echo '<p>Your shopping cart is empty</p>';
        }

        // Close product statement
        $product_statement->close();
        ?>
    </div>
    
    <!-- Allow the user to enter shipping address and payment information -->
    <form action="place_order.php" method="POST">
        <label for="shipping_address">Shipping Address:</label><br>
        <textarea id="shipping_address" name="shipping_address" rows="4" cols="50" required></textarea><br><br>
        
        <label for="payment_info">Payment Information:</label><br>
        <input type="text" id="payment_info" name="payment_info" required><br><br>
        
        <button type="submit">Place Order</button>
    </form>

    <?php
    // Close database connection
    $conn->close();
    ?>
</body>
</html>
