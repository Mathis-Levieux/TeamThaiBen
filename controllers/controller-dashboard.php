<?php

session_start();

if (!isset($_SESSION['login'])) { // On vérifie que l'utilisateur est connecté
    header('Location: controller-login.php'); // Sinon on le redirige vers la page de connexion
}

$title = 'Tableau de bord';
$user = $_SESSION['login']; // On récupère le login de l'utilisateur connecté pour l'afficher dans la navbar













include '../views/view-dashboard.php';
