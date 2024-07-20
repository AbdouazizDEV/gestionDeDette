<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/vendor/autoload.php';

use Core\Route;
use Core\Session;
use Symfony\Component\Yaml\Yaml;
use Dotenv\Dotenv;
use ReflectionClass;
use App\Controller\ClientController;
use App\Controller\DetteController;
const ROUT='/var/www/html/diallo_SHOP';
// Démarrer la session
Session::start();

// Charger les variables d'environnement à partir du fichier .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Charger la configuration à partir du fichier YAML
$config = Yaml::parseFile('aziz.yaml');

// Initialiser les services et interfaces
if (isset($config['DatabaseInterface'])) {
    $databaseClass = $config['DatabaseInterface'];
    if (class_exists($databaseClass)) {
        $reflectionClass = new ReflectionClass($databaseClass);
        $databaseInstance = $reflectionClass->newInstance();
        // Utilisez $databaseInstance comme nécessaire
    }
}

// Configurer les routes
if (isset($config['routes'])) {
    foreach ($config['routes'] as $route) {
        $method = strtoupper($route['method']);
        $path = $route['path'];
        $controller = $route['controller'];
        $action = $route['action'];

        switch ($method) {
            case 'GET':
                Route::get($path, [$controller, $action]);
                break;
            case 'POST':
                Route::post($path, [$controller, $action]);
                break;
            // Ajoutez d'autres méthodes HTTP si nécessaire
        }
    }
}

// Démarrer le routage
Route::run();
