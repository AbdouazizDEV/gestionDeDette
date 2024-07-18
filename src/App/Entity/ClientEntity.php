<?php

namespace App\Entity;


use Core\Entity\Entity;

class ClientEntity extends Entity {
    protected $table = 'Client';
    protected $id;
    protected $nom;
    protected $prenom;
    protected $adresse;
    protected $telephone;

    // Getters et setters
}

