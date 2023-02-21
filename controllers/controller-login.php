<?php

require('../config/env.php');
require('../helpers/Database.php');
require('../models/login.php');



class LogUser extends Login
{
    public function __construct()
    {
        parent::__construct();
    }

    public function logUser($login, $password)
    {
        $this->login($login, $password);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login']) && isset($_POST['password'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $logUser = new LogUser();
        $logUser->logUser($login, $password);

        if ($logUser->success) {
            echo 'Utilisateur connecté';
            session_start();
        } else {
            $errors = $logUser->errors;
            var_dump($errors);
        }
    }
}

















include('../views/login.php');
