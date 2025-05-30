<?php

<<<<<<< HEAD
class CreateUsersTable {
    public function up($pdo) {
        $query = "
            CREATE TABLE users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(100) NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                remember_token VARCHAR(100),
                email_verified_at TIMESTAMP NULL,
                is_active BOOLEAN DEFAULT TRUE,
                role ENUM('admin', 'user') DEFAULT 'user',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
=======
class CreateFacultyTable {
    public function up($pdo) {
        $query = "
            CREATE TABLE faculty (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100),
                email VARCHAR(100) UNIQUE,
                department VARCHAR(100),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
>>>>>>> 551d3d7087e4e7dc9d5f3d497e1b9601bbb4882f
            )
        ";
        $pdo->exec($query);
    }
}
