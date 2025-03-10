<?php
require_once 'koneksi.php';

function getData()
{
  $conn = dbConnect();
  $stmt = $conn->query("SELECT * FROM package_type"); //using query() without prepare()
  if (!$stmt) die("Query Error: " . $conn->error); // Cek error jika query gagal
  $res = $stmt->fetch_all(MYSQLI_ASSOC);
  $stmt->free();      //if using query()
  return $res;
}

function addData($dataInput)
{
  try {
    global $conn;
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $columns = implode(", ", array_keys($dataInput));
    $placeholders = implode(", ", array_fill(0, count($dataInput), "?"));
    $sql     = "INSERT INTO package_type ($columns) VALUES ($placeholders)";
    $stmt = $conn->prepare($sql);
    //$typeString = str_repeat("s", count($dataInput));
    $typeString = "ss";
    $params = array_values($dataInput);
    $args = array_merge([$typeString], $params);
    $refs = [];
    foreach ($args as $key => $value) {
      $refs[$key] = &$args[$key]; // Gunakan referensi untuk call_user_func_array
    }

    call_user_func_array([$stmt, 'bind_param'], $refs);
    $stmt->execute();
    $stmt->close();
    $msg = ['icon' => 'success', 'title' => 'Success!', 'text' => 'Data berhasil ditambahkan!'];
  } catch (mysqli_sql_exception $e) {
    error_log("Database Error: " . $e->getMessage());
    return;
  } catch (Exception $e) {
    $msg = ['icon' => 'error', 'title' => 'Error!', 'text' => "Terjadi kesalahan: " . $e->getMessage()];
  }
  return $msg;
}

function removeData($code)
{
  try {
    $conn = dbConnect();
    $stmt = $conn->prepare("DELETE FROM package_type WHERE type_id = ?");
    $stmt->bind_param("s", $code);
    $res = $stmt->execute();
    $stmt->close();
    return ['icon' => 'success', 'title' => 'Success!', 'text' => 'Data berhasil dihapus!'];
  } catch (mysqli_sql_exception $e) {
    error_log("Database Error: " . $e->getMessage());
    return ['icon' => 'error', 'title' => 'Error!', 'text' => 'Proses gagal! '];
  } catch (Exception $e) {
    return ['icon' => 'error', 'title' => 'Error!', 'text' => 'Terjadi kesalahan: ' . $e->getMessage()];
  }
}

if (isset($_POST['add'])) {
  $dataInput = [
    'type_name'      => $_POST['name'],
    'type_group'  => $_POST['group'] ?? 'smell'
  ];
  $add  = addData($dataInput);
  session_start();
  $_SESSION['message'] = $add;
  header("location:../product-type.php");
} elseif (isset($_GET['remove'])) {
  $code = $_GET['remove'];
  $remove = removeData($code);
  session_start();
  $_SESSION['message'] = $remove;
  header("location:../product-type.php");
}
