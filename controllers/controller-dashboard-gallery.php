<?php

require('../config/env.php');
require('../helpers/Database.php');
require('../models/albums.php');
require('../models/photos.php');

session_start();

if (!isset($_SESSION['login'])) {
    header('Location: controller-login.php');
}

$title = 'Administration - Galerie';

class UploadController // Création d'une classe UploadController pour gérer l'upload des photos
{
    private $_allowedExtensions = ['jpg', 'jpeg', 'png'];
    private $_maxFileSize = 4000000; // 4 Mo
    private $_destination;
    private string $_AlbumName;
    public array $errors = [];
    public string $success = '';

    public function upload() // Création d'une méthode upload
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Vérifier si les champs sont remplis
            if ($_FILES['photos']['error'][0] == 4) {
                $this->errors[] = 'Veuillez choisir une photo';
            }
            if (empty($_POST['AlbumSelect'])) {
                $this->errors[] = 'Veuillez choisir un album';
            } elseif (empty($this->errors)) {

                $files = $_FILES['photos'];
                $fileCount = count($files['name']);

                for ($i = 0; $i < $fileCount; $i++) {
                    $fileName = $files['name'][$i];
                    $fileType = $files['type'][$i];
                    $fileTmpName = $files['tmp_name'][$i];
                    $fileSize = $files['size'][$i];
                    $fileError = $files['error'][$i];
                    $albumId = $_POST['AlbumSelect'];

                    // Vérifier l'extension
                    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                    if (!in_array(strtolower($fileExtension), $this->_allowedExtensions)) {
                        // Extension non autorisée
                        // Gérer l'erreur
                        $this->errors[] = 'Extension non autorisée';
                    }

                    // Vérifier la taille
                    if ($fileSize > $this->_maxFileSize) {
                        // Fichier trop volumineux
                        // Gérer l'erreur
                        $this->errors[] = 'Fichier trop volumineux';
                    }
                    // Obtention du chemin de destination en utilisant la fonction getAlbumNameById de la classe Albums pour héberger le fichier dans le bon dossier
                    $obj = new Albums();
                    $_AlbumName = $obj->getAlbumNameById($albumId);
                    $this->_destination = '../uploads/albums/' . $_AlbumName . '/';
                    // Hébergement du fichier
                    $newFileName = uniqid() . '.' . $fileExtension;
                    $destination = $this->_destination . $newFileName;

                    if (move_uploaded_file($fileTmpName, $destination)) {
                        // Fichier hébergé
                        // Enregistrer le fichier en base de données
                        $photo = new Photos;
                        $photo->createPhoto($newFileName, $destination, $albumId);
                        $photo->uploadPhoto();
                        $this->success = 'Photo(s) hébergée(s)';
                    } else {
                        // Erreur lors de l'hébergement
                        // Gérer l'erreur
                        $this->errors[] = 'Erreur lors de l\'hébergement';
                    }
                }
            }
        }
    }

    public function getErrorsMessages()
    {
        return $this->errors;
    }

    public function getSuccessMessage()
    {
        return $this->success;
    }

    public function deletePhoto() // Fonction pour supprimer une photo
    {
        if (isset($_POST['submitDeletePhoto'])) { // Si le bouton submit est cliqué
            if (empty($_POST['photosToDelete'])) { // Si le champ est vide
                $this->errors[] = 'Veuillez choisir une photo à supprimer';
            } else {
                $photosToDelete = $_POST['photosToDelete']; // Récupération des photos à supprimer
                foreach ($photosToDelete as $photoToDelete) { // Boucle pour supprimer les photos
                    $photo = new Photos();
                    $photo = $photo->getPhotoById($photoToDelete); // Récupération des informations de la photo grâce à l'id
                    $photoPath = $photo['photos_path']; // Récupération du chemin de la photo
                    $photo = new Photos();
                    $photo->deletePhoto($photoToDelete); // Suppression de la photo en base de données
                    if (file_exists($photoPath)) { // Si la photo existe
                        unlink($photoPath); // Suppression de la photo
                        $this->success = 'Photo(s) supprimée(s)';
                    }
                }
            }
        }
    }

    public function deleteAlbum()  // Fonction pour supprimer un album
    {
        if (empty($_POST['AlbumSelect'])) { // Si le champ est vide
            $this->errors[] = 'Veuillez choisir un album à supprimer';
        } else {
            $albumName = new Albums();
            $albumId = $_POST['AlbumSelect']; // Récupération de l'id de l'album
            $albumName = $albumName->getAlbumNameById($albumId); // Récupération du nom de l'album grâce à l'id
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
            $this->success = 'Album supprimé';
        }
    }

    public function modifyAlbumName() // Fonction pour modifier le nom d'un album
    {
        if (empty($_POST['AlbumSelect'])) { // Si le champ est vide
            $this->errors[] = 'Veuillez choisir un album à modifier';
        }
        if (empty($_POST['NewAlbumName'])) { // Si le champ est vide
            $this->errors[] = 'Veuillez choisir un nouveau nom pour l\'album';
        } else {
            if (strlen($_POST['NewAlbumName']) > 50) { // Si le nom d'album contient plus de 50 caractères
                $this->errors[] = 'Le nom d\'album ne doit pas dépasser 50 caractères';
            } else if // On vérifie que le nom d'album n'est pas déjà utilisé
            (file_exists('../uploads/albums/' . $_POST['NewAlbumName'])) {
                $this->errors[] = 'Le nom d\'album est déjà utilisé';
            } else {
                $albumName = new Albums();
                $albumId = $_POST['AlbumSelect']; // Récupération de l'id de l'album
                $albumName = $albumName->getAlbumNameById($albumId); // Récupération du nom de l'album grâce à l'id
                $albumName = $albumName['albums_name']; // Récupération du nom de l'album dans le tableau
                $newAlbumName = $_POST['NewAlbumName']; // Récupération du nouveau nom de l'album
                $modifyAlbumName = new Albums();
                $modifyAlbumName->modifyAlbumName($newAlbumName, $albumId); // Modification du nom de l'album en base de données

                if (file_exists('../uploads/albums/' . $albumName)) { // Si le dossier existe
                    rename('../uploads/albums/' . $albumName, '../uploads/albums/' . $newAlbumName); // Modification du nom du dossier
                }
                $this->success = 'Nom d\'album modifié';
            }
        }
    }

    public function createAlbum()
    {
        if (empty($_POST['NewAlbum'])) {   // Si le champ est vide
            $this->errors[] = 'Veuillez choisir un nom pour l\'album';
        }
        if (strlen($_POST['NewAlbum']) > 50) { // Si le nom d'album contient plus de 50 caractères
            $this->errors[] = 'Le nom d\'album ne doit pas dépasser 50 caractères';
        }
        // On vérifie que l'album ne contient pas de caractères spéciaux
        if (empty($this->errors)) {

            $album = new Albums(); // Vérification de si le nom d'album existe déjà
            $album = $album->getAlbumsByName($_POST['NewAlbum']);
            if ($album) {
                $this->errors[] = 'Le nom d\'album est déjà utilisé';
            } else {
                // Création du dossier de l'album
                if (!file_exists('../uploads/albums/' . $_POST['NewAlbum'])) { // Si le dossier n'existe pas
                    mkdir('../uploads/albums/' . $_POST['NewAlbum']); // On le crée
                }
                $album = new Albums();
                $album->createNewAlbum($_POST['NewAlbum']);
                $this->success = 'Album créé';
            }
        }
    }
}


