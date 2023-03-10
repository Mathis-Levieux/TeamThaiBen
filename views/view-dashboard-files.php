<html lang="fr">
<?php include('templates/head.php'); ?>


<body>
    <main>
        <div class="container">
            <div class="row h-100">
                <div class="col-12 justify-content-center">

                    <h1>Dashboard - Fichiers</h1>

                    <form action='controller-dashboard-files.php' method="post" enctype="multipart/form-data">
                        <!-- affichage du résultat de l'upload -->
                        <?php if (!empty($errors)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php foreach ($errors as $error) : ?>
                                    <?= $error ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($file) && !empty($file->getSuccessMessage())) : ?>
                            <div class="alert alert-success"><?php echo $file->getSuccessMessage(); ?></div>
                        <?php endif; ?>
                        <!-- fin affichage du résultat de l'upload -->
                        <input name="inputFile" type="file" class="form-control" id="inputFile">
                        <input type="submit" name="submitFile" class="btn btn-primary" value="Envoyer">
                        <div class="h-100 preview-container d-flex flex-wrap gap-2"></div>
                </div>
            </div>
        </div>
    </main>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>

</body>

</html>