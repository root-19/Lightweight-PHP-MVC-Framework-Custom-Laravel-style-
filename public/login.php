<<<<<<< HEAD
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
=======
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Welcome to Root-Dev</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .typewriter-text::after {
      content: '|';
      animation: blink 1s infinite;
    }

    @keyframes blink {
      0%, 100% { opacity: 1; }
      50% { opacity: 0; }
    }

    .full-height {
      height: 100vh;
    }
  </style>
</head>
<body class="bg-black text-white">

  <!-- Welcome Section -->
  <div class="flex items-center justify-center full-height">
    <div class="text-center px-6">
      <h1 class="text-6xl font-bold mb-6">
        <span class="text-red-600">Root-Dev</span> PHP Framework
      </h1>

      <p id="typewriter" class="text-xl text-gray-300 mb-10 typewriter-text"></p>

      <button onclick="goToLogin()" class="inline-block bg-red-600 hover:bg-red-700 text-white text-lg font-medium px-8 py-3 rounded-full transition">
        Continue →
      </button>
    </div>
  </div>

  <!-- Login Form Section -->
  <div id="loginForm" class="hidden absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-gray-800 text-white w-full max-w-md p-10 rounded-lg shadow-xl">
    <div class="text-gray-800 p-10 rounded-lg shadow-xl w-full">
      <h2 class="text-3xl font-bold mb-4 text-center text-white">Login</h2>
      
      <!-- Error Message -->
      <?php if (isset($error)) { echo "<p class='text-red-500 text-center'>$error</p>"; } ?>

      <form method="POST" action="/login">
        <label class="block text-lg text-white">Email:</label>
        <input type="email" name="email" class="w-full p-3 mb-4 border border-gray-300 rounded" required>

        <label class="block text-lg text-white">Password:</label>
        <input type="password" name="password" class="w-full p-3 mb-6 border border-gray-300 rounded" required>

        <button type="submit" class="w-full bg-red-600 text-white py-3 rounded-full hover:bg-red-700 transition">
          Login
        </button>
      </form>

      <p class="text-center mt-4 text-white">Don't have an account? <a href="/register" class="text-red-600 hover:text-red-700">Register here</a></p>
    </div>
  </div>

  <script>
    const text = "Why settle for the old ways? Start better with PHP and build modern web apps faster, easier, and cleaner — only with Root-Dev.";
    const element = document.getElementById("typewriter");
    let i = 0;

    function type() {
      if (i < text.length) {
        element.innerHTML += text.charAt(i);
        i++;
        setTimeout(type, 45);
      }
    }

    window.onload = type;

    function goToLogin() {
      // Hide the welcome text and show the login form
      document.querySelector('.text-center').classList.add('hidden');
      document.getElementById('loginForm').classList.remove('hidden');
    }
  </script>

>>>>>>> 551d3d7087e4e7dc9d5f3d497e1b9601bbb4882f
</body>
</html>
