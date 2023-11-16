<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Saya</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }
        nav {
            background-color: #444;
            color: #fff;
            text-align: center;
            padding: 10px;
        }
        main {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }
        nav ul li {
    display: inline-block;
    margin-right: 90px;
}
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            color: #007BFF;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        a {
            text-decoration: none;
            font-weight: bold;
            color: #007BFF;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
    <h1>PENDATAAN ANGGOTA SMK</h1>
    </header>
    <nav>
        <ul>
        <li><a href="index.html">Beranda</a></li>
            <li><a href="#">Tentang Kami</a></li>
            <li><a href="#">Layanan</a></li>
            <li><a href="input_data.php">Pendataan</a></li>
            <li><a href="#">Kontak</a></li>
        </ul>
    </nav>
    <main>
<?php
// Informasi koneksi ke database (ganti dengan informasi Anda)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbbiodata";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Mengambil ID data yang akan diedit dari parameter URL
$id = $_GET["id"];

// Mengambil data yang akan diedit dari tabel tbanggota berdasarkan ID
$sql = "SELECT * FROM tbanggota WHERE id = $id";
$result = $conn->query($sql);

//style



// Inisialisasi variabel dengan data saat ini
$nama = "";
$alamat = "";
$tanggal_lahir = "";
$jenis_kelamin = "";
$email = "";

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nama = $row["nama"];
    $alamat = $row["alamat"];
    $tanggal_lahir = $row["tanggal_lahir"];
    $jenis_kelamin = $row["jenis_kelamin"];
    $email = $row["email"];
} else {
    echo "Data tidak ditemukan.";
}

// Memproses form edit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Location: tampilkan_data.php");
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];
    $tanggal_lahir = $_POST["tanggal_lahir"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $email = $_POST["email"];

    // Menangani foto
    if (isset($_FILES["foto"])) {
        $foto = $_FILES["foto"]["name"];
        $foto_tmp = $_FILES["foto"]["tmp_name"];
        $upload_directory = "uploads/";

        // Jika ada foto baru diunggah, perbarui foto
        if (!empty($foto)) {
            // Hapus foto lama jika ada
            if (file_exists($upload_directory . $row["foto_path"])) {
                unlink($upload_directory . $row["foto_path"]);
            }

            // Pindahkan foto baru ke direktori uploads
            if (move_uploaded_file($foto_tmp, $upload_directory . $foto)) {
                $foto_path = $upload_directory . $foto;
            } else {
                echo "Gagal mengunggah foto.";
            }
        } else {
            // Jika tidak ada foto baru diunggah, gunakan foto yang sudah ada
            $foto_path = $row["foto_path"];
        }
    } else {
        // Jika tidak ada file foto yang diunggah, gunakan foto yang sudah ada
        $foto_path = $row["foto_path"];

        
    }

    // SQL untuk melakukan update data
    $sql = "UPDATE tbanggota SET nama='$nama', alamat='$alamat', tanggal_lahir='$tanggal_lahir', jenis_kelamin='$jenis_kelamin', email='$email', foto_path='$foto_path' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil diperbarui.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
// Menutup koneksi ke database
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Anggota</title>
</head>
<body>
    <h2>Edit Data Anggota</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"] . "?id=" . $id; ?>" enctype="multipart/form-data">
    
        <label for="nama">Nama:</label>
        <input type="text" name="nama" value="<?php echo $nama; ?>" required><br><br>

        <label for="alamat">Alamat:</label>
        <input type="text" name="alamat" value="<?php echo $alamat; ?>" required><br><br>

        <label for="tanggal_lahir">Tanggal Lahir:</label>
        <input type="date" name="tanggal_lahir" value="<?php echo $tanggal_lahir; ?>" required><br><br>

        <label>Jenis Kelamin:</label>
        <input type="radio" name="jenis_kelamin" value="Laki-laki" <?php echo ($jenis_kelamin == "Laki-laki") ? "checked" : ""; ?> required>Laki-laki
        <input type="radio" name="jenis_kelamin" value="Perempuan" <?php echo ($jenis_kelamin == "Perempuan") ? "checked" : ""; ?> required>Perempuan<br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $email; ?>" required><br><br>

    <!-- Tampilkan foto yang sudah ada -->
    <label for="foto">Foto saat ini:</label>
    <img src="<?php echo $row['foto_path']; ?>" alt="Foto saat ini" style="max-width: 200px;">
    <br>

    <!-- Input untuk mengganti foto -->
    <label for="foto">Ganti Foto:</label>
    <input type="file" name="foto" accept="image/*">
    <br>


        <input type="submit" value="Simpan Perubahan">
    </form>
    <br>
    <a href="input_data.php">Kembali ke Form Input</a> ||
    <a href="tampilkan_data.php">Kembali ke tampil data</a>
    <footer>
        <p>&copy; 2023 Halaman Saya</p>
    </footer>
</body>
</html>