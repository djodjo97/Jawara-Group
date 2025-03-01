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

  private function handleError(PDOException $e)
  {
    $errorMessage = "Kesalahan database: " . $e->getMessage();
    http_response_code(500);
    echo json_encode(["status" => 500, "message" => $errorMessage]);
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
