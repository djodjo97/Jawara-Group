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
      $result = $conn->query("SELECT s.*, (ship_amount+amount)total, p.package_name, e.ship_name FROM sales_order s LEFT JOIN packages p ON s.package_code=p.package_code LEFT JOIN shipping_services e ON s.ship_code=e.ship_code");
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
    $sql = "INSERT INTO sales_order ($columns, docid) VALUES ($placeholders, CONCAT('S', LPAD((SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'db_jawara' AND TABLE_NAME = 'sales_order'), 5, '0')))";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
      die("Error prepare statement: " . $conn->error);
    }
    //$typeString = str_repeat("s", count($dataInput));
    $typeString = "sssssiissddsssss";
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
    $stmt = $conn->prepare("DELETE FROM sales_order WHERE id = ?");
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
  $dateTime = DateTime::createFromFormat('d-m-Y', $_POST['txndate']);
  $dateTime->setTime(0, 0, 0);
  if (!$dateTime) die("Format tanggal salah!");
  $formattedDate = $dateTime->format('Y-m-d H:i:s');

  $dataInput = [
    'docdate'           => $formattedDate,
    'mitra_id'          => $_POST['mitra'],
    'category_code'     => $_POST['catCode'],
    'package_code'      => $_POST['package'],
    'package_desc'      => $_POST['package_desc'] ?? NULL,
    'package_type'      => $_POST['type'],
    'qty'               => $_POST['qty'],
    'ship_code'         => $_POST['ship'],
    'tracking_number'   => $_POST['ship_num'],
    'ship_amount'       => str_replace(",", ".", str_replace(".", "", $_POST['price'])),
    'amount'            => str_replace(",", ".", str_replace(".", "", $_POST['ongkir'])),
    'leader_id'         => $leaderid ?? NULL,
    'upperid_i'         => $upperid_i ?? NULL,
    'upperid_ii'        => $upperid_ii ?? NULL,
    'upperid_iii'       => $upperid_iii ?? NULL,
    'description'       => $_POST['description']
  ];
  $add = addData($dataInput);
  session_start();
  $_SESSION['message'] = $add;
  header("location:../sales.php");
} elseif (isset($_GET['remove'])) {
  $code = $_GET['remove'];
  $remove = removeData($code);
  session_start();
  $_SESSION['message'] = $remove;
  header("location:../sales.php");
}
