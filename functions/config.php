<?php
$host = "localhost";
$user = "root"; // Ganti sesuai dengan database lo
$pass = "";
$dbname = "db_jawara";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
