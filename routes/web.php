<?php
session_start();

use root_dev\Controller\AuthController;  // Import AuthController

// Use __DIR__ to get the absolute path
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/controller/AuthController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case '/':
        header('Location: ./login');
        exit();

    case '/login':
        $controller = new AuthController();
        $controller->login();
        break;

    case '/logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    case '/register':
        $controller = new AuthController();
        $controller->register();
        break;

    case '/dashboard':
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        require_once __DIR__ . '/../app/views/dashboard.php';
        break;

    default:
        echo "404 Not Found: Route [$uri]";
        break;
}
