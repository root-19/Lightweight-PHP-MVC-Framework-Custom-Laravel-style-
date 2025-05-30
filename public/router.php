<?php

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle CLI server for development
if (php_sapi_name() === 'cli-server') {
    $url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $file = __DIR__ . $url;
    if (is_file($file)) {
        return false;
    }
}

// Define the base path
define('BASE_PATH', realpath(__DIR__ . '/..'));

// Load required files
require_once BASE_PATH . '/vendor/autoload.php';
require_once BASE_PATH . '/routes/web.php';

// Get the current URL path
$request_uri = $_SERVER['REQUEST_URI'];
$script_name = $_SERVER['SCRIPT_NAME'];
$base_path = dirname($script_name);

// Remove base path from request URI
$path = substr($request_uri, strlen($base_path));
$path = parse_url($path, PHP_URL_PATH);

// Handle the routing
if (isset($routes[$path])) {
    $route = $routes[$path];
    $handler = $route[0];
    $action = $route[1];
    $is_protected = $route[2] ?? false;
    $required_role = $route[3] ?? null;

    // Check if route is protected
    if ($is_protected) {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Please login to access this page.';
            header('Location: /login');
            exit;
        }

        // Check role if required
        if ($required_role && (!isset($_SESSION['role']) || $_SESSION['role'] !== $required_role)) {
            http_response_code(403);
            $_SESSION['error'] = 'You do not have permission to access this page.';
            header('Location: /dashboard');
            exit;
        }
    }

    // Handle different route types
    if ($handler === 'public') {
        // Handle public files
        require_once BASE_PATH . "/public/{$action}.php";
    } elseif ($handler === 'view') {
        // Handle view files
        require_once BASE_PATH . "/app/views/{$action}.php";
    } else {
        // Handle controller methods
        $controller = new $handler();
        $controller->$action();
    }
} else {
    // Handle 404
    http_response_code(404);
    require_once BASE_PATH . "/app/views/errors/404.php";
}

