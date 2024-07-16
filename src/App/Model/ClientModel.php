<?php

namespace App\Model;

use Core\Model\Model;
use Core\Database\MysqlDatabase;

class ClientModel extends Model {
    protected $table = 'Client';
    protected $db;

    public function __construct() {
        $this->db = new MysqlDatabase();
    }

    public function createClient($nom, $prenom, $email, $adresse, $tel, $photo) {
        $sql = "INSERT INTO $this->table (nom, prenom, email, adresse, telephone, photo) VALUES (:nom, :prenom, :email, :adresse, :telephone, :photo)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'adresse' => $adresse,
            'telephone' => $tel,
            'photo' => $photo,
        ]);
    }

    public function getClientByPhone($phone) {
        $sql = "SELECT * FROM $this->table WHERE telephone = :phone";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['phone' => $phone]);
        return $stmt->fetch();
    }

    public function getClientDebts($clientId) {
        $sql = "SELECT * FROM Dette WHERE id_client = :client_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['client_id' => $clientId]);
        return $stmt->fetchAll();
    }

    public function getClientById($id) {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
?>
