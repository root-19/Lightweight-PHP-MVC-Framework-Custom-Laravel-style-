<?php
require_once __DIR__ . '/config/database.php';

use root_dev\Config\Database;

try {
    $db = Database::connect();
    
    // Create admin user
    $username = 'admin';
    $email = 'admin@example.com';
    $password = 'admin123';
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // First, check if admin exists
    $stmt = $db->prepare("SELECT id FROM admins WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        // Update existing admin
        $updateQuery = "UPDATE admins SET username = ?, password = ? WHERE email = ?";
        $db->prepare($updateQuery)->execute([$username, $hashedPassword, $email]);
        echo "✅ Admin user updated successfully\n";
    } else {
        // Insert new admin
        $insertQuery = "INSERT INTO admins (username, email, password, role) VALUES (?, ?, ?, 'admin')";
        $db->prepare($insertQuery)->execute([$username, $email, $hashedPassword]);
        echo "✅ Admin user created successfully\n";
    }

    echo "\nAdmin credentials:\n";
    echo "Email: admin@example.com\n";
    echo "Password: admin123\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 