<?php

require('../config/env.php');
require('../helpers/Database.php');
require('../models/files.php');

session_start();

if (!isset($_SESSION['login'])) {
    header('Location: controller-login.php');
}

class File
{
    private $_destination = '../uploads/files/';
    private $_errors = [];
    private $_allowedExtensions = ['pdf'];
    private $_maxSize = 1000000; // 1Mo
    private $_success = '';

    public function verifyFile(): array
    {
        $file = $_FILES['inputFile'] ?? null; // récupère le fichier envoyé par le formulaire (s'il existe)

        if (!$file) { // si le fichier n'existe pas
            $this->_errors[] = 'Aucun fichier sélectionné';
            return $this->_errors; // on arrête la fonction et on retourne les erreurs
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION); // récupère l'extension du fichier

        if (!in_array($extension, $this->_allowedExtensions)) {
            $this->_errors[] = 'Extension non autorisée';
        }

        if ($file['size'] > $this->_maxSize) {
            $this->_errors[] = 'Fichier trop volumineux';
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->_errors[] = 'Erreur lors du transfert';
        }

        return $this->_errors; // on retourne les erreurs
    }

    public function uploadFile(): void
    {
        if (empty($this->_errors)) { // si il n'y a pas d'erreurs
            $file = $_FILES['inputFile']; // récupère le fichier envoyé par le formulaire
            $name = uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION); // génère un nom unique pour le fichier
            if (move_uploaded_file($file['tmp_name'], $this->_destination . $name)) { // déplace le fichier dans le dossier de destination
                $this->_success = 'Fichier envoyé avec succès';
                $this->saveFile($name); // on enregistre le fichier dans la base de données
            } else { // si le fichier n'a pas pu être déplacé
                $this->_errors[] = 'Erreur lors de l\'enregistrement';
            }
        }
    }

    private function saveFile(string $name): void
    {
        
    }

    public function getSuccessMessage(): string
    {
        return $this->_success;
    }
}

// Utilisation de la classe File pour vérifier et envoyer le fichier

if (isset($_POST['submitFile'])) { // si le formulaire a été envoyé
    $errors = new File();
    $errors = $errors->verifyFile(); // On vérifie si il y a des erreurs
    if (empty($errors)) { // si il n'y a pas d'erreurs, on upload le fichier
        $file = new File();
        $file->uploadFile();
    }
}














include('../views/view-dashboard-files.php');
