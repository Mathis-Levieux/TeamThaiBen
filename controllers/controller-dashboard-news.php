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

    public function createNewsType(string $name): void
    {

        if (empty($name)) { // On vérifie que le nom n'est pas vide
            $this->_errors[] = 'Le nom du type de news ne peut pas être vide';
        } else if (strlen($name) > 50) {  // On vérifie que le nom n'est pas trop long et ne contient pas de caractères spéciaux
            $this->_errors[] = 'Le nom du type de news ne peut pas dépasser 50 caractères';
        } else if (!preg_match('/^[a-zA-Z0-9_ ]+$/', $name)) { // On vérifie que le nom ne contient que des lettres, des chiffres, des underscores et des espaces
            $this->_errors[] = 'Le nom du type de news ne peut contenir que des lettres, des chiffres et des underscores';
        }

        // Si il n'y a pas d'erreurs, on vérifie que le type de news n'existe pas déjà

        if (empty($this->_errors)) {
            $news = new News();
            $news = $news->getNewsTypes();
            foreach ($news as $newsType) {
                if ($newsType['news_type'] == $name) {
                    $this->_errors[] = 'Ce type de news existe déjà';
                }
            }
        }

        // Si il n'y a pas d'erreurs, on valide la création du type de news

        if (empty($this->_errors)) {
            $name = trim($name); // On supprime les espaces en début et fin de chaîne
            $news = new News();
            $news->addNewsType($name);
            $this->_success = 'Le type de news a bien été créé';
        }
    }

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

    public function deleteNewsType(int $id): void
    {
        $deleteNews = new News();
        $deleteNews->deleteNewsType($id);
        $this->_success = 'Le type de news a bien été supprimé';
    }

    public function getErrorsMessages(): array
    {
        return $this->_errors;
    }

    public function getSuccessMessage(): string
    {
        return $this->_success;
    }



    public function createNews(): void
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
                $news->addNews($title, $content, $type, $date);
                $this->_success = 'La news a bien été créée';
            }
        } else {
            $this->_errors[] = 'Veuillez remplir tous les champs';
        }
    }

    private function verifyTitle(string $title): array
    {
        // On vérifie que le titre n'est pas vide
        if (empty($title)) {
            $this->_errors[] = 'Le titre de la news ne peut pas être vide';
        } else if (strlen($title) > 300) { // On vérifie que le titre n'est pas trop long
            $this->_errors[] = 'Le titre de la news ne peut pas dépasser 100 caractères';
        } else {
            $title = htmlspecialchars(ucfirst(trim($title))); // On supprime les espaces en début et fin de chaîne, on met la première lettre en majuscule et on convertit les caractères spéciaux en entités HTML
        }
        return $this->_errors;
    }

    private function verifyContent(string $content): array
    {
        // On vérifie que le contenu n'est pas vide
        if (empty($content)) {
            $this->_errors[] = 'Le contenu de la news ne peut pas être vide';
        } else if (strlen($content) > 3000) { // On vérifie que le contenu n'est pas trop long
            $this->_errors[] = 'Le contenu de la news ne peut pas dépasser 3000 caractères';
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
            $this->_errors[] = 'Le type de news n\'existe pas';
        }
        return $this->_errors;
    }

    public function deleteNews(int $id): void
    {
        // On vérifie que la news existe
        $news = new News();
        $news = $news->getNewsById($id);
        if (empty($news)) {
            $this->_errors[] = 'La news n\'existe pas';
        } else {
            $news = new News();
            $news->deleteNews($id);
            $this->_success = 'La news a bien été supprimée';
        }
    }
}

// Création d'un nouveau type de news

if (isset($_POST['submitNewsType'])) {
    $newNewsType = new NewsController();
    $newNewsType->createNewsType($_POST['inputNewsType']);
}

// Création d'une news

if (isset($_POST['submitNews'])) {
    $newNews = new NewsController();
    $newNews->createNews();
}

// Suppression d'un type de news

if (isset($_POST['submitDeleteNewsType'])) {
    $deleteNews = new NewsController();
    $deleteNews->deleteNewsType($_POST['selectNewsType']);
}

// Suppression d'une news

if (isset($_GET['delete']) && !empty($_GET['delete']) && is_numeric($_GET['delete'])) {
    $deleteNews = new NewsController();
    $deleteNews->deleteNews($_GET['delete']);
}


// Récupère tous les types de news pour les afficher dans la vue
$newsTypes = NewsController::showNewsTypes();
$newsList = NewsController::showNews();






















include('../views/view-dashboard-news.php');
