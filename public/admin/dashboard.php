<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: /login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-gray-800 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <span class="text-xl font-semibold">
                        Admin Dashboard - Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                    </span>
                </div>
                <div class="flex items-center space-x-4">
                    <form action="/logout" method="POST" class="ml-4">
                        <button type="submit" 
                                class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto mt-6 px-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4">Admin Control Panel</h2>
            <p class="text-gray-600 mb-4">
                You are logged in as: <?php echo htmlspecialchars($_SESSION['role']); ?>
            </p>
            
            <!-- Admin specific controls can be added here -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <h3 class="font-bold text-lg mb-2">User Management</h3>
                    <p class="text-gray-600">Manage user accounts and permissions</p>
                </div>
                
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <h3 class="font-bold text-lg mb-2">System Settings</h3>
                    <p class="text-gray-600">Configure system parameters</p>
                </div>
                
                <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <h3 class="font-bold text-lg mb-2">Activity Logs</h3>
                    <p class="text-gray-600">View system and user activity</p>
                </div>
            </div>
        </div>
    </main>

    <script>
    // Prevent form resubmission on page refresh
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    </script>
</body>
</html> 