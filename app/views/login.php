<!-- app/views/login.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    
    <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    
    <form method="POST" action="/login">
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        
        <button type="submit">Login</button>
    </form>
    
    <p>Don't have an account? <a href="/register">Register here</a></p>
</body>
</html>
