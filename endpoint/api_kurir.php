<?php
header('Content-Type: application/json');

require_once '../functions/koneksi.php';

$method = $_SERVER["REQUEST_METHOD"];

switch ($method) {
  case "GET":
    getShipping();
    break;
  case "PATCH":
    updateShipping();
    break;
  default:
    response(405, "Method Not Allowed");
}

function response($status, $message, $data = null)
{
  http_response_code($status);
  echo json_encode(["status" => $status, "message" => $message, "data" => $data]);
  exit();
}

function getShipping()
{
  global $conn;
  //$input = json_decode(file_get_contents('php://input'), true);
  $dataId = $_GET["id"] ?? null;

  if ($dataId) {
    $stmt = $conn->prepare("SELECT * FROM  shipping_services WHERE ship_code = ?");
    $stmt->bind_param("s", $dataId);
  } else {
    $stmt = $conn->prepare("SELECT * FROM shipping_services");
  }

  if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
      if ($dataId) $data = $result->fetch_assoc();
      else $data = $result->fetch_all(MYSQLI_ASSOC);

      response(200, "Success", $data);
    } else {
      response(500, "Gagal mengambil data!");
    }
  } else {
    response(500, "Gagal menyiapkan query!");
  }

  $stmt->close();
  $conn->close();
}

function updateShipping()
{
  global $conn;
  $input = json_decode(file_get_contents("php://input"), true);
  $id = $_GET["id"] ?? null;

  if (!$id) {
    response(400, "Bad Request: ID are required");
  }

  $setParts = [];
  $params = [];
  $types = '';

  foreach ($input as $column => $value) {
    if ($value !== null) {
      $setParts[] = "$column = ?";
      $params[] = $value;

      if (is_int($value)) {   // Tentukan tipe data
        $types .= 'i';
      } elseif (is_float($value)) {
        $types .= 'd';
      } elseif (is_bool($value)) {
        $types .= 'i';
        $params[count($params) - 1] = $value ? 1 : 0; // Konversi ke 0 atau 1
      } else {
        $types .= 's'; // Default ke string
      }
    }
  }

  if (empty($setParts)) {
    echo "Tidak ada data yang diubah.";
    return false;
  }

  $setQuery = implode(", ", $setParts);
  $stmt = $conn->prepare("UPDATE shipping_services SET $setQuery WHERE ship_code = ?");

  $params[] = $id;
  $types .= 's';

  $stmt->bind_param($types, ...$params);

  if ($stmt->execute()) {
    response(200, "Shipping Updated");
  } else {
    response(500, "Internal Server Error");
  }

  $stmt->close();
  $conn->close();
}
