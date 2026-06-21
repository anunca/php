<?php

namespace App\Repository;

use App\Connector\Database;
use PDO;
use PDOException;
use PDOStatement;

class TodoRepository
{
  private static ?TodoRepository $instance = null;

  private function __construct(private ?PDO $pdo = null)
  {
    $this->pdo = (Database::getInstance())->getPdo();
  }

  public static function getInstance(): TodoRepository
  {
    if (!self::$instance) {
      self::$instance = new TodoRepository();
    }
    return self::$instance;
  }

  public function getList(): PDOStatement|false
  {
    $list = $this->pdo->query("SELECT id, name FROM todo");
    return $list;
  }

  public function setRandomName(): string
  {
    $message = "Records inserted successfully.";

    try {
      $query = 'INSERT INTO todo (name) VALUES (:name)';
      $stmt = $this->pdo->prepare($query);

      $generator = $this->generateRandomNames();

      $this->pdo->beginTransaction();
      foreach ($generator as $name) {
        $stmt->bindParam(':name', $name);
        $stmt->execute();
      }
      $this->pdo->commit();
    } catch (PDOException $e) {
      $message = "Error: " . $e->getMessage();
    }

    return $message;
  }

  private function generateRandomNames()
  {
    for ($i = 0; $i < 10; $i++) {
      yield 'name' . $i;
    }
  }
}
