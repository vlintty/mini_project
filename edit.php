<?php
session_start();
include "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$id = (int)$_GET['id']; // Sanitize ID
$result = mysqli_query($conn, "SELECT * FROM barang WHERE id=$id");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>alert('Barang tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

if (isset($_POST['update'])) {
    $nama  = mysqli_real_escape_string($conn, $_POST['nama_barang']); // Basic escape
    $stok  = (int)$_POST['stok']; // Cast to int
    $harga = (float)$_POST['harga']; // Cast to float

    $path = $row['foto']; // Default to old photo

    // Check if new file uploaded
    if ($_FILES['foto']['name'] && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto']['name'];
        $tmp  = $_FILES['foto']['tmp_name'];
        
        // Basic validation: Image type and size (e.g., max 5MB)
        $fileType = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
        $fileSize = $_FILES['foto']['size'];
        if (in_array($fileType, ['jpg', 'jpeg', 'png', 'gif']) && $fileSize <= 5000000) {
            $folder = "uploads/";
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
            $newPath = $folder . time() . "_" . basename($foto); // Unique name
            if (move_uploaded_file($tmp, $newPath)) {
                // Delete old photo if exists
                if ($row['foto'] && file_exists($row['foto'])) {
                    unlink($row['foto']);
                }
                $path = $newPath;
            } else {
                echo "<script>alert('Gagal mengupload foto baru!');</script>";
                exit;
            }
        } else {
            echo "<script>alert('Hanya file gambar (JPG, PNG, GIF) dengan ukuran max 5MB yang diizinkan!');</script>";
            exit;
        }
    }

    // Update query
    $sql = "UPDATE barang 
            SET nama_barang='$nama', stok='$stok', harga='$harga', foto='$path' 
            WHERE id=$id";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data barang berhasil diperbarui!'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - Modern App</title>
    <link rel="stylesheet" href="style.css">
    <!-- Optional: Google Fonts for modern look (uncomment if desired) -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet"> -->
</head>
<body>
    <div class="background-animation"></div>
    <div class="form-container" id="formContainer">
        <div class="form-card">
            <h2 class="form-title">Edit Barang</h2>
            <p class="form-subtitle">Ubah detail barang yang ada</p>
            <form method="POST" enctype="multipart/form-data" id="editForm">
                <div class="input-group">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang" value="<?= htmlspecialchars($row['nama_barang']); ?>" placeholder="Masukkan nama barang" required>
                </div>
                <div class="input-group">
                    <label for="stok">Stok</label>
                    <input type="number" id="stok" name="stok" value="<?= $row['stok']; ?>" placeholder="Masukkan jumlah stok" min="0" required>
                </div>
                <div class="input-group">
                    <label for="harga">Harga</label>
                    <input type="number" id="harga" name="harga" value="<?= $row['harga']; ?>" placeholder="Masukkan harga (Rp)" step="0.01" min="0" required>
                </div>
                <div class="input-group">
                    <label>Foto Saat Ini</label>
                    <?php if ($row['foto'] && file_exists($row['foto'])): ?>
                        <div class="image-preview">
                            <img src="<?= htmlspecialchars($row['foto']); ?>" alt="Foto Barang Saat Ini" style="max-width: 150px; max-height: 150px; border-radius: 8px; border: 2px solid #71c0bb;">
                            <small style="color: #e3eeb2; display: block; margin-top: 5px;">Foto akan diganti jika upload baru.</small>
                        </div>
                    <?php else: ?>
                        <div class="image-preview">
                            <span style="color: #ccc; font-style: italic;">Tidak ada foto</span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="input-group">
                    <label for="foto">Foto Barang Baru (Opsional)</label>
                    <input type="file" id="foto" name="foto" accept="image/*">
                    <small style="color: #e3eeb2; font-size: 0.8rem;">Hanya JPG, PNG, GIF. Ukuran max 5MB. Biarkan kosong untuk mempertahankan foto lama.</small>
                </div>
                <button type="submit" name="update" class="btn-primary">Update Barang</button>
                <p class="form-link"><a href="index.php" class="btn">Kembali ke Daftar Barang</a></p>
            </form>
        </div>
    </div>

    <script>
        // Client-side validation
        document.getElementById('editForm').addEventListener('submit', function(e) {
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
            if (foto && foto.size > 5000000) {
                e.preventDefault();
                alert('Ukuran file max 5MB.');
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
