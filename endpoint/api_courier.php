<?php
header('Content-Type: application/json');

require_once '../functions/koneksi.php';

$method = $_SERVER["REQUEST_METHOD"];

switch ($method) {
  case "GET":
    getCouriers();
    break;
  case "PATCH":
    updateCourier();
    break;
  default:
    response(["status" => 405, "msg" => "Method Not Allowed"]);
}

function response($response, $data = null)
{
  http_response_code($response['status']);
  foreach (["status", "icon", "title", "msg"] as $key) array_key_exists($key, $response) && $response[$key] !== null && $response[$key] !== '' && $responSend[$key === "msg" ? "message" : $key] = $response[$key];
  $responSend['data'] = $data;
  echo json_encode($responSend);
  exit();
}

function getCouriers()
{
  try {
    $conn = dbConnect();
    //$input = json_decode(file_get_contents('php://input'), true);
    $dataId = $_GET["id"] ?? null;

    if ($dataId) {
      $stmt = $conn->prepare("SELECT * FROM shipping_services WHERE ship_code = ?");
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
        response(["status" => 200], $data);
      } else {
        response(["status" => 500, "icon" => "error", "title" => "Error!", "msg" => "Gagal mengambil data!"]);
      }
    } else {
      response(["status" => 500, "icon" => "error", "title" => "Error!", "msg" => "Gagal menyiapkan query!"]);
    }
    $stmt->close();
  } catch (Exception $e) {
    response(["status" => 500, "icon" => "error", "title" => "Error!", "msg" => "Terjadi kesalahan: " . $e->getMessage()]);
  }
}

function updateCourier()
{
  $conn = dbConnect();
  $input = json_decode(file_get_contents("php://input"), true);
  $id = $_GET["id"] ?? null;

  if (!$id) response(["status" => 400, "icon" => "success", "title" => "Success!", "msg" => "Bad Request: ID are required!"]);

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
    response(["status" => 200, "icon" => "success", "title" => "Success!", "msg" => "Product Updated!"]);
  } else {
    response(["status" => 500, "icon" => "error", "title" => "Error!", "msg" => "Internal Server Error"]);
  }
  $stmt->close();
}
