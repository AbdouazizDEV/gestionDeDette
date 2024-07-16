<?php
namespace App\Model;

use Core\Database\MysqlDatabase;

class DetteModel {
    private $db;

    public function __construct() {
        $this->db = MysqlDatabase::getInstance();
    }

    public function getDettesByClientId($id_client) {
        $stmt = $this->db->prepare("SELECT * FROM Dette WHERE id_client = :id_client");
        $stmt->bindParam(':id_client', $id_client);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getDetteById($id_dette) {
        $stmt = $this->db->prepare("SELECT * FROM Dette WHERE id_dette = :id_dette");
        $stmt->bindParam(':id_dette', $id_dette);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updatePayment($id_dette, $montantVerser, $montantRestant) {
        $stmt = $this->db->prepare("UPDATE Dette SET montant_verser = :montantVerser, montant_restant = :montantRestant WHERE id_dette = :id_dette");
        $stmt->bindParam(':montantVerser', $montantVerser);
        $stmt->bindParam(':montantRestant', $montantRestant);
        $stmt->bindParam(':id_dette', $id_dette);
        $stmt->execute();
    }

    public function addPayment($id_dette, $montant_paye) {
        $stmt = $this->db->prepare("INSERT INTO Paiement (montant_paye, date_paiement, id_dette) VALUES (:montant_paye, NOW(), :id_dette)");
        $stmt->bindParam(':montant_paye', $montant_paye);
        $stmt->bindParam(':id_dette', $id_dette);
        $stmt->execute();
    }

    public function getDettesPaginated($id_client, $offset, $limit) {
        $stmt = $this->db->prepare("SELECT * FROM Dette WHERE id_client = :id_client LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':id_client', $id_client);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function countDettes($id_client) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Dette WHERE id_client = :id_client");
        $stmt->bindParam(':id_client', $id_client);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getProductsByDetteId($id_dette) {
        $stmt = $this->db->prepare("
            SELECT p.nom, p.description, p.prix, p.quantite_en_stock 
            FROM Produit p 
            JOIN DetteProduit dp ON p.id_prod = dp.id_prod 
            WHERE dp.id_dette = :id_dette
        ");
        $stmt->bindParam(':id_dette', $id_dette, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function addDette($id_client, $id_prod, $montant, $quantite) {
        $stmt = $this->db->prepare("INSERT INTO Dette (id_client, id_prod, montant, quantite, date_emprunt) VALUES (:id_client, :id_prod, :montant, :quantite, NOW())");
        $stmt->bindParam(':id_client', $id_client);
        $stmt->bindParam(':id_prod', $id_prod);
        $stmt->bindParam(':montant', $montant);
        $stmt->bindParam(':quantite', $quantite);
        $stmt->execute();
    }
    
    public function getAllProducts() {
        $stmt = $this->db->query("SELECT * FROM Produit");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
}
