<?php
require('../config/env.php');
require('../helpers/Database.php');
require('../models/albums.php');
require('../models/photos.php');

session_start();

if (!isset($_SESSION['login'])) {
    header('Location: controller-login.php');
}


class UploadController // Création d'une classe UploadController pour gérer l'upload des photos
{
    private $_allowedExtensions = ['jpg', 'jpeg', 'png'];
    private $_maxFileSize = 4000000; // 4 Mo
    private $_destination;
    private string $_AlbumName;

    public function upload() // Création d'une méthode upload
    {


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $files = $_FILES['photos'];
            $fileCount = count($files['name']);

            for ($i = 0; $i < $fileCount; $i++) {
                $fileName = $files['name'][$i];
                $fileType = $files['type'][$i];
                $fileTmpName = $files['tmp_name'][$i];
                $fileSize = $files['size'][$i];
                $fileError = $files['error'][$i];
                $albumId = $_POST['albumchoice'];

                // Vérifier l'extension
                $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                if (!in_array(strtolower($fileExtension), $this->_allowedExtensions)) {
                    // Extension non autorisée
                    // Gérer l'erreur
                    echo 'Extension non autorisée';
                }

                // Vérifier la taille
                if ($fileSize > $this->_maxFileSize) {
                    // Fichier trop volumineux
                    // Gérer l'erreur
                    echo 'Fichier trop volumineux';
                }
                // Obtention du chemin de destination en utilisant la fonction getAlbumNameById de la classe Albums pour héberger le fichier dans le bon dossier
                $obj = new Albums();
                $_AlbumName = $obj->getAlbumNameById($albumId);
                $_AlbumName = $_AlbumName['albums_name'];
                $this->_destination = '../uploads/albums/' . $_AlbumName . '/';
                // Hébergement du fichier
                $newFileName = uniqid() . '.' . $fileExtension;
                $destination = $this->_destination . $newFileName;

                if (move_uploaded_file($fileTmpName, $destination)) {
                    // Fichier hébergé
                    // Enregistrer le fichier en base de données
                    $photo = new Photos($newFileName, $destination, $albumId);
                    $photo->uploadPhoto();
                    echo 'Fichier hébergé';
                } else {
                    // Erreur lors de l'hébergement
                    // Gérer l'erreur
                    echo 'Erreur lors de l\'hébergement';
                }
            }
        }
    }
}


// Utilisation de la classe UploadController
if (isset($_POST['submit']) && isset($_POST['albumchoice'])) {  // Si le bouton submit est cliqué
    $upload = new UploadController();  // On instancie la classe UploadController
    $upload->upload(); // On appelle la méthode upload
}

// Fonction pour créer un nouvel album
function createAlbum()
{
    if (empty($_POST['NewAlbum'])) {   // Si le champ est vide
        $errors['NewAlbum'] = 'Le nom d\'album ne doit pas être vide';
        echo 'Le nom d\'album ne doit pas être vide';
    } else {
        if (strlen($_POST['NewAlbum']) > 50) { // Si le nom d'album contient plus de 50 caractères
            $errors['NewAlbum'] = 'Le nom d\'album ne doit pas dépasser 50 caractères';
            echo 'Le nom d\'album ne doit pas dépasser 50 caractères';
        } else {
            $album = new Albums(); // Vérification de si le nom d'album existe déjà
            $album = $album->getAlbumsByName($_POST['NewAlbum']);
            if ($album) {
                $errors['NewAlbum'] = 'Le nom d\'album est déjà utilisé';
                echo 'Le nom d\'album est déjà utilisé';
            } else {
                // Création du dossier de l'album
                if (!file_exists('../uploads/albums/' . $_POST['NewAlbum'])) { // Si le dossier n'existe pas
                    mkdir('../uploads/albums/' . $_POST['NewAlbum']); // On le crée
                }
                $album = new Albums();
                $album->createNewAlbum($_POST['NewAlbum']);
                echo 'Album créé';
            }
        }
    }
}   

// Utilisation de la fonction createAlbum
if (isset($_POST['submit']) && isset($_POST['NewAlbum'])) { // Si le bouton submit est cliqué
    createAlbum(); // On appelle la fonction createAlbum
}



// class AlbumController / 
// {
//     public function getAlbumsById($id)
//     {
//         $album = new Albums();
//         $album = $album->getAlbumsById($id);
//         return $album;
//     }
// }


include('../views/dashboard-gallery.php');
