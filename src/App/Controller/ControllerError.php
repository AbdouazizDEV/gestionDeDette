<?php
namespace App\Controller;

class ControllerError {
    public static function handle() {
        include ROUT.'/src/Core/view/ERROR404.php'; // Ajustez le chemin si nécessaire
    }
}
