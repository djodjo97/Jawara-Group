<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .btn-orange {
      background-color: #F26D30;
      color: white;
      border: none;
    }

    .btn-orange:hover {
      background-color: #d95b27;
    }
  </style>
</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header text-center">
            <h4>Lupa Password</h4>
          </div>
          <div class="card-body">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
              require "functions/config.php";

              $username = $_POST["username"];

              $stmt = $conn->prepare("SELECT id_user FROM tb_user WHERE username = ?");
              $stmt->bind_param("s", $username);
              $stmt->execute();
              $result = $stmt->get_result();

              if ($result->num_rows > 0) {
                $token = bin2hex(random_bytes(50));
                $stmt = $conn->prepare("UPDATE tb_user SET reset_token = ? WHERE username = ?");
                $stmt->bind_param("ss", $token, $username);
                $stmt->execute();

                echo '<div class="alert alert-success">Gunakan link ini untuk reset password: <a href="reset_password.php?token=' . $token . '">Reset Password</a></div>';
              } else {
                echo '<div class="alert alert-danger">Username tidak ditemukan!</div>';
              }
            }
            ?>

            <form method="POST">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan Username" required>
              </div>
              <button type="submit" class="btn btn-orange w-100">Kirim Link Reset</button>
              <div class="text-center mt-3">
                <a href="login.php" class="text-decoration-none">Kembali ke Login</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
