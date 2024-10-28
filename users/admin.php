<?php
include '../config/config.php';
include '../includes/functions.php';
include '../includes/header.php';

if (!isAdmin()) {
    die("Access denied. You do not have permission to access this page.");
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $conn->query("DELETE FROM users WHERE id='$delete_id'");
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        /* body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        } */
        h1 {
            color: #333;
            text-align: center;
        }
        p {
            text-align: center;
            color: #555;
        }
        .table-container {
            max-width: 800px; /* Lebar maksimum kontainer */
            margin: 20px auto; /* Pusatkan kontainer */
            padding: 20px; /* Padding di dalam kontainer */
            background-color: #fff; /* Warna latar belakang kontainer */
            border-radius: 8px; /* Membuat sudut kontainer membulat */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Bayangan kontainer */
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        a {
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>Manage Users</h1>
<p>Sebagai admin, Anda dapat menambah, mengedit, atau menghapus pengguna dari halaman ini.</p>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td>
                    <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a>
                    <a href="?delete_id=<?php echo $user['id']; ?>" onclick="return confirm('Apa kamu yakin?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<a class="back-link" href="../index.php">Back to Home</a>

</body>
</html>


