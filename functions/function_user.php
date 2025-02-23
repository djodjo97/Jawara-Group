<?php
require_once 'koneksi.php';
include_once 'helper.php';

function getData($id = null)
{
  $conn = dbConnect();
  if ($id) {
    $stmt = $conn->prepare("SELECT * FROM tb_user WHERE code_user = ?");
    $stmt->bind_param("s", $id);
  } else {
    $stmt = $conn->prepare("SELECT * FROM tb_user");
  }
  if ($stmt === false) die("Query Error: " . $conn->error); // Cek error jika query gagal
  $stmt->execute();
  $result = $stmt->get_result();

  if ($id) $data = $result->fetch_assoc();
  else $data = $result->fetch_all(MYSQLI_ASSOC);
  $stmt->close();
  $conn->close();
  return $data;
}

function getMitra_noUser()
{
  $conn = dbConnect();
  $stmt = $conn->query("SELECT m.* FROM tb_mitra m LEFT JOIN tb_user u ON m.id_mitra=u.code_user WHERE u.code_user is NULL "); //using query() without prepare()
  if (!$stmt) die("Query Error: " . $conn->error); // Cek error jika query gagal
  $res = $stmt->fetch_all(MYSQLI_ASSOC);
  $stmt->free();      //if using query()
  $conn->close();
  return $res;
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

// function showData($id_user)
// {
//   global $conn;
//   $fixid     = mysqli_real_escape_string($conn, $id_user);
//   $sql     = "SELECT * FROM tb_user WHERE id_user='$fixid'";
//   $result    = mysqli_query($conn, $sql);
//   return mysqli_fetch_all($result, MYSQLI_ASSOC);
//   mysqli_close($conn);
// }

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
