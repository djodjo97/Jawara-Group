<?php
header('Content-Type: application/json');

require_once '../functions/koneksi.php';

$method = $_SERVER["REQUEST_METHOD"];

switch ($method) {
  case "PATCH":
    updateData();
    break;
  case "GET":
    // if ($_GET["action"] == "update") getMitra($_GET["id"]);
    if ($_GET["action"] == "reset-sandi") passwordReset($_GET["id"]);
    elseif (!$_GET["action"]) response(["status" => 400, "msg" => "Bad Request: ID are required"]);
    break;
  case "POST":
    unameCheck();
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

function unameCheck()
{
  try {
    $conn = dbConnect();
    $input = json_decode(file_get_contents("php://input"), true);
    $stmt = $conn->prepare("SELECT 1 from tb_user where username = ? LIMIT 1");
    if (!$stmt) throw new Exception("Query Error: " . $conn->error);

    $stmt->bind_param("s", $input['uname']);
    if (!$stmt->execute()) throw new Exception("Execution Error: " . $stmt->error);
    $result = $stmt->get_result();
    if ($result->num_rows > 0) response(["status" => 200, "icon" => "error", "title" => "Error!", "msg" => "Username tidak tersedia!"]);
    response(["status" => 200, "msg" => ""]);
  } catch (Exception $e) {
    response(["status" => 500, "icon" => "error", "title" => "Error!", "msg" => "Terjadi kesalahan: " . $e->getMessage()]);
  }
}

// function updateData($id = null)
// {
//   $conn = dbConnect();
//   $input = json_decode(file_get_contents("php://input"), true);

//   if (!$id) response(400, "Bad Request: ID are required");

//   $setParts = $params = [];
//   $types = '';

//   /* foreach ($input as $column => $value) {    if ($value !== null) {      $setParts[] = "$column = ?";      $params[] = $value;      if (is_int($value)) {   // Tentukan tipe data        $types .= 'i';      } elseif (is_float($value)) {        $types .= 'd';      } elseif (is_bool($value)) {        $types .= 'i';        $params[count($params) - 1] = $value ? 1 : 0; // Konversi ke 0 atau 1      } else {        $types .= 's'; // Default ke string      }    }  } */

//   foreach ($input as $column => $value) {
//     if ($value === null) continue;            // Lewati nilai null

//     $setParts[] = "$column = ?";

//     $types .= match (true) {      // Tentukan tipe data
//       is_int($value), is_bool($value) => 'i',
//       is_float($value), (is_numeric($value) && strpos($value, '.') !== false) => 'd',
//       default => 's',
//     };
//     $params[] = is_bool($value) ? (int) $value : $value;    // Konversi nilai jika perlu
//   }

//   if (empty($setParts)) {
//     echo "Tidak ada data yang diubah.";
//     return false;
//   }

//   $setQuery = implode(", ", $setParts);
//   $stmt = $conn->prepare("UPDATE tb_user SET $setQuery WHERE code_user = ?");

//   $params[] = $id;
//   $types .= 's';

//   $stmt->bind_param($types, ...$params);

//   if ($stmt->execute()) response(200, "Data Updated");
//   else response(500, "Internal Server Error");

//   $stmt->close();
// }

// function generatePassword($length = 8)
// {
//   $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789?=.*!@#$%^&*()_+{}\[\]:;<>,.?~\\-';

//   do {
//     $password = substr(str_shuffle($chars), 0, $length);
//   } while (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+{}\[\]:;<>,.?~\\-])[a-zA-Z0-9!@#$%^&*()_+{}\[\]:;<>,.?~\\-]{' . $length . ',}$/', $password));

//   return $password;
// }

function generateRandomPassword($length = 12)
{
  $lowercase = 'abcdefghijklmnopqrstuvwxyz';
  $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $digits = '0123456789';
  $specials = '!@#$%^&*()_+{}[]:;<>,.?~\\-';

  // Ambil 1 karakter dari masing-masing kategori
  $password = $lowercase[rand(0, strlen($lowercase) - 1)] .
    $uppercase[rand(0, strlen($uppercase) - 1)] .
    $digits[rand(0, strlen($digits) - 1)] .
    $specials[rand(0, strlen($specials) - 1)];

  // Gabungkan semua karakter yang diizinkan
  $all = $lowercase . $uppercase . $digits . $specials;
  for ($i = 4; $i < $length; $i++) {
    $password .= $all[rand(0, strlen($all) - 1)];
  }

  // Acak urutan karakter
  return str_shuffle($password);
}

function passwordReset($id = null)
{
  try {
    $conn = dbConnect();
    if (!$id) response(["status" => 400, "icon" => "success", "title" => "Success!", "msg" => "Bad Request: ID are required!"]);
    $newPwd = generateRandomPassword();
    $hashPwd = password_hash($newPwd, PASSWORD_ARGON2ID);

    $stmt = $conn->prepare("UPDATE tb_user SET password = ? WHERE code_user = ?");
    $stmt->bind_param("ss", $hashPwd, $id);
    if ($stmt->execute()) response(["status" => 200, "msg" => "Password has been reset!"], ['password' => $newPwd]);
    else response(["status" => 500, "icon" => "success", "title" => "Success!", "msg" => "Internal Server Error"]);
  } catch (Exception $e) {
    response(["status" => 500, "icon" => "error", "title" => "Error!", "msg" => "Terjadi kesalahan: " . $e->getMessage()]);
  }
}
