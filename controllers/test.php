<?php

require('../config/env.php');
require('../helpers/Database.php');
require('../models/photos.php');



// Appeler la fonction pour récupérer les images
$photo = new Photos(); // Instancier votre classe Photo
$images = $photo->getSomePhotos(5); // Appeler la fonction avec le nombre de photos

// Afficher les images
foreach ($images as $image) {
    echo '<img src="' . $image['photos_path'] . '" alt="' . $image['photos_name'] . '">';
}
