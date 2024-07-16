<?php 
namespace Core\config;
use Core\Route;

Route::post('clients/create', ['App\Controller\ClientController', 'create']);
Route::get('clients/search', ['App\Controller\ClientController', 'search']);
Route::get('clients', ['App\Controller\ClientController', 'list']);
Route::get('clients/phone', ['App\Controller\ClientController', 'searchByPhone']);

Route::post('dette/list', ['App\Controller\DetteController', 'list']);
Route::get('dette/list', ['App\Controller\DetteController', 'list']);
Route::post('dette/handlePayment', ['App\Controller\DetteController', 'handlePayment']);
Route::get('dette/paiements/{id_dette}', ['App\Controller\DetteController', 'listPaiements']);
Route::get('dette/view/{clientId}', ['App\Controller\DetteController', 'viewDettes']);
Route::post('dette/handlePayment', ['App\Controller\DetteController', 'handlePayment']);
Route::get('dette/produits/{id_dette}', ['App\Controller\ProductController', 'getProductsByDetteId']);
Route::get('dette/list/{page}', ['App\Controller\DetteController', 'list']);
Route::get('dette/products/{id_dette}', ['App\Controller\DetteController', 'listProducts']);
Route::get('dette/list/{page}', ['App\Controller\DetteController', 'list']);
