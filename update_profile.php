<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newEmail = $_POST['email'];
    
    // Update email in database
    $stmt = $conn->prepare("UPDATE user SET email = ? WHERE username = ?");
    $stmt->bind_param("ss", $newEmail, $_SESSION['username']);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Profile updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating profile.";
    }
    
    header("Location: profile.php");
    exit();
}
?>