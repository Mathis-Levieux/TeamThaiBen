<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/bootstrap-5.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/calendarstyle.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Team Thai Ben</title>
</head>

<body class="body-calendar">
    <?php include('templates/header.php'); ?>





    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {  // Si la méthode GET est utilisée
        if (isset($_GET['date'])) { // Si la méthode GET est utilisée et que la date est définie
            if (empty($_GET['date'])) { // Si la méthode GET est utilisée et que la date est vide
                header('Location: controller-calendar.php'); // On redirige vers la page d'accueil
            } else {
                $date = $_GET['date']; // On récupère la date
                displayWeekWithEvents($date); // On affiche la semaine avec les événements
            }
        } else {
            displayWeekWithEvents(date('Y-m-d')); // Sinon on affiche la semaine avec les événements à partir de la date du jour
        }
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>