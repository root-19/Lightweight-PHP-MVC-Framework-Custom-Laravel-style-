<?php
namespace root_dev\Controller;

use root_dev\Models\User;
use root_dev\Auth\UserAuth;
use root_dev\Auth\AdminAuth;

class ProfileController {
    private $userAuth;
    private $adminAuth;
    private $user;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userAuth = new UserAuth();
        $this->adminAuth = new AdminAuth();
        $this->user = new User();
    }

    public function index() {
        require_once __DIR__ . '/../views/profile.php';
    }

    public function updateProfile() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /profile');
            exit();
        }

        $username = trim($_POST['username'] ?? '');
        
        if (empty($username)) {
            $_SESSION['error'] = "Username cannot be empty.";
            header('Location: /profile');
            exit();
        }

        // Update based on user role
        $success = false;
        if ($_SESSION['role'] === 'admin') {
            $success = $this->adminAuth->updateUsername($_SESSION['user_id'], $username);
        } else {
            $success = $this->userAuth->updateUsername($_SESSION['user_id'], $username);
        }

        if ($success) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "Profile updated successfully.";
        } else {
            $_SESSION['error'] = "Failed to update profile.";
        }

        header('Location: /profile');
        exit();
    }

    public function updatePassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /profile');
            exit();
        }

        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['error'] = "All password fields are required.";
            header('Location: /profile');
            exit();
        }

        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = "New passwords do not match.";
            header('Location: /profile');
            exit();
        }

        if (strlen($newPassword) < 8) {
            $_SESSION['error'] = "Password must be at least 8 characters long.";
            header('Location: /profile');
            exit();
        }

        // Verify current password and update based on user role
        $success = false;
        if ($_SESSION['role'] === 'admin') {
            $admin = $this->adminAuth->attemptLogin($_SESSION['email'], $currentPassword);
            if ($admin['success']) {
                $success = $this->adminAuth->updatePassword($_SESSION['email'], $newPassword);
            }
        } else {
            $user = $this->userAuth->attemptLogin($_SESSION['email'], $currentPassword);
            if ($user['success']) {
                $success = $this->userAuth->updatePassword($_SESSION['email'], $newPassword);
            }
        }

        if ($success) {
            $_SESSION['success'] = "Password updated successfully.";
        } else {
            $_SESSION['error'] = "Current password is incorrect or failed to update password.";
        }

        header('Location: /profile');
        exit();
    }

    // Admin only methods
    public function usersList() {
        if ($_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = "Access denied.";
            header('Location: /dashboard');
            exit();
        }

        $users = $this->user->getAllUsers();
        require_once __DIR__ . '/../views/admin/users.php';
    }

    public function editUser() {
        if ($_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = "Access denied.";
            header('Location: /dashboard');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'] ?? '';
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $role = $_POST['role'] ?? 'user';

            if (empty($userId) || empty($username) || empty($email)) {
                $_SESSION['error'] = "All fields are required.";
                header('Location: /admin/users');
                exit();
            }

            if ($this->user->updateUser($userId, $username, $email, $role)) {
                $_SESSION['success'] = "User updated successfully.";
            } else {
                $_SESSION['error'] = "Failed to update user.";
            }

            header('Location: /admin/users');
            exit();
        }

        $userId = $_GET['id'] ?? '';
        $userData = $this->user->getUserById($userId);
        require_once __DIR__ . '/../views/admin/edit_user.php';
    }

    public function deleteUser() {
        if ($_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = "Access denied.";
            header('Location: /dashboard');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'] ?? '';

            if (empty($userId)) {
                $_SESSION['error'] = "User ID is required.";
                header('Location: /admin/users');
                exit();
            }

            if ($this->user->deleteUser($userId)) {
                $_SESSION['success'] = "User deleted successfully.";
            } else {
                $_SESSION['error'] = "Failed to delete user.";
            }
        }

        header('Location: /admin/users');
        exit();
    }
} 