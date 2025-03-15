<?php
<<<<<<< HEAD

require_once 'koneksi.php';
include_once 'helper.php';


if (isset($_POST['add'])) {
    $dataInput = [
        'category_product' => trim(htmlspecialchars($_POST['category_product'])),
        'category_code'    => trim(htmlspecialchars($_POST['category_code'])),
        'category_name'    => trim(htmlspecialchars($_POST['category_name'])),
    ];

    $add = addData($dataInput);

    $_SESSION['message'] = $add ? "Data berhasil ditambahkan!" : "Gagal menambahkan data.";
    header("location:../category.php");
    exit;
}

if (isset($_GET['remove'])) {
    $id_mitra = trim(htmlspecialchars($_GET['remove']));
    $remove = removeData($id_mitra);

    $_SESSION['message'] = $remove ? "Data berhasil dihapus!" : "Gagal menghapus data.";
    header("location:../category.php");
    exit;
}

function getAllData()
{
    global $conn;
    $stmt = $conn->query("SELECT * FROM package_category");

    if (!$stmt) {
        die("Query Error: " . $conn->error);
    }

    $res = $stmt->fetch_all(MYSQLI_ASSOC);
    $stmt->free_result();
    return $res;
}

function addData($data)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO package_category (category_product, category_code, category_name) VALUES (?, ?, ?)");

    if (!$stmt) {
        die("Query Error: " . $conn->error);
    }

    $stmt->bind_param("sss", $data['category_product'], $data['category_code'], $data['category_name']);
    $res = $stmt->execute();

    if (!$res) {
        error_log("Insert Error: " . $stmt->error);
    }

    $stmt->close();
    return $res;
}

function removeData($id)
{
    global $conn;
    $stmt = $conn->prepare("DELETE FROM package_category WHERE category_code = ?");

    if (!$stmt) {
        die("Query Error: " . $conn->error);
    }

    $stmt->bind_param("s", $id);
    $result = $stmt->execute();

    if (!$result) {
        error_log("Delete Error: " . $stmt->error);
    }

    $stmt->close();
    return $result;
}

function getCategoryProducts()
{
    global $conn;
    $stmt = $conn->query("SELECT DISTINCT category_product FROM package_category");

    if (!$stmt) {
        die("Query Error: " . $conn->error);
    }

    $res = $stmt->fetch_all(MYSQLI_ASSOC);
    $stmt->free_result();
    return $res;
}

=======
require_once 'koneksi.php';

function getData()
{
  $conn = dbConnect();
  $stmt = $conn->query("SELECT * FROM package_category"); //using query() without prepare()
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
    $sql     = "INSERT INTO package_category ($columns) VALUES ($placeholders)";
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
    $stmt = $conn->prepare("DELETE FROM package_category WHERE category_code = ?");
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
    'category_code' =>  $_POST['code'],
    'category_name' =>  $_POST['name']
  ];
  $add = addData($dataInput);
  session_start();
  $_SESSION['message'] = $add;
  header("location:../category.php");
} elseif (isset($_GET['remove'])) {
  $code = $_GET['remove'];
  $remove = removeData($code);
  session_start();
  $_SESSION['message'] = $remove;
  header("location:../category.php");
}
>>>>>>> mabro
