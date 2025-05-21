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
    
    $table_check = mysqli_query($conn, "SHOW TABLES LIKE 'users'");
    if (mysqli_num_rows($table_check) == 0) {
        die("Error: The 'users' table doesn't exist in database '$database'");
    }

    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $input_username, $input_password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        $_SESSION['username'] = $user['username'];
        header('Location: profile.php');
        exit;
    } else {
        $_SESSION['error'] = "Invalid username or password. Please try again.";
        header('Location: login.php');
        exit;
    }
}
header('Location: login.php');
exit;
?>