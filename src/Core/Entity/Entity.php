<?php

namespace Core\Entity;

abstract class Entity {
    protected $table;

    public function __get($name) {
        return $this->$name;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }

    // Ajouter d'autres méthodes nécessaires
}
