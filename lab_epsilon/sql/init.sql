CREATE DATABASE IF NOT EXISTS research_db;
USE research_db;

CREATE TABLE papers_n5k (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(120) UNIQUE,
    title VARCHAR(200),
    author VARCHAR(80),
    abstract TEXT,
    field VARCHAR(60),
    year INT
);

CREATE TABLE portal_staff_x3 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    staff_name VARCHAR(80),
    access_code VARCHAR(80),
    clearance VARCHAR(20)
);

INSERT INTO papers_n5k (slug, title, author, abstract, field, year) VALUES
('ai-security-2025', 'AI-Driven Intrusion Detection Systems', 'Dr. Ram Bahadur', 'This paper explores machine learning models for detecting network intrusions in real time.', 'Cybersecurity', 2025),
('quantum-crypto', 'Post-Quantum Cryptography Standards', 'Dr. Sita Devi', 'Analysis of NIST post-quantum cryptographic algorithms and their implementation challenges.', 'Cryptography', 2024),
('iot-vulnerabilities', 'IoT Device Vulnerability Assessment', 'Dr. Bikash Rana', 'Systematic evaluation of common vulnerabilities in consumer IoT devices.', 'IoT Security', 2025);

INSERT INTO portal_staff_x3 VALUES
(1, 'labdirector', 'R3s34rch$L4b!2025', 'top_secret'),
(2, 'analyst', '4n4lys3&D4ta#Now', 'classified');
