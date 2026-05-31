CREATE DATABASE IF NOT EXISTS cloudstore_db;
USE cloudstore_db;

CREATE TABLE files_meta_j9 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(150),
    owner VARCHAR(80),
    size_kb INT,
    file_type VARCHAR(30),
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE system_users_b4 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(80),
    password VARCHAR(80),
    ssh_key_path VARCHAR(200),
    ssh_user VARCHAR(60),
    role VARCHAR(20)
);

INSERT INTO files_meta_j9 (filename, owner, size_kb, file_type) VALUES
('report_q1_2025.pdf', 'alice', 245, 'PDF'),
('backup_march.tar.gz', 'admin', 1024, 'Archive'),
('invoice_042.docx', 'bob', 88, 'Document'),
('server_logs.txt', 'admin', 512, 'Log');

INSERT INTO system_users_b4 VALUES
(1, 'cloudadmin', 'Cl0ud$t0r3!Admin', '/var/www/html/.hidden/.sk_rsa', 'storekeeper', 'superadmin'),
(2, 'devuser', 'D3v&Acc3ss#Now', '/home/devuser/.ssh/id_rsa', 'devuser', 'developer');
