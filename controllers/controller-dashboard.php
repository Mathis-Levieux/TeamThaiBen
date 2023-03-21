<?php

session_start();
$title = 'Tableau de bord';
$user = $_SESSION['login'];
















include '../views/view-dashboard.php';
