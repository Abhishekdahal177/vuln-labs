CREATE DATABASE IF NOT EXISTS foodorder_db;
USE foodorder_db;

CREATE TABLE menu_items_q6 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    category VARCHAR(50),
    price DECIMAL(8,2),
    calories INT,
    available TINYINT DEFAULT 1
);

CREATE TABLE admin_accounts_w2 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(80),
    password VARCHAR(80),
    restaurant VARCHAR(80)
);

INSERT INTO menu_items_q6 (name, category, price, calories) VALUES
('Momo Platter', 'Nepali', 250.00, 380),
('Dal Bhat Set', 'Nepali', 180.00, 650),
('Chow Mein', 'Chinese', 220.00, 420),
('Buff Burger', 'Fast Food', 300.00, 520),
('Lassi', 'Drinks', 120.00, 180);

INSERT INTO admin_accounts_w2 VALUES
(1, 'kitchenadmin', 'F00d$Serv3r!2025', 'MomoHouse'),
(2, 'manager', 'R3st0&Manage!', 'HQBranch');
