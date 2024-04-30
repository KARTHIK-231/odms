<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order Status</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Update Order Status</h1>
    <form action="update_status.php" method="POST">
        <label for="order_id">Order ID:</label>
        <input type="text" id="order_id" name="order_id" required><br><br>
        <label for="status">New Status:</label>
        <select name="status" id="status">
            <option value="Pending">Pending</option>
            <option value="Shipped">Shipped</option>
            <option value="Delivered">Delivered</option>
        </select><br><br>
        <input type="submit" value="Update Status">
    </form>
</body>
</html>
