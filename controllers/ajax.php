<?php

require('../config/env.php');
require('../helpers/Database.php');
require('../models/photos.php');
require('../models/albums.php');


$albumId = $_POST['album'];
$photo = new Albums();
$photos = $photo->showPhotosFromAlbum($albumId);

foreach ($photos as $photo) {
    echo '<img src="' . $photo['photos_path'] . '" alt="' . $photo['photos_name'] . '">';
};
