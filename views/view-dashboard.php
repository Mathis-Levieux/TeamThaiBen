<?php include('templates/head.php'); ?>

<body>
    <main class="main-dashboard bg-dark d-lg-flex">
        <?php include('templates/dashboard.php'); ?>

        <div class="container rounded-3 div-dashboard col-lg-8 mt-5 mb-5 m-auto bg-light">
            <!-- Top dashboard -->
            <div class="div-top-dashboard mt-1">
                <div class="col-lg-12 fs-1 text-center position-relative">
                <span class="border-bottom border-2 border-warning-subtle thai-font">TABLEAU DE BORD</span>
                    <a href="controller-login.php?logout"><img src="../assets/img/icon-logout.png" alt="logo" class="position-absolute top-0 end-0 logout-button"></a>
                </div>
            </div>
            <!-- Fin du top dashboard -->

            <!-- Début du contenu du dashboard -->







            <!-- Fin du contenu du dashboard -->
        </div>



    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>