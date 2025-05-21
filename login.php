<!DOCTYPE html>
<html>
    <head>

    </head>
<body>
<form method="post" action="process.php">
    <label for="username">Username:</label>
    <input type="text" name="username" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br>

    <input type="hidden" name="token" value="abc123">
    <input type="submit" value="Login">
</form>
</body>

</html>