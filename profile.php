<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "web_lab");
$username = $_SESSION['username'];

$stmt = $conn->prepare("SELECT username, email FROM user WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<h2>Welcome, <?php echo htmlspecialchars($user['username']); ?></h2>
<p>Email: <?php echo htmlspecialchars($user['email']); ?></p>

<h3>Edit Profile</h3>
<form action="update_profile.php" method="POST">
    <label>New Email:</label><input type="email" name="email" required>
    <input type="submit" value="Update Email">
</form>

<a href="logout.php">Logout</a>
