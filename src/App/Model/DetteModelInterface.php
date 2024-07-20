<?php
namespace App\Model;

interface DetteModelInterface {
    public function __construct();

    public function getDettesByClientId($id_client);

    public function getDetteById($id_dette);

    public function updatePayment($id_dette, $montantVerser, $montantRestant);

    public function addPayment($id_dette, $montant_paye);

    public function getDettesPaginated($id_client, $offset, $limit);

    public function countDettes($id_client);

    public function getProductsByDetteId($id_dette);
    
    public function getAllProducts();

    public function enregistrerNouvelleDette($id_client, $montant, $montant_verser, $montant_restant, $date_emprunt, $date_remboursement, $product_ids_string);

    public function beginTransaction();

    public function commit();

    public function rollBack();
}
