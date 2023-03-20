<?php

require('../config/env.php');
require('../helpers/Database.php');
require('../models/files.php');

session_start();

if (!isset($_SESSION['login'])) {
    header('Location: controller-login.php');
}

$title = 'Administration - Fichiers';

class File
{
    private string $_destination = '../uploads/files/';
    private array $_errors = [];
    private array $_allowedExtensions = ['pdf'];
    private int $_maxSize = 1000000; // 1Mo
    private string $_success = '';

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
            $name = uniqid() . '_' . $file['name'];  // Ajoute un uniqid en plus du nom du fichier pour éviter les doublons
            $name = str_replace(' ', '_', $name);   // supprime les espaces dans le nom du fichier en les remplaçant par des underscores
            if (move_uploaded_file($file['tmp_name'], $this->_destination . $name)) { // déplace le fichier dans le dossier de destination
                $this->_success = 'Fichier envoyé avec succès';
                $this->saveFileInDatabase($name); // on enregistre le fichier dans la base de données
            } else { // si le fichier n'a pas pu être déplacé
                $this->_errors[] = 'Erreur lors de l\'enregistrement';
            }
        }
    }

    private function saveFileInDatabase(string $name): void
    {
        $file = new Files();
        $file->uploadFile($name);
    }

    public function getSuccessMessage(): string
    {
        return $this->_success;
    }

    public function getErrorsMessage(): array
    {
        return $this->_errors;
    }

    public function showFiles(): array
    {
        $file = new Files();
        return $file->getAllFiles();
    }

    public function deleteFile($id): void // Supprime un fichier
    {
        if (empty($_GET['delete'])) { // si l'identifiant n'est pas renseigné
            $this->_errors[] = 'Aucun fichier sélectionné';
        } else if (!is_numeric($_GET['delete'])) { // si l'identifiant n'est pas un nombre
            $this->_errors[] = 'Identifiant invalide';
        } else if (empty($this->getFileById($_GET['delete']))) { // si le fichier n'existe pas
            $this->_errors[] = 'Aucun fichier trouvé';
        } else { // si tout est ok
            $file = $this->getFileById($_GET['delete']);
            if (unlink($this->_destination . $file['files_name'])) { // on supprime le fichier
                $this->_success = 'Fichier supprimé avec succès';
                $file = new Files();
                $file->deleteFile($id);
            } else {
                $this->_errors[] = 'Erreur lors de la suppression';
            }
        }
    }

    public function getFileById($id)
    {
        $file = new Files();
        return $file->getFileById($id);
    }

    public function changeFileBoolean($id, $boolean): void
    {
        // Vérification des paramètres
        if (empty($id)) {
            $this->_errors[] = 'Aucun fichier sélectionné';
        } elseif (!is_numeric($id)) {
            $this->_errors[] = 'Identifiant invalide';
        } elseif ($boolean !== 0 && $boolean !== 1) {
            $this->_errors[] = 'Valeur invalide';
        }

        // Vérification de l'existence du fichier
        if (empty($this->_errors)) {
            $file = $this->getFileById($id);
            if (empty($file)) {
                $this->_errors[] = 'Aucun fichier trouvé';
            }
        }

        // Modification de la valeur du boolean
        if (empty($this->_errors)) {
            $file = new Files();
            $file->changeFileBoolean($id, $boolean);
            $this->_success = 'Fichier modifié avec succès';
        }
    }

    public function downloadFile($id): void
    {
        // Vérification des paramètres
        if (empty($id)) {
            $this->_errors[] = 'Aucun fichier sélectionné';
        } elseif (!is_numeric($id)) {
            $this->_errors[] = 'Identifiant invalide';
        }

        // Vérification de l'existence du fichier
        if (empty($this->_errors)) {
            $file = $this->getFileById($id);
            if (empty($file)) {
                $this->_errors[] = 'Aucun fichier trouvé';
            }
        }

        // Téléchargement du fichier
        if (empty($this->_errors)) {
            $file = $this->getFileById($id);
            $file = $this->_destination . $file['files_name'];
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
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

// Utilisation de la classe File pour supprimer un fichier

if (isset($_GET['delete'])) { // si l'id du fichier à supprimer est envoyé
    $file = new File();
    $file->deleteFile($_GET['delete']); // on supprime le fichier
}

if (isset($_GET['show'])) { // si l'id du fichier à montrer est envoyé
    $file = new File();
    $file->changeFileBoolean($_GET['show'], 1); // on montre le fichier
}

if (isset($_GET['hide'])) { // si l'id du fichier à caché est envoyé
    $file = new File();
    $file->changeFileBoolean($_GET['hide'], 0); // on cache le fichier
}

// Utilisation de la classe File pour télécharger un fichier

if (isset($_GET['download'])) { // si l'id du fichier à télécharger est envoyé
    $file = new File();
    $file->downloadFile($_GET['download']); // on télécharge le fichier
}




include('../views/view-dashboard-files.php');
