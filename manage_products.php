<?php
session_start();

// Check if seller is not logged in, redirect to login page
if(!isset($_SESSION["seller_id"])) {
    header("location: seller_login.php");
    exit;
}

// Include database connection
require_once "db_connection.php";

// Fetch products associated with the logged-in seller
$sql = "SELECT * FROM products WHERE seller_id = ?";
if($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $_SESSION["seller_id"]);
    if($stmt->execute()) {
        $result = $stmt->get_result();
        $products = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
    $stmt->close();
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="product-list">
        <h2>Manage Products</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity Available</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $product): ?>
                <tr>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo $product['description']; ?></td>
                    <td><?php echo $product['price']; ?></td>
                    <td><?php echo $product['quantity_available']; ?></td>
                    <td><a href="edit_product.php?id=<?php echo $product['product_id']; ?>">Edit</a> | <a href="delete_product.php?id=<?php echo $product['product_id']; ?>">Delete</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
