<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="styles.css"> <!-- Assuming you have a separate CSS file named styles.css -->
</head>
<body>
    <?php
        // Include your database connection file
        include('db_connection.php');

        // Check if product_id is set in the URL
        if(isset($_GET['product_id'])) {
            // Sanitize the input to prevent SQL injection
            $product_id = mysqli_real_escape_string($connection, $_GET['product_id']);
            
            // Query to fetch product details from the database based on product_id
            $query = "SELECT * FROM Products WHERE product_id = $product_id";
            $result = mysqli_query($connection, $query);

            // Check if product exists
            if(mysqli_num_rows($result) > 0) {
                // Fetch product details
                $product = mysqli_fetch_assoc($result);

                // Display product details
                echo '<h2>' . $product['name'] . '</h2>';
                echo '<p>Description: ' . $product['description'] . '</p>';
                echo '<p>Price: $' . $product['price'] . '</p>';
                echo '<button>Add to Cart</button>';
            } else {
                echo '<p>Product not found</p>';
            }
        } else {
            echo '<p>Product ID not provided</p>';
        }

        // Close database connection
        mysqli_close($connection);
    ?>
</body>
</html>
