<?php
header('Content-Type: application/json');

require_once '../functions/koneksi.php';

$method = $_SERVER["REQUEST_METHOD"];

switch ($method) {
  case "GET":
    getMitra();
    break;
  case "PATCH":
    updateData();
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

function getMitra()
{
  global $conn;
  //$input = json_decode(file_get_contents('php://input'), true);
  $dataId = $_GET["id"] ?? null;
  $orderby = $_GET["order"] ?? null;
  $purpose = $_GET["p"] ?? null;

  if ($purpose) {
    if ($purpose == "data-code") {
      $genId = $_GET["genid"] ?? null;
      if (array_key_exists('up_id', $_GET)) {
        $upId = $_GET["up_id"] ?? null;
        $stmt = $conn->prepare("SELECT seq FROM mitra_generation WHERE id_generation = ?");
        $stmt->bind_param("s", $genId);
        $stmt->execute();
        $result = $stmt->get_result();
        $genData = $result->fetch_assoc();
        $genIdParam = $genData['seq'] - $upId;
        if ($genIdParam < 0) {
          response(200, "Success", []);
        } else {
          $stmt = $conn->prepare("SELECT id_mitra, name FROM tb_mitra where gen_id = (SELECT id_generation FROM mitra_generation WHERE seq = ?)");
          $stmt->bind_param("s", $genIdParam);
        }
      } else {
        if ($genId === 'G1') {
          $genIdParam = 'FDR';
        } else {
          $genIdParam = 'G1';
        }
        $stmt = $conn->prepare("SELECT id_mitra, name FROM tb_mitra where gen_id = ?");
        $stmt->bind_param("s", $genIdParam);
      }
    }
  } else {
    if ($dataId) {
      $stmt = $conn->prepare("SELECT * FROM tb_mitra WHERE id_mitra = ?");
      $stmt->bind_param("s", $dataId);
    } else {
      $query = "SELECT * FROM mitra_generation";
      if ($orderby) {
        $query .= " ORDER BY $orderby";
      }
      $stmt = $conn->prepare($query);
    }
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

function updateData()
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

  // foreach ($input as $column => $value) {
  //   if ($value !== null) {
  //     $setParts[] = "$column = ?";
  //     $params[] = $value;

  //     if (is_int($value)) {   // Tentukan tipe data
  //       $types .= 'i';
  //     } elseif (is_float($value)) {
  //       $types .= 'd';
  //     } elseif (is_bool($value)) {
  //       $types .= 'i';
  //       $params[count($params) - 1] = $value ? 1 : 0; // Konversi ke 0 atau 1
  //     } else {
  //       $types .= 's'; // Default ke string
  //     }
  //   }
  // }

  foreach ($input as $column => $value) {
    if ($value === null) continue; // Lewati nilai null

    $setParts[] = "$column = ?";

    // Tentukan tipe data
    $types .= match (true) {
      is_int($value), is_bool($value) => 'i',
      is_float($value), (is_numeric($value) && strpos($value, '.') !== false) => 'd',
      default => 's',
    };

    // Konversi nilai jika perlu
    $params[] = is_bool($value) ? (int) $value : $value;
  }

  if (empty($setParts)) {
    echo "Tidak ada data yang diubah.";
    return false;
  }

  $setQuery = implode(", ", $setParts);
  $stmt = $conn->prepare("UPDATE tb_mitra SET $setQuery WHERE id_mitra = ?");

  $params[] = $id;
  $types .= 's';

  $stmt->bind_param($types, ...$params);

  if ($stmt->execute()) {
    response(200, "Data Updated");
  } else {
    response(500, "Internal Server Error");
  }

  $stmt->close();
  $conn->close();
}
