<?php
namespace App\Model;

use PDO;
use Core\Database\MysqlDatabase;

class ProductModel {
    private $db;

    public function __construct() {
        $this->db = MysqlDatabase::getInstance();
    }

    public function getProductsByDetteId($id_dette) {
        $query = 'SELECT p.nom, p.description, p.prix, p.quantite_en_stock AS quantite
                  FROM Produit p
                  JOIN Dette d ON p.id_produit = d.id_prod
                  WHERE d.id_dette = :id_dette';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_dette', $id_dette, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllProducts() {
        $stmt = $this->db->query("SELECT id_produit, nom, description, prix, quantite_en_stock AS quantite FROM Produit");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $sql = "SELECT * FROM Produit WHERE id_produit = :id_produit";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id_produit' => $id]);
        return $stmt->fetch();
    }

    public function updateProductQuantity($id, $quantity) {
        $sql = "UPDATE Produit SET quantite_en_stock = :quantity WHERE id_produit = :id_produit";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['quantity' => $quantity, 'id_produit' => $id]);
    }
}
