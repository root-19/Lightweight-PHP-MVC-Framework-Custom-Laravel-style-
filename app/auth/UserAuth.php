<?php
namespace root_dev\Auth;

use root_dev\Config\Database;

class UserAuth {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function attemptLogin($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return [
                'success' => true,
                'user' => $user,
                'role' => 'user'
            ];
        }

        return ['success' => false];
    }

    public function updatePassword($email, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE email = ?");
        return $stmt->execute([$hashedPassword, $email]);
    }

    public function emailExists($email) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public function updateRememberToken($userId, $token) {
        try {
            $stmt = $this->db->prepare("UPDATE users SET remember_token = ?, token_expires_at = DATE_ADD(NOW(), INTERVAL 30 DAY) WHERE id = ?");
            return $stmt->execute([$token, $userId]);
        } catch (\PDOException $e) {
            error_log("Error updating remember token: " . $e->getMessage());
            return false;
        }
    }

    public function getUserByRememberToken($token) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE remember_token = ? AND token_expires_at > NOW()");
            $stmt->execute([$token]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error getting user by remember token: " . $e->getMessage());
            return false;
        }
    }

    public function clearRememberToken($userId) {
        try {
            $stmt = $this->db->prepare("UPDATE users SET remember_token = NULL, token_expires_at = NULL WHERE id = ?");
            return $stmt->execute([$userId]);
        } catch (\PDOException $e) {
            error_log("Error clearing remember token: " . $e->getMessage());
            return false;
        }
    }
} 