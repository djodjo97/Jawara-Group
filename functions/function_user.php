<?php
require_once 'koneksi.php';
include_once 'helper.php';

function getData($id = null)
{
  try {
    $conn = dbConnect();

    if ($id) {
      $stmt = $conn->prepare("SELECT * FROM tb_user WHERE code_user = ?");
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

function getMitra_noUser()
{
  try {
    $conn = dbConnect();
    if (!$conn) throw new Exception("Koneksi database gagal.");
    $result = $conn->query("SELECT m.* FROM tb_mitra m LEFT JOIN tb_user u ON m.id_mitra=u.code_user WHERE u.code_user is NULL "); //using query() without prepare()
    if (!$result) throw new Exception("Query Error: " . $conn->error);
    $res = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();      //if using query()
    return $res;
  } catch (Exception $e) {
    return ['icon' => 'error', 'title' => 'Error!', 'text' => "Terjadi kesalahan: " . $e->getMessage()];
  }
}

function addData($data)
{
  $conn = dbConnect();
  $stmt = $conn->prepare("INSERT INTO tb_user (code_user, name, username, role)  VALUES (?, ?, ?)");
  $stmt->bind_param("sssi", $data['code'], $data['name'], $data['username'], $data['role']);
  $res = $stmt->execute();
  $stmt->close();
  $conn->close();
  return $res;
}

function deleteData($code)
{
  $conn = dbConnect();
  $stmt = $conn->prepare("SELECT * FROM tb_user WHERE code_user = ?");
  $stmt->bind_param("s", $code);
  if ($stmt === false) die("Query Error: " . $conn->error);
  $res = $stmt->execute();
  $stmt->close();
  $conn->close();
  return $res;
}

if (isset($_POST['add'])) {
  $dataInput = [
    'code'      => $_POST['code'],
    'name'      => $_POST['name'],
    'username'  => $_POST['username'],
    'role'      => $_POST['role']
  ];
  $add  = addData($dataInput);
  session_start();
  unset($_SESSION["message"]);
  if ($add) {
    $_SESSION['message'] = $added;
  } else {
    $_SESSION['message'] = $failed;
  }
  header("location:../user.php");
} elseif (isset($_GET['hapus'])) {
  $code    = $_GET['hapus'];
  $delete = deleteData($code);
  session_start();
  unset($_SESSION["message"]);
  $_SESSION['message'] = $delete ? $deleted : $failed;
  header("location:../user.php");
}
