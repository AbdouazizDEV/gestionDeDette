<?php

namespace Core;

class Controller {
    protected function renderView($view, $data = []) {
        extract($data);
        include __DIR__ . "/../../view/$view.html.php";
    }

    protected function redirect($url) {
        header("Location: $url");
        exit();
    }
    protected function flashMessage($message, $type ='success') {
        $_SESSION['flash_message'] = [
            'type' => $type,
           'message' => $message,
        ];
    }
}

