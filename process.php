<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli("localhost", "root", "", "web_lab");

    $username = $_SESSION['username'];
    $new_email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE user SET email=? WHERE username=?");
    $stmt->bind_param("ss", $new_email, $username);
    if ($stmt->execute()) {
        // Update successful, redirect to profile
        header("Location: profile.php");
        exit();
    } else {
        echo "Error updating record.";
    }
} else {
    header("Location: settings.php");
    exit();
}
