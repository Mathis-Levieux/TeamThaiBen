<?php include('templates/head.php'); ?>

<body>
    <main class="main-dashboard bg-dark d-lg-flex">
        <?php include('templates/dashboard.php'); ?>

        <div class="container rounded-3 div-dashboard col-lg-8 mt-5 mb-5 m-auto bg-light">
            <!-- Top dashboard -->
            <div class="div-top-dashboard mt-1 border-bottom border-1 border-dark">
                <div class="col-lg-12 fs-1 text-center position-relative">
                    <span class="border-bottom border-2 border-warning-subtle thai-font">GALERIE</span>
                    <a href="controller-login.php?logout"><img src="../assets/img/icon-logout.png" alt="logo" class="position-absolute top-0 end-0 logout-button"></a>
                </div>
                <div class="col-lg-12">
                    <ul class="nav-item d-flex p-0 mt-2 gap-5 fw-bold text-center justify-content-center fs-7">
                        <li id="addPhoto" class="dashboard-tabs active-tab d-flex align-items-center">AJOUT DE PHOTOS</li>
                        <li id="deletePhoto" class="dashboard-tabs d-flex align-items-center">SUPPRESSION DE PHOTOS</li>
                        <li id="editAlbum" class="dashboard-tabs text-uppercase d-flex align-items-center">gérer les albums</li>
                    </ul>
                </div>
            </div>
            <!-- Fin du top dashboard -->

            <!-- Début du contenu du dashboard -->


            <!-- Fin du contenu du dashboard -->
        </div>
    </main>








    <div class="container">
        <div class="row">
            <div class="col-12 justify-content-center">

                <h2>Ajout d'un type d'event</h2>
                <form method="post">
                    <input type="text" name="NewEventType" class="form-control" placeholder="Type d'évènement">
                    <input type="submit" name="submitNewEventType" class="mt-3 btn btn-outline-dark rounded-pill border-2 fw-bold" value="Envoyer">
                    <div class="preview-container d-flex flex-wrap gap-2"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 justify-content-center">
                <h2>Suppression d'un type d'évènement</h2>
                <form action="controller-dashboard-events.php" method="post">
                    <select name="deleteEventType" class="form-select" aria-label="Default select example">
                        <option selected disabled value="">Sélectionne un album</option>
                        <?php
                        $newEventType = new EventsController(); // Création d'un nouvel objet
                        $newEventType->showSelectEventType(); // Affichage du select des albums
                        ?>
                    </select>
                    <input type="submit" name="submitDeleteEventType" class="mt-3 btn btn-outline-dark rounded-pill border-2 fw-bold" value="Envoyer">
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 justify-content-center">
                <h2>Ajout d'un évènement</h2>
                <form action="controller-dashboard-events.php" method="post">
                    <label for="newEventTitle">Titre de l'évènement</label>
                    <input type="text" name="newEventTitle" id="newEventTitle" class="form-control" placeholder="Titre de l'évènement">
                    <label for="newEventDate">Date de l'évènement</label>
                    <input type="date" name="newEventDate" class="form-control" id="newEventDate" placeholder="Date de l'évènement">
                    <label for="newEventHour">Heure de l'évènement</label>
                    <input type="time" name="newEventHour" class="form-control" id="newEventHour" placeholder="Heure de l'évènement">
                    <label for="newEventDesc">Description de l'évènement</label>
                    <textarea name="newEventDesc" class="form-control" id="newEventDesc" placeholder="Description de l'évènement"></textarea>
                    <select name="newEventType" class="form-select" aria-label="Default select example">
                        <option selected disabled value="">Sélectionne un album</option>
                        <?php
                        $newEventType = new EventsController(); // Création d'un nouvel objet
                        $newEventType->showSelectEventType(); // Affichage du select des albums
                        ?>
                        <input type="submit" name="submitNewEvent" class="mt-3 btn btn-outline-dark rounded-pill border-2 fw-bold" value="Envoyer">
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 justify-content-center">
                <h2>Suppression d'évènements</h2>
                <?php $displayEventList = new EventsController(); // Création d'un nouvel objet
                $displayEventList->displayEventList(); // Affichage du select des albums
                ?>
            </div>
        </div>




        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="../assets/js/script.js"></script>
</body>

</html>