<?php

require('../config/env.php');
require('../helpers/Database.php');
require('../models/files.php');

session_start();

if (!isset($_SESSION['login'])) {
    header('Location: controller-login.php');
}


















include('../views/view-dashboard-files.php');
