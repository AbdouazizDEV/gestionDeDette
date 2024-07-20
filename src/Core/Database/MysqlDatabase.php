<?php

namespace Core\Database;

use PDO;
use PDOException;
use Core\Database\DatabaseInterface;
use Symfony\Component\Yaml\Yaml;

class MysqlDatabase implements DatabaseInterface  {
    private $pdo;

    public function __construct() {
        $routes = Yaml::parseFile('/var/www/html/diallo_SHOP/aziz.yaml');
        $dsn = $routes['DSN'];$PASSWORD = $routes['DB_PASS'];$USER = $routes['DB_USER'];

        $this->pdo = new PDO($dsn, $USER, $PASSWORD);
    }

    public function prepare($sql, $options = []) {
        return $this->pdo->prepare($sql, $options);
    }

    public function query($sql) {
        return $this->pdo->query($sql);
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    public function errorInfo() {
        return $this->pdo->errorInfo();
    }

    public static function getInstance() {
        static $instance = null;
        if ($instance === null) {
            $instance = new MysqlDatabase();
        }
        return $instance;
    }
    public function beginTransaction() {
        $this->pdo->beginTransaction();
        return $this;
    }
    public function commit() {
        $this->pdo->commit();
        return $this;
    }
    public function rollBack() {
        $this->pdo->rollBack();
        return $this;
    }
    public function getConnection() {
        return $this->pdo;
    }
}
