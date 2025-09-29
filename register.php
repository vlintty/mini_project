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
