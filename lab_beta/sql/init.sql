CREATE DATABASE IF NOT EXISTS auction_db;
USE auction_db;

CREATE TABLE auction_items_k3 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150),
    seller VARCHAR(80),
    starting_bid DECIMAL(10,2),
    current_bid DECIMAL(10,2),
    ends_in VARCHAR(30),
    category VARCHAR(50)
);

CREATE TABLE site_admins_p7 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login_name VARCHAR(80),
    login_pass VARCHAR(80),
    role VARCHAR(20)
);

INSERT INTO auction_items_k3 (title, seller, starting_bid, current_bid, ends_in, category) VALUES
('Vintage Camera 1965', 'collector99', 50.00, 145.00, '2 days', 'Electronics'),
('Antique Vase Ming Era', 'rarefinds', 200.00, 580.00, '5 hours', 'Antiques'),
('Signed Football Jersey', 'sportsfan', 80.00, 210.00, '1 day', 'Sports'),
('First Edition Book', 'bookworm42', 100.00, 330.00, '3 days', 'Books');

INSERT INTO site_admins_p7 VALUES
(1, 'bidmaster', 'Auct10n$M4ster!', 'superadmin'),
(2, 'mod_team', 'M0d3r4te&Now', 'moderator');
