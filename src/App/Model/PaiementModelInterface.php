<?php
namespace App\Model;


interface PaiementModelInterface {
    public function __construct();

    public function getPaiementsByDetteId($id_dette);
}
