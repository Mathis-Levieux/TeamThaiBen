<?php

require('../config/env.php');
require('../helpers/Database.php');
require('../models/albums.php');
require('../models/photos.php');

$AlbumList = new Albums();
$albums = $AlbumList->getAlbums();

$somePhotos = new Photos();
$somePhotos = $somePhotos->getSomePhotos(5);


include('../views/view-test.php');
