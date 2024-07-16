<?php

    namespace App\Controller;

    use Core\Controller;
    use Core\Database\MysqlDatabase;
    use Core\Model\AbstractValidator;   
    
    class Validator extends AbstractValidator {

        protected $errors = [];
        public function validateNom($nom) {
            if (empty($nom)) {
                return 'Le nom est requis';
            } elseif (!preg_match('/^[a-zA-Z��-Ö��-öø-��\s]{2,50}$/', $nom)) {
                return 'Le nom doit contenir entre 2 et 50 caractères alphabétiques et espaces';
            }
            return null;
        }

        public function validatePrenom($prenom) {
            if (empty($prenom)) {
                return 'Le prénom est requis';
            } elseif (!preg_match('/^[a-zA-Z��-Ö��-öø-��\s]{2,50}$/', $prenom)) {
                return 'Le prénom doit contenir entre 2 et 50 caractères alphabétiques et espaces';
            }
            return null;
        }

        public function validateEmail($email) {
            if (empty($email)) {
                return 'L\'email est requis';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return 'L\'email n\'est pas valide';
            }
            return null;
        }

        public function validateAdresse($adresse) {
            if (empty($adresse)) {
                return 'L\'adresse est requise';
            } elseif (!preg_match('/^[a-zA-Z��-Ö��-öø-��0-9\s]{5,100}$/', $adresse)) {
                return 'L\'adresse doit contenir entre 5 et 100 caractères alphanumériques et espaces';
            }
            return null;
        }

        public function validateTelephone($telephone) {
            if (empty($telephone)) {
                return 'Le téléphone est requis';
            } elseif (!preg_match('/^[0-9]{10}$/', $telephone)) {
                return 'Le téléphone doit être un numéro de 10 chiffres';
            }
            return null;
        }
        public function validatePhoto($photo) {
            if ($photo === null) {
                return 'Une photo est requise';
            } elseif (!is_uploaded_file($photo['tmp_name'])) {
                return 'Une photo a été détectée mais n\'a pas été téléchargée';
            }
            return null;
        }

        public function validate($field, $value, $rules) {
            foreach ($rules as $rule => $ruleValue) {
                if ($rule === 'required' && empty($value)) {
                    $this->addError($field, "Le champ $field est requis.");
                }
                if ($rule === 'numeric' && !is_numeric($value)) {
                    $this->addError($field, "Le champ $field doit être un nombre.");
                }
            }
        }
    
        public function addError($field, $message) {
            $this->errors[$field] = $message;
        }
    
        public function hasErrors() {
            return !empty($this->errors);
        }
    
        public function getErrors() {
            return $this->errors;
        }

    }