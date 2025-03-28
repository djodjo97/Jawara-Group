<?php
require 'functions/login_check.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Jawara Group</title>
  <link rel="icon" type="image/x-icon" href="img/favicon1.png" />
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Arial', sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: url('https://example.com/herbal-background.jpg') no-repeat center center/cover;
    }

    .login-container {
      background: rgba(255, 255, 255, 0.9);
      padding: 2rem;
      border-radius: 10px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 1rem;
      color: #333;
    }

    .form-group {
      margin-bottom: 1rem;
    }

    .form-group label {
      display: block;
      margin-bottom: 0.5rem;
      font-size: 0.9rem;
      color: #555;
    }

    .form-group input {
      width: 100%;
      padding: 0.8rem;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 1rem;
    }

    .form-group input:focus {
      border-color: #6a11cb;
      outline: none;
      box-shadow: 0 0 5px rgba(106, 17, 203, 0.5);
    }

    .login-btn {
      width: 100%;
      padding: 0.8rem;
      background: #f4623a;
      color: #fff;
      font-size: 1rem;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .login-btn:hover {
      background: #f4623a;
    }

    .logo {
      display: block;
      margin: 0 auto 1rem;
      width: 200px;
      height: auto;
    }

    .forgot-password {
      display: block;
      text-align: center;
      margin-top: 1rem;
      font-size: 0.9rem;
      color: #f4623a;
      text-decoration: none;
    }

    .forgot-password:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>

  <div class="login-container nav-link">
    <a href="index.html">
      <img src="img/logo_login.png" alt="Jawara Group Logo" class="logo">
    </a>
    <h2>Login</h2>
    <form action="functions/login_check.php" method="POST" class="user">
      <div class="form-group">
        <label for="email">Username</label>
        <input type="text" name="username" placeholder="Masukkan Username Anda" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Masukkan password Anda" required>
      </div>
      <button type="submit" class="login-btn">Login</button>
    </form>
    <a href="form_forgot_password.php" class="forgot-password">Lupa Password?</a>
  </div>

  <script src="vendor/sweetalert2/sweetalert2.min.js"></script>
  <?php
  // Menampilkan notifikasi jika ada pesan dari login.php
  if (isset($_SESSION['message'])) {
    echo "<script>Swal.fire({
            icon: 'error',
            title: 'Login Gagal!',
            text: '" . $_SESSION['message'] . "',
            showConfirmButton: false,
            timer: 2500
        });</script>";
    unset($_SESSION['message']);
  }
  ?>
</body>

</html>