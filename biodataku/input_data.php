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
// Informasi koneksi ke database
$servername = "localhost"; // Ganti dengan nama server Anda
$username = "root"; // Ganti dengan nama pengguna database Anda
$password = ""; // Ganti dengan kata sandi database Anda
$dbname = "dbbiodata"; // Ganti dengan nama database Anda

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Menangani form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];
    $tanggal_lahir = $_POST["tanggal_lahir"];
    $jenis_kelamin = $_POST["jenis_kelamin"];
    $email = $_POST["email"];

    // SQL untuk menyisipkan data ke dalam tabel tbanggota
    $sql = "INSERT INTO tbanggota (nama, alamat, tanggal_lahir, jenis_kelamin, email) VALUES ('$nama', '$alamat', '$tanggal_lahir', '$jenis_kelamin', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil disimpan.";
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
    <title>Input Anggota</title>
    <style>
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
    <center><h2>Input Anggota</h2></center>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="nama">Nama:</label>
        <input type="text" name="nama" required>

        <label for="alamat">Alamat:</label>
        <input type="text" name="alamat" required>

        <label for="tanggal_lahir">Tanggal Lahir:</label>
        <input type="date" name="tanggal_lahir" required>

        <label>Jenis Kelamin:</label>
        <input type="radio" name="jenis_kelamin" value="Laki-laki" required>Laki-laki
        <input type="radio" name="jenis_kelamin" value="Perempuan" required>Perempuan

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <input type="submit" value="Simpan">
        <a href="tampilkan_data.php">Tampilkan Data</a>
    </form>
</main>
    <footer>
        <p>&copy; 2023 Halaman Saya</p>
    </footer>
</body>
</html>
