<?php

namespace Core\Database;

use PDO;
use PDOException;

class MysqlDatabase {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=localhost;dbname=Diallo_SHOP', 'Zulo', 'A@deldiablo10');
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
