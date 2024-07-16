<?php

namespace Core\Security;

use Core\Database\MysqlDatabase;

class SecurityDatabase {
    protected $database;

    public function __construct() {
        $this->database = new MysqlDatabase();
    }

    public function login($username, $password) {
        $query = "SELECT * FROM Authentification WHERE username = :username AND password = :password";
        $stmt = $this->database->prepare($query);
        $stmt->execute([
            ':username' => $username,
            ':password' => $password
        ]);

        return $stmt->fetch() !== false;
    }
}
