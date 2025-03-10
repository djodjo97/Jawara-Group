<?php
require_once 'koneksi.php';

function getData($id = null)
{
  try {
    $conn = dbConnect();
    if ($id) {
      $stmt = $conn->prepare("SELECT p.*, c.category_name, t.type_name FROM packages p LEFT JOIN package_category c ON p.category_code=c.category_code LEFT JOIN package_type t ON p.smell_type=t.type_id WHERE p.package_code = ?");
      if (!$stmt) throw new Exception("Query Error: " . $conn->error);
      $stmt->bind_param("s", $id);
      if (!$stmt->execute()) throw new Exception("Execution Error: " . $stmt->error);
      $result = $stmt->get_result();
      $data = $result->fetch_assoc();
      $stmt->close();
    } else {
      $result = $conn->query("SELECT p.*,
      CASE 
        WHEN p.gender='M' THEN 'Pria'
        WHEN p.gender='F' THEN 'Wanita' 
        ELSE 'Unisex'
      END gender_name,
       c.category_name, t.type_name FROM packages p LEFT JOIN package_category c ON p.category_code=c.category_code LEFT JOIN package_type t ON p.smell_type=t.type_id");
      if (!$result) throw new Exception("Query Error: " . $conn->error);
      $data = $result->fetch_all(MYSQLI_ASSOC);
      $result->free();
    }
    return $data;
  } catch (Exception $e) {
    return ['icon' => 'error', 'title' => 'Error!', 'text' => "Terjadi kesalahan: " . $e->getMessage()];
  }
}

function addData($dataInput)
{
  try {
    $conn = dbConnect();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $columns = implode(", ", array_keys($dataInput));
    $placeholders = implode(", ", array_fill(0, count($dataInput), "?"));
    $sql     = "INSERT INTO packages ($columns) VALUES ($placeholders)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
      die("Error prepare statement: " . $conn->error);
    }
    //$typeString = str_repeat("s", count($dataInput));
    $typeString = "sssisdds";
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
    //return;
    $msg = ['icon' => 'error', 'title' => 'Error!', 'text' => "Database Error: " . $e->getMessage()];
  } catch (Exception $e) {
    $msg = ['icon' => 'error', 'title' => 'Error!', 'text' => "Terjadi kesalahan: " . $e->getMessage()];
  }
  return $msg;
}

function removeData($code)
{
  try {
    $conn = dbConnect();
    $stmt = $conn->prepare("DELETE FROM packages WHERE package_code = ?");
    $stmt->bind_param("s", $code);
    $stmt->execute();
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
    'package_code'  => $_POST['code'],
    'package_name'  => $_POST['name'],
    'category_code' => $_POST['catCode'],
    'smell_type'    => $_POST['type'],
    'gender'        => $_POST['gender'],
    'price'         => str_replace(",", ".", str_replace(".", "", $_POST['price'])),
    'commission'    => str_replace(",", ".", str_replace(".", "", $_POST['comm'])),
    'description'   => $_POST['description']
  ];
  $add = addData($dataInput);
  session_start();
  unset($_SESSION["message"]);
  if ($add) {
    $_SESSION['message'] = $added;
  } else {
    $_SESSION['message'] = $failed;
  }
  header("location:../package.php");
} elseif (isset($_GET['remove'])) {
  $code = $_GET['remove'];
  $remove = removeData($code);
  session_start();
  $_SESSION['message'] = $remove;
  header("location:../package.php");
}
