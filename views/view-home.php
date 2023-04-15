<?php require('../controllers/controller-calendar.php');
require('../models/news.php');
// On récupère la dernière news
$news = new News();
$lastNews = $news->getLastNews();
$formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE);

function reduceString(string $string): string
{
    $string = substr($string, 0, 600); // On coupe la chaîne à 600 caractères
    $string = substr($string, 0, strrpos($string, ' ')); // On supprime les mots coupés
    $string = $string . '...'; // On ajoute des points de suspension
    return $string;
}

if (!empty($lastNews)) {
    $lastNews['news_content'] = reduceString($lastNews['news_content']);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/bootstrap-5.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/calendarstyle.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Accueil - Team Thai Ben</title>
</head>

<body class="body-home">
    <?php include('templates/header.php'); ?>
    <main class="main-home">
        <div class="main-home-background-container">
            <div class="main-home-background-dark col-sm-5 col-lg-4 col-xl-3 col-xxl-2 py-5 px-5">
                <img class="img-fluid" src="../assets/img/logobentitleless.png" alt="logo">
                <h3 class="thai-font text-light fs-3 text-center pt-2">Club de Muay Thai au Havre</h3>
            </div>
        </div>

        <!-- Le club -->

        <section class="border border-5 border-warning-subtle container my-5 bg-light">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <img src="../assets/img/groupbgremove.png" alt="image" class="img-fluid">
                </div>
                <div class="col-md-7">
                    <h2 class="thai-font fs-1 text-center text-md-start mb-4">LE CLUB</h2>
                    <p class="text-center text-md-start mb-4">Team Thai Ben est un club de boxe fondé en 2014 au Havre par Ben, un entraîneur diplômé en boxe thaïlandaise. Le club propose des cours pour tous les niveaux, du débutant au confirmé. Les cours sont dispensés dans une ambiance conviviale et familiale, où chacun peut progresser à son rythme tout en bénéficiant d'un encadrement de qualité...</p>
                    <a href="notre-histoire.php"><button class="my-3 btn btn-outline-dark rounded-pill border-2 fw-bold" type="button">En savoir plus</button></a>
                </div>
            </div>
        </section>

        <!-- Dernière actualité -->
        <section class="container my-5 py-5">
            <h3 class="thai-font fs-1 text-center mb-4 text-light">DERNIÈRE ACTUALITÉ</h3>
            <div class="row">
                <?php
                if ($lastNews) {
                    echo '<div class="container news-container mt-4">
                        <div class="card p-4 bg bg-dark">
                        <div class="card-body">
                        <h2 class="card-title title-container">' . $lastNews['news_title'] . '</h2>
                        <p class="card-subtitle text-light my-3">Publié le ' . $formatter->format(new DateTime($lastNews['news_date'])) . '</p>
                        <div class="card-text content-container">' . $lastNews['news_content'] . '</div>
                        <a href="actualites.php"><button class="mt-2 mb-2 btn btn-outline-light rounded-pill border-2 fw-bold">Aller aux actualités</button></a>
                        </div>
                        </div>
                        </div>';
                }
                ?>
            </div>
        </section>







        <!-- Calendrier -->

        <section class="my-5">

            <?php displayWeekWithEvents(date('Y-m-d')); ?>
        </section>



    </main>


    <?php include('templates/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>