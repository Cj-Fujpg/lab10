<?php
session_start();
require_once("settings.php");

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
    }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_username = trim($_POST['username']);
    $input_password = trim($_POST['password']);
    
    $table_check = mysqli_query($conn, "SHOW TABLES LIKE 'user'");
    if (mysqli_num_rows($table_check) == 0) {
        die("Error: The 'user' table doesn't exist in database '$database'");
    }

    $query = "SELECT * FROM user WHERE username = '$input_username'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        if ($input_password === $user['password']) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
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