<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "web_lab");
$username = $_SESSION['username'];
$new_email = $_POST['email'];

$stmt = $conn->prepare("UPDATE user SET email=? WHERE username=?");
$stmt->bind_param("ss", $new_email, $username);
$stmt->execute();

header("Location: profile.php");
exit();
