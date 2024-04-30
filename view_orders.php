<?php
session_start();

// Check if seller is not logged in, redirect to login page
if (!isset($_SESSION["seller_id"])) {
    header("location: seller_login.php");
    exit;
}

// Include database connection
$mysqli = require_once "db_connection.php";

// Check if $mysqli is set
if (!$mysqli) {
    die("Database connection not established.");
}

// Fetch orders associated with the logged-in seller
$sql = "SELECT * FROM orders WHERE seller_id = ?";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $_SESSION["seller_id"]);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
    $stmt->close();
}

// Close connection
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Orders</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="order-list">
        <h2>View Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Buyer Name</th>
                    <th>Total Price</th>
                    <th>Order Status</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($orders as $order): ?>
                <tr>
                    <td><?php echo $order['order_id']; ?></td>
                    <td><?php echo $order['buyer_id']; ?></td>
                    <td><?php echo $order['total_price']; ?></td>
                    <td><?php echo $order['order_status']; ?></td>
                    <td><?php echo $order['order_date']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
