<?php
namespace App\Model;


interface ClientModelInterface {
    public function __construct();

    public function createClient($nom, $prenom, $email, $adresse, $tel, $photo);

    public function getClientByPhone($phone);

    public function getClientDebts($clientId);

    public function getClientById($id);
}
