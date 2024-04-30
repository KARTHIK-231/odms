<?php
// Include database connection
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];

    // Check if username already exists
    $query = "SELECT * FROM buyers WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        echo "Username already exists. Please choose a different username.";
    } else {
        // Insert user data into database
        $query = "INSERT INTO buyers (username, password, email, name, address, phone_number) VALUES ('$username', '$password', '$email', '$name', '$address', '$phone_number')";
        if (mysqli_query($conn, $query)) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Username:</label><br>
        <input type="text" name="username" required><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br>
        <label>Email:</label><br>
        <input type="email" name="email" required><br>
        <label>Name:</label><br>
        <input type="text" name="name" required><br>
        <label>Address:</label><br>
        <textarea name="address" rows="4" cols="50" required></textarea><br>
        <label>Phone Number:</label><br>
        <input type="text" name="phone_number" required><br><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
