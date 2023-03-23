<?php include('templates/head.php'); ?>

<body>

    <!-- début dashboard -->

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
            <!-- Ajout de photos -->

            <div id="addPhotoContent" class="container">
                <div class="row">
                    <div class="col-12 justify-content-center">
                        <form action='controller-dashboard-gallery.php' method="post" enctype="multipart/form-data">
                            <p class="mt-3 text-center">Formats acceptés : jpg, jpeg, png</p>
                            <input name="photos[]" type="file" class="mt-3 form-control" id="inputPhotos" multiple="multiple">
                            <?php
                            showSelectAlbums(); // Affichage du select des albums
                            ?>
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

            <!-- Suppression des photos -->

            <div id="deletePhotoContent" class="d-none container">
                <div class="row">
                    <div class="col-12 justify-content-center">
                        <form action='controller-dashboard-gallery.php' method="post">
                            <?php
                            showSelectAlbums(); // Affichage du select des albums
                            ?>
                            <input id="deletePhotoButton" type="submit" name="submitDisplayAlbum" class="mt-3 mb-3 btn btn-outline-dark rounded-pill border-2 fw-bold" value="Afficher">
                        </form>
                        <div class="album-container gap-2">
                            <?php if (isset($_POST['submitDisplayAlbum'])) { // Si le bouton submit est cliqué
                                showPhotosInAdminDashboard();
                            } ?>
                        </div>

                        <!-- Affichage des erreurs -->
                        <?php if (!empty($_POST) && isset($_POST['submitDeletePhoto']) && !empty($deletePhoto->getErrorsMessages())) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php foreach ($deletePhoto->getErrorsMessages() as $error) : ?>
                                    <?= $error . ' <br> ' ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <!-- Fin affichage des erreurs -->

                        <!-- Affichage des messages de succès -->
                        <?php if (!empty($_POST) && isset($_POST['submitDeletePhoto']) && !empty($deletePhoto->getSuccessMessage())) : ?>
                            <div class="alert alert-success"><?php echo $deletePhoto->getSuccessMessage(); ?></div>
                        <?php endif; ?>
                        <!-- Fin affichage des messages de succès -->

                    </div>
                </div>
            </div>

            <!-- Gestion des albums -->
            <div id="editAlbumContent" class="container d-none">

                <div>
                    <div class="row">
                        <div class="col-12 justify-content-center">

                            <h3 class="mt-3">Créer un album</h3>
                            <form action='controller-dashboard-gallery.php' method="post">
                                <input type="text" name="NewAlbum" class="mt-3 form-control" placeholder="Nom de l'album">
                                <input id="editAlbumButton" type="submit" name="submitNewAlbum" class="mt-3 mb-3 btn btn-outline-dark rounded-pill border-2 fw-bold" value="Envoyer">
                            </form>

                            <!-- Affichage des erreurs -->
                            <?php if (!empty($_POST) && isset($_POST['submitNewAlbum']) && !empty($createAlbum->getErrorsMessages())) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php foreach ($createAlbum->getErrorsMessages() as $error) : ?>
                                        <?= $error . ' <br> ' ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <!-- Fin affichage des erreurs -->

                            <!-- Affichage des messages de succès -->
                            <?php if (!empty($_POST) && isset($_POST['submitNewAlbum']) && !empty($createAlbum->getSuccessMessage())) : ?>
                                <div class="alert alert-success"><?php echo $createAlbum->getSuccessMessage(); ?></div>
                            <?php endif; ?>
                            <!-- Fin affichage des messages de succès -->

                        </div>
                    </div>
                </div>



                <div>
                    <div class="row">
                        <div class="col-12 justify-content-center">
                            <h3 class="mt-3">Supprimer un album</h3>
                            <form action='controller-dashboard-gallery.php' method="post">
                                <?php
                                showSelectAlbums(); // Affichage du select des albums
                                ?>
                                <input id="editAlbumButton2" type="submit" name="submitDeleteAlbum" class="mt-3 mb-3 btn btn-outline-dark rounded-pill border-2 fw-bold" value="Envoyer">
                            </form>

                            <!-- Affichage des erreurs -->
                            <?php if (!empty($_POST) && isset($_POST['submitDeleteAlbum']) && !empty($deleteAlbum->getErrorsMessages())) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php foreach ($deleteAlbum->getErrorsMessages() as $error) : ?>
                                        <?= $error . ' <br> ' ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <!-- Fin affichage des erreurs -->

                            <!-- Affichage des messages de succès -->
                            <?php if (!empty($_POST) && isset($_POST['submitDeleteAlbum']) && !empty($deleteAlbum->getSuccessMessage())) : ?>
                                <div class="alert alert-success"><?php echo $deleteAlbum->getSuccessMessage(); ?></div>
                            <?php endif; ?>
                            <!-- Fin affichage des messages de succès -->

                        </div>
                    </div>
                </div>


                <div>
                    <div class="row">
                        <div class="col-12 justify-content-center">
                            <h3 class="mt-3">Modifier le nom d'un album</h3>
                            <form action='controller-dashboard-gallery.php' method="post">
                                <?php
                                showSelectAlbums(); // Affichage du select des albums
                                ?>
                                <input type="text" name="NewAlbumName" class="mt-3 form-control" placeholder="Nouveau nom de l'album">
                                <input id="editAlbumButton3" type="submit" name="submitModifyAlbumName" class="mt-3 mb-3 btn btn-outline-dark rounded-pill border-2 fw-bold" value="Envoyer">
                            </form>

                            <!-- Affichage des erreurs -->
                            <?php if (!empty($_POST) && isset($_POST['submitModifyAlbumName']) && !empty($modifyAlbumName->getErrorsMessages())) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php foreach ($modifyAlbumName->getErrorsMessages() as $error) : ?>
                                        <?= $error . ' <br> ' ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <!-- Fin affichage des erreurs -->

                            <!-- Affichage des messages de succès -->
                            <?php if (!empty($_POST) && isset($_POST['submitModifyAlbumName']) && !empty($modifyAlbumName->getSuccessMessage())) : ?>
                                <div class="alert alert-success"><?php echo $modifyAlbumName->getSuccessMessage(); ?></div>
                            <?php endif; ?>
                            <!-- Fin affichage des messages de succès -->

                        </div>
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