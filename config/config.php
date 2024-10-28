<?php
$host = "localhost";       // Nama host
$db   = "blog_db";         // Nama database
$user = "root";            // Nama user MySQL
$pass = "your_password";   // Password MySQL

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
