<?php

class CreateAdminsTable {
    public function up($pdo) {
        // Drop existing table if exists
        $pdo->exec("DROP TABLE IF EXISTS admins");

        // Create admins table
        $tableCreationQuery = "
            CREATE TABLE IF NOT EXISTS admins (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                role ENUM('admin', 'user') NOT NULL DEFAULT 'admin',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ";
        $pdo->exec($tableCreationQuery);

        // Create default admin account
        $username = 'admin';
        $email = 'admin@example.com';
        $password = 'admin123';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insertAdminQuery = "
            INSERT INTO admins (username, email, password, role) 
            VALUES (?, ?, ?, 'admin');
        ";
        
        $stmt = $pdo->prepare($insertAdminQuery);
        $stmt->execute([$username, $email, $hashedPassword]);

        echo "✔️  Admins table created successfully with default admin account.\n";
        echo "Default admin credentials:\n";
        echo "Email: admin@example.com\n";
        echo "Password: admin123\n";
    }

    public function down($pdo) {
        $query = "DROP TABLE IF EXISTS admins;";
        $pdo->exec($query);
    }
} 