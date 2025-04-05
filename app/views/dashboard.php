<!-- app/views/dashboard.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <p>This is your dashboard.</p>
    <a href="/logout">Logout</a>
</body>
</html>
