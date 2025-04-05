<?php

class CreateFacultyTable {
    public function up($pdo) {
        $query = "
            CREATE TABLE faculty (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100),
                email VARCHAR(100) UNIQUE,
                department VARCHAR(100),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ";
        $pdo->exec($query);
    }
}
