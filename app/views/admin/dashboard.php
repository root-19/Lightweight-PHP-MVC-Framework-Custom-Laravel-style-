<?php

use root_dev\Config\Database;

require_once __DIR__ . '/layouts/header.php';
require_once __DIR__ . '/../../../config/database.php';

// Create database connection
$db = Database::connect();

// Get total users count from database
$sql = "SELECT COUNT(*) as total FROM users";
$stmt = $db->query($sql);
$totalUsers = $stmt->fetch(\PDO::FETCH_ASSOC)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-white">
    <div class="container mx-auto px-4 py-8">
        <!-- Welcome Section -->
        <div class="mb-8 bg-black rounded-lg p-8 shadow-lg">
            <h1 class="text-4xl font-bold text-white mb-2">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p class="text-gray-300">Manage your system efficiently</p>
        </div>

        <!-- Main Stats -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <div class="flex items-center space-x-4">
                <div class="p-4 rounded-full bg-red-50">
                    <i class="fas fa-users text-3xl text-red-600"></i>
                </div>
                <div>
                    <p class="text-black text-lg">Total Users</p>
                    <p class="text-3xl font-bold text-red-600"><?php echo $totalUsers; ?></p>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-black mb-4">System Status</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                    <span class="text-black">Server Status</span>
                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-medium">Online</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-black">Last Updated</span>
                    <span class="text-red-600"><?php echo date('Y-m-d H:i:s'); ?></span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php

Database::close();
?>

<script>
    const menuButton = document.querySelector('button[aria-controls="mobile-menu"]');
    const mobileMenu = document.getElementById('mobile-menu');

    menuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>
