<?php
require_once __DIR__ . '/config/database.php';

use root_dev\Config\Database;

try {
    $db = Database::connect();
    
    // Drop and recreate admins table
    $db->exec("DROP TABLE IF EXISTS admins");
    
    $createTable = "
        CREATE TABLE admins (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'user') NOT NULL DEFAULT 'admin',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ";
    $db->exec($createTable);
    
    // Create admin user with fresh password hash
    $username = 'admin';
    $email = 'admin@example.com';
    $password = 'admin123';
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert admin
    $insertQuery = "INSERT INTO admins (username, email, password, role) VALUES (?, ?, ?, 'admin')";
    $stmt = $db->prepare($insertQuery);
    $stmt->execute([$username, $email, $hashedPassword]);
    
    // Verify the inserted data
    $stmt = $db->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "✅ Admin table recreated\n";
    echo "✅ Admin user created\n\n";
    echo "Admin details:\n";
    echo "Username: " . $admin['username'] . "\n";
    echo "Email: " . $admin['email'] . "\n";
    echo "Password (unhashed): admin123\n";
    echo "Role: " . $admin['role'] . "\n";
    
    // Verify password hash
    $verifyPassword = password_verify('admin123', $admin['password']);
    echo "\nPassword verification test: " . ($verifyPassword ? "✅ PASSED" : "❌ FAILED") . "\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 