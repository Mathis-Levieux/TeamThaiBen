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
            // Vérifier si les champs sont remplis
            if (empty($_POST['albumchoice'])) {
                // Gérer l'erreur
                echo 'Veuillez choisir un album';
                $errors['albumchoice'] = 'Veuillez choisir un album';
            } elseif (empty($_FILES['photos'])) {
                // Gérer l'erreur
                echo 'Veuillez choisir au moins une photo';
                $errors['photos'] = 'Veuillez choisir au moins une photo';
            } else {

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
                        $errors['photos'] = 'Extension non autorisée';
                    }

                    // Vérifier la taille
                    if ($fileSize > $this->_maxFileSize) {
                        // Fichier trop volumineux
                        // Gérer l'erreur
                        echo 'Fichier trop volumineux';
                        $errors['photos'] = 'Fichier trop volumineux';
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
                        $message = 'Fichier hébergé';
                    } else {
                        // Erreur lors de l'hébergement
                        // Gérer l'erreur
                        echo 'Erreur lors de l\'hébergement';
                        $errors['photos'] = 'Erreur lors de l\'hébergement';
                    }
                }
            }
        }
    }
}

// Utilisation de la classe UploadController
if (isset($_POST['submitPhotos'])) {  // Si le bouton submit est cliqué
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
if (isset($_POST['submitNewAlbum']) && isset($_POST['NewAlbum'])) { // Si le bouton submit est cliqué
    createAlbum(); // On appelle la fonction createAlbum
}


// Affichage du select des albums
function showSelectAlbums()
{
    $albums = new Albums();
    $albums = $albums->getAlbums();
    foreach ($albums as $album) {
        echo '<option value="' . $album['albums_id'] . '">' . $album['albums_name'] . '</option>';
    }
}


function deleteAlbum()  // Fonction pour supprimer un album
{
    if (empty($_POST['deleteAlbum'])) { // Si le champ est vide
        $errors['deleteAlbum'] = 'Veuillez choisir un album';
        echo 'Veuillez choisir un album';
    } else {
        $albumName = new Albums();
        $albumId = $_POST['deleteAlbum']; // Récupération de l'id de l'album
        $albumName = $albumName->getAlbumNameById($albumId); // Récupération du nom de l'album grâce à l'id
        $albumName = $albumName['albums_name']; // Récupération du nom de l'album dans le tableau
        $deleteAlbum = new Albums();
        $deleteAlbum->deleteAlbum($albumId); // Suppression de l'album en base de données
        if (file_exists('../uploads/albums/' . $albumName)) { // Si le dossier existe
            // Récupère les photos dans le dossier
            $files = glob('../uploads/albums/' . $albumName . '/*');
            // Boucle pour supprimer les photos
            foreach ($files as $file) {
                unlink($file);
            }
            rmdir('../uploads/albums/' . $albumName); // Suppression du dossier
        }
        echo 'Album supprimé';
    }
}

if (isset($_POST['submitDeleteAlbum'])) { // Si le bouton submit est cliqué
    deleteAlbum(); // On appelle la fonction deleteAlbum
}

include('../views/dashboard-gallery.php');
