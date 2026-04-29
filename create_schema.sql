CREATE DATABASE IF NOT EXISTS autoparts_online;
USE autoparts_online;

CREATE TABLE inventory (
    part_number INT PRIMARY KEY,
    quantity_on_hand INT NOT NULL DEFAULT 0,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE shipping_rules (
    rule_id INT AUTO_INCREMENT PRIMARY KEY,
    min_weight DECIMAL(8,2) NOT NULL,
    max_weight DECIMAL(8,2) NOT NULL,
    charge DECIMAL(8,2) NOT NULL,
    active TINYINT(1) NOT NULL DEFAULT 1
);

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('ADMIN', 'SHIPPING', 'RECEIVING') NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100)
);

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100) NOT NULL,
    address_line1 VARCHAR(150) NOT NULL,
    address_line2 VARCHAR(150),
    city VARCHAR(80) NOT NULL,
    state VARCHAR(40) NOT NULL,
    zip_code VARCHAR(20) NOT NULL,
    order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status ENUM('PENDING', 'AUTHORIZED', 'PACKED', 'SHIPPED', 'DECLINED') NOT NULL DEFAULT 'PENDING',
    subtotal DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    shipping_cost DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    total_cost DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    total_weight DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    auth_number VARCHAR(50),
    shipped_date DATETIME NULL
);

CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    part_number INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    unit_weight DECIMAL(8,2) NOT NULL,
    line_total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE
);

CREATE TABLE inventory_receipts (
    receipt_id INT AUTO_INCREMENT PRIMARY KEY,
    part_number INT NOT NULL,
    quantity_received INT NOT NULL,
    received_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    received_by INT NULL,
    notes VARCHAR(255),
    FOREIGN KEY (received_by) REFERENCES users(user_id) ON DELETE SET NULL
);

CREATE TABLE shipments (
    shipment_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    packed_by INT NULL,
    shipped_by INT NULL,
    tracking_number VARCHAR(100),
    shipped_at DATETIME NULL,
    notes VARCHAR(255),
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (packed_by) REFERENCES users(user_id) ON DELETE SET NULL,
    FOREIGN KEY (shipped_by) REFERENCES users(user_id) ON DELETE SET NULL
);

CREATE INDEX idx_orders_status ON orders(status);
CREATE INDEX idx_orders_date ON orders(order_date);
CREATE INDEX idx_orders_total_cost ON orders(total_cost);
