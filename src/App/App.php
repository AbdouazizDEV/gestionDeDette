<?php

namespace App;

use Core\Database\MysqlDatabase;

class App{
    private static $instance;
    private $database;
    
    public function __construct(){

    }

    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getDatabase(){
        if ($this->database === null) {
            /*$dotenv = Dotenv::createImmutable(_DIR_ . '/../../');
            $dotenv->load();*/

            //$this->database =new MysqlDatabase($_ENV['dsn'],$_ENV['DB_USER'],$_ENV['DB_PASSWORD']);
            //$this->database =new MysqlDatabase("mysql:host=localhost;dbname=Diallo_SHOP;charset=utf8mb4", "Zulo", "A@deldiablo10");
        }
        return $this->database;
    }

    public function getModel($model)
    {
        $modelClass = "App\\Model\\" . ucfirst($model) . "Model";
        //newModel = new $modelClass($this->getDatabase());
        $newModel = new $modelClass();
        $newModel->setDatabase($this->getDatabase());
        return $newModel;
    }

    public function notFound(){

    }

    public function forbidden(){

    }
}