<?php
$title = 'Galerie - Team Thai Ben';
include('templates/head.php');
include('templates/header.php');
?>

<body class="bg-dark">
    <main>
        <div class="container">
            <h1 class="my-5 text-center">Galerie</h1>
        </div>

        <div class="container">
            <h2> <!-- Album name --> </h2>
            <!-- formulaire pour choisir l'album -->
            <form class="col-3" action="" method="post">
                <select class="form-select" name="album" id="album">
                    <option selected disabled>Choisissez un album</option>
                    <?php
                    foreach ($albums as $album) {
                        echo '<option value="' . $album['albums_id'] . '">' . $album['albums_name'] . '</option>';
                    }
                    ?>
                </select>
                <input class="my-3 btn btn-primary" type="submit" value="Valider">
        </div>





    </main>
</body>


<?php include('templates/footer.php'); ?>

</html>