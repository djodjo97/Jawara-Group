<?php
session_start();

if ($_POST) {
  require_once 'koneksi.php';
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Query untuk memeriksa username dan password
  $sql = "SELECT username, password,role_id FROM tb_user WHERE username = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  // Bersihkan sumber daya
  $stmt->close();
  $conn->close();

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();   // User ditemukan
    if (!password_verify($password, $user['password'])) {
      $_SESSION['message'] = "Username atau Password salah!";
      header("Location: ../login.php");
      exit();
    }

    // Set sesi
    $_SESSION['login'] = "yes";
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role_id'];

    // Arahkan berdasarkan peran
    if ($_SESSION['role'] === 1) {
      header("Location: ../dashboard.php");
    } elseif ($user['role'] === 2) {
      header("Location: ../dashboard.php");
    } else {
      header("Location: ../dashboard.php");
    }
    exit();
  } else {
    // Login gagal
    $_SESSION['message'] = "Username atau Password salah!";
    header("Location: ../login.php");
    exit();
  }
}

if (isset($_SESSION['username'])) {
  switch ($_SESSION['role']) {
    case 1:
      header("Location: dashboard.php");
      exit();
      break;
    case 2:
      header("Location: dashboard.php");
      exit();
      break;
    default:
      header("Location: dashboard.php");
      exit();
      break;
  }
}
