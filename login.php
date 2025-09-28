<?php
session_start();
include "config.php";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']); 
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Login gagal! Username atau password salah.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Modern App</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="background-animation"></div>
    <div class="form-container" id="formContainer">
        <div class="form-card">
            <h2 class="form-title">Selamat Datang</h2>
            <p class="form-subtitle">Masuk ke akun Anda</p>
            <form method="POST" id="loginForm">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                </div>
                <button type="submit" name="login" class="btn-primary">Login</button>
                <p class="form-link">Belum punya akun? <a href="register.php">Daftar sekarang</a></p>
            </form>
        </div>
    </div>

    <script>
        
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            if (username.length < 2 || password.length < 6) {
                e.preventDefault();
                alert('Username minimal 2 karakter, password minimal 6 karakter.');
            }
        });

        // Trigger animation on load
        window.addEventListener('load', function() {
            document.getElementById('formContainer').classList.add('animate-in');
        });
    </script>
</body>
</html>
