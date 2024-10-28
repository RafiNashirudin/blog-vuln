<?php
include '../config/config.php';
include '../includes/functions.php';
include '../includes/header.php';

// Redirect if user is not logged in
if (!isLoggedIn()) {
    header('Location: ../users/login.php');
    exit;
}

// Validate post ID and fetch the post
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Ensure post_id is an integer

if ($post_id > 0) {
    // Use a prepared statement to fetch the post
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();

    if (!$post) {
        die("Post not found."); // Avoid revealing details about invalid IDs
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize user input
        $title = htmlspecialchars(trim($_POST['title']));
        $content = htmlspecialchars(trim($_POST['content']));

        // Use a prepared statement to update the post
        $update_stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        $update_stmt->bind_param("ssi", $title, $content, $post_id);

        if ($update_stmt->execute()) {
            // Redirect to the view post page
            header('Location: view_post.php?id=' . $post_id);
            exit;
        } else {
            echo "Error updating post."; // Generic error message to avoid information leakage
        }
    }

    // Clean up
    $stmt->close();
} else {
    die("Invalid post ID."); // This can be a generic message
}
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

    .btn-warning {
        background-color: #FFC107; /* Yellow for Edit */
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
    <h1>Edit Post</h1>

    <form method="post">
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="content">Content:</label>
            <textarea name="content" class="form-control" required><?php echo htmlspecialchars($post['content']); ?></textarea>
        </div>

        <button type="submit" class="btn btn-warning">Perbarui Posting</button>

    </form>

    <a href="../index.php" class="btn btn-secondary mt-3">Back to Home</a>
</div>
