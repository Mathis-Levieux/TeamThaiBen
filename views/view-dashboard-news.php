<!DOCTYPE html>
<html lang="fr">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/bootstrap-5.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../node_modules/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: '#newsTitle',
            height: 200,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
            setup: function(editor) {
                editor.on('init', function(e) {
                    editor.setContent('<h2></h2>');
                });
            }
        });
        tinymce.init({
            selector: '#newsContent',
            height: 500,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });
    </script>
    <title>Team Thai Ben</title>
</head>

<body>
    <main>
        <div class="container">
            <div class="row h-100">
                <div class="col-12 justify-content-center">

                    <h1>Dashboard - News</h1>

                    <!-- Formulaire d'article -->
                    <h2>Ajouter une news</h2>
                    <form method="post">
                        <h3>Type de news</h3>

                        <!-- Affichage du select -->
                        <select name="newsType" id="newsType">
                            <?php if (empty($newsTypes)) : ?>
                                <option value="">Aucun type de news</option>
                            <?php endif; ?>

                            <?php foreach ($newsTypes as $newsType) : ?>
                                <option value="<?= $newsType['news_type_id'] ?>"><?= $newsType['news_type'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <!-- Fin affichage du select -->

                        <h3>Titre</h3>
                        <textarea name="newsTitle" id="newsTitle"></textarea>
                        <h3>Contenu</h3>
                        <textarea name="newsContent" id="newsContent"></textarea>
                        <input type="submit" name="submitNews" class="btn btn-primary" value="Envoyer">
                    </form>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="row h-100">
                <div class="col-12 justify-content-center">

                    <h1>Dashboard - Ajouter un type de news</h1>
                    <!-- Affichage des erreurs -->
                    <?php if (!empty($_POST) && isset($newNewsType) && !empty($newNewsType->getErrorsMessages())) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php foreach ($newNewsType->getErrorsMessages() as $error) : ?>
                                <?= $error ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <!-- Fin affichage des erreurs -->

                    <!-- Affichage des messages de succès -->
                    <?php if (!empty($_POST) && isset($newNewsType) && !empty($newNewsType->getSuccessMessage())) : ?>
                        <div class="alert alert-success"><?php echo $newNewsType->getSuccessMessage(); ?></div>
                    <?php endif; ?>
                    <!-- Fin affichage des messages de succès -->

                    <!-- Formulaire de type de news -->
                    <form method="post">
                        <input type="text" name="inputNewsType" id="inputNewsType" placeholder="Nom du type de news">
                        <input type="submit" name="submitNewsType" class="btn btn-primary" value="Envoyer">
                    </form>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="row h-100">
                <div class="col-12 justify-content-center">
                    <h1>Dashboard - Supprimer un type de news</h1>

                    <!-- Affichage des erreurs -->
                    <?php if (!empty($_POST) && isset($deleteNews) && !empty($deleteNews->getErrorsMessages())) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php foreach ($deleteNews->getErrorsMessages() as $error) : ?>
                                <?= $error ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <!-- Fin affichage des erreurs -->

                    <!-- Affichage des messages de succès -->
                    <?php if (!empty($_POST) && isset($deleteNews) && !empty($deleteNews->getSuccessMessage())) : ?>
                        <div class="alert alert-success"><?php echo $deleteNews->getSuccessMessage(); ?></div>
                    <?php endif; ?>
                    <!-- Fin affichage des messages de succès -->

                    <!-- Liste des types de news dans un select -->
                    <form method="post">
                        <select name="selectNewsType" id="selectNewsType">
                            <?php if (empty($newsTypes)) : ?>
                                <option value="">Aucun type de news</option>
                            <?php endif; ?>

                            <?php foreach ($newsTypes as $newsType) : ?>
                                <option value="<?= $newsType['news_type_id'] ?>"><?= $newsType['news_type'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" name="submitDeleteNewsType" class="btn btn-danger" value="Supprimer">

                </div>
            </div>

    </main>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>