<?php

namespace root_dev\Models;


require_once __DIR__ . '/../../config/database.php';
<<<<<<< HEAD
use root_dev\Config\Database;
=======
use \Database;
>>>>>>> 551d3d7087e4e7dc9d5f3d497e1b9601bbb4882f



class User {
<<<<<<< HEAD
    private $db;
    private $errors = [];

    public function __construct() {
        $this->db = Database::connect();
    }

    // Check if email exists
    public function emailExists($email) {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetchColumn() > 0;
        } catch (\PDOException $e) {
            $this->errors[] = "Database error: " . $e->getMessage();
            return false;
        }
=======

    // Check if email exists
    public function emailExists($email) {
        $db = Database::connect();
        $query = "SELECT COUNT(*) FROM users WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
>>>>>>> 551d3d7087e4e7dc9d5f3d497e1b9601bbb4882f
    }

    // Get user data by email
    public function getUserByEmail($email) {
<<<<<<< HEAD
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $this->errors[] = "Database error: " . $e->getMessage();
            return false;
        }
    }

    // Get user by remember token
    public function getUserByRememberToken($token) {
        try {
            $query = "SELECT * FROM users WHERE remember_token = ?";
            $stmt = $this->db->prepare($query);
            $stmt->execute([$token]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $this->errors[] = "Database error: " . $e->getMessage();
            return false;
        }
    }

    // Update remember token
    public function updateRememberToken($userId, $token) {
        try {
            $query = "UPDATE users SET remember_token = ? WHERE id = ?";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$token, $userId]);
        } catch (\PDOException $e) {
            $this->errors[] = "Database error: " . $e->getMessage();
            return false;
        }
    }

    // Clear remember token
    public function clearRememberToken($userId) {
        try {
            $query = "UPDATE users SET remember_token = NULL WHERE id = ?";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$userId]);
        } catch (\PDOException $e) {
            $this->errors[] = "Database error: " . $e->getMessage();
            return false;
        }
    }

    // Register a new user
    public function register($username, $email, $password, $role = 'user') {
        try {
            // Validate input
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->errors[] = "Invalid email format";
                return false;
            }

            if (strlen($username) < 3 || strlen($username) > 20) {
                $this->errors[] = "Username must be between 3 and 20 characters";
                return false;
            }

            if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
                $this->errors[] = "Username can only contain letters, numbers, and underscores";
                return false;
            }

            if (strlen($password) < 8) {
                $this->errors[] = "Password must be at least 8 characters long";
                return false;
            }

            // Check if email already exists
            if ($this->emailExists($email)) {
                $this->errors[] = "Email already exists";
                return false;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
            $result = $stmt->execute([$username, $email, $hashedPassword, $role]);
            
            if (!$result) {
                $this->errors[] = "Failed to register user";
                return false;
            }
            
            return true;
        } catch (\PDOException $e) {
            $this->errors[] = "Database error: " . $e->getMessage();
            return false;
        }
    }

    // Update password
    public function updatePasswordByEmail($email, $newPassword) {
        try {
            if (strlen($newPassword) < 8) {
                $this->errors[] = "Password must be at least 8 characters long";
                return false;
            }

            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE email = ?");
            return $stmt->execute([$hashedPassword, $email]);
        } catch (\PDOException $e) {
            $this->errors[] = "Database error: " . $e->getMessage();
            return false;
        }
    }

    // Get last error
    public function getErrors() {
        return $this->errors;
=======
        $db = Database::connect();
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC); // Use \PDO here
    }

    // Register a new user
    public function register($username, $email, $password) {
        $db = Database::connect();
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        return $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT)]);
>>>>>>> 551d3d7087e4e7dc9d5f3d497e1b9601bbb4882f
    }
}
