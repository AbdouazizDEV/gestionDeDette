<?php

namespace App\Model;

use Core\Database\MysqlDatabase;

class PaiementModel {
    private $db;

    public function __construct() {
        $this->db = MysqlDatabase::getInstance();
    }

    public function getPaiementsByDetteId($id_dette) {
        $stmt = $this->db->prepare("SELECT * FROM Paiement WHERE id_dette = :id_dette");
        $stmt->bindParam(':id_dette', $id_dette);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
