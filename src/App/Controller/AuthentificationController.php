<?php

namespace App\Controller;

use Core\Session;
use Core\Security\SecurityDatabase;


class AuthentificationController {
    public function showLoginForm() {
        require_once __DIR__ . '../../../Core/view/Connexion.php';
    }

    public function login() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $auth = new SecurityDatabase();
        if ($auth->login($username, $password)) {
            Session::start();
            Session::set('user', $username);
            header('Location: /RechercheClient.html.php');
            exit;
        } else {
            header('Location: /connexion.php');
            exit;
        }
    }
}
