<?php require('../controllers/controller-calendar.php'); ?>

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
                    <p class="text-center text-md-start mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed aliquam ligula euismod mauris dignissim, a commodo purus consequat. Donec euismod enim quis augue maximus, sed sodales lectus fermentum. Aliquam ornare turpis sed euismod hendrerit.</p>
                    <a href="view-aboutus.php"><button class="my-3 btn btn-outline-dark rounded-pill border-2 fw-bold" type="button">En savoir plus</button></a>
                </div>
            </div>
        </section>

        <!-- Calendrier -->

        <section class="">

            <?php displayWeekWithEvents(date('Y-m-d')); ?>
        </section>

        

    </main>


    <?php include('templates/footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>