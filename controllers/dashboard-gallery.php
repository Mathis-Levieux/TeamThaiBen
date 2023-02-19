<?php
require('../config/env.php');
require('../helpers/Database.php');
require('../models/albums.php');
require('../models/photos.php');




class UploadController
{
    private $_allowedExtensions = ['jpg', 'jpeg', 'png'];
    private $_maxFileSize = 4000000; // 4 Mo
    private $_destination = '../uploads/photos/';
    
    public function upload()
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
                $albumId = $_POST['album'];
                
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
                
                // Héberger le fichier
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

if (isset($_POST['submit'])) { 
    $upload = new UploadController();
    $upload->upload();
}












include('../views/dashboard-gallery.php');