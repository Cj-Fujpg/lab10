<?php
session_start();
require_once("settings.php");

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $input_password = trim($_POST['password']);

    if (empty($input_username) || empty($input_password)) {
        $_SESSION['error'] = "Please enter both username and password";
        header('Location: login.php');
        exit;
    }

    $query = "SELECT username, password, email FROM user WHERE username = '$input_username'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        $_SESSION['error'] = "Database error occurred";
        header('Location: login.php');
        exit;
    }

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        if ($input_password === $user['password']) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            session_regenerate_id(true);
            header('Location: profile.php');
            exit;
        }
    }
    
    $_SESSION['error'] = "Invalid username or password";
    header('Location: login.php');
    exit;
}

header('Location: login.php');
exit;
?>