<?php

require_once 'koneksi.php';
include_once 'helper.php';

function getData($id = null)
{
  global $conn;
  if ($id) {
    $stmt = $conn->prepare("SELECT * FROM tb_mitra WHERE id_mitra = ?");
    $stmt->bind_param("s", $id);
  } else {
    $stmt = $conn->prepare("SELECT * FROM tb_mitra");
  }
  if ($stmt === false) {
    die("Query Error: " . $conn->error); // Cek error jika query gagal
  }
  $stmt->execute();
  $result = $stmt->get_result();

  if ($id) $data = $result->fetch_assoc();
  else $data = $result->fetch_all(MYSQLI_ASSOC);
  $stmt->close();
  $conn->close();
  return $data;
}

function addData($dataInput)
{
  try {
    global $conn;
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $columns = implode(", ", array_keys($dataInput));
    $placeholders = implode(", ", array_fill(0, count($dataInput), "?"));
    $sql     = "INSERT INTO tb_mitra ($columns) VALUES ($placeholders)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
      die("Error prepare statement: " . $conn->error);
    }
    //$typeString = str_repeat("s", count($dataInput));
    $typeString = "sisssssssssssiii";
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

function deleteData($id_mitra)
{
  global $conn;
  $sql     = "DELETE FROM tb_mitra WHERE id_mitra='$id_mitra'";
  $result    = mysqli_query($conn, $sql);
  return ($result) ? true : false;
  mysqli_close($conn);
}

if (isset($_POST['add'])) {
  $dataInput = [
    'id_mitra'             => $_POST['idmitra'],
    'registration_number'  => $_POST['regnum'],
    'name'                 => $_POST['name'],
    'email'                => $_POST['email'],
    'phone'                => $_POST['phone'],
    'address'              => $_POST['address'],
    'gen_id'               => $_POST['gen'] ?? null,
    'ktp'                  => $_POST['ktp'],
    'sim'                  => $_POST['sim'],
    'leader_id'            => $_POST['leader'],
    'upper_i'              => $_POST['up_i'],
    'upper_ii'             => $_POST['up_ii'],
    'upper_iii'            => $_POST['up_iii'],
    'bonus_i'              => $_POST['bonus_i'],
    'bonus_ii'             => $_POST['bonus_ii'],
    'bonus_iii'            => $_POST['bonus_iii'] ?? NULL
  ];
  $add  = addData($dataInput);
  session_start();
  unset($_SESSION["message"]);
  if ($add) {
    $_SESSION['message'] = $added;
  } else {
    $_SESSION['message'] = $failed;
  }
  header("location:../mitra_form.php?id=" . $dataInput['id_mitra']);
  exit;
} elseif (isset($_GET['hapus'])) {
  $id_mitra    = mysqli_real_escape_string($conn, $_GET['hapus']);
  $delete = deleteData($id_mitra);
  session_start();
  unset($_SESSION["message"]);
  if ($delete) {
    $_SESSION['message'] = $deleted;
  } else {
    $_SESSION['message'] = $failed;
  }
  header("location:../mitra.php");
}
