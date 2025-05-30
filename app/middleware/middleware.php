<?php
namespace root_dev\Middleware;

class AuthMiddleware
<<<<<<< HEAD


/**
 * Performs authentication checks for different user roles and access levels.
 * 
 * @method check() Verifies general user login status
 * @method checkAdmin() Restricts access to admin-only routes
 * @method checkUser() Ensures only regular user access
 */
// AuthMiddleware::check();        // For general login
// AuthMiddleware::checkAdmin();   // For admin-only
// AuthMiddleware::checkUser();    // For user-only

{
    // Start session if it's not already started
    private static function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Check if the user is logged in
    public static function check()
    {
        self::startSession();

        if (empty($_SESSION['user_id']) || !isset($_SESSION['role'])) {
            self::logoutAndRedirect('/login');
        }
    }

    // Check if the user is an admin
    public static function checkAdmin()
    {
        self::startSession();

        if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? null) !== 'admin') {
            self::logoutAndRedirect('/dashboard.php');
        }
    }

    // Check if the user is a regular user
    public static function checkUser()
    {
        self::startSession();

        if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? null) !== 'user') {
            self::logoutAndRedirect('/admin/dashboard.php');
        }
    }

    // Redirect and destroy session
    private static function logoutAndRedirect($location)
    {
        session_unset();
        session_destroy();
        header("Location: {$location}");
        exit();
    }
=======
{
    public static function check()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
    }

    public static function checkAdmin()
    {
        session_start();

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: /dashboard.php'); // redirect non-admins
            exit();
        }
    }

    public static function checkUser()
    {
        session_start();

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
            header('Location: /admin/dashboard.php'); 
            exit();
        }
    }
>>>>>>> 551d3d7087e4e7dc9d5f3d497e1b9601bbb4882f
}
