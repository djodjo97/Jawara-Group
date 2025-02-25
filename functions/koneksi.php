<?php
class Database
{
  private static $instance = null;
  private $connection;

  private $host = "localhost";
  private $username = "root";
  private $password = "";
  private $database = "db_jawara";

  private function __construct()
  {
    try {
      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Laporkan error sebagai Exception
      $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
      $this->connection->set_charset("utf8mb4"); // Pastikan charset UTF-8 untuk keamanan
    } catch (Exception $e) {
      $this->handleError("Db Error: " . $e->getMessage());
    }
  }

  public static function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = new Database();
    }
    return self::$instance->connection;
  }

  private function handleError($errorMessage)
  {
    if (php_sapi_name() == "cli" || isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
      http_response_code(500);
      echo json_encode(['error' => 'Gagal terhubung ke database: ' . $errorMessage]);
    } else {
      // return ['icon' => 'error', 'title' => 'Error!', 'text' => "SQL Error: " . $errorMessage];

      echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Database Error!',
                text: `" . addslashes($errorMessage) . "`,
                showConfirmButton: true
            }).then(() => {
                
            });
        </script>";
      // echo "<script>alert(`" . $errorMessage . "`);</script>";
    }
    exit;
  }
}

// Fungsi koneksi (Menggunakan Singleton)
function dbConnect()
{
  return Database::getInstance();
}

$host = "localhost";
$uname = "root";
$pass = "";
$db = "db_jawara";
$conn = mysqli_connect($host, $uname, $pass, $db);

if (!$conn) {
  http_response_code(500);
  echo json_encode(['error' => 'Gagal terhubung ke database']);
  exit;
}
