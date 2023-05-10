<?php

require('../config/env.php');
require('../helpers/Database.php');
require('../models/photos.php');
require('../models/albums.php');

// ajax.php
// Récupérer le corps de la requête
$requestBody = file_get_contents('php://input');

// Décoder le corps de la requête JSON en un tableau associatif
$requestData = json_decode($requestBody, true);

// Récupérer la valeur de "albumId" du tableau associatif
$albumId = $requestData['albumId'] ?? null; // Utiliser la syntaxe de fusion null pour définir $albumId à null si la clé n'est pas définie

if ($albumId !== null) {
    // Utiliser $albumId pour récupérer les photos de l'album choisi
    $photo = new Albums();
    $photos = $photo->getAlbumsById($albumId);
    $album = new Albums();
    $albumName = $album->getAlbumNameById($albumId);
    // Générer la réponse avec les images des photos
    echo '<h3 class="my-3 text-light">Album ' . $albumName . '</h3>';
    if (empty($photos)) {
        echo '<p class="text-light">Aucune photo dans cet album</p>';
    }
    foreach ($photos as $photo) {
        echo '<span class="col-md-2 col-6 my-2">
        <a href="' . $photo['photos_path'] . '" data-pswp-width="850" data-pswp-height="850" target="_blank">
        <img src="' . $photo['photos_path'] . '" alt="Photo Team Thai Ben de l\'Album ' . $photo['albums_name'] . '" class="img-fluid">
        </a>
        </span>';
    }
} else {
    // Gérer le cas où "albumId" n'est pas défini dans la requête
    echo 'Erreur : albumId non défini dans la requête.';
}
