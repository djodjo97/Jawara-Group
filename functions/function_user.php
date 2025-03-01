<?php
require_once 'koneksi.php';
include_once 'helper.php';

function getData($id = null)
{
  try {
    $conn = dbConnect();
    if ($id) {
      $stmt = $conn->prepare("SELECT u.*, r.rolename, m.name mitra_name FROM tb_user u JOIN roles r ON u.role_id = r.role_id JOIN tb_mitra m ON u.code_user = m.id_mitra WHERE u.code_user = ?");
      if (!$stmt) throw new Exception("Query Error: " . $conn->error);
      $stmt->bind_param("s", $id);
      if (!$stmt->execute()) throw new Exception("Execution Error: " . $stmt->error);
      $result = $stmt->get_result();
      $data = $result->fetch_assoc();
      $stmt->close();
    } else {
      $result = $conn->query("SELECT * FROM tb_user");
      if (!$result) throw new Exception("Query Error: " . $conn->error);
      $data = $result->fetch_all(MYSQLI_ASSOC);
      $result->free();
    }
    return $data;
  } catch (Exception $e) {
    return ['icon' => 'error', 'title' => 'Error!', 'text' => "Terjadi kesalahan: " . $e->getMessage()];
  }
}

function generateRandomPassword()
{
  $lowercase = 'abcdefghijklmnopqrstuvwxyz';
  $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $digits = '0123456789';
  $specials = '!@#$%^&*()_+{}[]:;<>,.?~\\-';
  $length = 8;

  // Ambil 1 karakter dari masing-masing kategori
  $password = $lowercase[rand(0, strlen($lowercase) - 1)] .
    $uppercase[rand(0, strlen($uppercase) - 1)] .
    $digits[rand(0, strlen($digits) - 1)] .
    $specials[rand(0, strlen($specials) - 1)];

  // Gabungkan semua karakter yang diizinkan
  $all = $lowercase . $uppercase . $digits . $specials;
  for ($i = 4; $i < $length; $i++) {
    $password .= $all[rand(0, strlen($all) - 1)];
  }

  // Acak urutan karakter
  return str_shuffle($password);
}

function addData($data)
{
  try {
    $conn = dbConnect();
    $stmt = $conn->prepare("SELECT 1 from tb_user where username = ? LIMIT 1");
    $stmt->bind_param("s", $data['username']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) throw new Exception("Username tidak tersedia!");

    $pwd = generateRandomPassword();
    $hashPwd = password_hash($pwd, PASSWORD_ARGON2ID);
    $stmt = $conn->prepare("INSERT INTO tb_user (code_user, name, username, role_id, password)  VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $data['code'], $data['name'], $data['username'], $data['role'], $hashPwd);
    $stmt->execute();
    $msg = ['icon' => 'success', 'title' => 'Success!', 'text' => 'Password berhasil diubah', 'data' => ['password' => $pwd]];
    $stmt->close();
  } catch (Exception $e) {
    $msg = ['icon' => 'error', 'title' => 'Error!', 'text' => "Terjadi kesalahan: " . $e->getMessage()];
  }
  return $msg;
}

function deleteData($code)
{
  $conn = dbConnect();
  $stmt = $conn->prepare("DELETE FROM tb_user WHERE code_user = ?");
  $stmt->bind_param("s", $code);
  if (!$stmt) die("Query Error: " . $conn->error);
  $res = $stmt->execute();
  $stmt->close();
  if ($res) return ['icon' => 'success', 'title' => 'Success!', 'text' => 'Data berhasil dihapus!'];
  else return ['icon' => 'error', 'title' => 'Error!', 'text' => 'Terjadi kesalahan: Eksekusi gagal!'];
}

if (isset($_POST['add'])) {
  $dataInput = [
    'code'      => $_POST['code'],
    'name'      => $_POST['name'],
    'username'  => $_POST['uname'],
    'role'      => $_POST['role']
  ];
  $add  = addData($dataInput);
  session_start();
  $_SESSION['message'] = $add;
  header("location:../user_form.php?id=" . $dataInput['code']);
} elseif (isset($_GET['hapus'])) {
  $code    = $_GET['hapus'];
  $delete = deleteData($code);
  session_start();
  $_SESSION['message'] = $delete;
  header("location:../user.php");
}
