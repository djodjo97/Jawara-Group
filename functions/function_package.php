<?php

require_once 'koneksi.php';
include_once 'helper.php';

function getData()
{
  global $conn;
  $sql     = "SELECT * FROM packages";
  $result    = mysqli_query($conn, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
  mysqli_free_result($result);
  mysqli_close($conn);
}

function addData($dataInput)
{
  try {
    global $conn;
    // $sql     = "INSERT INTO packages (package_code, package_name, category_code, smell_type, gender, price, commission, ship_code, description) 
    //                 VALUES ('$package_code', '$package_name', '$category_code', '$smell_type', '$gender', '$price', '$commission', '$ship_code', '$description')";
    // $result    = mysqli_query($conn, $sql);
    // mysqli_close($conn);

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $columns = implode(", ", array_keys($dataInput));
    $placeholders = implode(", ", array_fill(0, count($dataInput), "?"));
    $sql     = "INSERT INTO packages ($columns) VALUES ($placeholders)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
      die("Error prepare statement: " . $conn->error);
    }
    //$typeString = str_repeat("s", count($dataInput));
    $typeString = "sssisddss";
    $params = array_values($dataInput);
    $args = array_merge([$typeString], $params);
    $refs = [];
    foreach ($args as $key => $value) {
      $refs[$key] = &$args[$key]; // Gunakan referensi untuk call_user_func_array
    }

    call_user_func_array([$stmt, 'bind_param'], $refs);
    $stmt->execute();
    return true;
  } catch (mysqli_sql_exception $e) {
    error_log("Database Error: " . $e->getMessage());

    // Tampilkan pesan error umum ke user
    return;
  } finally {
    // Pastikan statement dan koneksi ditutup
    if (isset($stmt) && $stmt !== false) {
      $stmt->close();
    }
    if (isset($conn) && $conn !== false) {
      $conn->close();
    }
  }
}

function showData($category_product)
{
  global $conn;
  $fixid     = mysqli_real_escape_string($conn, $category_product);
  $sql     = "SELECT * FROM packages WHERE category_product='$fixid'";
  $result    = mysqli_query($conn, $sql);
  return mysqli_fetch_all($result, MYSQLI_ASSOC);
  mysqli_close($conn);
}

function editData($category_product, $category_code, $category_name, $smell_type, $gender, $price, $commission, $ship_code, $description)
{
  global $conn;
  $fixid     = mysqli_real_escape_string($conn, $category_product);
  $sql     = "UPDATE packages SET category_product='$category_product', category_code='$category_code', category_name='$category_name',  smell_type='$smell_type', gender='$gender', price='$price', commission='$commission', ship_code='$ship_code', description='$description'
                    WHERE package_code='$fixid'";
  $result    = mysqli_query($conn, $sql);
  mysqli_close($conn);
  return ($result) ? true : false;
}

function deleteData($package_code)
{
  global $conn;
  $sql     = "DELETE FROM packages WHERE category_product='$package_code'";
  $result    = mysqli_query($conn, $sql);
  return ($result) ? true : false;
  mysqli_close($conn);
}

if (isset($_POST['add'])) {
  $dataInput = [
    'category_product'                      => $_POST['category_product'],
    'category_code'                         => $_POST['category_code'],
    'category_name'                         => $_POST['category_name'],
    'smell_type'                            => $_POST['smell_type'],
    'gender'                                => $_POST['gender'],
    'price'                                 => $_POST['price'],
    'commission'                            => $_POST['commission'],
    'ship_code'                             => $_POST['ship_code'],
    'description'                           => $_POST['description']
  ];
  $add = addData($dataInput);
  var_dump($add);
  die;
  session_start();
  unset($_SESSION["message"]);
  if ($add) {
    $_SESSION['message'] = $added;
  } else {
    $_SESSION['message'] = $failed;
  }
  header("location:../package.php");
} elseif (isset($_POST['edit'])) {
  $category_product               = mysqli_real_escape_string($conn, $_POST['category_product']);
  $category_code                  = mysqli_real_escape_string($conn, $_POST['category_code']);
  $caregory_name                  = mysqli_real_escape_string($conn, $_POST['category_name']);
  $smell_type                     = mysqli_real_escape_string($conn, $_POST['smell_type']);
  $gender                         = mysqli_real_escape_string($conn, $_POST['gender']);
  $price                          = mysqli_real_escape_string($conn, $_POST['price']);
  $commission                     = mysqli_real_escape_string($conn, $_POST['commission']);
  $ship_code                      = mysqli_real_escape_string($conn, ($_POST['ship_code']));
  $description                    = mysqli_real_escape_string($conn, $_POST['description']);

  $edit                           = editData($category_product, $category_code, $category_name, $smell_type,  $gender, $price, $commission, $ship_code, $description);
  session_start();
  unset($_SESSION["message"]);
  if ($edit) {
    $_SESSION['message'] = $edited;
  } else {
    $_SESSION['message'] = $failed;
  }
  header("location:../package.php");
} elseif (isset($_GET['hapus'])) {
  $package_code    = mysqli_real_escape_string($conn, $_GET['hapus']);
  $delete = deleteData($package_code);
  session_start();
  unset($_SESSION["message"]);
  if ($delete) {
    $_SESSION['message'] = $deleted;
  } else {
    $_SESSION['message'] = $failed;
  }
  header("location:../package.php");
}
