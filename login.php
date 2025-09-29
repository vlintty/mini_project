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
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(120deg, #71c0bb, #4e6688);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            animation: fadeIn 1s ease-in-out;
        }

        .form-card {
            background: #2e2157;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            width: 350px;
            text-align: center;
        }

        .form-title {
            color: #fff;
            margin-bottom: 10px;
        }

        .form-subtitle {
            color: #c0c0c0;
            margin-bottom: 20px;
        }

        .input-group {
            text-align: left;
            margin-bottom: 15px;
        }

        .input-group label {
            color: #fff;
            font-size: 14px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: none;
            margin-top: 5px;
        }

        /* Tombol Login Modern */
        .btn-primary {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background: linear-gradient(135deg, #71c0bb, #4e6688);
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            margin-top: 15px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #4e6688, #71c0bb);
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0,0,0,0.3);
        }

        .btn-primary:active {
            transform: scale(0.97);
        }

        .form-link {
            margin-top: 15px;
            font-size: 14px;
            color: #fff;
        }

        .form-link a {
            color: #71c0bb;
            text-decoration: none;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
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
