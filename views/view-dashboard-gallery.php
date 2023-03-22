<?php include('templates/head.php'); ?>

<body>

    <!-- début dashboard -->

    <main class="main-dashboard bg-dark d-lg-flex">
        <?php include('templates/dashboard.php'); ?>

        <div class="container rounded-3 div-dashboard col-lg-8 mt-5 m-auto bg-light">
            <!-- Top dashboard -->
            <div class="div-top-dashboard ms-3 me-3 mt-1 border-bottom border-1 border-dark">
                <div class="col-lg-12 fs-1 text-center">
                    <span class="border-bottom border-2 border-warning-subtle thai-font">GALERIE</span>
                </div>
                <div class="col-lg-12">
                    <ul class="nav-item d-flex p-0 mt-2 gap-5 fw-bold text-center justify-content-center fs-7">
                        <li id="addPhoto" class="nav-link">AJOUT DE PHOTOS</li>
                        <li id="deletePhoto" class="nav-link d-flex align-items-center">SUPPRESSION DE PHOTOS</li>
                        <li id="editAlbum" class="nav-link text-uppercase">gérer les albums</li>
                    </ul>
                </div>
            </div>
            <!-- Fin du top dashboard -->

            <!-- Début du contenu du dashboard -->

            <div id="addPhotoContent" class="container">
                <div class="row">
                    <div class="col-12 justify-content-center">
                        <form action='controller-dashboard-gallery.php' method="post" enctype="multipart/form-data">
                            <input name="photos[]" type="file" class="mt-3 form-control" id="inputPhotos" multiple="multiple">
                            <select name="albumchoice" class="mt-3 form-select">
                                <option selected disabled value="">Sélectionne un album</option>
                                <?php
                                showSelectAlbums(); // Affichage du select des albums
                                ?>
                            </select>
                            <input type="submit" name="submitPhotos" class="mt-3 btn btn-outline-dark rounded-pill border-2 fw-bold" value="Envoyer">
                            <div class="preview-container d-flex flex-wrap gap-2 mt-3"></div>
                        </form>


                        <!-- Affichage des erreurs -->
                        <?php if (!empty($_POST) && isset($_POST['submitPhotos']) && !empty($upload->getErrorsMessages())) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php foreach ($upload->getErrorsMessages() as $error) : ?>
                                    <?= $error . ' <br> ' ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <!-- Fin affichage des erreurs -->

                        <!-- Affichage des messages de succès -->
                        <?php if (!empty($_POST) && isset($_POST['submitPhotos']) && !empty($upload->getSuccessMessage())) : ?>
                            <div class="alert alert-success"><?php echo $upload->getSuccessMessage(); ?></div>
                        <?php endif; ?>
                        <!-- Fin affichage des messages de succès -->


                    </div>
                </div>
            </div>

            <!-- Affichage des photos -->

            <div id="deletePhotoContent" class="d-none container">
                <div class="row">
                    <div class="col-12 justify-content-center">
                        <form action='controller-dashboard-gallery.php' method="post">
                            <select name="DisplayAlbum" class="mt-3 form-select" aria-label="Default select example">
                                <option selected disabled value="">Sélectionne un album</option>
                                <?php
                                showSelectAlbums();
                                ?>
                            </select>
                            <input id="deletePhotoButton" type="submit" name="submitDisplayAlbum" class="mt-3 mb-3 btn btn-outline-dark rounded-pill border-2 fw-bold" value="Afficher">
                        </form>
                        <div class="album-container gap-2">
                            <?php if (isset($_POST['submitDisplayAlbum'])) { // Si le bouton submit est cliqué
                                showPhotosInAdminDashboard();
                            } ?>
                        </div>
                    </div>
                </div>
            </div>




            <!-- Fin du contenu du dashboard -->
        </div>
    </main>



    <h1>Dashboard - Galerie</h1>

    <div class="container">
        <div class="row">
            <div class="col-12 justify-content-center">

                <h2>Création d'un album</h2>
                <form action='controller-dashboard-gallery.php' method="post">
                    <input type="text" name="NewAlbum" class="form-control" placeholder="Nom de l'album">
                    <input type="submit" name="submitNewAlbum" class="btn btn-primary" value="Envoyer">
                </form>

            </div>
        </div>
    </div>




    <div class="container">
        <div class="row">
            <div class="col-12 justify-content-center">
                <h2>Suppression d'un album</h2>
                <form action='controller-dashboard-gallery.php' method="post">
                    <select name="deleteAlbum" class="form-select" aria-label="Default select example">
                        <option selected disabled value="">Sélectionne un album</option>
                        <?php
                        showSelectAlbums();
                        ?>
                    </select>
                    <input type="submit" name="submitDeleteAlbum" class="btn btn-primary" value="Envoyer">
                </form>

            </div>
        </div>
    </div>



    <div class="container">
        <div class="row">
            <div class="col-12 justify-content-center">
                <h2>Modifier le nom d'un album</h2>
                <form action='controller-dashboard-gallery.php' method="post">
                    <select name="updateAlbum" class="form-select" aria-label="Default select example">
                        <option selected disabled value="">Sélectionne un album</option>
                        <?php
                        showSelectAlbums();
                        ?>
                    </select>
                    <input type="text" name="NewAlbumName" class="form-control" placeholder="Nouveau nom de l'album">
                    <input type="submit" name="submitModifyAlbumName" class="btn btn-primary" value="Envoyer">
                </form>
            </div>
        </div>
    </div>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>