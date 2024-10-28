<?php
include '../config/config.php';
include '../includes/functions.php';
include '../includes/header.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
?>

<div class="container mt-5">
    <h1 class="text-center">Selamat datang, <?php echo htmlspecialchars($user['username']); ?> <!-- username --> </h1>

    <div class="card">
        <div class="card-header">
        Profil Anda
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Username: <?php echo htmlspecialchars($user['username']); ?></li>
            <li class="list-group-item">Email: <?php echo htmlspecialchars($user['email']); ?></li>
            <li class="list-group-item">Role: <?php echo htmlspecialchars($user['role']); ?></li>
        </ul>
    </div>

    <div class="text-center mt-4">

        <a href="../index.php" class="btn btn-secondary">Kembali ke Beranda</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
