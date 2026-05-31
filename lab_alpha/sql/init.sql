CREATE DATABASE IF NOT EXISTS travelhub_db;
USE travelhub_db;

CREATE TABLE destinations_r4x (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(100),
    name VARCHAR(150),
    country VARCHAR(80),
    category VARCHAR(60),
    price DECIMAL(10,2),
    rating DECIMAL(3,1),
    description TEXT
);

CREATE TABLE portal_admins_v2 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uname VARCHAR(80),
    passwd VARCHAR(80),
    access_level VARCHAR(20)
);

INSERT INTO destinations_r4x (slug, name, country, category, price, rating, description) VALUES
('paris-escape', 'Paris City Escape', 'France', 'City', 1299.00, 4.8, 'Explore the city of lights'),
('bali-retreat', 'Bali Wellness Retreat', 'Indonesia', 'Beach', 899.00, 4.6, 'Tropical paradise awaits'),
('nepal-trek', 'Himalayan Trek', 'Nepal', 'Adventure', 599.00, 4.9, 'Conquer the Himalayas'),
('tokyo-tour', 'Tokyo City Tour', 'Japan', 'City', 1599.00, 4.7, 'Modern meets ancient');

INSERT INTO portal_admins_v2 VALUES
(1, 'traveladmin', 'Tr4v3l$Hub!2025', 'superadmin'),
(2, 'content_mgr', 'C0nt3nt&Pub!', 'editor');
