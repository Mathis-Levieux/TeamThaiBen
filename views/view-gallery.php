<?php
$title = 'Galerie - Team Thai Ben';
include('templates/head.php');
include('templates/header.php');
?>

<body class="bg-dark inter-font">
    <main class="mb-5">
        <div class="container">
            <h1 class="mt-5 text-center">Galerie</h1>
            <p class="mb-5 text-center text-light">Vous pouvez retrouver ici les photos de nos entrainements, de nos évènements et de nos sorties.</p>
        </div>

        <div class="container">
            <!-- formulaire pour choisir l'album -->
            <form class="col-md-4 col-12" action="" method="post">
                <select class="form-select" name="album" id="album">

                    <option selected disabled>Choisissez un album</option>
                    <?php
                    foreach ($albums as $album) {
                        echo '<option value="' . $album['albums_id'] . '"' . (isset($_POST['album']) && $_POST['album'] == $album['albums_id'] ? ' selected' : '') . '>' . $album['albums_name'] . '</option>';
                    }
                    ?>
                </select>
                <input class="my-3 btn btn-outline-light rounded-pill border-2 fw-bold" type="submit" value="Valider">
            </form>
            <!-- Affichage des 5 dernières photos -->
            <?php if (!isset($_POST['album'])) : ?>
                <div class="row">
                    <?php
                    echo '<h3 class="my-3 text-light">Les dernières photos ajoutées</h3>';
                    foreach ($somePhotos as $photo) {
                        echo '<div class="col-md-2 col-6 my-2">
                        <img src="' . $photo['photos_path'] . '" alt="' . $photo['photos_name'] . '" class="img-fluid">
                        </div>';
                    }
                    ?>
                </div>
            <?php endif; ?>

            <!-- Affichage des photos de l'album choisi -->
            <?php if (isset($_POST['album'])) : ?>
                <div class="row">
                    <?php
                    echo '<h3 class="my-3 text-light">Album ' . $albumName . '</h3>';
                    if (empty($photos)) {
                        echo '<p class="text-light">Aucune photo dans cet album</p>';
                    }
                    foreach ($photos as $photo) {
                        echo '<div class="col-md-2 col-6 my-2">
                        <img src="' . $photo['photos_path'] . '" alt="' . $photo['photos_name'] . '" class="img-fluid">
                        </div>';
                    }
                    ?>
                </div>
            <?php endif; ?>


    </main>
    <?php include('templates/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>


</body>



</html>