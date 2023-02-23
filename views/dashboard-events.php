<?php include('templates/head.php'); ?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12 justify-content-center">

                <h1>Dashboard - Events</h1>
                <form method="post">
                    <input type="text" name="NewEventType" class="form-control" placeholder="Type d'évènement">
                    <input type="submit" name="submitNewEventType" class="btn btn-primary" value="Envoyer">
                    <div class="preview-container d-flex flex-wrap gap-2"></div>
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 justify-content-center">
                <h2>Suppression d'un type d'évènement</h2>
                <form action="dashboard-events.php" method="post">
                    <select name="deleteEventType" class="form-select" aria-label="Default select example">
                        <option selected disabled value="">Sélectionne un album</option>
                        <?php
                        $newEventType = new EventsController(); // Création d'un nouvel objet
                        $newEventType->showSelectEventType(); // Affichage du select des albums
                        ?>
                    </select>
                    <input type="submit" name="submitDeleteEventType" class="btn btn-primary" value="Envoyer">
                </form>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 justify-content-center">
                <h2>Ajout d'un évènement</h2>
                <form action="dashboard-events.php" method="post">
                    <label for="typeOfNewEvent">Type d'évènement</label>
                    <select name="typeOfNewEvent" class="form-select" aria-label="Default select example">
                        <option selected disabled value="">Sélectionne un album</option>
                        <?php
                        $newEventType = new EventsController(); // Création d'un nouvel objet
                        $newEventType->showSelectEventType(); // Affichage du select des albums
                        ?>
                    </select>
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
                        <input type="submit" name="submitNewEvent" class="btn btn-primary" value="Envoyer">
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>