<?php
$host    = "localhost";
$uname    = "root";
$pass    = "";
$db     = "db_jawara";
$conn     = mysqli_connect($host, $uname, $pass, $db);
if (mysqli_connect_errno()) {
    echo "Koneksi Database Gagal : " . mysqli_connect_errno();
}
