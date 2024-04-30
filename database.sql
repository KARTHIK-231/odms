-- Create Buyers Table
CREATE TABLE Buyers (
    buyer_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone_number VARCHAR(15) NOT NULL
);

-- Create Sellers Table
CREATE TABLE Sellers (
    seller_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone_number VARCHAR(15) NOT NULL,
    is_delivery_guy BOOLEAN NOT NULL
);

-- Create Delivery Persons Table
CREATE TABLE DeliveryPersons (
    delivery_person_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone_number VARCHAR(15) NOT NULL
);

-- Create Products Table
CREATE TABLE Products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    quantity_available INT NOT NULL,
    FOREIGN KEY (seller_id) REFERENCES Sellers(seller_id)
);

-- Create Orders Table
CREATE TABLE Orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT,
    seller_id INT,
    delivery_person_id INT,
    total_price DECIMAL(10, 2) NOT NULL,
    order_status ENUM('Pending', 'Shipped', 'Delivered') NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (buyer_id) REFERENCES Buyers(buyer_id),
    FOREIGN KEY (seller_id) REFERENCES Sellers(seller_id),
    FOREIGN KEY (delivery_person_id) REFERENCES DeliveryPersons(delivery_person_id)
);

-- Create Order Details Table
CREATE TABLE OrderDetails (
    order_detail_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES Orders(order_id),
    FOREIGN KEY (product_id) REFERENCES Products(product_id)
);

-- Create Cart Table
CREATE TABLE Cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT,
    product_id INT,
    quantity INT NOT NULL,
    FOREIGN KEY (buyer_id) REFERENCES Buyers(buyer_id),
    FOREIGN KEY (product_id) REFERENCES Products(product_id)
);
