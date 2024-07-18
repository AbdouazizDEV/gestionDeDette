<?php

namespace App\Validator;

use App\App;

class Validator {
    private $data;
    private $errors = [];

    private $clientModel;

    public function __construct($data) {
        $this->data = $data;
        $this->clientModel = App::getInstance()->getModel('client');
    }

    public function validate() {
        // Validate each field
        $this->validateField('nom', '/^[a-zA-Z]+$/', 'Le nom doit contenir uniquement des lettres.');
        $this->validateField('prenom', '/^[a-zA-Z]+$/', 'Le prénom doit contenir uniquement des lettres.');
        $this->validateField('email', '/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,}$/', 'L\'e-mail n\'est pas valide.');
        //$this->validateUniqueEmail('email', 'L\'e-mail existe déjà.');
        $this->validateField('adresse', '/^.+$/', 'L\'adresse ne doit pas être vide.');
        $this->validatePhoneNumber('tel', 'Le numéro de téléphone doit comporter 9 chiffres et commencer par 77, 76, 75, ou 78.');

        return $this->errors;
    }

    private function validateField($field, $pattern, $errorMessage) {
        if (!preg_match($pattern, $this->data[$field])) {
            $this->errors[$field] = $errorMessage;
        }
    }

    private function validatePhoneNumber($field, $errorMessage) {
        if (!preg_match('/^(77|76|75|78)\d{7}$/', $this->data[$field])) {
            $this->errors[$field] = $errorMessage;
        } else {
            $client = null;
            $client = $this->clientModel->getClientByPhone($field);
            if ($client){
                $this->errors[$field] = 'Le numéro de téléphone existe déjà.';
            }
        }
    }

    /*private function validateUniqueEmail($field, $errorMessage) {
        $db = \Core\Database\MysqlDatabase::getInstance();
        $stmt = $db->prepare("SELECT COUNT(*) FROM Client WHERE email = :email");
        $stmt->bindParam(':email', $this->data[$field]);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if ($count > 0) {
            $this->errors[$field] = $errorMessage;
        }
    }*/
}
