```markdown
# Simple Blog Application

Aplikasi ini adalah blog sederhana dengan kontrol akses untuk pengguna dan administrator. Aplikasi ini mendukung pembuatan, pengeditan, dan tampilan artikel, serta manajemen pengguna.

## Persyaratan
- PHP
- MySQL atau MariaDB
- Web Server (Apache atau NGINX)

## Langkah-langkah Setup

### 1. Clone Repository
Clone repository ini ke direktori server Anda:
```bash
git clone https://github.com/username/blog-app.git
cd blog-app
```

### 2. Buat Database MySQL

#### a. Masuk ke MySQL
Pastikan Anda sudah login ke MySQL, bisa dengan menjalankan perintah berikut di terminal:

```bash
mysql -u root -p
```

#### b. Buat Database Baru
Buat database baru untuk aplikasi ini:

```sql
CREATE DATABASE blog_db;
USE blog_db;
```

#### c. Buat Tabel untuk Users dan Posts
Jalankan perintah SQL di bawah ini untuk membuat tabel `users` dan `posts`:

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user'
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### d. Tambahkan Pengguna Awal (Opsional)
Anda bisa menambahkan pengguna awal untuk testing. Misalnya:

```sql
INSERT INTO users (username, password, email, role) VALUES
('admin', 'admin_password', 'admin@example.com', 'admin'),
('user', 'user_password', 'user@example.com', 'user');
```

**Catatan:** Pastikan mengganti `admin_password` dan `user_password` dengan password yang telah di-hash untuk keamanan lebih baik.

### 3. Konfigurasi Koneksi Database
Buka file `config.php` di root proyek dan sesuaikan pengaturan database:

```php
<?php
$host = 'localhost';       // Nama host
$db   = 'blog_db';         // Nama database
$user = 'root';            // Nama user MySQL
$pass = 'your_password';   // Password MySQL

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```

Gantilah `your_password` dengan password MySQL Anda.

### 4. Jalankan Aplikasi
- Arahkan server Anda ke direktori `blog-app`.
- Buka aplikasi di browser untuk memastikan semuanya bekerja dengan baik.

## Fitur
- Login dan Logout
- Buat, Edit, dan Hapus Artikel (untuk pengguna yang login)
- Manajemen akses untuk pengguna biasa dan administrator


Selamat mencoba!
