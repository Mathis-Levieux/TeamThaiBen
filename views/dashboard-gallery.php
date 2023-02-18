<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/bootstrap-5.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Dashboard - Galerie</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="justify-content-center">
                    <h1>Dashboard - Galerie</h1>
                    <form method="post" enctype="multipart/form-data">
                        <input name="photos[]" type="file" class="form-control" id="inputPhotos" multiple="multiple">
                        <select name="album" class="form-select" aria-label="Default select example">
                            <option value="1">Saison 2022-2023</option>
                            <option value="2">Saison 2021-2022</option>
                            <option value="3">Saison 2020-2022</option>
                            <option value="4">Saison 2019-2020</option>
                        </select>
                        <input type="submit" name="submit" class="btn btn-primary" value="Envoyer">
                        <div class="preview-container d-flex flex-wrap gap-2"></div>
                    </form>

                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>