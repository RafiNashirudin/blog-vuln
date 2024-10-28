<?php
include '../config/config.php';
include '../includes/functions.php';
include '../includes/header.php';

if (!isAdmin()) {
    die("Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.");
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        $sql = "UPDATE users SET username='$username', email='$email', role='$role' WHERE id='$user_id'";
        
        if ($conn->query($sql)) {
            header('Location: admin.php');
            exit;
        } else {
            echo "Error updating user: " . $conn->error;
        }
    }

    $sql = "SELECT * FROM users WHERE id='$user_id'";
    $user = $conn->query($sql)->fetch_assoc();
} else {
    die("Invalid user ID.");
}
?>

<h1>Edit User</h1>

<form method="post">
    <label for="username">Username:</label><br>
    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br><br>

    <label for="role">Role:</label><br>
    <select name="role" required>
        <option value="user" <?php echo ($user['role'] === 'user') ? 'selected' : ''; ?>>User</option>
        <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
    </select><br><br>

    <button type="submit">Update User</button>
</form>

<a href="admin.php">Back to User Management</a>
