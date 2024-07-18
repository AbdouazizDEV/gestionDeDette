<?php

namespace App\Controller;

use App\Model\ProductModel;

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    public function getProductsByDetteId() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_dette = $_POST['id_dette'];
            $products = $this->productModel->getProductsByDetteId($id_dette);

            // Inclure la vue de la liste des dettes avec les produits
            require ROUT.'/src/Core/view/ListeDette.html.php';
        } else {
            // Rediriger ou afficher une erreur si la requête n'est pas POST
            header('Location: /dette/list');
            exit();
        }
    }
    
   //getAllProducts
    public function getAllProducts() {
        $products = $this->productModel->getAllProducts();
        return $products;
    }

    
}
