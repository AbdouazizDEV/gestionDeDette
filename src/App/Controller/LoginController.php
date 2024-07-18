<?php

namespace App\Controller;

use App\Core\Security\SecurityDatabase;
use Core\Database\MysqlDatabase;




class LoginController
{
    /*private $security;

    public function __construct()
    {
        $this->security = new SecurityDatabase(MysqlDatabase::getInstance());
    }

    public function authenticate()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $this->security->login($username, $password);

        if ($user) {
            session_start();
            $_SESSION['user'] = $user;
            header("Location: /view/RechercheClient.html.php");
        } else {
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }
    }*/
}
