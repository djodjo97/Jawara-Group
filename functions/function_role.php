<?php

require_once 'koneksi.php';

if (isset($_POST['add'])) {
  $dataInput = [
    'role_id'     =>  $_POST['idrole'],
    'rolename'    =>  $_POST['name'],
    'description' =>  $_POST['description']
  ];
  $add = addData($dataInput);
  session_start();
  unset($_SESSION["message"]);
  if ($add) {
    $_SESSION['message'] = $added;
  } else {
    $_SESSION['message'] = $failed;
  }
  header("location:../role.php");
} elseif (isset($_GET['remove'])) {
  $id_mitra = $_GET['remove'];
  $remove = removeData($id_mitra);

  session_start();
  unset($_SESSION["message"]);
  if ($remove) {
    $_SESSION['message'] = $deleted;
  } else {
    $_SESSION['message'] = $failed;
  }
  header("location:../role.php");
}


function getAllData()
{
  global $conn;
  $stmt = $conn->query("SELECT * FROM roles"); //using query() without prepare()
  if (!$stmt) {
    die("Query Error: " . $conn->error); // Cek error jika query gagal
  }
  $res = $stmt->fetch_all(MYSQLI_ASSOC);
  $stmt->free();      //if using query()
  $conn->close();
  return $res;
}

function addData($data)
{
  global $conn;
  $stmt = $conn->prepare("INSERT INTO roles (rolename, description) VALUES (?, ?)");
  $stmt->bind_param("ss",  $data['rolename'], $data['description']);
  $res = $stmt->execute();
  $stmt->close();
  $conn->close();
  return $res;
}

function removeData($id)
{
  global $conn;
  $stmt = $conn->prepare("DELETE FROM roles WHERE role_id = ?");
  $stmt->bind_param("s", $id);
  $result = $stmt->execute();
  $stmt->close();
  $conn->close();
  return $result;
}
