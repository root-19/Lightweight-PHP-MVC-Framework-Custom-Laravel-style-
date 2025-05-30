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
    <title>Profile - <?php echo htmlspecialchars($_SESSION['username']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <?php require_once __DIR__ . '/layouts/header.php'; ?>

    <main class="max-w-6xl mx-auto mt-6 px-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-600 text-3xl">
                        <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                    </span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold"><?php echo htmlspecialchars($_SESSION['username']); ?></h1>
                    <p class="text-gray-600">Role: <?php echo htmlspecialchars($_SESSION['role']); ?></p>
                </div>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-500 text-white p-3 rounded mb-4">
                    <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-500 text-white p-3 rounded mb-4">
                    <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Update Profile Section -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h2 class="text-xl font-semibold mb-4">Update Profile</h2>
                    <form action="/profile/update" method="POST" class="space-y-4">
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" name="username" id="username" 
                                   value="<?php echo htmlspecialchars($_SESSION['username']); ?>"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                        </div>
                        <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700 transition">
                            Update Profile
                        </button>
                    </form>
                </div>

                <!-- Change Password Section -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h2 class="text-xl font-semibold mb-4">Change Password</h2>
                    <form action="/profile/password" method="POST" class="space-y-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                            <input type="password" name="current_password" id="current_password" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                        </div>
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                            <input type="password" name="new_password" id="new_password" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                        </div>
                        <div>
                            <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                            <input type="password" name="confirm_password" id="confirm_password" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                        </div>
                        <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700 transition">
                            Change Password
                        </button>
                    </form>
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