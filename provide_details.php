<?php
// provide_details.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve order ID and delivery details from form submission
    $order_id = $_POST["order_id"];
    $delivery_details = $_POST["delivery_details"];

    // Include database connection file
    require_once "db_connection.php";

    // Update delivery details in the database
    $sql = "UPDATE orders SET delivery_details = '$delivery_details' WHERE order_id = $order_id";
    if (mysqli_query($conn, $sql)) {
        // Redirect to the delivery_orders.php page
        header("Location: delivery_orders.php");
        exit();
    } else {
        echo "Error updating delivery details: " . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
}
?>