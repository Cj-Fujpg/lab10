<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

require_once 'settings.php';

// Fetch user data
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT username, email FROM user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if profile was updated
$update_success = isset($_GET['success']) ? $_GET['success'] : null;
$message = isset($_GET['message']) ? $_GET['message'] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <style>
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?></h1>
    
    <?php if ($update_success !== null): ?>
        <p class="<?php echo $update_success === '1' ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </p>
    <?php endif; ?>
    
    <h2>Your Profile</h2>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
    <p>
        <strong>Email:</strong> 
        <span id="email"><?php echo htmlspecialchars($user['email']); ?></span>
        <button onclick="showEditForm()">Edit</button>
    </p>
    
    <div id="editForm" style="display:none;">
        <h3>Edit Email</h3>
        <form action="process.php" method="post">
            <input type="hidden" name="action" value="update_profile">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">
            
            <label for="email">New Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            
            <button type="submit">Save Changes</button>
            <button type="button" onclick="hideEditForm()">Cancel</button>
        </form>
    </div>
    
    <p><a href="logout.php">Logout</a></p>
    
    <script>
        function showEditForm() {
            document.getElementById('editForm').style.display = 'block';
        }
        
        function hideEditForm() {
            document.getElementById('editForm').style.display = 'none';
        }
    </script>
</body>
</html>