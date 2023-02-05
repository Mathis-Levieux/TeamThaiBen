<?php

require_once('controller-session.php');
require_once('database-login.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['lastname']) && isset($_POST['firstname']) && isset($_POST['password']) && isset($_POST['verifypassword']) && isset($_POST['email']) && isset($_POST['gender'])) {
        $lastname = htmlspecialchars(ucfirst(strtolower($_POST['lastname'])));  // On met la première lettre du nom en majuscule
        $firstname = htmlspecialchars(ucfirst(strtolower($_POST['firstname']))); // On met la première lettre du prénom en majuscule
        $password = $_POST['password'];
        $verifypassword = $_POST['verifypassword'];
        $email = htmlspecialchars($_POST['email']);
        $gender = htmlspecialchars($_POST['gender']);

        $namesRegex = "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð-]{1,25}$/u"; // Regex des enfers pour les noms et prénoms
        $passwordRegex = "/^(?!.*\s)(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=\[\]{};':\\|,.<>\/?])(?=.*[0-9]).{8,40}$/";
        // $signInErrors['regexpassword'] = 'Votre mot de passe doit contenir au moins une majuscule, un chiffre, et faire au moins 8 caractères avec au moins un de ces caractères spéciaux : (!, @, #, $, %, ^, &, *)';

        $signInErrors = checkEmptyFields($gender, $_POST); // On lance la fonction de vérification des champs vides, et on stocke le résultat dans un tableau

        if (empty($signInErrors)) { // Si le tableau est vide, c'est qu'il n'y a pas d'erreurs

            $regexmessages = getRegexMessagesArray();

            if (!preg_match($namesRegex, $lastname)) { // On vérifie si le nom correspond à la regex
                $signInErrors['lastname'] = $regexmessages['lastname'];
            }
            if (!preg_match($namesRegex, $firstname)) { // On vérifie si le prénom correspond à la regex
                $signInErrors['firstname'] = $regexmessages['firstname'];
            }
            if ($password != $verifypassword) { // On vérifie si les mots de passe correspondent
                $signInErrors['password'] = '<span class="danger login-error"><i class="bi bi-x-circle-fill"></i> Les mots de passe ne correspondent pas</span>';
                $signInErrors['verifypassword'] = '<span class="danger login-error"><i class="bi bi-x-circle-fill"></i> Les mots de passe ne correspondent pas</span>';
            }
            if (!preg_match($passwordRegex, $password)) { // On vérifie si le mot de passe correspond à la regex
                $signInErrors['password'] = $regexmessages['password'];
                $signInErrors['verifypassword'] = $regexmessages['verifypassword'];
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // On vérifie si l'email est valide
                $signInErrors['email'] = $regexmessages['email'];
            }

            if (emailExists($email)) { // On vérifie si l'email existe déjà dans la BDD
                $signInErrors['email'] = '<span class="danger login-error"><i class="bi bi-x-circle-fill"></i> Cette adresse e-mail est déjà enregistrée</span>';
            }

            // Si le tableau d'erreurs est toujours vide, on peut insérer les données dans la base de données


            if (empty($signInErrors)) {

                $conn = logInDatabase(); // Appel de la fonction de connexion à la BDD

                if (!$conn) { // Si la connexion échoue, on affiche un message d'erreur
                    die("Erreur de connexion : " . mysqli_connect_error());
                }

                // Hashage du mot de passe pour sécuriser les données
                $password = password_hash($password, PASSWORD_DEFAULT);

                // Préparation de la requête SQL d'insertion
                $sql = "INSERT INTO users (lastname, firstname, password, email, gender)
                VALUES ('$lastname', '$firstname', '$password', '$email', '$gender')";

                // Exécution de la requête
                if (mysqli_query($conn, $sql)) {
                    echo "Inscription réussie";
                } else {
                    echo "Erreur : " . $sql . "<br>" . mysqli_error($conn);
                }

                // Fermeture de la connexion à la BDD
                mysqli_close($conn);
            }
        }
    }
}



function emailExists($email)
{
    $check_email_query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query(logInDatabase(), $check_email_query);

    if (mysqli_num_rows($result) > 0) {
        // L'e-mail existe déjà dans la base de données
        return true;
    }
}


function rewriteForm($value) // Fonction qui réécrit les valeurs des champs du formulaire en cas d'erreur
{
    if (isset($_POST[$value])) {
        echo $_POST[$value];
    }
}

function rewriteGenderForm($value) // Fonction qui réécrit les valeurs des champs du formulaire en cas d'erreur
{
    if (isset($_POST['gender'])) {
        if (($_POST['gender'] == $value)) {
            echo 'selected';
        }
    }
}



function checkEmptyFields($gender, $array)
{
    $signInErrors = []; // Tableau des erreurs
    $emptyFields = getEmptyFieldsMessagesArray();
    foreach ($emptyFields as $emptyField => $message) { // On vérifie si les champs obligatoires sont bien remplis
        if (empty($array[$emptyField])) {
            $signInErrors[$emptyField] = $message;
        }
    }
    if ($gender !== "Homme" && $gender !== "Femme") { // On vérifie si le genre est bien renseigné et correspond à un genre existant
        $signInErrors['gender'] = '<span class="danger login-error"><i class="bi bi-x-circle-fill"></i> Veuillez renseigner votre genre</span>';
    }
    return $signInErrors;
}


function getEmptyFieldsMessagesArray()
{
    $emptyFields = [ // Tableau des champs à vérifier et les messages d'erreurs associés
        'lastname' => '<span class="danger login-error"><i class="bi bi-x-circle-fill"></i> Veuillez renseigner votre nom</span>',
        'firstname' => '<span class="danger login-error"><i class="bi bi-x-circle-fill"></i> Veuillez renseigner votre prénom</span>',
        'password' => '<span class="danger login-error"><i class="bi bi-x-circle-fill"></i> Veuillez renseigner votre mot de passe</span>',
        'verifypassword' => '<span class="danger login-error"><i class="bi bi-x-circle-fill"></i> Veuillez confirmer votre mot de passe</span>',
        'email' => '<span class="danger login-error"><i class="bi bi-x-circle-fill"></i> Veuillez renseigner votre email</span>',
    ];
    return $emptyFields;
}

function getRegexMessagesArray() 
{
    $regexmessages = [ // Tableau des messages d'erreurs associés aux regex
        'lastname' => '<span class="danger login-error"><i class="bi bi-x-circle-fill"></i> Votre nom ne doit contenir que des lettres</span>',
        'firstname' => '<span class="danger login-error"><i class="bi bi-x-circle-fill"></i> Votre prénom ne doit contenir que des lettres</span>',
        'password' => '<span class="danger login-error"><i class="bi bi-x-circle-fill"></i> Votre mot de passe doit contenir au moins une majuscule, un chiffre, et faire au moins 8 caractères avec au moins un de ces caractères spéciaux : (!, @, #, $, %, ^, &, *)</span>',
        'verifypassword' => '<span class="danger login-error"><i class="bi bi-x-circle-fill"></i> Votre mot de passe doit contenir au moins une majuscule, un chiffre, et faire au moins 8 caractères avec au moins un de ces caractères spéciaux : (!, @, #, $, %, ^, &, *)</span>',
        'email' => '<span class="danger login-error"><i class="bi bi-x-circle-fill"></i> Veuillez renseigner un email valide</span>'
    ];
    return $regexmessages;
}

