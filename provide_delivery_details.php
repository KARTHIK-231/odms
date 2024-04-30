<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Provide Delivery Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Provide Delivery Details</h1>
    <form action="provide_details.php" method="POST">
        <label for="order_id">Order ID:</label>
        <input type="text" id="order_id" name="order_id" required><br><br>
        <label for="delivery_details">Delivery Details:</label><br>
        <textarea id="delivery_details" name="delivery_details" rows="4" cols="50" required></textarea><br><br>
        <input type="submit" value="Submit Details">
    </form>
</body>
</html>
