<?php
namespace root_dev\Auth;

use root_dev\Config\Database;

class AdminAuth {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function attemptLogin($email, $password) {
        try {
            // Debug: Log the login attempt
            // file_put_contents('admin_debug.log', "Login attempt - Email: $email\n", FILE_APPEND);
            
            // Check if admin exists
            $stmt = $this->db->prepare("SELECT * FROM admins WHERE email = ?");
            $stmt->execute([$email]);
            $admin = $stmt->fetch(\PDO::FETCH_ASSOC);

            // Debug: Log admin data
            // file_put_contents('admin_debug.log', "Admin data found: " . print_r($admin, true) . "\n", FILE_APPEND);

            if (!$admin) {
                // file_put_contents('admin_debug.log', "No admin found with email: $email\n", FILE_APPEND);
                return ['success' => false];
            }

            // // Debug: Log password verification attempt
            // file_put_contents('admin_debug.log', "Stored hashed password: {$admin['password']}\n", FILE_APPEND);
            // file_put_contents('admin_debug.log', "Attempting to verify password...\n", FILE_APPEND);

            $passwordVerified = password_verify($password, $admin['password']);
            file_put_contents('admin_debug.log', "Password verification result: " . ($passwordVerified ? "true" : "false") . "\n", FILE_APPEND);

            if ($passwordVerified) {
                file_put_contents('admin_debug.log', "Login successful for admin: {$admin['username']}\n", FILE_APPEND);
                return [
                    'success' => true,
                    'user' => $admin,
                    'role' => 'admin'
                ];
            }

            // file_put_contents('admin_debug.log', "Password verification failed\n", FILE_APPEND);
            return ['success' => false];

        } catch (\Exception $e) {
            // file_put_contents('admin_debug.log', "Error in admin login: " . $e->getMessage() . "\n", FILE_APPEND);
            return ['success' => false];
        }
    }

    public function updatePassword($email, $newPassword) {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE admins SET password = ? WHERE email = ?");
            $success = $stmt->execute([$hashedPassword, $email]);
            
            // Debug: Log password update attempt
            // file_put_contents('admin_debug.log', "Password update for $email - Success: " . ($success ? "true" : "false") . "\n", FILE_APPEND);
            
            return $success;
        } catch (\Exception $e) {
            // file_put_contents('admin_debug.log', "Error updating admin password: " . $e->getMessage() . "\n", FILE_APPEND);
            return false;
        }
    }

    public function emailExists($email) {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM admins WHERE email = ?");
            $stmt->execute([$email]);
            $exists = $stmt->fetchColumn() > 0;
            
            // Debug: Log email check
            // file_put_contents('admin_debug.log', "Email check for $email - Exists: " . ($exists ? "true" : "false") . "\n", FILE_APPEND);
            
            return $exists;
        } catch (\Exception $e) {
            // file_put_contents('admin_debug.log', "Error checking admin email: " . $e->getMessage() . "\n", FILE_APPEND);
            return false;
        }
    }

    public function updateRememberToken($userId, $token) {
        try {
            $stmt = $this->db->prepare("UPDATE admins SET remember_token = ?, token_expires_at = DATE_ADD(NOW(), INTERVAL 30 DAY) WHERE id = ?");
            $success = $stmt->execute([$token, $userId]);
            
            // Debug: Log token update
            // file_put_contents('admin_debug.log', "Remember token update for admin ID $userId - Success: " . ($success ? "true" : "false") . "\n", FILE_APPEND);
            
            return $success;
        } catch (\Exception $e) {
            // file_put_contents('admin_debug.log', "Error updating admin remember token: " . $e->getMessage() . "\n", FILE_APPEND);
            return false;
        }
    }

    public function getUserByRememberToken($token) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM admins WHERE remember_token = ? AND token_expires_at > NOW()");
            $stmt->execute([$token]);
            $admin = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            // Debug: Log token lookup
            // file_put_contents('admin_debug.log', "Remember token lookup - Found admin: " . ($admin ? "yes" : "no") . "\n", FILE_APPEND);
            
            return $admin;
        } catch (\Exception $e) {
            // file_put_contents('admin_debug.log', "Error getting admin by remember token: " . $e->getMessage() . "\n", FILE_APPEND);
            return false;
        }
    }

    public function clearRememberToken($userId) {
        try {
            $stmt = $this->db->prepare("UPDATE admins SET remember_token = NULL, token_expires_at = NULL WHERE id = ?");
            $success = $stmt->execute([$userId]);
            
            // Debug: Log token clearing
            // file_put_contents('admin_debug.log', "Remember token cleared for admin ID $userId - Success: " . ($success ? "true" : "false") . "\n", FILE_APPEND);
            
            return $success;
        } catch (\Exception $e) {
            // file_put_contents('admin_debug.log', "Error clearing admin remember token: " . $e->getMessage() . "\n", FILE_APPEND);
            return false;
        }
    }
} 