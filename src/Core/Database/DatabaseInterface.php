<?php
namespace Core\Database;


interface DatabaseInterface {
    public function prepare($sql, $options = []);

    public function query($sql);

    public function lastInsertId();

    public function errorInfo();

    public static function getInstance();

    public function beginTransaction();

    public function commit();

    public function rollBack();

    public function getConnection();
}
