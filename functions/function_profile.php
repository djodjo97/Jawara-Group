<?php
require_once 'koneksi.php';
include_once 'helper.php';

function getData()
{
  $conn = dbConnect();
  $stmt = $conn->prepare("SELECT u.*, rolename FROM tb_user u JOIN roles r ON u.role_id=r.role_id WHERE u.username = ?");
  $stmt->bind_param("s", $_SESSION['username']);
  if ($stmt === false) die("Query Error: " . $conn->error); // Cek error jika query gagal
  $stmt->execute();
  $result = $stmt->get_result();
  $data = $result->fetch_assoc();
  $stmt->close();
  // $conn->close();
  return $data;
}

function updateProfile($data)
{
  try {
    $conn = dbConnect();
    $stmt = $conn->prepare("UPDATE tb_user SET name = ?, username = ? where username = ?");
    if (!$stmt) throw new Exception("Query Error: " . $conn->error);
    $stmt->bind_param("sss", $data['name'], $data['uname'], $_SESSION['username']);
    if (!$stmt->execute()) {
      throw new Exception("Execution Error: " . $stmt->error);
    } else {
      $msg = ['icon' => 'success', 'title' => 'Success!', 'text' => 'Data berhasil diubah'];
    }
    $stmt->close();
    $conn->close();
  } catch (mysqli_sql_exception $e) {
    // Tangkap error MySQLi dan tampilkan pesan yang lebih informatif
    $msg = ['icon' => 'error', 'title' => 'Error!', 'text' => "SQL Error: " . $e->getMessage()];
  } catch (Exception $e) {
    $msg = ['icon' => 'error', 'title' => 'Error!', 'text' => "Terjadi kesalahan: " . $e->getMessage()];
  }
  return $msg;
}

function changePwd($newPwd, $id)
{
  try {
    $conn = dbConnect();
    if (!$conn->ping()) {
      throw new Exception("❌ Koneksi database sudah ditutup!");
    }
    $stmt = $conn->prepare("UPDATE tb_user SET password = ? WHERE id_user = ?");
    if (!$stmt) throw new Exception("Query Error: " . $conn->error);
    $stmt->bind_param("ss", $newPwd, $id);

    if (!$stmt->execute()) {
      throw new Exception("Execution Error: " . $stmt->error);
    } else {
      $msg = ['icon' => 'success', 'title' => 'Success!', 'text' => 'Password berhasil diubah'];
    }
    $stmt->close();
    $conn->close();
  } catch (Exception $e) {
    $msg = ['icon' => 'error', 'title' => 'Error!', 'text' => "Terjadi kesalahan: " . $e->getMessage()];
  }
  return $msg;
}

function isValidPassword($pwd)
{
  if (strlen($pwd) < 8) {
    return ['error' => '0', 'msg' => "Password harus memiliki minimal 8 karakter"];
  }
  /// Cek minimal satu huruf besar
  if (!preg_match('/[A-Z]/', $pwd)) {
    return ['error' => '1', 'msg' => "Password harus mengandung minimal satu huruf besar (A-Z)"];
  }

  // Cek minimal satu huruf kecil
  if (!preg_match('/[a-z]/', $pwd)) {
    return ['error' => '2', 'msg' => "Password harus mengandung minimal satu huruf kecil (a-z)"];
  }

  // Cek minimal satu angka
  if (!preg_match('/[0-9]/', $pwd)) {
    return ['error' => '3', 'msg' => "Password harus mengandung minimal satu angka (0-9)"];
  }

  // Cek minimal satu karakter spesial
  if (!preg_match('/[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/', $pwd)) {
    return ['error' => '4', 'msg' => "Password harus mengandung minimal satu karakter spesial (!@#$%^&*()_+{}[]:;<>,.?~\\/-)"];
  }

  // Cek karakter tidak diizinkan
  if (preg_match_all('/[^a-zA-Z0-9!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/', $pwd, $matches) && !empty($matches[0])) {
    $invalidChars = array_unique($matches[0]);
    return ['error' => '5', 'msg' => "( " . implode(', ', $invalidChars) . " ) tidak diizinkan!"];
  }

  // Cek tiga karakter yang sama berturut-turut
  if (preg_match('/(.)\1{2,}/', $pwd)) {
    return ['error' => '6', 'msg' => "Tidak boleh ada tiga karakter berulang berturut-turut!"];
  }

  // Cek pola tiga karakter yang berulang
  $length = strlen($pwd);
  for ($i = 0; $i < $length - 2; $i++) {
    $pattern = substr($pwd, $i, 3);
    if (substr_count($pwd, $pattern) > 1) {
      return ['error' => '7', 'msg' => "Tidak boleh ada pola tiga karakter yang berulang dalam password!"];
    }
  }
  return true;
}

if (isset($_POST['update'])) {
  $dataInput = [
    'name' => $_POST['name'],
    'uname' => $_POST['uname']
  ];
  session_start();
  $res = updateProfile($dataInput);
  $_SESSION['message'] = $res;
  header("location:../profile.php");
  exit;
} elseif (isset($_POST['chPwd'])) {
  $pwd = $_POST['pwd'];
  $newPwd = $_POST['newPwd'];
  $confPwd = $_POST['confPwd'];

  session_start();
  $user = getData($_SESSION['username'], 'username');
  $msgPwd = [
    'pwd' => ['val' => $pwd, 'text' => null],
    'newPwd' => ['val' => $newPwd, 'text' => null],
    'confPwd' => ['val' => $confPwd, 'text' => null]
  ];
  if (!$pwd) $msgPwd['pwd']['text'] = "Isi Password!";
  if (!$newPwd) $msgPwd['newPwd']['text'] = "Isi Password!";
  if (!$confPwd) $msgPwd['confPwd']['text'] = "Isi Password Konfirmasi!";

  if (isset($msgPwd['pwd']['text']) || isset($msgPwd['newPwd']['text']) || isset($msgPwd['confPwd']['text'])) {
    $_SESSION['message'] = $msgPwd;
    header("location:../profile.php");
    exit;
  }

  if ($user['username'] == "Admin") {
    if (md5($pwd) != $user['password']) {
      $msgPwd['pwd']['text'] = "Password salah!";
      $_SESSION['message'] = $msgPwd;
      header("location:../profile.php");
      exit;
    }
  } else {
    if (password_verify($pwd, $user['password'])) {
      $msgPwd['pwd']['text'] = "Password salah!";
      $_SESSION['message'] = $msgPwd;
      header("location:../profile.php");
      exit;
    }
  }

  $valid = isValidPassword($newPwd);

  if ($valid !== true) {
    $msgPwd['newPwd']['text'] = "Password tidak Diizinkan!";
    $_SESSION['message'] = $msgPwd;
    header("location:../profile.php");
    exit;
  }

  if ($newPwd != $confPwd) {
    $msgPwd['confPwd']['text'] = "Password tidak sama!";
    $_SESSION['message'] = $msgPwd;
    header("location:../profile.php");
    exit;
  }

  $hashPwd = password_hash($newPwd, PASSWORD_ARGON2ID);
  $res = changePwd($hashPwd, $user['id_user']);
  $_SESSION['message'] = $res;
  header("location:../profile.php");
}
