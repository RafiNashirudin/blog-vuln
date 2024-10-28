<?php
session_start();

// Memeriksa apakah pengguna adalah admin
function isAdmin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

// Memeriksa apakah pengguna sudah login
function isLoggedIn() {
    return isset($_SESSION['user']);
}
?>
