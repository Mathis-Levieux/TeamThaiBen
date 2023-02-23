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
                <form method="post">
                    <select name="deleteEventType" class="form-select" aria-label="Default select example">
                        <option selected disabled value="">Sélectionne un album</option>
                        <?php
                        $newEventType = new EventsController();
                        $newEventType->showSelectEventType();
                        ?>
                    </select>
                    <input type="submit" name="submitDeleteEventType" class="btn btn-primary" value="Envoyer">
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>