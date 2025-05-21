<?php
require_once 'settings.php';
session_start();

// Redirect to profile if already logged in
if (isset($_SESSION['username'])) {
    header('Location: profile.php');
    exit();
}

// Get the database connection
$conn = getDBConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Validate inputs
    if (empty($username) || empty($password)) {
        $error = "Username and password are required";
    } else {
        // Prepare SQL statement
        $stmt = $conn->prepare("SELECT username, password FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password (in real app, use password_verify() with hashed passwords)
            if ($password === $user['password']) {
                $_SESSION['username'] = $user['username'];
                header('Location: profile.php');
                exit();
            }
        }
        
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - <?php echo APP_NAME; ?></title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error)): ?>
        <p style="color:red"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="post" action="login.php">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        
        <label>Password:</label>
        <input type="password" name="password" required><br>
        
        <button type="submit">Login</button>
    </form>
</body>
</html>