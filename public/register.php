<?php
// session_start();
require_once __DIR__ . '/../vendor/autoload.php';

// Generate CSRF token if not exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password strength
    if (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long";
    } elseif (!preg_match("/[A-Z]/", $password)) {
        $error = "Password must contain at least one uppercase letter";
    } elseif (!preg_match("/[a-z]/", $password)) {
        $error = "Password must contain at least one lowercase letter";
    } elseif (!preg_match("/[0-9]/", $password)) {
        $error = "Password must contain at least one number";
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // TODO: Save user to database
        // After successful registration, generate JWT token
        $token = \App\Helpers\JwtHelper::generateToken([
            'user_id' => 1, // Replace with actual user ID
            'username' => $username
        ]);
        
        // Set token in cookie
        setcookie('auth_token', $token, time() + 3600, '/', '', true, true);
        
        // Redirect to dashboard
        header('Location: /dashboard');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white">

  <!-- Register Form Section -->
  <div class="flex items-center justify-center min-h-screen">
    <div class="bg-gray-800 text-white w-full max-w-md p-10 rounded-lg shadow-xl">
      <h2 class="text-3xl font-bold mb-4 text-center">Register</h2>

      <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-500 text-white p-3 rounded mb-4">
          <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>

      <form action="/register" method="POST" class="space-y-4">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        
        <div>
          <label for="username" class="block text-lg">Username:</label>
          <input type="text" name="username" id="username" required 
                 pattern="[a-zA-Z0-9_]{3,20}"
                 title="Username must be between 3 and 20 characters and can only contain letters, numbers, and underscores"
                 class="w-full p-3 text-black mb-4 border border-gray-300 rounded" />
        </div>

        <div>
          <label for="email" class="block text-lg">Email:</label>
          <input type="email" name="email" id="email" required 
                 class="w-full p-3 mb-4 text-black border border-gray-300 rounded" />
        </div>

        <div>
          <label for="password" class="block text-lg">Password:</label>
          <input type="password" name="password" id="password" required 
                 minlength="8"
                 class="w-full p-3 text-black mb-2 border border-gray-300 rounded" />
        </div>

        <div>
          <label for="confirm_password" class="block text-lg">Confirm Password:</label>
          <input type="password" name="confirm_password" id="confirm_password" required 
                 minlength="8"
                 class="w-full p-3 text-black mb-4 border border-gray-300 rounded" />
          <p class="text-sm text-gray-400">Password must be at least 8 characters long</p>
        </div>

        <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-full hover:bg-red-700 transition">
          Register
        </button>
      </form>

      <p class="text-center mt-4 text-lg">Already have an account? <a href="/login" class="text-red-600 hover:text-red-700">Login here</a></p>
    </div>
  </div>

</body>
</html>

