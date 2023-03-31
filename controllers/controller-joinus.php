<?php

require('../config/env.php');
require('../helpers/Database.php');
require('../models/files.php');

$filesToShow = new Files();
$files = $filesToShow->getFilesToShow();

include('../views/view-joinus.php');
