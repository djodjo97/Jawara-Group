<?php

require_once 'koneksi.php';
include_once 'helper.php';

if (isset($_POST['add'])) {
  $dataInput = [
    'idgen'       =>  $_POST['idgen'],
    'seq'         =>  $_POST['seq'],
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
  header("location:../generation.php");
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
  header("location:../generation.php");
}


function getAllData()
{
  global $conn;
  $stmt = $conn->query("SELECT * FROM mitra_generation"); //using query() without prepare()
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
  $stmt = $conn->prepare("INSERT INTO mitra_generation (id_generation, seq, description) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $data['idgen'], $data['seq'], $data['description']);
  $res = $stmt->execute();
  $stmt->close();
  $conn->close();
  return $res;
}

function removeData($id)
{
  global $conn;
  $stmt = $conn->prepare("DELETE FROM mitra_generation WHERE id_generation = ?");
  $stmt->bind_param("s", $id);
  $result = $stmt->execute();
  $stmt->close();
  $conn->close();

  return $result;
}
