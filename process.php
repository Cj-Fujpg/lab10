<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

if($username=='Cj'&& $password == '105927887') {
    $_SESSION['user'] = $username;
    header('Location: profile.php');
} else {
    echo "Invalid login. <a href='login.php'>Try again</a>";
}
?>