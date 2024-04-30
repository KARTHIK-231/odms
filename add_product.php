<?php
session_start();

// Check if seller is not logged in, redirect to login page
if(!isset($_SESSION["seller_id"])) {
    header("location: seller_login.php");
    exit;
}

// Include database connection
require_once "db_connection.php";

// Define variables and initialize with empty values
$product_name = $description = $price = $quantity = "";
$product_name_err = $description_err = $price_err = $quantity_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate product name
    if(isset($_POST["product_name"]) && !empty(trim($_POST["product_name"]))) {
        $product_name = trim($_POST["product_name"]);
    } else {
        $product_name_err = "Please enter a product name.";
    }

    // Validate description
    if(isset($_POST["description"]) && !empty(trim($_POST["description"]))) {
        $description = trim($_POST["description"]);
    } else {
        $description_err = "Please enter a description.";
    }

    // Validate price
    if(isset($_POST["price"]) && !empty(trim($_POST["price"]))) {
        $price = trim($_POST["price"]);
    } else {
        $price_err = "Please enter a price.";
    }

    // Validate quantity
    if(isset($_POST["quantity"]) && !empty(trim($_POST["quantity"]))) {
        $quantity = trim($_POST["quantity"]);
    } else {
        $quantity_err = "Please enter a quantity.";
    }

    // Check input errors before inserting into database
    if(empty($product_name_err) && empty($description_err) && empty($price_err) && empty($quantity_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO products (seller_id, name, description, price, quantity_available) VALUES (?, ?, ?, ?, ?)";

        if($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("isssi", $param_seller_id, $param_product_name, $param_description, $param_price, $param_quantity);

            // Set parameters
            $param_seller_id = $_SESSION["seller_id"];
            $param_product_name = $product_name;
            $param_description = $description;
            $param_price = $price;
            $param_quantity = $quantity;

            // Attempt to execute the prepared statement
            if($stmt->execute()) {
                // Clear input fields
                $product_name = $description = $price = $quantity = "";

                // Optionally, you can display a success message here

                // Redirect back to add_product.php to allow adding more products
                header("location: add_product.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="product-form">
        <h2>Add Product</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" name="product_name" id="product_name" value="<?php echo $product_name; ?>">
                <span class="error"><?php echo $product_name_err; ?></span>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description"><?php echo $description; ?></textarea>
                <span class="error"><?php echo $description_err; ?></span>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" name="price" id="price" value="<?php echo $price; ?>">
                <span class="error"><?php echo $price_err; ?></span>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="text" name="quantity" id="quantity" value="<?php echo $quantity; ?>">
                <span class="error"><?php echo $quantity_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" value="Add Product">
            </div>
        </form>
    </div>
</body>
</html>
