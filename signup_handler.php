<?php
// Include the database connection file
require_once 'db_connection.php';

// Retrieve signup form data
// You should validate and sanitize user input before using it in a query to prevent SQL injection

$username = $_POST['username'];
$password = $_POST['password']; // Ensure to hash the password for security
$email = $_POST['email'];
$name = $_POST['name'];
$address = $_POST['address'];
$phone_number = $_POST['phone_number'];

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert new delivery person record into the database
$sql = "INSERT INTO DeliveryPersons (username, password, email, name, address, phone_number) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $username, $hashed_password, $email, $name, $address, $phone_number);
$stmt->execute();

// Redirect to login page after successful signup
header("Location: delivery_login.php");
exit();
?>
