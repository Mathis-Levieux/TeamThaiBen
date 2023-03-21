<?php include('templates/head.php'); ?>

<body>
    <main class="main-dashboard bg-body-secondary d-lg-flex">
        <?php include('templates/dashboard.php'); ?>

        <div class="container div-dashboard col-lg-8 m-auto bg-light">
            <!-- Top dashboard -->
            <div class="div-top-dashboard ms-3 me-3 mt-1 border-bottom border-1 border-dark">
                <div class="col-lg-12 fs-3">
                    <span class="">Bienvenue <?= $user ?></span>
                </div>
            </div>
            <!-- Fin du top dashboard -->

            <!-- Début du contenu du dashboard -->
            <div class="row justify-content-center align-items-center h-100 pb-5">
            </div>






            <!-- Fin du contenu du dashboard -->
        </div>



    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>