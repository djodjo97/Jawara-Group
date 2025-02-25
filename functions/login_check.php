<?php
session_start();
require_once 'koneksi.php';

if ($_POST) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Query untuk memeriksa username dan password
  $sql = "SELECT username, password,role_id FROM tb_user WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();   // User ditemukan
    if ($username == "Admin") {
      if (md5($password) != $user['password']) {
        $_SESSION['message'] = "Username atau Password salah!";
        header("Location: ../login.php");
        exit();
      }
    } elseif (!password_verify($password, $user['password'])) {
      $_SESSION['message'] = "Username atau Password salah!";
      header("Location: ../login.php");
      exit();
    }

    // Set sesi
    $_SESSION['login'] = "yes";
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role_id'];

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
    // $_SESSION['message'] = "<script>
    //                 $.toast({
    //                     heading: 'Login Gagal!',
    //                     text: 'Username / Password Salah!',
    //                     position: 'top-right',
    //                     hideAfter: 3500,
    //                     textAlign: 'center',
    //                     icon: 'error'
    //                 });
    //             </script>";
    $_SESSION['message'] = "Username atau Password salah!";
    header("Location: ../login.php");
    exit();
  }
  // Bersihkan sumber daya
  $stmt->close();
  $conn->close();
}
