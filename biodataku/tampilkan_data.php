<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>SMKN 6 MUARO JAMBI</title>
    
</head>
<body>
    <header>
    <h1>PENDATAAN ANGGOTA SMK NEGERI 6 MUARO JAMBI</h1>
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

// Mengambil data dari tabel tbanggota
$sql = "SELECT * FROM tbanggota";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Tampil Data Anggota</title>
</head>
<body>
    <h2>Data Anggota</h2>
    
</head>
<body>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Email</th>
            <th>Foto</th>
            <th>Aksi</th> <!-- Kolom untuk tombol Edit dan Hapus -->
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["nama"] . "</td>";
                echo "<td>" . $row["alamat"] . "</td>";
                echo "<td>" . $row["tanggal_lahir"] . "</td>";
                echo "<td>" . $row["jenis_kelamin"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td><img src='" . $row["foto_path"] . "' alt='Foto' style='max-width: 100px;'></td>";

                // Tombol Edit (mengarahkan ke halaman edit_data.php)
                echo "<td><a class='edit-button' href='edit_data.php?id=" . $row["id"] . "'>Edit</a>";

                // Tombol Hapus (menggunakan JavaScript untuk konfirmasi)
                echo "<a class='delete-button' href='hapus_data.php?id=" . $row["id"] . "' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?')\">Hapus</a></td>";

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Tidak ada data anggota.</td></tr>";
        }
        ?>
    </table>
    <br>
    <a href="input_data.php">Kembali ke Form Input</a>
    </main>
    <footer>
        <p>&copy; 2023 Halaman Saya</p>
    </footer>
</body>
</html>

<?php
// Menutup koneksi ke database
$conn->close();
?>
