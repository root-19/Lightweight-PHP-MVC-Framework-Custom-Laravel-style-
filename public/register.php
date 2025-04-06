<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <link rel="stylesheet" href="../../resources/css/app.css" />
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Register</h2>

    <form action="/register" method="POST" class="space-y-4">
      <div>
        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
        <input type="text" name="username" id="username" required
               class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" id="email" required
               class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" name="password" id="password" required
               class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500" />
      </div>

      <button type="submit"
              class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
        Register
      </button>
    </form>

    <p class="text-center text-sm text-gray-600 mt-4">
      Already have an account?
      <a href="/login" class="text-blue-600 hover:underline">Login here</a>
    </p>
  </div>

</body>
</html>
