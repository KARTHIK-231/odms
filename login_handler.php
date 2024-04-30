<?php
session_start();

// Include the database connection file
require_once 'db_connection.php';

// Retrieve username and password from the login form
$username = $_POST['username'];
$password = $_POST['password'];

// Query to fetch delivery person details based on username
$sql = "SELECT * FROM DeliveryPersons WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Verify password
if ($user && password_verify($password, $user['password'])) {
    // Password is correct, set session variables
    $_SESSION['delivery_person_id'] = $user['delivery_person_id'];
    $_SESSION['username'] = $user['username'];
    // Redirect to delivery_orders.php
    header("Location: delivery_orders.php");
    exit();
} else {
    // Display error message
    echo "Invalid username or password.";
}
?>
