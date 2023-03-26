<?php
require('../config/env.php');
require('../helpers/Database.php');
require('../models/news.php');

session_start();

if (!isset($_SESSION['login'])) { // On vérifie que l'utilisateur est connecté
    header('Location: controller-login.php'); // Sinon on le redirige vers la page de connexion
}



class NewsController
{
    private array $_errors = [];
    private string $_success = '';

    public static function showNewsTypes(): array
    {
        $newsTypes = new News();
        $newsTypes = $newsTypes->getNewsTypes();
        return $newsTypes;
    }

    public static function showNews(): array
    {
        $news = new News();
        $news = $news->getNews();
        return $news;
    }

    public static function showNewsById(int $id): array | bool
    {
        $news = new News();
        $news = $news->getNewsById($id);
        return $news;
    }

    public function getErrorsMessages(): array
    {
        return $this->_errors;
    }

    public function getSuccessMessage(): string
    {
        return $this->_success;
    }

    public function modifyNews(int $id): void
    {
        if (isset($_POST['newsTitle']) && isset($_POST['newsContent']) && isset($_POST['newsType'])) {
            $title = $_POST['newsTitle'];
            $content = $_POST['newsContent'];
            $type = $_POST['newsType'];

            $this->verifyTitle($title);
            $this->verifyContent($content);
            $this->verifyType($type);

            $date = date('Y-m-d'); // On récupère la date et l'heure actuelle

            if (empty($this->_errors)) {
                $news = new News();
                $news->modifyNews($id, $title, $content, $type);
                $this->_success = 'L\'article a bien été modifié';
            }
        } else {
            $this->_errors[] = 'Veuillez remplir tous les champs';
        }
    }

    private function verifyTitle(string $title): array
    {
        // On vérifie que le titre n'est pas vide
        if (empty($title)) {
            $this->_errors[] = 'Le titre de l\'article ne peut pas être vide';
        } else if (strlen($title) > 300) { // On vérifie que le titre n'est pas trop long
            $this->_errors[] = 'Le titre de l\'article ne peut pas dépasser 100 caractères';
        } else {
            $title = htmlspecialchars(ucfirst(trim($title))); // On supprime les espaces en début et fin de chaîne, on met la première lettre en majuscule et on convertit les caractères spéciaux en entités HTML
        }
        return $this->_errors;
    }

    private function verifyContent(string $content): array
    {
        // On vérifie que le contenu n'est pas vide
        if (empty($content)) {
            $this->_errors[] = 'Le contenu de l\'article ne peut pas être vide';
        } else {
            $content = trim($content); // On supprime les espaces en début et fin de chaîne
        }
        return $this->_errors;
    }

    private function verifyType(int $type): array
    {
        // On vérifie que le type de news existe
        $newsTypes = new News();
        $newsTypes = $newsTypes->getNewsTypes();
        $newsTypesArray = [];
        foreach ($newsTypes as $newsType) {
            $newsTypesArray[] = $newsType['news_type_id'];
        }
        if (!in_array($type, $newsTypesArray)) {
            $this->_errors[] = 'Le type d\'article n\'existe pas';
        }
        return $this->_errors;
    }

    public function deleteNews(int $id): void
    {
        // On vérifie que la news existe
        $news = new News();
        $news = $news->getNewsById($id);
        if (empty($news)) {
            $this->_errors[] = 'L\'article n\'existe pas';
        } else {
            $news = new News();
            $news->deleteNews($id);
            $this->_success = 'L\'article a bien été supprimée';
        }
    }
}


// Modification d'un type de news

if (isset($_POST['submitModifyNews'])) {
    $modifyNews = new NewsController();
    $modifyNews->modifyNews($_GET['id']);
}

// Suppression d'une news

if (isset($_GET['delete']) && !empty($_GET['delete']) && is_numeric($_GET['delete'])) {
    $deleteNews = new NewsController();
    $deleteNews->deleteNews($_GET['delete']);
}


// Récupère tous les types de news pour les afficher dans la vue
$newsTypes = NewsController::showNewsTypes();
$newsList = NewsController::showNews();


// Si l'id de la news est correctement défini, on récupère les informations de la news, 
// sinon on redirige vers la page d'accueil

if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
    $news = NewsController::showNewsById($_GET['id']);
    if (empty($news)) {
        header('Location: controller-dashboard-news.php');
    }
} else {
    header('Location: controller-dashboard-news.php');
}















include('../views/view-dashboard-modify.php');
