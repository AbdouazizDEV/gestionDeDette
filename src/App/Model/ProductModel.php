<?php
namespace App\Model;

use PDO;
use Core\Database\MysqlDatabase;
class ProductModel {
    private $db;

    public function __construct() {
        $this->db = new MysqlDatabase();

        // Instanciation de la connexion à la base de données (à adapter selon votre configuration)
        $this->db = new PDO('mysql:host=localhost;dbname=Diallo_SHOP', 'Zulo', 'A@deldiablo10');
    }

    public function getProductsByDetteId($id_dette) {
        $query = 'SELECT p.nom, p.description, p.prix, p.quantite_en_stock AS quantite
                  FROM Produit p
                  JOIN DetteProduit dp ON p.id_produit = dp.id_produit
                  WHERE dp.id_dette = :id_dette';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_dette', $id_dette, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllProducts() {
        $stmt = $this->db->query("SELECT id_produit, nom FROM Produit");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    

}


