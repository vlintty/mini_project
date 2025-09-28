<?php
session_start();
include "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $result = mysqli_query($conn, "SELECT * FROM barang WHERE nama_barang LIKE '%$search%'");
} else {
    $result = mysqli_query($conn, "SELECT * FROM barang");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #71C0BB, #4E6688);
            margin: 0;
            padding: 0;
        }
        .container {
            width: 85%;
            margin: 40px auto;
            background: #2e2b4f;
            color: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.4);
        }
        .header {
            display: flex;
            justify-content: space-between; 
            align-items: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
        }
        .header-right {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            background: #cde67f;
            color: #000;
            font-weight: bold;
        }
        .btn-danger {
            background: #e74c3c;
            color: #fff;
        }
        .search-box {
            margin: 15px 0;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .search-box input {
            padding: 7px;
            width: 250px;
            border-radius: 6px;
            border: none;
        }
        .search-box button {
    padding: 7px 12px;
    border: none;
    border-radius: 6px;
    background: #cde67f;
    font-weight: bold;
    cursor: pointer;
    width: auto;      
    min-width: unset;  
}

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: #3d3a63;
            border-radius: 10px;
            overflow: hidden;
        }
        table th, table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #555;
        }
        table th {
            background: #5cc6b0;
            color: #000;
        }
        table tr:hover {
            background: rgba(255,255,255,0.05);
        }
        img {
            max-width: 60px;
            max-height: 60px;
            border-radius: 8px;
        }
        a {
            color: #f1c40f;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <h2>Selamat datang, <?= $_SESSION['username']; ?>!</h2>
        <div class="header-right">
            <a href="add.php" class="btn">+ Tambah Barang</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <form method="GET" class="search-box">
        <input type="text" name="search" placeholder="Cari barang..." value="<?= $search ?>">
        <button type="submit">Search</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Foto</th>
            <th>Nama Barang</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td>
                <?php if (!empty($row['foto'])): ?>
                    <img src="<?= $row['foto']; ?>" alt="foto barang">
                <?php else: ?>
                    <span style="color:#ccc;">-</span>
                <?php endif; ?>
            </td>
            <td><?= $row['nama_barang']; ?></td>
            <td><?= $row['stok']; ?></td>
            <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id']; ?>">Edit</a> | 
                <a href="delete.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>
