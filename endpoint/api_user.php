<?php
header('Content-Type: application/json');

require_once '../functions/koneksi.php';

$method = $_SERVER["REQUEST_METHOD"];

switch ($method) {
  case "PATCH":
    updateData();
    break;
  case "GET":
    getMitra();
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

function updateData()
{
  $conn = dbConnect();
  $input = json_decode(file_get_contents("php://input"), true);
  $id = $_GET["id"] ?? null;

  if (!$id) response(400, "Bad Request: ID are required");

  $setParts = $params = [];
  $types = '';

  /* foreach ($input as $column => $value) {    if ($value !== null) {      $setParts[] = "$column = ?";      $params[] = $value;      if (is_int($value)) {   // Tentukan tipe data        $types .= 'i';      } elseif (is_float($value)) {        $types .= 'd';      } elseif (is_bool($value)) {        $types .= 'i';        $params[count($params) - 1] = $value ? 1 : 0; // Konversi ke 0 atau 1      } else {        $types .= 's'; // Default ke string      }    }  } */

  foreach ($input as $column => $value) {
    if ($value === null) continue;            // Lewati nilai null

    $setParts[] = "$column = ?";

    $types .= match (true) {      // Tentukan tipe data
      is_int($value), is_bool($value) => 'i',
      is_float($value), (is_numeric($value) && strpos($value, '.') !== false) => 'd',
      default => 's',
    };
    $params[] = is_bool($value) ? (int) $value : $value;    // Konversi nilai jika perlu
  }

  if (empty($setParts)) {
    echo "Tidak ada data yang diubah.";
    return false;
  }

  $setQuery = implode(", ", $setParts);
  $stmt = $conn->prepare("UPDATE tb_user SET $setQuery WHERE code_user = ?");

  $params[] = $id;
  $types .= 's';

  $stmt->bind_param($types, ...$params);

  if ($stmt->execute()) response(200, "Data Updated");
  else response(500, "Internal Server Error");

  $stmt->close();
  $conn->close();
}
