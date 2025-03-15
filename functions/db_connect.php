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
      // $this->connection = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
      // $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // //opsional, set default fetch mode
      // $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      // $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

      $dsn = "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4";
      $this->connection = new PDO($dsn, $this->username, $this->password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
      ]);
    } catch (PDOException $e) {
      $this->handleError($e);
    }
  }

  public static function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = new Database();
    }
    return self::$instance->connection;
  }

  public function getConnection()
  {
    return $this->connection;
  }

  private function handleError(PDOException $e)
  {
    $errorCode = (int) $e->getCode(); // Pastikan error code dalam bentuk integer
    $errorMessage = match ($errorCode) {
      1045 => "Akses ditolak!", // Akses ke database ditolak! Periksa username dan password.
      1049 => "Kesalahan database!", // Database tidak ditemukan! Pastikan database sudah dibuat.
      1064 => "Query Error!", // Kesalahan sintaks SQL!/ Periksa query Anda.
      1146 => "Kesalahan database!", // Tabel yang diminta tidak ditemukan!
      default => "Kesalahan database: " . $e->getMessage(),
    };
    if (php_sapi_name() == "cli" || isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
      http_response_code(500);
      echo json_encode([
        "status" => 500,
        "icon" => "error",
        "title" => "Error!",
        "message" => 'Gagal terhubung ke database: ' . $errorMessage
      ]);
    } else {
      echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Database Error!',
                text: `" . addslashes($errorMessage) . "`,
                showConfirmButton: true
            });
            console.error(`$e`);
        </script>";
    }
    exit;
  }

  private function extractTableName($query)
  {
    $query = trim(preg_replace('/\s+/', ' ', $query));
    $queryType = strtoupper(strtok($query, ' '));

    switch ($queryType) {
      case 'SELECT':
      case 'DELETE':
        preg_match('/\bFROM\s+`?([\w\d_]+)`?/i', $query, $matches);
        break;
      case 'INSERT':
        preg_match('/\bINTO\s+`?([\w\d_]+)`?/i', $query, $matches);
        break;
      case 'UPDATE':
        preg_match('/\bUPDATE\s+`?([\w\d_]+)`?/i', $query, $matches);
        break;
      default:
        return null;
    }
    return $matches[1] ?? null;
  }

  private function executeQuery($query, $params = [])
  {
    $stmt = $this->connection->prepare($query);
    $stmt->execute($params);
    return $stmt;
  }

  public function fetchOne($query, $params = [])
  {
    $stmt = $this->executeQuery($query, $params);
    return $stmt->fetch();
  }

  public function fetchAll($query, $params = [])
  {
    $stmt = $this->executeQuery($query, $params);
    return $stmt->fetchAll();
  }
}

function dbConnect()
{
  return Database::getInstance();
}
