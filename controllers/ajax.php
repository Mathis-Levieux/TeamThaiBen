<?php

require('../config/env.php');
require('../helpers/Database.php');
require('../models/photos.php');
require('../models/albums.php');

// ajax.php
$albumId = $_POST['albumId'] ?? null; // Utiliser la syntaxe de fusion null pour définir $albumId à null si la clé n'est pas définie

if ($albumId !== null) {
    // Utiliser $albumId pour récupérer les photos de l'album choisi
    $photo = new Albums();
    $photos = $photo->showPhotosFromAlbum($albumId);

    // Générer la réponse avec les images des photos
    foreach ($photos as $photo) {
        echo '<img src="' . $photo['photos_path'] . '" alt="' . $photo['photos_name'] . '">';
    };
} else {
    // Gérer le cas où "albumId" n'est pas défini dans la requête
    echo 'Erreur : albumId non défini dans la requête.';
}
