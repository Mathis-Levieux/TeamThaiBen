<?php

require('../config/env.php');
require('../helpers/Database.php');
require('../models/login.php');

session_start(); // On démarre la session

if (isset($_SESSION['login'])) { // Si l'utilisateur est connecté
    header('Location: controller-dashboard-news.php'); // On le redirige vers la page d'accueil
}

$title = 'Connexion'; // On définit le titre de la page

class UserController
{
    public array $errors = [];
    public string $success = '';

    public function logIn() // Fonction qui permet de se connecter
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $login = $_POST['login'];
            $password = $_POST['password'];


            if (empty($login) || empty($password)) {
                $this->errors[] = 'Veuillez remplir tous les champs';
            } else {

                $this->verifyCaptcha();   // On vérifie le captcha est coché

                if (empty($this->errors)) { // Si le captcha est coché, on vérifie les identifiants

                    $login = new Login($login, $password);
                    $user = $login->checkCredentials();

                    if ($user) {
                        // Si les identifiants sont corrects, on stocke l'utilisateur dans la session
                        $_SESSION['login'] = $user['admin_login'];
                        header('Location: controller-dashboard.php');
                        exit;
                    } else {
                        // Sinon on affiche un message d'erreur
                        $this->errors[] = 'Identifiants incorrects';
                    }
                }
            }
        }
    }

    public function verifyCaptcha()
    {
        if (isset($_POST['g-recaptcha-response'])) {
            $captcha = $_POST['g-recaptcha-response'];
            $secretKey = "6Ld8vxglAAAAAM02yGCAhm-242S7BGd3k1CKSFyx";
            $ip = $_SERVER['REMOTE_ADDR'];
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha . "&remoteip=" . $ip);
            $responseKeys = json_decode($response, true);
            if ($responseKeys['score'] < 0.5) {
                $this->errors[] = 'Veuillez cocher la case "Je ne suis pas un robot"';
            }
            if (intval($responseKeys["success"]) !== 1) {
                $this->errors[] = 'Veuillez cocher la case "Je ne suis pas un robot"';
            } else {
                $this->success = 'Vous êtes un humain';
            }
        } else {
            $this->errors = 'Veuillez cocher la case "Je ne suis pas un robot"';
        }
    }

    public function getErrorsMessages()
    {
        return $this->errors;
    }

    public function getSuccessMessage()
    {
        return $this->success;
    }
}

// On vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login']) && isset($_POST['password'])) {
    $login = new UserController();
    $login->logIn();
}















include('../views/view-login.php');
