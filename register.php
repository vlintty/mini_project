<?php
include "config.php";

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']); 
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check_sql = "SELECT * FROM users WHERE username='$username'";
    $check_result = mysqli_query($conn, $check_sql);
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Username sudah terdaftar!');</script>";
    } else {
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Registrasi berhasil!'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Modern App</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="background-animation"></div>
    <div class="form-container" id="formContainer">
        <div class="form-card">
            <h2 class="form-title">Buat Akun Baru</h2>
            <p class="form-subtitle">Daftar untuk memulai</p>
            <form method="POST" id="registerForm">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password (min. 6 karakter)" required>
                </div>
                <button type="submit" name="register" class="btn-primary">Daftar</button>
                <p class="form-link">Sudah punya akun? <a href="login.php">Masuk sekarang</a></p>
            </form>
        </div>
    </div>

    <script>
        
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            if (username.length < 2 || password.length < 6) {
                e.preventDefault();
                alert('Username minimal 2 karakter, password minimal 6 karakter.');
            }
        });

        
        window.addEventListener('load', function() {
            document.getElementById('formContainer').classList.add('animate-in');
        });
    </script>
</body>
</html>
