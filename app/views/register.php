<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="path_to_your_styles.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form action="/register" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="/login">Login here</a></p>
    </div>
</body>
</html>
