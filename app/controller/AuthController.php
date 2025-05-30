<?php
namespace root_dev\Controller;

require_once __DIR__ . '/../models/User.php'; 
require_once __DIR__ . '/../auth/UserAuth.php';
require_once __DIR__ . '/../auth/AdminAuth.php';
require_once __DIR__ . '/../../config/database.php';

use root_dev\Models\User;
use root_dev\Auth\UserAuth;
use root_dev\Auth\AdminAuth;
use root_dev\Config\Database;

class AuthController {
    private $db;
    private $userAuth;
    private $adminAuth;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = Database::connect();
        $this->userAuth = new UserAuth();
        $this->adminAuth = new AdminAuth();
    }

    public function index() {
        header('Location: /');
        exit();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']) ? true : false;

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = 'Please fill in all fields';
                header('Location: /login');
                exit();
            }

            // Try admin login first
            $adminResult = $this->adminAuth->attemptLogin($email, $password);
            
            // Debug log
            file_put_contents('auth_debug.log', "Admin login attempt result: " . print_r($adminResult, true) . "\n", FILE_APPEND);
            
            if ($adminResult['success']) {
                if (isset($adminResult['user']) && is_array($adminResult['user'])) {
                    $_SESSION['user_id'] = $adminResult['user']['id'];
                    $_SESSION['username'] = $adminResult['user']['username'];
                    $_SESSION['role'] = 'admin';

                    if ($remember) {
                        $token = bin2hex(random_bytes(32));
                        $this->adminAuth->updateRememberToken($adminResult['user']['id'], $token);
                        setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/', '', true, true);
                    }

                    header('Location: /admin/dashboard');
                    exit();
                }
            }

            // Try user login if admin login failed
            $userResult = $this->userAuth->attemptLogin($email, $password);
            
            // Debug log
            file_put_contents('auth_debug.log', "User login attempt result: " . print_r($userResult, true) . "\n", FILE_APPEND);
            
            if ($userResult['success']) {
                if (isset($userResult['user']) && is_array($userResult['user'])) {
                    $_SESSION['user_id'] = $userResult['user']['id'];
                    $_SESSION['username'] = $userResult['user']['username'];
                    $_SESSION['role'] = 'user';

                    if ($remember) {
                        $token = bin2hex(random_bytes(32));
                        $this->userAuth->updateRememberToken($userResult['user']['id'], $token);
                        setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/', '', true, true);
                    }

                    header('Location: /dashboard');
                    exit();
                }
            }

            $_SESSION['error'] = 'Invalid email or password';
            header('Location: /login');
            exit();
        }

        // Check for remember token cookie
        $rememberToken = $_COOKIE['remember_token'] ?? null;
        if ($rememberToken) {
            // Try admin remember token
            $adminUser = $this->adminAuth->getUserByRememberToken($rememberToken);
            if ($adminUser) {
                $_SESSION['user_id'] = $adminUser['id'];
                $_SESSION['username'] = $adminUser['username'];
                $_SESSION['role'] = 'admin';
                header('Location: /admin/dashboard');
                exit();
            }

            // Try user remember token
            $user = $this->userAuth->getUserByRememberToken($rememberToken);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = 'user';
                header('Location: /dashboard');
                exit();
            }

            // Invalid remember token, clear it
            setcookie('remember_token', '', time() - 3600, '/', '', true, true);
        }

        require_once __DIR__ . '/../../public/login.php';
    }

    private function setUserSession($user, $role) {
        if (!is_array($user)) {
            throw new \Exception('Invalid user data provided');
        }
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $role;
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
                $_SESSION['error'] = "All fields are required.";
                header('Location: /register');
                exit();
            }

            if ($password !== $confirmPassword) {
                $_SESSION['error'] = "Passwords do not match.";
                header('Location: /register');
                exit();
            }
            
            if ($this->userAuth->emailExists($email) || $this->adminAuth->emailExists($email)) {
                $_SESSION['error'] = "Email is already registered.";
                header('Location: /register');
                exit();
            }

            $user = new User();
            if ($user->register($username, $email, $password, 'user')) {
                $userData = $user->getUserByEmail($email);
                if ($userData) {
                    $this->setUserSession($userData, 'user');
                    header('Location: /dashboard');
                    exit();
                }
            } else {
                $_SESSION['error'] = implode(", ", $user->getErrors());
                header('Location: /register');
                exit();
            }

            $_SESSION['error'] = "Failed to register. Please try again.";
            header('Location: /register');
            exit();
        }

        require_once __DIR__ . '/../../public/register.php';
    }

    public function logout() {
        // Get user info before clearing session
        $userId = $_SESSION['user_id'] ?? null;
        $role = $_SESSION['role'] ?? null;

        // Clear remember token if exists
        if (isset($_COOKIE['remember_token'])) {
            // Clear the cookie
            setcookie('remember_token', '', time() - 3600, '/', '', true, true);
            
            // Clear token from database based on role
            if ($userId) {
                if ($role === 'admin') {
                    $this->adminAuth->clearRememberToken($userId);
                } else {
                    $this->userAuth->clearRememberToken($userId);
                }
            }
        }

        // Clear all session data
        session_unset();
        session_destroy();
        
        // Start a new session for flash messages
        session_start();
        $_SESSION['success'] = 'You have been successfully logged out.';
        
        // Redirect to login page
        header('Location: /login');
        exit();
    }

    public function forgetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $retypePassword = $_POST['retype_password'] ?? '';

            if (empty($email) || empty($newPassword) || empty($retypePassword)) {
                $_SESSION['error'] = "All fields are required.";
                header('Location: /forget-password');
                exit();
            }

            if ($newPassword !== $retypePassword) {
                $_SESSION['error'] = "Passwords do not match.";
                header('Location: /forget-password');
                exit();
            }

            // Try updating admin password first
            if ($this->adminAuth->emailExists($email)) {
                if ($this->adminAuth->updatePassword($email, $newPassword)) {
                    $_SESSION['success'] = "Admin password updated successfully.";
                    header('Location: /login');
                    exit();
                }
            }
            
            // Try updating user password
            if ($this->userAuth->emailExists($email)) {
                if ($this->userAuth->updatePassword($email, $newPassword)) {
                    $_SESSION['success'] = "Password updated successfully.";
                    header('Location: /login');
                    exit();
                }
            }

            $_SESSION['error'] = "Email not found or failed to update password.";
            header('Location: /forget-password');
            exit();
        }

        require_once __DIR__ . '/../../public/forget-password.php';
    }

    public function showLoginForm() {
        require_once __DIR__ . '/../../public/login.php';
    }
}   