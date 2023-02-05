<?php

include('controller-session.php');
require_once('database-login.php');
$loginErrors = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $checkemail = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query(logInDatabase(), $checkemail);

    if (mysqli_num_rows($result) > 0) {
        // Si l'email est trouvé dans la base de données
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            // Si le mot de passe est correct
            
            $_SESSION['user'] = $user;
            echo "<h1>Vous êtes connecté</h1>";
        } else {
            // Si le mot de passe est incorrect
           echo "Le mot de passe est incorrect";
        }
    } else {
        echo "L'email n'existe pas";
    }
}

function rewriteForm($value) // Fonction qui réécrit les valeurs des champs du formulaire en cas d'erreur
{
    if (isset($_POST[$value])) {
        echo $_POST[$value];
    }
}