<?php
include '../config/config.php';
include '../includes/functions.php';
include '../includes/header.php';

// Start the session to access session variables
session_start();

// Bypass for Broken Access Control
$post_id = $_GET['id']; 

// SQL Injection vulnerability (directly using user input in query)
$sql = "SELECT * FROM posts WHERE id = $post_id";
$result = $conn->query($sql);
$post = $result->fetch_assoc();

// Security Misconfiguration: No error handling for query execution
if (!$post) {
    die("Post not found."); // Revealing internal messages to the user
}

// Cryptographic Failure: No encryption on sensitive data
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? ''; // Storing and using plain-text passwords
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $login_sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $login_result = $conn->query($login_sql);
    if ($login_result->num_rows > 0) {
        $_SESSION['user'] = $login_result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger'>Invalid username or password.</div>";
    }
}

// SSRF Vulnerability
if (isset($_GET['url'])) {
    $url = $_GET['url']; 
    echo file_get_contents($url); 
}

// Insecure Design and Lack of Authentication
if (isset($_POST['delete']) && isset($_SESSION['user'])) { // Check if the user is logged in
    $delete_sql = "DELETE FROM posts WHERE id = $post_id"; // SQL Injection possible here too
    $conn->query($delete_sql);
    header('Location: ../index.php');
    exit;
}

// Handle post edit redirection
if (isset($_POST['edit']) && isset($_SESSION['user'])) { // Check if the user is logged in
    header("Location: edit_post.php?id=$post_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <style>
        .post-container {
        margin: 20px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f9f9f9;
    }

    .button-group {
        margin-top: 15px;
    }

    .btn {
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        margin-right: 10px; /* Space between buttons */
    }

    .btn-warning {
        background-color: #FFC107; /* Yellow for Edit */
        color: white;
    }

    .btn-danger {
        background-color: #F44336; /* Red for Delete */
        color: white;
    }

    .btn-secondary {
        background-color: #6c757d; /* Gray for Back */
        color: white;
    }

    .btn:hover {
        opacity: 0.9; /* Slightly darker on hover */
    }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="post-container">
        <h1><?php echo htmlspecialchars($post['title']); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>

        <?php if (isset($_SESSION['user'])): // Only show buttons if user is logged in ?>
            <form method="post" style="display:inline;">
                <button type="submit" name="edit" class="btn btn-primary btn-warning">Edit Post</button>
            </form>
            <form method="post" style="display:inline;">
                <button type="submit" name="delete" class="btn btn-danger btn-custom" onclick="return confirm('Apa kamu yakin?')">Hapus Post</button>
            </form>
        <?php endif; ?>

        <!-- Kembali ke Menu Button -->
        <a href="../index.php" class="btn btn-secondary">Kembali</a>
    </div>
</div>


<?php include '../includes/footer.php'; ?>
</body>
</html>
