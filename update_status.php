<?php
// update_status.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve order ID and new status from form submission
    $order_id = $_POST["order_id"];
    $status = $_POST["status"];

    // Include database connection file
    require_once "db_connection.php";

    // Update order status in the database
    $sql = "UPDATE orders SET order_status = '$status' WHERE order_id = $order_id";
    if (mysqli_query($conn, $sql)) {
        // Redirect to the delivery_orders.php page
        header("Location: delivery_orders.php");
        exit();
    } else {
        echo "Error updating order status: " . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
}
?>
