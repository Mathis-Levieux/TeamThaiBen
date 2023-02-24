<html lang="fr">
<?php include('templates/head.php'); ?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12 justify-content-center">

                <h1>Dashboard - Galerie</h1>
                <form action='controller-dashboard-gallery.php' method="post" enctype="multipart/form-data">
                    <input name="photos[]" type="file" class="form-control" id="inputPhotos" multiple="multiple">
                    <select name="albumchoice" class="form-select">
                        <option selected disabled value="">Sélectionne un album</option>
                        <?php
                        showSelectAlbums(); // Affichage du select des albums
                        ?>
                    </select>
                    <input type="submit" name="submitPhotos" class="btn btn-primary" value="Envoyer">
                    <div class="preview-container d-flex flex-wrap gap-2"></div>
                </form>

            </div>
        </div>
    </div>


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
                <h2>Affichage galerie</h2>
                <form action='controller-dashboard-gallery.php' method="post">
                    <select name="DisplayAlbum" class="form-select" aria-label="Default select example">
                        <option selected disabled value="">Sélectionne un album</option>
                        <?php
                        showSelectAlbums();
                        ?>
                    </select>
                    <input type="submit" name="submitDisplayAlbum" class="btn btn-primary" value="Afficher">
                </form>
                <div class="album-container gap-2">
                    <?php if (isset($_POST['submitDisplayAlbum'])) { // Si le bouton submit est cliqué
                        showPhotosInAdminDashboard();
                    } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>