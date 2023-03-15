<html lang="fr">
<?php include('templates/head.php'); ?>


<body>
    <main>
        <div class="container">
            <div class="row h-100">
                <div class="col-12 justify-content-center">
                    <h1>Dashboard - Fichiers</h1>
                    <form action='controller-dashboard-files.php' method="post" enctype="multipart/form-data">

                        <!-- affichage des erreurs -->
                        <?php if (!empty($_POST) && !empty($errors)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php foreach ($errors as $error) : ?>
                                    <?= $error ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <!-- fin affichage des erreurs -->

                        <!-- affichage du résultat de l'upload -->
                        <?php if (!empty($_POST) && isset($file) && !empty($file->getSuccessMessage())) : ?>
                            <div class="alert alert-success"><?php echo $file->getSuccessMessage(); ?></div>
                        <?php endif; ?>
                        <!-- fin affichage du résultat de l'upload -->

                        <input name="inputFile" type="file" class="form-control" id="inputFile">
                        <input type="submit" name="submitFile" class="btn btn-primary" value="Envoyer">
                        <div class="h-100 preview-container d-flex flex-wrap gap-2"></div>
                </div>
            </div>
        </div>
        </form>

        <div class="container">
            <div class="row h-100">
                <div class="col-12 justify-content-center">
                    <h2>Liste des fichiers</h2>
                    <!-- Affichage des erreurs -->
                    <?php if (!empty($_GET) && isset($file) && !empty($file->getErrorsMessage())) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php foreach ($file->getErrorsMessage() as $error) : ?>
                                <?= $error ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <!-- Fin affichage des erreurs -->

                    <!-- Affichage des messages de succès -->
                    <?php if (!empty($_GET) && isset($file) && !empty($file->getSuccessMessage())) : ?>
                        <div class="alert alert-success"><?php echo $file->getSuccessMessage(); ?></div>
                    <?php endif; ?>
                    <!-- Fin affichage des messages de succès -->

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
                            foreach ($displayFiles->showFiles() as $file) : ?>
                                <tr>
                                    <td><?= $file['files_name'] ?></td>
                                    <td>
                                        <a href="controller-dashboard-files.php?delete=<?= $file['files_id'] ?>" class="btn btn-danger">Supprimer</a>
                                        <a href="controller-dashboard-files.php?download=<?= $file['files_id'] ?>" class="btn btn-success">Télécharger</a>
                                        <?php if ($file['files_show'] == 0) : ?>
                                            <a href="controller-dashboard-files.php?show=<?= $file['files_id'] ?>" class="btn btn-primary">Afficher</a>
                                        <?php else : ?>
                                            <a href="controller-dashboard-files.php?hide=<?= $file['files_id'] ?>" class="btn btn-secondary">Masquer</a>
                                        <?php endif; ?>
                                    </td>


                                </tr>
                            <?php endforeach; ?>
                            <!-- Fin affichage des fichiers -->

                        </tbody>
                    </table>
                </div>
            </div>
    </main>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>

</body>

</html>