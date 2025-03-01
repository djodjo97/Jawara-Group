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
    } catch (mysqli_sql_exception $e) {
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

  private function handleError(mysqli_sql_exception $e)
  {
    $errorMessage = match ($e->getCode()) {
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
            }).then(() => {
                
            });
            console.log(`$e`);
        </script>";
    }
    exit;
  }

  public function __destruct()
  {
    if ($this->connection) {
      $this->connection->close();
    }
  }

  private function extractTableName($query)
  {
    $query = trim(preg_replace('/\s+/', ' ', $query)); // Hilangkan spasi berlebih
    $queryType = strtoupper(strtok($query, ' ')); // Ambil kata pertama (SELECT, INSERT, UPDATE, DELETE)

    switch ($queryType) {
      case 'SELECT':
        preg_match('/\bFROM\s+`?([\w\d_]+)`?/i', $query, $matches);
        break;
      case 'INSERT':
        preg_match('/\bINTO\s+`?([\w\d_]+)`?/i', $query, $matches);
        break;
      case 'UPDATE':
        preg_match('/\bUPDATE\s+`?([\w\d_]+)`?/i', $query, $matches);
        break;
      case 'DELETE':
        preg_match('/\bFROM\s+`?([\w\d_]+)`?/i', $query, $matches);
        break;
      default:
        return null;
    }
    return $matches[1] ?? null;
  }

  private function getColumnTypes($table)
  {
    $types = [];
    if (!$table) return $types;

    $result = $this->connection->query("SHOW COLUMNS FROM `$table`");
    while ($row = $result->fetch_assoc()) {
      $column = $row['Field'];
      $type = strtolower($row['Type']);
      $baseType = explode('(', $type)[0];

      if (in_array($baseType, ['int', 'tinyint', 'smallint', 'mediumint', 'bigint'])) {
        $types[$column] = 'i';
      } elseif (in_array($baseType, ['float', 'double', 'decimal'])) {
        $types[$column] = 'd';
      } elseif (in_array($baseType, ['blob', 'binary'])) {
        $types[$column] = 'b';
      } else {
        $types[$column] = 's';
      }
    }
    return $types;
  }

  private function executeQuery($query, $params = [])
  {
    $table = $this->extractTableName($query);

    if (!empty($params)) {
      $columnTypes = $this->getColumnTypes($table);
      $stmt = $this->connection->prepare($query);
      if ($stmt === false) {
        die("SQL error: " . $this->connection->error);
      }

      $types = "";
      $bindParams = [];
      foreach ($params as $column => $value) {
        $types .= $columnTypes[$column] ?? 's';
        $bindParams[] = $value;
      }

      $stmt->bind_param($types, ...array_values($bindParams));
      $stmt->execute();
      $result = $stmt->get_result();
      $stmt->close();
      return $result;
    } else {
      $result = $this->connection->query($query);
      if (!$result) {
        die("SQL error: " . $this->connection->error);
      }
      return $result;
    }
  }

  public function fetchOne($query, $params = [])
  {
    $result = $this->executeQuery($query, $params);
    return $result ? $result->fetch_assoc() : null;
  }

  public function fetchAll($query, $params = [])
  {
    $result = $this->executeQuery($query, $params);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
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
