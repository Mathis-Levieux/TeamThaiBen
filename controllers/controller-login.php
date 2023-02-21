<?php

require('../config/env.php');
require('../helpers/Database.php');
require('../models/login.php');

session_start(); // On démarre la session

class LogUser extends Login // Création d'une classe LogUser qui hérite de la classe Login
{
    public function __construct() // Création d'un constructeur
    {
        parent::__construct(); // On appelle le constructeur de la classe parente
    }

    public function logUser($login, $password) // Création d'une méthode logUser qui prend en paramètre $login et $password
    {
        $this->login($login, $password); // On appelle la méthode login de la classe parente
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Si la méthode de la requête est POST
    if (empty($_POST['login']) || empty($_POST['password'])) { // Si les champs login et password sont vides
        $errors = ['empty' => 'Veuillez remplir tous les champs'];
    } else
    if (isset($_POST['login']) && isset($_POST['password'])) { // Si les champs login et password sont remplis
        $login = $_POST['login'];
        $password = $_POST['password'];

        $logUser = new LogUser(); // On instancie la classe LogUser
        $logUser->logUser($login, $password); // On appelle la méthode logUser

        if ($logUser->success) { // Si la méthode logUser retourne true

            $_SESSION['login'] = $login; // On stocke le login dans la session
            header('Location: dashboard-gallery.php'); // On redirige vers la page dashboard-gallery.php
        } else {
            $errors = $logUser->errors; // On stocke les erreurs dans la variable $errors
        }
    }
}

















include('../views/login.php');
