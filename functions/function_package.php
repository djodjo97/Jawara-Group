<?php
require_once 'koneksi.php';

function getData($id = null)
{
  try {
    $conn = dbConnect();
    if ($id) {
      $stmt = $conn->prepare("SELECT p.*, c.category_name FROM packages p LEFT JOIN package_category c ON p.category_code=c.category_code WHERE p.package_code = ?");
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
       c.category_name FROM packages p LEFT JOIN package_category c ON p.category_code=c.category_code");
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

<<<<<<< HEAD
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
=======
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
>>>>>>> mabro
}

if (isset($_POST['add'])) {
  $dataInput = [
<<<<<<< HEAD
    'category_product'                      => $_POST['category_product'],
    'category_code'                         => $_POST['category_code'],
    'category_name'                         => $_POST['category_name'],
    'smell_type'                            => $_POST['smell_type'],
    'gender'                                => $_POST['gender'],
    'price'                                 => $_POST['price'],
    'commission'                            => $_POST['commission'],
    'ship_code'                             => $_POST['ship_code'],
    'description'                           => $_POST['description']
=======
    'package_code'  => $_POST['code'],
    'package_name'  => $_POST['name'],
    'category_code' => $_POST['catCode'],
    'gender'        => $_POST['gender'],
    'price'         => str_replace(",", ".", str_replace(".", "", $_POST['price'])),
    'commission'    => str_replace(",", ".", str_replace(".", "", $_POST['comm'])),
    'description'   => $_POST['description']
>>>>>>> mabro
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
<<<<<<< HEAD
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
=======
} elseif (isset($_GET['remove'])) {
  $code = $_GET['remove'];
  $remove = removeData($code);
>>>>>>> mabro
  session_start();
  $_SESSION['message'] = $remove;
  header("location:../package.php");
}
