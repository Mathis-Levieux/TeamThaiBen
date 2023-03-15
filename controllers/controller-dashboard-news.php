<?php
require('../config/env.php');
require('../helpers/Database.php');
require('../models/news.php');

session_start();

if (!isset($_SESSION['login'])) {
    header('Location: controller-login.php');
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
}

// Création d'un nouveau type de news

if (isset($_POST['submitNewsType'])) {
    $newNewsType = new NewsController();
    $newNewsType->createNewsType($_POST['inputNewsType']);
}

// Création d'une news

// if (isset($_POST['submitNews'])) {
//     $newNews = new NewsController();
//     $newNews->createNews($_POST['inputNewsTitle'], $_POST['inputNewsContent'], $_POST['selectNewsType']);
//     var_dump($_POST);
// }

// Suppression d'un type de news

if (isset($_POST['submitDeleteNewsType'])) {
    $deleteNews = new NewsController();
    $deleteNews->deleteNewsType($_POST['selectNewsType']);
}

// Récupère tous les types de news pour les afficher dans la vue
$newsTypes = NewsController::showNewsTypes();






















include('../views/view-dashboard-news.php');
