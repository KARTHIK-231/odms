<?php
// Start session
session_start();

// Logout functionality
if(isset($_GET['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page or any other page you want
    header("Location: delivery_login.php");
    exit();
}

// Check if the delivery person is logged in
if (!isset($_SESSION['delivery_person_id'])) {
    // If not logged in, redirect to login page
    header("Location: delivery_login.php");
    exit();
}

// Include your database connection file
include_once "db_connection.php";

// Fetch assigned orders for the current delivery person
$delivery_person_id = $_SESSION['delivery_person_id'];
$sql = "SELECT * FROM Orders WHERE delivery_person_id = $delivery_person_id";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Orders</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Logout link -->
    <a href="?logout">Logout</a>

    <h1>Assigned Orders</h1>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Buyer ID</th>
            <th>Order Status</th>
            <th>Action</th>
        </tr>
        <?php
        // Check if there are any assigned orders
        if (mysqli_num_rows($result) > 0) {
            // Output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["order_id"] . "</td>";
                echo "<td>" . $row["buyer_id"] . "</td>";
                echo "<td>" . $row["order_status"] . "</td>";
                echo "<td><a href='update_order_status.php?order_id=" . $row["order_id"] . "'>Update Status</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No assigned orders found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
