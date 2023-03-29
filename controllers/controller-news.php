<?php
require('../config/env.php');
require('../helpers/Database.php');
require('../models/news.php');

// On récupère toutes les news
$getAllNews = new News();
$news = $getAllNews->getNews();













include('../views/view-news.php');
