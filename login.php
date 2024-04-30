<?php
// Include database connection
include 'db_connection.php';

// Start or resume the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username and password match
    $query = "SELECT * FROM buyers WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        // User authenticated, store buyer_id in session
        $row = mysqli_fetch_assoc($result);
        $_SESSION['buyer_id'] = $row['buyer_id'];
        
        // Redirect to browse_products.php
        header("Location: browse_products.php");
        exit(); // Ensure no further code execution after redirection
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
</head>
<body>
    <h2>User Login</h2>
    <?php if(isset($error)) { echo '<p>' . $error . '</p>'; } ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Username:</label><br>
        <input type="text" name="username" required><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
