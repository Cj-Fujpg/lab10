<?php
session_start();
require_once 'settings.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit();
}

// Get action parameter
$action = $_POST['action'] ?? '';

switch ($action) {
    case 'login':
        handleLogin();
        break;
    case 'update_profile':
        handleProfileUpdate();
        break;
    default:
        // Invalid action
        header('Location: login.php');
        exit();
}

function handleLogin() {
    global $conn;
    
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Validate inputs
    if (empty($username) || empty($password)) {
        redirectWithError('Username and password are required');
    }
    
    // Prepare SQL statement to prevent SQL injection
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
    
    // If we get here, login failed
    redirectWithError('Invalid username or password');
}

function handleProfileUpdate() {
    global $conn;
    
    // Check if user is logged in
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }
    
    $username = $_POST['username'];
    $new_email = trim($_POST['email']);
    
    // Validate inputs
    if (empty($new_email) || !filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        redirectToProfile('0', 'Invalid email address');
    }
    
    // Verify the logged in user matches the profile being edited
    if ($username !== $_SESSION['username']) {
        redirectToProfile('0', 'Unauthorized action');
    }
    
    // Update the email in database
    $stmt = $conn->prepare("UPDATE user SET email = ? WHERE username = ?");
    $stmt->bind_param("ss", $new_email, $username);
    
    if ($stmt->execute()) {
        redirectToProfile('1', 'Profile updated successfully');
    } else {
        redirectToProfile('0', 'Failed to update profile');
    }
}

function redirectWithError($error) {
    header('Location: login.php?error=' . urlencode($error));
    exit();
}

function redirectToProfile($success, $message = '') {
    $location = 'profile.php?success=' . $success;
    if (!empty($message)) {
        $location .= '&message=' . urlencode($message);
    }
    header('Location: ' . $location);
    exit();
}