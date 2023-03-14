<?php
require('../config/env.php');
require('../helpers/Database.php');
require('../models/news.php');

session_start();

if (!isset($_SESSION['login'])) {
    header('Location: controller-login.php');
}





if (isset($_POST['submitNews'])) {
var_dump($_POST);
}























include('../views/view-dashboard-news.php');
