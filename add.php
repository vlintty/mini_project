<?php
session_start();
include "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $nama  = mysqli_real_escape_string($conn, $_POST['nama_barang']); 
    $stok  = (int)$_POST['stok']; 
    $harga = (float)$_POST['harga']; 

    
    $foto = $_FILES['foto']['name'];
    $tmp  = $_FILES['foto']['tmp_name'];
    $path = null;

    if ($foto && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
       
        $fileType = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
        if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $folder = "uploads/"; 
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
            $path = $folder . time() . "_" . basename($foto); 
            if (move_uploaded_file($tmp, $path)) {
               
            } else {
                echo "<script>alert('Gagal mengupload foto!');</script>";
            }
        } else {
            echo "<script>alert('Hanya file gambar (JPG, PNG, GIF) yang diizinkan!');</script>";
        }
    }

    if ($path !== null || !$foto) { 
        $sql = "INSERT INTO barang (nama_barang, stok, harga, foto) 
                VALUES ('$nama', '$stok', '$harga', '$path')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Data barang berhasil ditambahkan!'); window.location='index.php';</script>";
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
    <title>Tambah Barang - Modern App</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet"> 
    <style>
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .input-group.full-width {
            grid-column: 1 / -1; 
        }
        @media (max-width: 600px) {
            .form-grid {
                grid-template-columns: 1fr; 
            }
        }
        
        .input-group {
            margin-bottom: 0.75rem; 
        }
    </style>
</head>
<body>
    <div class="background-animation"></div>
    <div class="form-container" id="formContainer">
        <div class="form-card">
            <h2 class="form-title">Tambah Barang Baru</h2>
            <p class="form-subtitle">Isi detail barang untuk menambahkannya</p>
            <form method="POST" enctype="multipart/form-data" id="tambahForm">
                <div class="form-grid">
                    <div class="input-group">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" id="nama_barang" name="nama_barang" placeholder="Masukkan nama barang" required>
                    </div>
                    <div class="input-group">
                        <label for="stok">Stok</label>
                        <input type="number" id="stok" name="stok" placeholder="Masukkan jumlah stok" min="0" required>
                    </div>
                    <div class="input-group">
                        <label for="harga">Harga</label>
                        <input type="number" id="harga" name="harga" placeholder="Masukkan harga (Rp)" step="0.01" min="0" required>
                    </div>
                    <div class="input-group full-width">
                        <label for="foto">Foto Barang (Opsional)</label>
                        <input type="file" id="foto" name="foto" accept="image/*">
                        <small style="color: #e3eeb2; font-size: 0.8rem;">Hanya JPG, PNG, GIF. Ukuran disarankan 300x300px.</small>
                    </div>
                </div>
                <button type="submit" name="simpan" class="btn-primary">Simpan Barang</button>
                <p class="form-link"><a href="index.php" class="btn">Kembali ke Daftar Barang</a></p>
            </form>
        </div>
    </div>

    <script>
        // Client-side validation
        document.getElementById('tambahForm').addEventListener('submit', function(e) {
            const nama = document.getElementById('nama_barang').value.trim();
            const stok = parseInt(document.getElementById('stok').value);
            const harga = parseFloat(document.getElementById('harga').value);
            const foto = document.getElementById('foto').files[0];

            if (nama.length < 3) {
                e.preventDefault();
                alert('Nama barang minimal 3 karakter.');
                return;
            }
            if (stok < 0 || isNaN(stok)) {
                e.preventDefault();
                alert('Stok harus angka positif.');
                return;
            }
            if (harga < 0 || isNaN(harga)) {
                e.preventDefault();
                alert('Harga harus angka positif.');
                return;
            }
            if (foto && !foto.type.startsWith('image/')) {
                e.preventDefault();
                alert('Hanya file gambar yang diizinkan.');
                return;
            }
        });

        // Trigger animation on load
        window.addEventListener('load', function() {
            document.getElementById('formContainer').classList.add('animate-in');
        });
    </script>
</body>
</html>
