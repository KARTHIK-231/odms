<?php
session_start();
// Check if seller is already logged in, redirect to dashboard if true
if(isset($_SESSION['seller_id'])) {
    header("Location: seller_dashboard.php");
    exit;
}
// Check if form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    require_once "db_connection.php";

    // Get form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare SQL statement to fetch seller from database
    $sql = "SELECT * FROM sellers WHERE username = ?";
    if($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $param_username);
        $param_username = $username;

        // Execute statement
        if($stmt->execute()) {
            $result = $stmt->get_result();

            // Check if username exists
            if($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                // Verify password
                if(password_verify($password, $row["password"])) {
                    // Password is correct, start a new session
                    session_start();

                    // Store data in session variables
                    $_SESSION["seller_id"] = $row["seller_id"];
                    $_SESSION["username"] = $row["username"];
                    // Redirect to dashboard
                    header("Location: seller_dashboard.php");
                } else {
                    // Display error message if password is not valid
                    $login_err = "Invalid username or password.";
                }
            } else {
                // Display error message if username doesn't exist
                $login_err = "Invalid username or password.";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-form">
        <h2>Seller Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password">
            </div>
            <div class="form-group">
                <input type="submit" class="btn" value="Login">
            </div>
            <p>Don't have an account? <a href="seller_register.php">Sign up now</a>.</p>
            <?php
            // Display error message if login fails
            if(isset($login_err)) {
                echo "<div class='error'>" . $login_err . "</div>";
            }
            ?>
        </form>
    </div>
</body>
</html>
