<?php

namespace App\Connector;

use PDO;

class Database
{
  private static ?Database $instance = null;

  public function __construct(private ?\PDO $pdo = null)
  {
    $this->setPdo();
  }

  public static function getInstance(): Database
  {
    if (!self::$instance) {
      self::$instance = new Database();
    }
    return self::$instance;
  }

  private function setPdo(): void
  {
    $this->pdo = new PDO("mysql:host=db;dbname=todo", 'root', 'root');
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  public function getPdo(): PDO
  {
    return $this->pdo;
  }
}
