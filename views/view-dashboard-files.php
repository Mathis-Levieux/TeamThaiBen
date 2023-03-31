<?php include('templates/head.php'); ?>

<body>






    <main class="main-dashboard bg-dark d-lg-flex">
        <?php include('templates/dashboard.php'); ?>

        <div class="container rounded-3 div-dashboard col-lg-8 mt-5 mb-5 m-auto bg-light">
            <!-- Top dashboard -->
            <div class="div-top-dashboard mt-1 border-bottom border-1 border-dark">
                <div class="col-lg-12 fs-1 text-center position-relative">
                    <span class="border-bottom border-2 border-warning-subtle thai-font">FICHIERS</span>
                    <a href="controller-login.php?logout"><img src="../assets/img/icon-logout.png" alt="logo" class="position-absolute top-0 end-0 logout-button"></a>
                </div>
                <div class="col-lg-12">
                    <ul class="nav-item d-flex p-0 mt-2 gap-5 fw-bold text-center justify-content-center fs-7">
                        <li id="addFile" class="dashboard-tabs active-tab d-flex align-items-center">AJOUT DE FICHIERS</li>
                        <li id="editFile" class="dashboard-tabs d-flex align-items-center">GESTION DES FICHIERS</li>
                    </ul>
                </div>
            </div>
            <!-- Fin du top dashboard -->

            <!-- Début du contenu du dashboard -->



            <div class="container" id="addFileContent">
                <div class="row h-100">
                    <div class="col-12 justify-content-center">
                        <p class="mt-3 text-center">Vous pouvez ajouter ici des fichiers à télécharger sur la page "Rejoindre la Team Thai Ben".</p>
                        <form action='controller-dashboard-files.php' method="post" enctype="multipart/form-data">

                            <!-- affichage des erreurs -->
                            <?php if (!empty($_POST) && !empty($errors)) : ?>
                                <div class="alert alert-danger mt-3" role="alert">
                                    <?php foreach ($errors as $error) : ?>
                                        <?= $error . ' <br> ' ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <!-- fin affichage des erreurs -->

                            <!-- affichage du résultat de l'upload -->
                            <?php if (!empty($_POST) && isset($file) && !empty($file->getSuccessMessage())) : ?>
                                <div class="alert alert-success mt-3"><?php echo $file->getSuccessMessage(); ?></div>
                            <?php endif; ?>
                            <!-- fin affichage du résultat de l'upload -->

                            <input name="inputFile" type="file" class="mt-3 form-control" id="inputFile">
                            <input type="submit" name="submitFile" class="mt-3 mb-3 btn btn-outline-dark rounded-pill border-2 fw-bold" value="Envoyer">
                            <div class="h-100 preview-container d-flex flex-wrap gap-2"></div>
                    </div>
                </div>
            </div>
            </form>

            <div class="container d-none" id="editFileContent">
                <div class="row h-100">
                    <div class="col-12 justify-content-center">
                        <p class="mt-3 text-center">Vous pouvez ici supprimer, télécharger et décider d'afficher ou non les fichiers sur la page "Rejoindre la Team Thai Ben".</p>



                        <!-- Affichage des erreurs -->
                        <?php if (!empty($_GET) && isset($file) && !empty($file->getErrorsMessage())) : ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <?php foreach ($file->getErrorsMessage() as $error) : ?>
                                    <?= $error . ' <br> ' ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <!-- Fin affichage des erreurs -->

                        <!-- Affichage des messages de succès -->
                        <?php if (!empty($_GET) && isset($file) && !empty($file->getSuccessMessage())) : ?>
                            <div class="alert alert-success mt-3"><?php echo $file->getSuccessMessage(); ?></div>
                        <?php endif; ?>
                        <!-- Fin affichage des messages de succès -->
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nom du fichier</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <!-- Affichage des fichiers -->
                                    <?php $displayFiles = new File();
                                    if ($displayFiles->showFiles() == false) : ?>
                                        <tr>
                                            <td colspan="2" class="text-center">Aucun fichier n'a été ajouté</td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php
                                    foreach ($displayFiles->showFiles() as $file) : ?>
                                        <tr>
                                            <td><?= $file['files_name'] ?></td>
                                            <td>
                                                <a href="controller-dashboard-files.php?delete=<?= $file['files_id'] ?>" class="editFileButton btn btn-danger">Supprimer</a>
                                                <a href="controller-dashboard-files.php?download=<?= $file['files_id'] ?>" class="btn btn-success">Télécharger</a>
                                                <?php if ($file['files_show'] == 0) : ?>
                                                    <a href="controller-dashboard-files.php?show=<?= $file['files_id'] ?>" class="editFileButton2 btn btn-primary">Afficher</a>
                                                <?php else : ?>
                                                    <a href="controller-dashboard-files.php?hide=<?= $file['files_id'] ?>" class="editFileButton2 btn btn-secondary">Masquer</a>
                                                <?php endif; ?>
                                            </td>


                                        </tr>
                                    <?php endforeach; ?>
                                    <!-- Fin affichage des fichiers -->

                                </tbody>
                            </table>
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