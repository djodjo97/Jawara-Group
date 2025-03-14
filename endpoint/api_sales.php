<?php
header('Content-Type: application/json');

require_once '../functions/koneksi.php';
$method = $_SERVER["REQUEST_METHOD"];

switch ($method) {
  case "PATCH":
    updateSales();
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

// copy getSales from api_package function getPackage

function updateSales()
{
  try {
    $conn = dbConnect();
    $input = json_decode(file_get_contents("php://input"), true);
    $id = $_GET["id"] ?? null;

    if (!$id) response(["status" => 400, "icon" => "error", "title" => "Error!", "msg" => "Bad Request: ID are required!"]);

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
      response(["status" => 200, "icon" => "success", "title" => "Success!", "msg" => "Tidak ada data yang diubah!"]);
      return false;
    }

    $setQuery = implode(", ", $setParts);
    $stmt = $conn->prepare("UPDATE sales_order SET $setQuery WHERE docid = ?");

    $params[] = $id;
    $types .= 's';
    $stmt->bind_param($types, ...$params);

    $stmt->execute();
    response(["status" => 200, "icon" => "success", "title" => "Success!", "msg" => "Data berhasil diubah!"]);
    $stmt->close();
  } catch (mysqli_sql_exception $e) {
    error_log("Database Error: " . $e->getMessage());
    response(["status" => 500, "icon" => "error", "title" => "Error!", "msg" => "Terjadi kesalahan: " . $e->getMessage()]);
  } catch (Exception $e) {
    response(["status" => 500, "icon" => "error", "title" => "Error!", "msg" => "Terjadi kesalahan: " . $e->getMessage()]);
  }
}
