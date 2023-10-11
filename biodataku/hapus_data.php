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

// Mengambil ID data yang akan dihapus dari parameter URL
$id = $_GET["id"];

// SQL untuk menghapus data berdasarkan ID
$sql = "DELETE FROM tbanggota WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil dihapus.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Menutup koneksi ke database
$conn->close();

// Mengarahkan kembali ke halaman tabel
echo '<script>window.location.href = "tampilkan_data.php";</script>';
?>
