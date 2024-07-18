<?php
    //require_once 'vendor/autoload.php';   
    //require_once '/var/www/html/diallo_SHOP/src/Core/view/RechercheClient.html.php';
    //require_once '/var/www/html/diallo_SHOP/src/Core/view/menu.php';
    /*$page = isset($_GET['page']) ? $_GET['page'] : 'home';

    switch ($page) {
    case 'home':
        include '/var/www/html/diallo_SHOP/src/Core/view/RechercheClient.html.php';
        break;
    case 'enregistrerDette':
        include '/var/www/html/diallo_SHOP/src/Core/view/EnregistrerDette.html.php';
        break;
    case 'paiement':
        include './views/dette/client.html.php'; 
        break;
    case 'Ajoute_article':
        // Inclure le fichier Ajoute_article.php si nécessaire
        include './views/partision/Ajoute_article.php';
        break;
    case 'liste':
        include '/var/www/html/diallo_SHOP/src/Core/view/ListerDettea.html.php'; 
        break;
    default:
        include './views/partision/ERROR404.php';
        break;
} */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

use Core\Route;
use Core\Session;
use App\Controller\DetteController;

use App\Controller\ClientController;
const ROUT='/var/www/html/diallo_SHOP';

// Démarrer la session
Session::start();

// Désactiver le routage automatique
Route::disableAutoRouting();

// Définir les routes pour ClientController
Route::post('clients/create', ['App\Controller\ClientController', 'create']);
Route::get('clients/search', ['App\Controller\ClientController', 'search']);
Route::get('clients', ['App\Controller\ClientController', 'list']);
Route::get('clients/phone', ['App\Controller\ClientController', 'searchByPhone']);

Route::get('/clients', [ClientController::class, 'search']);
Route::post('/clients/create', [ClientController::class, 'create']);
Route::get('/clients/phone', [ClientController::class, 'searchByPhone']);
Route::post('/clients/list', [ClientController::class, 'list']);
Route::get('/clients/info', [ClientController::class, 'getClient']);

// Définir les routes pour DetteController
Route::post('dette/list', ['App\Controller\DetteController', 'list']);
Route::get('dette/list', ['App\Controller\DetteController', 'list']);
Route::post('dette/handlePayment', ['App\Controller\DetteController', 'handlePayment']);
Route::get('dette/paiements/{id_dette}', ['App\Controller\DetteController', 'listPaiements']);

// Ajouter les nouvelles routes
Route::get('dette/view/{clientId}', ['App\Controller\DetteController', 'viewDettes']);
Route::post('dette/handlePayment', ['App\Controller\DetteController', 'handlePayment']);
//Route::get('dette/produits/{id_dette}', ['App\Controller\ProductController', 'getProductsByDetteId']);

// Ajouter les routes pour la pagination
Route::get('dette/list/{page}', ['App\Controller\DetteController', 'list']);

use App\Controller\ProductController;

// Dans votre fichier de routes
Route::post('/dette/produit', ['App\Controller\ProductController', 'getProductsByDetteId']);
ROute::post('dette/create', ['App\Controller\DetteController', 'create']);
Route::get('dette/create', ['App\Controller\DetteController', 'create']);

Route::post('dette/save', ['App\Controller\DetteController', 'saveDette']);
Route::get('dette/save', ['App\Controller\DetteController','saveDette']);



// Démarrer le routage
Route::run();
