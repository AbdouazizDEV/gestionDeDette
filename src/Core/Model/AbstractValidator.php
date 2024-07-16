<?php 

namespace Core\Model;

   abstract class AbstractValidator {
        public abstract function validateNom($nom);
        public abstract function validatePrenom($prenom);
        public abstract function validateEmail($email);
        public abstract function validateAdresse($adresse);
        public abstract function validateTelephone($telephone);
        public abstract function validatePhoto($photo);
   }
   