<?php
require_once __DIR__ . '/config/database.php';

use root_dev\Config\Database;

try {
    $db = Database::connect();
    
    // Check if admin table exists
    $stmt = $db->query("SHOW TABLES LIKE 'admins'");
    if ($stmt->rowCount() == 0) {
        echo "❌ Admin table does not exist!\n";
        exit;
    }
    
    echo "✅ Admin table exists\n\n";
    
    // Check admin table structure
    $stmt = $db->query("DESCRIBE admins");
    echo "Table structure:\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "{$row['Field']} - {$row['Type']} - {$row['Null']} - {$row['Key']}\n";
    }
    echo "\n";
    
    // Check admin records
    $stmt = $db->query("SELECT * FROM admins");
    echo "Admin records:\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "ID: {$row['id']}\n";
        echo "Username: {$row['username']}\n";
        echo "Email: {$row['email']}\n";
        echo "Role: {$row['role']}\n";
        echo "Created at: {$row['created_at']}\n";
        echo "------------------------\n";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
} 