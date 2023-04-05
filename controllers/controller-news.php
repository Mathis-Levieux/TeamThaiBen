<?php
require('../config/env.php');
require('../helpers/Database.php');
require('../models/news.php');

// On récupère toutes les news
$getAllNews = new News();
$news = $getAllNews->getNewsSortedByDateAndId();

foreach ($news as $key => $value) {
    $news[$key]['news_content'] = reduceString($value['news_content']);
}

// On affiche que les 400 premiers caractères de la news
function reduceString(string $string): string
{
    $string = substr($string, 0, 400); // On coupe la chaîne à 300 caractères
    $string = substr($string, 0, strrpos($string, ' ')); // On supprime les mots coupés
    $string = $string . '...'; // On ajoute des points de suspension
    return $string;
}


// Si on récupère un id de news dans l'url, on affiche la news correspondante
if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
    // On vérifie que l'id de la news est un nombre
    $id = $_GET['id'];
    $getNewsById = new News();
    $newsById = $getNewsById->getNewsById($id);
    if (empty($newsById)) { // Si la news n'existe pas, on affiche une erreur
        header('Location: 404.php');
    }
}







include('../views/view-news.php');
