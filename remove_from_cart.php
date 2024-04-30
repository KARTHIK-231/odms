<?php
session_start();

// Check if the user is logged in or has a valid session
if (!isset($_SESSION['buyer_id']) || empty($_SESSION['buyer_id'])) {
    // Redirect the user to the login page or display an error message
    header("Location: login.php"); // Adjust the redirection URL as per your application logic
    exit; // Stop further execution
}

// Check if product_id is provided in the POST request
if(isset($_POST['product_id'])) {
    // Sanitize the input to prevent SQL injection
    $product_id = intval($_POST['product_id']);

    // Remove the item from the session cart
    if(isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    } else {
        echo 'Item not found in cart';
        exit; // Stop further execution
    }

    // Include your database connection file
    include('db_connection.php');

    // Prepare and execute the SQL query to delete the item from the Cart table
    $buyer_id = $_SESSION['buyer_id'];
    $delete_query = "DELETE FROM Cart WHERE buyer_id = $buyer_id AND product_id = $product_id";
    $delete_result = mysqli_query($conn, $delete_query);

    // Check if the deletion was successful
    if($delete_result) {
        echo 'Item removed from cart successfully';
    } else {
        echo 'Error removing item from cart';
    }

    // Close database connection
    mysqli_close($conn);
} else {
    echo 'Product ID not provided';
}
?>