// Utilisation de la classe UploadController
if (isset($_POST['submitPhotos'])) {  // Si le bouton submit est cliqué
    $upload = new UploadController();  // On instancie la classe UploadController
    $upload->upload(); // On appelle la méthode upload
}

// Utilisation de la fonction createAlbum
if (isset($_POST['submitNewAlbum']) && isset($_POST['NewAlbum'])) { // Si le bouton submit est cliqué
    $createAlbum = new UploadController();
    $createAlbum->createAlbum(); // On appelle la fonction createAlbum
}


// Affichage du select des albums
function showSelectAlbums()
{
    $albums = new Albums();
    $albums = $albums->getAlbums();
    echo ' <select name="AlbumSelect" class="mt-3 form-select">
    <option selected disabled value="">Sélectionne un album</option>';
    foreach ($albums as $album) {
        echo '<option value="' . $album['albums_id'] . '"' . ((isset($_POST['AlbumSelect']) && $_POST['AlbumSelect'] == $album['albums_id']) ? ' selected' : '') . '>' . $album['albums_name'] . '</option>';
    }
    echo '</select>';
}



// Utilisation de la fonction deleteAlbum
if (isset($_POST['submitDeleteAlbum'])) { // Si le bouton submit est cliqué
    $deleteAlbum = new UploadController();
    $deleteAlbum->deleteAlbum(); // On appelle la fonction deleteAlbum
}
// Fonction pour afficher toutes les photos d'un album
function showPhotosInAdminDashboard()
{
    if (isset($_POST['submitDisplayAlbum'])) { // Si l'album est sélectionné
        if (!isset($_POST['AlbumSelect'])) { // Si le champ est vide
            echo '<div class="alert alert-danger" role="alert">Veuillez choisir un album</div>';
        } else {
            $albumId = $_POST['AlbumSelect']; // Récupération de l'id de l'album
            $photos = new Albums();
            $photos = $photos->showPhotosFromAlbum($albumId); // Récupération des photos de l'album grâce à l'id
            echo '<form class="row" action="controller-dashboard-gallery.php" method="post">';
            $count = 1; // Compteur pour le nom de la photo
            if (empty($photos)) { // Si l'album est vide
                echo '<div class="alert alert-danger" role="alert">L\'album ne contient pas de photos</div>';
            } else {
                foreach ($photos as $photo) {
                    $photoPath = '../uploads/albums/' . $photo['albums_name'] . '/' . $photo['photos_name'] . '';
                    echo '<div class="col-lg-3 col-sm-6 col-12 mb-3">';
                    echo '<div class="card lg-4 border shadow-sm">';
                    echo '<img style="height: 200px" class="card-img-top" src="' . $photoPath . '" alt="Club de Boxe Thai de l\'Album ' . $photo['albums_name'] . '">';
                    echo '<div class="card-body">';
                    echo '<div class="d-flex justify-content-between align-items-center">';
                    echo '<div class="btn-group">';
                    echo '<input type="checkbox" name="photosToDelete[]" value="' . $photo['photos_id'] . '" id="' . $photo['photos_id'] . '" class="btn btn-sm btn-outline-secondary">';
                    echo '<label for="' . $photo['photos_id'] . '" class="btn btn-outline-dark rounded border-1 fw-bold ms-2">Cocher</label>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '<div class="col-lg-12 text-center">';
                echo '<input id="deletePhotoButton2" type="submit" name="submitDeletePhoto" class="col-lg-3 mb-3 m-auto btn btn-danger" value="Supprimer">';
                echo '</div>';
                echo '</form>';
            }
        }
    }
}



// Utilisation de la fonction deletePhoto
if (isset($_POST['submitDeletePhoto'])) { // Si le bouton submit est cliqué
    $deletePhoto = new UploadController();
    $deletePhoto->deletePhoto(); // On appelle la fonction deletePhoto
}


// Utilisation de la fonction modifyAlbumName
if (isset($_POST['submitModifyAlbumName']) && isset($_POST['NewAlbumName'])) { // Si le bouton submit est cliqué
    $modifyAlbumName = new UploadController();
    $modifyAlbumName->modifyAlbumName(); // On appelle la fonction modifyAlbumName
}



include('../views/view-dashboard-gallery.php');
