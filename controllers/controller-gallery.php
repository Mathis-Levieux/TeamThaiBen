<?php
require('../config/env.php');
require('../helpers/Database.php');
require('../models/albums.php');
require('../models/photos.php');

$AlbumList = new Albums();
$albums = $AlbumList->getAlbums();

$somePhotos = new Photos();
$somePhotos = $somePhotos->getSomePhotos(5);

// if (isset($_POST['album'])) {
//     $albumId = $_POST['album'];
//     $albumPhotos = new Albums();
//     $photos = $albumPhotos->getAlbumsById($albumId);
//     $albumName = $albumPhotos->getAlbumNameById($albumId);
// }


include('../views/view-gallery.php');
