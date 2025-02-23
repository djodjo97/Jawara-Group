<?php
session_start();
require_once 'koneksi.php';

unset($_SESSION['message']);

if ($_POST) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $encrypted = md5($password);

    // Query untuk memeriksa username dan password
    $sql = "SELECT * FROM tb_user WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $encrypted);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User ditemukan
        $user = $result->fetch_assoc();

        // Set sesi
        $_SESSION['login'] = "yes";
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Arahkan berdasarkan peran
        if ($user['role'] === '1') {
            header("Location: ../dashboard.php");
        } elseif ($user['role'] === '2') {
            header("Location: ../dashboard.php");
        } else {
            header("Location: ../dashboard.php");
        }
        exit();
    } else {
        // Login gagal
        $_SESSION['message'] = "<script>
                    $.toast({
                        heading: 'Login Gagal!',
                        text: 'Username / Password Salah!',
                        position: 'top-right',
                        hideAfter: 3500,
                        textAlign: 'center',
                        icon: 'error'
                    });
                </script>";
        header("Location: ../login.php");
        exit();
    }
    // Bersihkan sumber daya
    $stmt->close();
    $conn->close();
}
