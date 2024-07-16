<?php 
namespace App\Controller;

use App\Model\DetteModel;
use App\Model\ProductModel;
use App\Model\ClientModel;
use App\Model\PaiementModel;
use Core\Database\MysqlDatabase;
use symfony\Component\Yaml\Yaml;

class DetteController {
    private $clientModel;
    private $detteModel;
    private $paiementModel;
    private $productModel;
    private $db;
    public function __construct() {
        $this->clientModel = new ClientModel();
        $this->detteModel = new DetteModel();
        $this->paiementModel = new PaiementModel();
        $this->db = new MysqlDatabase();
        $this->productModel = new ProductModel();
    }
    public function list($page = 1) {
        $itemsPerPage = 4;
        $offset = ($page - 1) * $itemsPerPage;
        $clientId = $_SESSION['id_client'];
    
        // Vérifiez si l'ID du client est défini dans la session
        if (!isset($_SESSION['id_client'])) {
            // Redirigez ou affichez une erreur
            echo "Aucun client sélectionné.";
            return;
        }
    
        // Récupérez les informations du client
        $queryClient = "SELECT * FROM Client WHERE id = :clientId";
        $stmtClient = $this->db->prepare($queryClient);
        $stmtClient->bindValue(':clientId', $clientId, \PDO::PARAM_INT);
        $stmtClient->execute();
        $client = $stmtClient->fetch(\PDO::FETCH_ASSOC);
    
        // Définir le filtre par défaut à 'non'
        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'non';
        $filterCondition = $filter === 'non' ? 'montant_restant > 0' : 'montant_restant = 0';
    
        // Récupérez les dettes du client en fonction du filtre
        $queryDettes = "SELECT * FROM Dette WHERE id_client = :clientId AND $filterCondition LIMIT :offset, :itemsPerPage";
        $stmtDettes = $this->db->prepare($queryDettes);
        $stmtDettes->bindValue(':clientId', $clientId, \PDO::PARAM_INT);
        $stmtDettes->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmtDettes->bindValue(':itemsPerPage', $itemsPerPage, \PDO::PARAM_INT);
        $stmtDettes->execute();
        $dettes = $stmtDettes->fetchAll(\PDO::FETCH_ASSOC);
    
        // Récupérez le nombre total de dettes pour la pagination
        $totalDettesQuery = "SELECT COUNT(*) as total FROM Dette WHERE id_client = :clientId AND $filterCondition";
        $totalStmt = $this->db->prepare($totalDettesQuery);
        $totalStmt->bindValue(':clientId', $clientId, \PDO::PARAM_INT);
        $totalStmt->execute();
        $totalDettes = $totalStmt->fetch(\PDO::FETCH_ASSOC)['total'];
        $totalPages = ceil($totalDettes / $itemsPerPage);
    
        require ROUT.'/src/Core/view/ListeDette.html.php';
    }
    
    //on doit utiliser l'id client définie dans la session pour ajouter une dette
    public function create() {
        // Vérifiez si l'ID du client est déjà dans la session
        if (!isset($_SESSION['id_client'])) {
            // Redirigez ou affichez une erreur
            echo "Aucun client sélectionné.";
            return;
        }
        // Récupérez les informations du client
        $client = $this->clientModel->getClientById($_SESSION['id_client']);
        // Afficher le formulaire pour ajouter une dette
        require ROUT.'/src/Core/view/AjouterDette.html.php';
    }

    
    public function listPaiements($id_dette) {
        // Récupérer les paiements pour la dette donnée
        $paiements = $this->paiementModel->getPaiementsByDetteId($id_dette);
    
        // Récupérer les informations de la dette
        $dette = $this->detteModel->getDetteById($id_dette);
    
        // Récupérer les informations du client associé à cette dette
        $client = $this->clientModel->getClientById($dette['id_client']);
    
        // Passer les données à la vue
        require ROUT.'/src/Core/view/ListePaiements.html.php';
    }
    public function listProducts($id_dette) {
        // Supposons que vous ayez une méthode dans votre modèle pour obtenir les produits par ID de dette
        $products = $this->productModel->getProductsByDetteId($id_dette);
    
        header('Content-Type: application/json');
        echo json_encode($products);
    }
    
    
    
    public function handlePayment() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_dette = $_POST['id_dette'];
            $paymentAmount = $_POST['paymentAmount'];
    
            // Validation
            $validator = new Validator();
            $validator->validate('paymentAmount', $paymentAmount, [
                'required' => true,
                'numeric' => true,
            ]);
    
            // Récupération de la dette
            $dette = $this->detteModel->getDetteById($id_dette);
            if (!$dette) {
                $validator->addError('dette', "La dette spécifiée n'existe pas.");
            }
    
            // Vérification si le montant saisi est supérieur au montant restant
            if ($dette && $paymentAmount > $dette['montant_restant']) {
                $validator->addError('paymentAmount', 'Le montant saisi ne peut pas être supérieur au montant restant.');
            }
    
            if ($validator->hasErrors()) {
                // Retourner les erreurs en JSON
                header('Content-Type: application/json');
                echo json_encode(['errors' => $validator->getErrors()]);
                return;
            }
    
            if ($dette) {
                $montantVerser = $dette['montant_verser'] + $paymentAmount;
                $montantRestant = $dette['montant_restant'] - $paymentAmount;
    
                // Mise à jour de la dette
                $this->detteModel->updatePayment($id_dette, $montantVerser, $montantRestant);
    
                // Ajouter un enregistrement dans la table Paiement
                $this->detteModel->addPayment($id_dette, $paymentAmount);
    
                // Retourner une réponse de succès en JSON
                header('Content-Type: application/json');
                echo json_encode(['success' => true]);
                return;
            }
        }
    }
    
    

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_client = $_POST['id_client'];
            $id_prod = $_POST['id_prod'];
            $montant = $_POST['montant'];
            $quantite = $_POST['quantite'];
    
            // Calculez le montant total
            $total = $montant * $quantite;
    
            // Ajoutez la dette
            $this->detteModel->addDette($id_client, $id_prod, $total, $quantite);
    
            // Redirigez vers la liste des dettes ou affichez un message de succès
            header('Location: /dette/list');
            exit;
        }
    }

    public function getProducts() {
        $products = $this->detteModel->getAllProducts();
        echo json_encode($products);
    }
    
}