<?php
$host = "localhost";       // Nama host
$user = "root";            // Nama user MySQL
$pass = "your_password";   // Password MySQL
$db   = "blog_db";         // Nama database

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
