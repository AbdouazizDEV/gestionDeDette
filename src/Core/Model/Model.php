<?php

namespace Core\Model;

use Core\Database\MysqlDatabase;

abstract class Model {
    protected $database;
    protected $table;

    public function __construct() {
        $this->database = MysqlDatabase::getInstance();
    }

    public function all() {
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->database->query($sql);
        return $stmt->fetchAll();
    }

    public function find($id) {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->database->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function save($data) {
        $keys = array_keys($data);
        $fields = implode(',', $keys);
        $values = ':' . implode(',:', $keys);

        $sql = "INSERT INTO $this->table ($fields) VALUES ($values)";
        $stmt = $this->database->prepare($sql);
        $stmt->execute($data);

        return $this->database->lastInsertId();
    }

    public function delete($id) {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->database->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function update($id, $data) {
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ', ');

        $data['id'] = $id;

        $sql = "UPDATE $this->table SET $fields WHERE id = :id";
        $stmt = $this->database->prepare($sql);
        return $stmt->execute($data);
    }
    
}
