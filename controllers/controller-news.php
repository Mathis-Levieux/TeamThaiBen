<?php
require('../config/env.php');
require('../helpers/Database.php');
require('../models/news.php');

// On récupère toutes les news
$getAllNews = new News();
$news = $getAllNews->getNewsSortedByDateAndId();













include('../views/view-news.php');
