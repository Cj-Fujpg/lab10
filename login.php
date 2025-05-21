<?php
session_start();
require_once 'settings.php'; // Assuming you have a database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT username, password FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify password (in a real app, you'd use password_verify() with hashed passwords)
        if ($password === $user['password']) {
            $_SESSION['username'] = $user['username'];
            header('Location: profile.php');
            exit();
        }
    }
    
    // If we get here, login failed
    $error = "Invalid username or password";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="post">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        
        <label>Password:</label>
        <input type="password" name="password" required><br>
        
        <button type="submit">Login</button>
    </form>
</body>
</html>