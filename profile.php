<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
</head>
<body>
    <header>
        <h1>Welcome to My Website</h1>
    <hr>
</header>


<?php
session_start();

if (isset($_SESSION['user'])) {
    echo "Welcome, ".$_SESSION['user'];
} else {
    header('Location: login.php');
}
?>


<footer>
    <p>&copy; 2025 My Website. All rights reserved.</p>
</footer>
</body>
</html> 