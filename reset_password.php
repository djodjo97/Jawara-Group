
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 400px;
            margin-top: 100px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn-orange {
            background-color: #F26D30; /* Warna orange sesuai gambar */
            color: white;
        }
        .btn-orange:hover {
            background-color: #d95b27;
        }
    </style>
</head>
<body>

<div class="container">
    <h3 class="text-center">Reset Password</h3>
    <p class="text-center">Masukkan password baru Anda.</p>

    <?php
    require "functions/config.php";
    
    $success = false;
    $error = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $token = $_POST["token"];
        $new_password = password_hash($_POST["password"], PASSWORD_ARGON2ID);

        // Cek token di database
        $stmt = $conn->prepare("SELECT id_user FROM tb_user WHERE reset_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Update password dan hapus token
            $stmt = $conn->prepare("UPDATE tb_user SET password = ?, reset_token = NULL WHERE reset_token = ?");
            $stmt->bind_param("ss", $new_password, $token);
            $stmt->execute();
            $success = true;
        } else {
            $error = "Token tidak valid atau kadaluarsa!";
        }
    }
    ?>

    <?php if ($success): ?>
        <div class="alert alert-success" role="alert">
            Password berhasil direset! Silakan <a href="login.php">login</a>.
        </div>
        <script>
            setTimeout(() => {
                window.location.href = "login.php";
            }, 3000);
        </script>
    <?php elseif ($error): ?>
        <div class="alert alert-danger" role="alert">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">
        
        <div class="mb-3">
            <label for="password" class="form-label">Password Baru</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password Baru" required>
        </div>
        <button type="submit" class="btn btn-orange w-100">Reset Password</button>
    </form>

    <div class="text-center mt-3">
        <a href="login.php" class="text-decoration-none">Kembali ke Login</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
