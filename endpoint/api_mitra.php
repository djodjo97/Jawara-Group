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

function getUpper($conn, $getData)
{
  $genId = $getData["genid"] ?? null;
  if (array_key_exists('up_id', $getData)) {
    $upId = $getData["up_id"] ?? null;
    $stmt = $conn->prepare("SELECT seq FROM mitra_generation WHERE id_generation = ?");
    $stmt->bind_param("s", $genId);
    $stmt->execute();
    $result = $stmt->get_result();
    $genData = $result->fetch_assoc();
    $genIdParam = $genData['seq'] - $upId;
    if ($genIdParam < 0) {
      response(["status" => 200, "title" => "Succes"], []);
    } else {
      $stmt = $conn->prepare("SELECT id_mitra, name FROM tb_mitra where gen_id = (SELECT id_generation FROM mitra_generation WHERE seq = ?)");
      $stmt->bind_param("s", $genIdParam);
    }
  } else {
    $genIdParam = ($genId === 'G1') ? 'FDR' : 'G1';
    $stmt = $conn->prepare("SELECT id_mitra, name FROM tb_mitra where gen_id = ?");
    $stmt->bind_param("s", $genIdParam);
  }
  return $stmt;
}

function getMitra_noUser($conn, $getData)
{
  $dataId = $getData["id"] ?? null;
  if ($dataId) {
    $stmt = $conn->prepare("SELECT * FROM tb_mitra WHERE id_mitra = ?");
    $stmt->bind_param("s", $dataId);
  } else {    /* Form used: user form */
    $stmt = $conn->prepare("SELECT id_mitra,m.name FROM tb_mitra m LEFT JOIN tb_user u ON m.id_mitra=u.code_user WHERE u.code_user is NULL");
  }
  return $stmt;
}

function getMitra()
{
  try {
    $conn = dbConnect();

    $dataId = $_GET["id"] ?? null;
    //$orderby = $_GET["order"] ?? null;
    $purpose = $_GET["p"] ?? null;
    //$input = json_decode(file_get_contents('php://input'), true);
    if ($purpose == "data-code") $stmt = getUpper($conn, $_GET);
    elseif ($purpose == "update-user") $stmt = getMitra_noUser($conn, $_GET);

    if ($stmt) {
      if (!$stmt->execute()) throw new Exception("Execution Error: " . $stmt->error);
      $result = $stmt->get_result();

      if ($result) {
        if ($dataId) $data = $result->fetch_assoc();
        else $data = $result->fetch_all(MYSQLI_ASSOC);
        response(["status" => 200], $data);
      } else {
        throw new Exception("Gagal mengambil data!");
      }
    } else {
      throw new Exception("Gagal menyiapkan query!");
    }
    $stmt->close();
  } catch (Exception $e) {
    response(["status" => 500, "icon" => "error", "title" => "Error!", "msg" => "Terjadi kesalahan: " . $e->getMessage()]);
  }
}

function updateData()
{
  global $conn;
  $input = json_decode(file_get_contents("php://input"), true);
  $id = $_GET["id"] ?? null;

  if (!$id) response(["status" => 400, "icon" => "error", "title" => "Error!", "msg" => "Bad Request: ID are required"]);

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
    response(["status" => 200, "icon" => "error", "title" => "Error!", "message" => 'Tidak ada data yang diubah!']);
    return false;
  }

  $setQuery = implode(", ", $setParts);
  $stmt = $conn->prepare("UPDATE tb_mitra SET $setQuery WHERE id_mitra = ?");

  $params[] = $id;
  $types .= 's';

  $stmt->bind_param($types, ...$params);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}
