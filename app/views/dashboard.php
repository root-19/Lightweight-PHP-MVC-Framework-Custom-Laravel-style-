<!-- app/views/dashboard.php -->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <?php require_once __DIR__ . '/layouts/header.php'; ?>

    <main class="max-w-6xl mx-auto mt-6 px-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4">Dashboard</h2>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-500 text-white p-3 rounded mb-4">
                    <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Quick Stats -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="font-bold text-lg mb-2">Profile Overview</h3>
                    <p class="text-gray-600">
                        Welcome back, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                    </p>
                    <p class="text-gray-600">
                        Role: <?php echo htmlspecialchars($_SESSION['role']); ?>
                    </p>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="font-bold text-lg mb-2">Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="/profile" class="block text-red-600 hover:text-red-700">
                            → Update Profile
                        </a>
                        <a href="/profile#password" class="block text-red-600 hover:text-red-700">
                            → Change Password
                        </a>
                    </div>
                </div>

                <!-- System Info -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="font-bold text-lg mb-2">System Info</h3>
                    <p class="text-gray-600">
                        Last Login: <?php echo date('Y-m-d H:i:s'); ?>
                    </p>
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
