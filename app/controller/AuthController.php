<?php
namespace root_dev\Controller;

require_once __DIR__ . '/../models/User.php';  // Include the correct path to the User model
use root_dev\Models\User;  // Use the correct namespace for the User model

class AuthController {

    // Show login form or process the login request
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get POST data
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            // Create User object
            $user = new User();
            
            // Check if the email exists
            if ($user->emailExists($email)) {
                // Get user data
                $userData = $user->getUserByEmail($email);
                
                // Verify password
                if (password_verify($password, $userData['password'])) {
                    // Store user session
                    $_SESSION['user_id'] = $userData['id'];
                    $_SESSION['username'] = $userData['username'];
                    
                    // Redirect to the dashboard after successful login
                    header('Location: /dashboard');
                    exit();
                } else {
                    // Invalid password
                    $error = "Invalid password.";
                    require_once __DIR__ . '/../views/login.php';
                }
            } else {
                // Email not found
                $error = "Email not found.";
                require_once __DIR__ . '/../views/login.php';
            }
        } else {
            // Display the login form
            require_once __DIR__ . '/../views/login.php';
        }
    }

    // Show registration form or process the registration request
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get POST data
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            // Create User object
            $user = new User();
            
            // Check if email already exists
            if ($user->emailExists($email)) {
                // Email already exists
                $error = "Email is already registered.";
                require_once __DIR__ . '/../views/register.php';
            } else {
                // Register new user
                if ($user->register($username, $email, $password)) {
                    // Get user data after registration
                    $_SESSION['user_id'] = $user->getUserByEmail($email)['id'];
                    $_SESSION['username'] = $username;
                    
                    // Redirect to the dashboard after successful registration
                    header('Location: /dashboard');
                    exit();
                } else {
                    // Registration failed
                    $error = "Failed to register. Please try again.";
                    require_once __DIR__ . '/../views/register.php';
                }
            }
        } else {
            // Display the registration form
            require_once __DIR__ . '/../views/register.php';
        }
    }

    // Handle user logout
    public function logout() {
        // Start session and destroy it
        session_start();
        session_destroy();
        
        // Redirect to login page after logout
        header('Location: /login');
        exit();
    }
}
