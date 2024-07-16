<?php

namespace App\Controller;

use Core\Controller;
use Core\Database\MysqlDatabase;
use App\Validator\Validator;
use App\Model\ClientModel;
use Core\Session;

class ClientController {
    private $clientModel;

    public function __construct() {
        $this->clientModel = new ClientModel();
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator($_POST);
            $errors = $validator->validate();

            if (!empty($errors)) {
                include ROUT.'/src/Core/view/RechercheClient.html.php';
                include ROUT.'/src/Core/view/menu.php';
                echo "<script>showModal();</script>";
                return;
            }

            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $adresse = $_POST['adresse'];
            $tel = $_POST['tel'];

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $photoTmpPath = $_FILES['photo']['tmp_name'];
                $photoName = $_FILES['photo']['name'];
                $uploadDir = '/uploads/';
                $destPath = $uploadDir . $photoName;

                if (move_uploaded_file($photoTmpPath, $destPath)) {
                    $photo = $destPath;
                } else {
                    echo "Erreur lors du téléchargement de la photo.";
                    return;
                }
            } else {
                $photo = null;
            }

            $this->clientModel->createClient($nom, $prenom, $email, $adresse, $tel, $photo);

            include ROUT.'/src/Core/view/RechercheClient.html.php';
            include ROUT.'/src/Core/view/menu.php';
            echo "<script>showSuccessModal();</script>";
        }
    }

    public function search() {
        include ROUT.'/src/Core/view/RechercheClient.html.php';
        include ROUT.'/src/Core/view/menu.php';
    }

    public function getClient() {
        if (isset($_SESSION['id_client'])) {
            $client = $this->clientModel->getClientById($_SESSION['id_client']);
            echo json_encode($client);
        } else {
            echo json_encode(['error' => 'Client non trouvé']);
        }
    }

    public function searchByPhone() {
        $phone = $_GET['tel'] ?? '';

        if (empty($phone)) {
            echo json_encode(['error' => 'Numéro de téléphone requis']);
            return;
        }

        $client = $this->clientModel->getClientByPhone($phone);
        if ($client) {
            Session::start();
            Session::set('id_client', $client['id']); 
            
            $dettes = $this->clientModel->getClientDebts($client['id']);

            $totalDebt = 0;
            $amountPaid = 0;
            $remainingAmount = 0;

            foreach ($dettes as $dette) {
                $totalDebt += (float)$dette['montant'];
                $amountPaid += (float)$dette['montant_verser'];
                $remainingAmount += (float)$dette['montant_restant'];
            }

            $client['totalDebt'] = $totalDebt;
            $client['amountPaid'] = $amountPaid;
            $client['remainingAmount'] = $remainingAmount;
            echo json_encode($client);
        } else {
            echo json_encode(['error' => 'Client non trouvé']);
        }
    }

    public function list() {
        echo "Liste des clients";
    }

    public function error() {
        http_response_code(404);
        include ROUT.'/src/Core/view/ERROR404.php';
    }
}
?>
