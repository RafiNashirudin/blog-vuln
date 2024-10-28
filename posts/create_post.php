<?php
include '../config/config.php';
include '../includes/functions.php';
include '../includes/header.php';

// Redirect if user is not logged in
if (!isLoggedIn()) {
    header('Location: ../users/login.php');
    exit;
}

// Initialize variables
$title = '';
$content = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user input
    $title = htmlspecialchars(trim($_POST['title']));
    $content = htmlspecialchars(trim($_POST['content']));

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO posts (title, content, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("ss", $title, $content);

    if ($stmt->execute()) {
        // Redirect to the specified page after creation
        header('Location: ' . ($_POST['redirect'] ?? '../index.php'));
        exit;
    } else {
        echo "Error creating post: " . htmlspecialchars($conn->error);
    }
}

// CSRF token for form submission
$csrf_token = bin2hex(random_bytes(32));
?>

<style>
    .btn {
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        margin-right: 10px; /* Space between buttons */
    }
    
    .btn-success {
        background-color: #4CAF50; /* Yellow for Edit */
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

<div class="container mt-5">
    <h1>Buat Postingan Baru</h1>

    <form method="post">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="content">Content:</label>
            <textarea name="content" class="form-control" required></textarea>
        </div>

        <input type="hidden" name="redirect" value="../index.php">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

        <button type="submit" class="btn btn-success">Buat Postingan</button>
    </form>

    <a href="../index.php" class="btn btn-secondary mt-3">Back to Home</a>
</div>

<?php
// Display post if an ID is provided (for authorized users)
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $postId = intval($_GET['id']);

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
            echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
        }
    } else {
        echo "Post not found.";
    }
}

// Clean up
$stmt->close();
$conn->close();
?>
