<?php
// session_start();
require_once __DIR__ . '/../vendor/autoload.php';

// Generate CSRF token if not exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-gray-800 text-white w-full max-w-md p-10 rounded-lg shadow-xl">
            <h2 class="text-3xl font-bold mb-4 text-center">Login</h2>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="bg-red-500 text-white p-3 rounded mb-4">
                    <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="bg-green-500 text-white p-3 rounded mb-4">
                    <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <form action="/login" method="POST" class="space-y-4">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <div>
                    <label for="email" class="block text-lg">Email:</label>
                    <input type="email" name="email" id="email" required 
                           class="w-full p-3 mb-4 text-black border border-gray-300 rounded" />
                </div>

                <div>
                    <label for="password" class="block text-lg">Password:</label>
                    <input type="password" name="password" id="password" required 
                           class="w-full p-3 mb-4 text-black border border-gray-300 rounded" />
                </div>

                <div class="flex items-center mb-4">
                    <input type="checkbox" name="remember" id="remember" 
                           class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500" />
                    <label for="remember" class="ml-2 text-sm text-gray-300">
                        Remember me for 30 days
                    </label>
                </div>

                <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-full hover:bg-red-700 transition">
                    Login
                </button>
            </form>

            <div class="mt-4 text-center">
                <a href="/forget-password" class="text-sm text-gray-400 hover:text-gray-300">
                    Forgot your password?
                </a>
            </div>

            <p class="text-center mt-4 text-lg">
                Don't have an account? 
                <a href="/register" class="text-red-600 hover:text-red-700">Register here</a>
            </p>
        </div>
    </div>
</body>
</html>
