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
                        <li id="addEvent" class="dashboard-tabs active-tab d-flex align-items-center">AJOUT D'ÉVÈNEMENTS</li>
                        <li id="deleteEvent" class="dashboard-tabs d-flex align-items-center">SUPPRESSION D'ÉVÈNEMENTS</li>
                        <li id="editEventTypes" class="dashboard-tabs d-flex align-items-center">GÉRER LES TYPES D'ÉVÈNEMENTS</li>
                    </ul>
                </div>
            </div>
            <!-- Fin du top dashboard -->

            <!-- Début du contenu du dashboard -->
            <div id="addEventContent" class="container">
                <div class="row">
                    <div class="col-12 justify-content-center">
                        <form action="controller-dashboard-events.php" method="post">
                            <label class="mt-3" for="newEventTitle">Titre de l'évènement</label>
                            <input type="text" name="newEventTitle" id="newEventTitle" class="mt-2 form-control" placeholder="Titre de l'évènement">
                            <label class="mt-3" for="newEventDate">Date de l'évènement</label>
                            <input type="date" name="newEventDate" class="mt-2 form-control" id="newEventDate" placeholder="Date de l'évènement">
                            <label class="mt-3" for="newEventHour">Heure de l'évènement</label>
                            <input type="time" name="newEventHour" class="mt-2 form-control" id="newEventHour" placeholder="Heure de l'évènement">
                            <label class="mt-3" for="newEventDesc">Description de l'évènement</label>
                            <textarea name="newEventDesc" class="mt-2 form-control" id="newEventDesc" placeholder="Description de l'évènement"></textarea>
                            <select name="newEventType" class="mt-2 form-select" aria-label="Default select example">
                                <option selected disabled value="">Sélectionne un album</option>
                                <?php
                                $newEventSelect = new EventsController(); // Création d'un nouvel objet
                                $newEventSelect->showSelectEventType(); // Affichage du select des albums
                                ?>
                                <input type="submit" name="submitNewEvent" class="mt-3 mb-3 btn btn-outline-dark rounded-pill border-2 fw-bold" value="Envoyer">
                        </form>

                        <!-- Affichage des erreurs -->
                        <?php if (!empty($_POST) && isset($_POST['submitNewEvent']) && !empty($newEvent->getErrorsMessages())) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php foreach ($newEvent->getErrorsMessages() as $error) : ?>
                                    <?= $error . ' <br> ' ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <!-- Fin affichage des erreurs -->

                        <!-- Affichage des messages de succès -->
                        <?php if (!empty($_POST) && isset($_POST['submitNewEvent']) && !empty($newEvent->getSuccessMessage())) : ?>
                            <div class="alert alert-success"><?php echo $newEvent->getSuccessMessage(); ?></div>
                        <?php endif; ?>
                        <!-- Fin affichage des messages de succès -->


                    </div>
                </div>
            </div>

            <div id="editEventTypesContent" class="container d-none">
                <div>
                    <div class="row">
                        <div class="col-12 justify-content-center">
                            <h3 class="mt-3">Ajout d'un type d'event</h3 class="mt-3">
                            <form method="post">
                                <input type="text" name="NewEventType" class="form-control" placeholder="Type d'évènement">
                                <input id="editEventTypesButton" type="submit" name="submitNewEventType" class="mt-3 btn btn-outline-dark rounded-pill border-2 fw-bold" value="Envoyer">
                                <div class="preview-container d-flex flex-wrap gap-2"></div>
                            </form>

                            <!-- Affichage des erreurs -->
                            <?php if (!empty($_POST) && isset($_POST['submitNewEventType']) && !empty($newEventType->getErrorsMessages())) : ?>
                                <div class="alert alert-danger mt-3" role="alert">
                                    <?php foreach ($newEventType->getErrorsMessages() as $error) : ?>
                                        <?= $error . ' <br> ' ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <!-- Fin affichage des erreurs -->

                            <!-- Affichage des messages de succès -->
                            <?php if (!empty($_POST) && isset($_POST['submitNewEventType']) && !empty($newEventType->getSuccessMessage())) : ?>
                                <div class="alert alert-success mt-3"><?php echo $newEventType->getSuccessMessage(); ?></div>
                            <?php endif; ?>
                            <!-- Fin affichage des messages de succès -->

                        </div>
                    </div>
                </div>

                <div>
                    <div class="row">
                        <div class="col-12 justify-content-center">
                            <h3 class="mt-3">Suppression d'un type d'event</h3 class="mt-3">

                            <form action="controller-dashboard-events.php" method="post">
                                <select name="deleteEventType" class="form-select mt-3" aria-label="Default select example">
                                    <option selected disabled value="">Sélectionne un type</option>
                                    <?php
                                    $eventTypeSelect = new EventsController(); // Création d'un nouvel objet
                                    $eventTypeSelect->showSelectEventType(); // Affichage du select des albums
                                    ?>
                                </select>
                                <input id="editEventTypesButton2" type="submit" name="submitDeleteEventType" class="mt-3 btn btn-outline-dark rounded-pill border-2 fw-bold" value="Envoyer">
                            </form>

                            <!-- Affichage des erreurs -->
                            <?php if (!empty($_POST) && isset($_POST['submitDeleteEventType']) && !empty($deleteEventType->getErrorsMessages())) : ?>
                                <div class="alert alert-danger mt-3" role="alert">
                                    <?php foreach ($deleteEventType->getErrorsMessages() as $error) : ?>
                                        <?= $error . ' <br> ' ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <!-- Fin affichage des erreurs -->

                            <!-- Affichage des messages de succès -->
                            <?php if (!empty($_POST) && isset($_POST['submitDeleteEventType']) && !empty($deleteEventType->getSuccessMessage())) : ?>
                                <div class="alert alert-success mt-3"><?php echo $deleteEventType->getSuccessMessage(); ?></div>
                            <?php endif; ?>
                            <!-- Fin affichage des messages de succès -->

                        </div>
                    </div>
                </div>
            </div>

            <div id="deleteEventContent" class="mt-3 container d-none">
                <div class="row">
                    <div class="col-12 justify-content-center">
                        <?php $getEvents = new Events(); // Création d'un nouvel objet
                        if (!empty($getEvents->getEvents())) {
                            $displayEventList = new EventsController(); // Création d'un nouvel objet
                            $displayEventList->displayEventList();
                        } else {
                            echo '<span class="d-none" id="deleteEventButton"></span>';
                            echo '<span class="mt-2">Aucun évènement à afficher pour l\'instant !</span>';
                        } ?>

                        <!-- Affichage des erreurs -->
                        <?php if (!empty($_POST) && isset($_POST['submitDeleteEvents']) && !empty($deleteEvents->getErrorsMessages())) : ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <?php foreach ($deleteEvents->getErrorsMessages() as $error) : ?>
                                    <?= $error . ' <br> ' ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <!-- Fin affichage des erreurs -->

                        <!-- Affichage des messages de succès -->
                        <?php if (!empty($_POST) && isset($_POST['submitDeleteEvents']) && !empty($deleteEvents->getSuccessMessage())) : ?>
                            <div class="alert alert-success mt-3"><?php echo $deleteEvents->getSuccessMessage(); ?></div>
                        <?php endif; ?>
                        <!-- Fin affichage des messages de succès -->

                    </div>
                </div>
            </div>
            <!-- Fin du contenu du dashboard -->
        </div>
    </main>

















    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>