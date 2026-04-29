USE autoparts_online;
INSERT INTO users (username, password_hash, role, full_name, email) VALUES
('admin', SHA2('admin123',256), 'ADMIN', 'System Administrator', 'admin@example.com'),
('ship1', SHA2('ship123',256), 'SHIPPING', 'Shipping Worker', 'shipping@example.com'),
('recv1', SHA2('recv123',256), 'RECEIVING', 'Receiving Worker', 'receiving@example.com');
