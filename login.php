<?php
session_start();
$conn = new mysqli("localhost", "root", "", "web_lab");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE username=? AND password=?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['username'] = $username;
        header("Location: profile.php");
        exit();
    } else {
        echo "Invalid credentials.";
    }
}
?>

<form method="POST">
    <label>Username:</label><input type="text" name="username" required><br>
    <label>Password:</label><input type="password" name="password" required><br>
    <input type="submit" value="Login">
</form>
