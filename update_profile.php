<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

require_once 'settings.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $new_email = trim($_POST['email']);
    
    // Verify the logged in user matches the profile being edited
    if ($username !== $_SESSION['username']) {
        header('Location: profile.php?success=0');
        exit();
    }
    
    // Update the email in database
    $stmt = $conn->prepare("UPDATE user SET email = ? WHERE username = ?");
    $stmt->bind_param("ss", $new_email, $username);
    
    if ($stmt->execute()) {
        header('Location: profile.php?success=1');
    } else {
        header('Location: profile.php?success=0');
    }
    exit();
}

// If not a POST request, redirect to profile
header('Location: profile.php');