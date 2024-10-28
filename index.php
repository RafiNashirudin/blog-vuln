<?php
include 'config/config.php';
include 'includes/functions.php';
include 'includes/header.php';

// Ambil semua artikel dari database
$sql = "SELECT * FROM posts ORDER BY created_at DESC"; 
$result = $conn->query($sql);
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

<div class="container mt-5">
    <h1 class="text-center mb-4">Postingan Blog Terbaru</h1>

    <div class="row">
        <?php while ($post = $result->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <!-- Vulnerability 3: XSS - Outputting user data directly -->
                        <h5 class="card-title">
                            <a href="posts/view_post.php?id=<?php echo htmlspecialchars($post['id']); // Vulnerable to XSS if 'id' is tampered ?>">
                                <?php echo htmlspecialchars($post['title']); ?>
                            </a>
                        </h5>
                        <p class="card-text">
                            <?php echo htmlspecialchars(substr($post['content'], 0, 100)); ?>...
                        </p>
                        <a href="posts/view_post.php?id=<?php echo htmlspecialchars($post['id']); ?>" class="btn btn-primary">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <?php if (isLoggedIn()): ?>
        <div class="text-center mt-4">
            <a href="posts/create_post.php" class="btn btn-success">Buat Postingan Baru</a>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>


<?php include 'includes/footer.php'; ?>
