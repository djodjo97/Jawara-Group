<?php

require_once 'koneksi.php';
include_once 'helper.php';

function getRoles()
{
  $conn = dbConnect();
  $stmt = $conn->query("SELECT * FROM roles"); //using query() without prepare()
  if (!$stmt) {
    die("Query Error: " . $conn->error); // Cek error jika query gagal
  }
  $res = $stmt->fetch_all(MYSQLI_ASSOC);
  $stmt->free();      //if using query()
  $conn->close();
  return $res;
}

function getData()
{
  $conn = dbConnect();
  $stmt = $conn->query("SELECT * FROM tb_user"); //using query() without prepare()
  if (!$stmt) {
    die("Query Error: " . $conn->error); // Cek error jika query gagal
  }
  $res = $stmt->fetch_all(MYSQLI_ASSOC);
  $stmt->free();      //if using query()
  $conn->close();
  return $res;
}

function geMitra_noUser()
{
  $conn = dbConnect();
  $stmt = $conn->query("SELECT m.* FROM tb_mitra m LEFT JOIN tb_user u ON m.id_mitra=u.code_user WHERE u.code_user is NULL "); //using query() without prepare()
  if (!$stmt) {
    die("Query Error: " . $conn->error); // Cek error jika query gagal
  }
  $res = $stmt->fetch_all(MYSQLI_ASSOC);
  $stmt->free();      //if using query()
  $conn->close();
  return $res;
}

function addData($code_user, $name, $username, $password, $role)
{
  global $conn;
  $sql     = "INSERT INTO tb_user (code_user, name, username, password, role) 
                    VALUES ('$code_user', '$name', '$username', '$password','$role')";
  $result    = mysqli_query($conn, $sql);
  return ($result) ? true : false;
  mysqli_close($conn);
}

function showData($id_user)
{
  global $conn;
  $fixid     = mysqli_real_escape_string($conn, $id_user);
  $sql     = "SELECT * FROM tb_user WHERE id_user='$fixid'";
  $result    = mysqli_query($conn, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
  mysqli_close($conn);
}

function editData($id_user, $code_user, $name, $username, $password, $role)
{
  global $conn;
  $fixid     = mysqli_real_escape_string($conn, $id_user);
  $sql     = "UPDATE tb_user SET code_user='$code_user', name='$name',  username='$username', password='$password', role='$role'
                    WHERE id_user='$fixid'";
  $result    = mysqli_query($conn, $sql);
  return ($result) ? true : false;
  mysqli_close($conn);
}

function deleteData($id_user)
{
  global $conn;
  $sql     = "DELETE FROM tb_user WHERE id_user='$id_user'";
  $result    = mysqli_query($conn, $sql);
  return ($result) ? true : false;
  mysqli_close($conn);
}

if (isset($_POST['add'])) {
  $code_user       = mysqli_real_escape_string($conn, $_POST['code_user']);
  $name            = mysqli_real_escape_string($conn, $_POST['name']);
  $username        = mysqli_real_escape_string($conn, $_POST['username']);
  $password        = mysqli_real_escape_string($conn, md5($_POST['password']));
  $role            = mysqli_real_escape_string($conn, $_POST['role']);
  $add             = addData($code_user, $name, $username, $password, $role);
  session_start();
  unset($_SESSION["message"]);
  if ($add) {
    $_SESSION['message'] = $added;
  } else {
    $_SESSION['message'] = $failed;
  }
  header("location:../user.php");
} elseif (isset($_POST['edit'])) {
  $code_user       = mysqli_real_escape_string($conn, $_POST['code_user']);
  $id_user         = mysqli_real_escape_string($conn, $_POST['id_user']);
  $name            = mysqli_real_escape_string($conn, $_POST['name']);
  $username        = mysqli_real_escape_string($conn, $_POST['username']);
  $password        = mysqli_real_escape_string($conn, md5($_POST['password']));
  $role            = mysqli_real_escape_string($conn, $_POST['role']);
  $edit            = editData($code_user, $id_user, $name, $username, $password, $role);
  session_start();
  unset($_SESSION["message"]);
  if ($edit) {
    $_SESSION['message'] = $edited;
  } else {
    $_SESSION['message'] = $failed;
  }
  header("location:../user.php");
} elseif (isset($_GET['hapus'])) {
  $id_user    = mysqli_real_escape_string($conn, $_GET['hapus']);
  $delete = deleteData($id_user);
  session_start();
  unset($_SESSION["message"]);
  if ($delete) {
    $_SESSION['message'] = $deleted;
  } else {
    $_SESSION['message'] = $failed;
  }
  header("location:../user.php");
}
