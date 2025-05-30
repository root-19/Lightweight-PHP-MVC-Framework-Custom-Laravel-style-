<?php

use root_dev\Controller\AuthController;
use root_dev\Controller\ProfileController;

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/controller/AuthController.php';
require_once __DIR__ . '/../app/controller/ProfileController.php';

// Define routes as handler_type, action, is_protected, required_role 
$routes = [
    // Auth routes
    '/' => ['public', 'index', false],
    '/index' => ['public', 'index', false],
    '/login' => [AuthController::class, 'login', false],
    '/logout' => [AuthController::class, 'logout', true],
    '/register' => [AuthController::class, 'register', false],
    '/forget-password' => [AuthController::class, 'forgetPassword', false],

    // Profile routes
    '/profile' => [ProfileController::class, 'index', true],
    '/profile/update' => [ProfileController::class, 'updateProfile', true],
    '/profile/password' => [ProfileController::class, 'updatePassword', true],

    // User routes
    '/dashboard' => ['view', 'dashboard', true, 'user'],
    '/home' => ['view', 'home', true, 'user'],
    '/about' => ['view', 'about', true, 'user'],
    '/contact' => ['view', 'contact', true, 'user'],

    // Admin routes
    '/admin/dashboard' => ['view', 'admin/dashboard', true, 'admin'],
    '/admin/users' => [ProfileController::class, 'usersList', true, 'admin'],
    '/admin/users/edit' => [ProfileController::class, 'editUser', true, 'admin'],
    '/admin/users/delete' => [ProfileController::class, 'deleteUser', true, 'admin'],
    '/admin/home' => ['view', 'admin/home', true, 'admin'],
    '/admin/about' => ['view', 'admin/about', true, 'admin'],
    '/admin/contact' => ['view', 'admin/contact', true, 'admin'],
];

// Get the current path
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Route handling logic
if (isset($routes[$uri])) {
    [$handler, $action, $isProtected, $requiredRole] = array_pad($routes[$uri], 4, null);

    // Middleware: Check login
    if ($isProtected) {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Please login to access this page.';
            header('Location: /login');
            exit();
        }

        // Middleware: Check role
        if ($requiredRole && (!isset($_SESSION['role']) || $_SESSION['role'] !== $requiredRole)) {
            http_response_code(403);
            $_SESSION['error'] = 'You do not have permission to access this page.';
            header('Location: /dashboard');
            exit();
        }
    }

    // Route type logic
    if ($handler === 'redirect') {
        header("Location: ./$action");
        exit();
    } elseif ($handler === 'view') {
        require_once __DIR__ . "/../app/views/$action.php";
    } elseif ($handler === 'public') {
        require_once __DIR__ . "/../public/$action.php";
    } else {
        $controller = new $handler();
        $controller->$action();
    }
} else {
    // Fallback for unknown routes
    http_response_code(404);
    require_once __DIR__ . "/../app/views/errors/404.php";
}
