<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "web_lab");

$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT email FROM user WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<h2>Settings</h2>
<form action="process.php" method="POST">
    <label>Username:</label>
    <input type="text" value="<?php echo htmlspecialchars($username); ?>" disabled><br>

    <label>Current Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

    <input type="submit" value="Update Email">
</form>

<a href="profile.php">Back to Profile</a>
