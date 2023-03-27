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
            selector: '#newsContent',
            height: 500,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'help', 'wordcount', 'image code',
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help' + 'undo redo | link image | code',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
            language: 'fr_FR',
            image_title: true,
            /* enable automatic uploads of images represented by blob or data URIs*/
            automatic_uploads: true,
            /*
              URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
              images_upload_url: 'postAcceptor.php',
              here we add custom filepicker only to Image dialog
            */
            file_picker_types: 'image',
            /* and here's our custom image picker*/
            file_picker_callback: (cb, value, meta) => {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.addEventListener('change', (e) => {
                    const file = e.target.files[0];

                    const reader = new FileReader();
                    reader.addEventListener('load', () => {
                        /*
                          Note: Now we need to register the blob in TinyMCEs image blob
                          registry. In the next release this part hopefully won't be
                          necessary, as we are looking to handle it internally.
                        */
                        const id = 'blobid' + (new Date()).getTime();
                        const blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        const base64 = reader.result.split(',')[1];
                        const blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        /* call the callback and populate the Title field with the file name */
                        cb(blobInfo.blobUri(), {
                            title: file.name
                        });
                    });
                    reader.readAsDataURL(file);
                });

                input.click();
            },
        });
    </script>
    <title>Administration - Articles</title>
</head>

<body>
    <main class="main-dashboard bg-dark d-lg-flex">
        <?php include('templates/dashboard.php'); ?>

        <div class="container rounded-3 div-dashboard col-lg-8 mt-5 mb-5 m-auto bg-light">
            <!-- Top dashboard -->
            <div class="div-top-dashboard mt-1 border-bottom border-1 border-dark">
                <div class="col-lg-12 fs-1 text-center position-relative">
                    <span class="border-bottom border-2 border-warning-subtle thai-font">ARTICLES</span>
                    <a href="controller-login.php?logout"><img src="../assets/img/icon-logout.png" alt="logo" class="position-absolute top-0 end-0 logout-button"></a>
                </div>
                <div class="col-lg-12">
                    <ul class="nav-item d-flex p-0 mt-2 gap-5 fw-bold text-center justify-content-center fs-7">
                        <li id="addNews" class="dashboard-tabs active-tab d-flex align-items-center">CRÉER UN ARTICLE</li>
                        <li id="deleteNews" class="dashboard-tabs d-flex align-items-center">GESTION DES ARTICLES</li>
                        <li id="editNewsTypes" class="dashboard-tabs d-flex align-items-center">GÉRER LES TYPES D'ARTICLES</li>
                    </ul>
                </div>
            </div>
            <!-- Fin du top dashboard -->

            <!-- Début du contenu du dashboard -->
            <!-- Ajout d'un article -->
            <div class="container" id="addNewsContent">
                <div class="row h-100">
                    <div class="col-12 justify-content-center">

                        <!-- Formulaire d'article -->

                        <!-- Affichage des erreurs -->
                        <?php if (!empty($_POST) && isset($newNews) && !empty($newNews->getErrorsMessages())) : ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <?php foreach ($newNews->getErrorsMessages() as $error) : ?>
                                    <?= $error . ' <br> ' ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <!-- Fin affichage des erreurs -->

                        <!-- Affichage des messages de succès -->
                        <?php if (!empty($_POST) && isset($newNews) && !empty($newNews->getSuccessMessage())) : ?>
                            <div class="alert alert-success mt-3"><?php echo $newNews->getSuccessMessage(); ?></div>
                        <?php endif; ?>
                        <!-- Fin affichage des messages de succès -->
                        <form method="post">
                            <h3 class="mt-3">Type d'article</h3>

                            <!-- Affichage du select -->
                            <select class="col-lg-3" name="newsType" id="newsType">
                                <option selected disabled>Choisissez un type d'article</option>
                                <?php foreach ($newsTypes as $newsType) : ?>
                                    <option value="<?= $newsType['news_type_id'] ?>"><?= $newsType['news_type'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <!-- Fin affichage du select -->

                            <h3 class="mt-3">Titre</h3>
                            <input placeholder="Titre de l'article" class="col-lg-3" type="text" name="newsTitle" id="newsTitle"></input>
                            <h3 class="mt-3">Contenu</h3>
                            <textarea name="newsContent" id="newsContent"></textarea>
                            <input id="addNewsButton" type="submit" name="submitNews" class="mt-3 mb-3 btn btn-outline-dark rounded-pill border-2 fw-bold" value="Envoyer">
                        </form>

                    </div>
                </div>
            </div>
            <!-- Fin ajout d'un article -->

            <!-- Modification des types d'articles -->

            <div class="container d-none" id="editNewsTypesContent">
                <div class="row">
                    <div class="col-12 justify-content-center">
                        <h3 class="mt-3">Ajouter un type d'article</h3>
                        <!-- Affichage des erreurs -->
                        <?php if (!empty($_POST) && isset($newNewsType) && !empty($newNewsType->getErrorsMessages())) : ?>
                            <div class="alert alert-danger mt-3 mb-0" role="alert">
                                <?php foreach ($newNewsType->getErrorsMessages() as $error) : ?>
                                    <?= $error ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <!-- Fin affichage des erreurs -->

                        <!-- Affichage des messages de succès -->
                        <?php if (!empty($_POST) && isset($newNewsType) && !empty($newNewsType->getSuccessMessage())) : ?>
                            <div class="alert alert-success mt-3 mb-0"><?php echo $newNewsType->getSuccessMessage(); ?></div>
                        <?php endif; ?>
                        <!-- Fin affichage des messages de succès -->

                        <!-- Formulaire de type de news -->
                        <form action="controller-dashboard-news.php" method="post">
                            <input type="text" name="inputNewsType" id="inputNewsType" placeholder="Nom du type d'article" class="col-lg-3">
                            <input type="submit" name="submitNewsType" id="editNewsTypesButton" class="ms-2 mt-3 mb-3 btn btn-outline-dark rounded-pill border-2 fw-bold" value="Envoyer">
                        </form>

                    </div>
                </div>
                <div class="row">
                    <div class="col-12 justify-content-center">
                        <h3>Supprimer un type d'article</h3>

                        <!-- Affichage des erreurs -->
                        <?php if (!empty($_POST) && isset($deleteNews) && !empty($deleteNews->getErrorsMessages())) : ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <?php foreach ($deleteNews->getErrorsMessages() as $error) : ?>
                                    <?= $error ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <!-- Fin affichage des erreurs -->

                        <!-- Affichage des messages de succès -->
                        <?php if (!empty($_POST) && isset($deleteNews) && !empty($deleteNews->getSuccessMessage())) : ?>
                            <div class="alert alert-success mt-3"><?php echo $deleteNews->getSuccessMessage(); ?></div>
                        <?php endif; ?>
                        <!-- Fin affichage des messages de succès -->

                        <!-- Liste des types de news dans un select -->
                        <form method="post">
                            <select class="col-lg-3" name="selectNewsType" id="selectNewsType">
                                <option selected disabled>Choisissez un type d'article</option>
                                <?php if (empty($newsTypes)) : ?>
                                    <option value="">Aucun type d'article</option>
                                <?php endif; ?>

                                <?php foreach ($newsTypes as $newsType) : ?>
                                    <option value="<?= $newsType['news_type_id'] ?>"><?= $newsType['news_type'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="submit" name="submitDeleteNewsType" id="editNewsTypesButton2" class="ms-2 btn btn-danger" value="Supprimer">

                    </div>
                </div>
            </div>

            <!-- Fin modification des types d'articles -->

            <!-- Modification ou suppression d'un article -->

            <div class="container d-none" id="deleteNewsContent">
                <div class="row h-100">
                    <div class="col-12 justify-content-center">

                        <!-- Affichage des erreurs -->
                        <?php if (!empty($_GET) && isset($deleteNews) && !empty($deleteNews->getErrorsMessages())) : ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <?php foreach ($deleteNews->getErrorsMessages() as $error) : ?>
                                    <?= $error . ' <br> ' ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <!-- Fin affichage des erreurs -->

                        <!-- Affichage des messages de succès -->
                        <?php if (!empty($_GET) && isset($deleteNews) && !empty($deleteNews->getSuccessMessage())) : ?>
                            <div class="alert alert-success mt-3"><?php echo $deleteNews->getSuccessMessage(); ?></div>
                        <?php endif; ?>
                        <!-- Fin affichage des messages de succès -->

                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Nom de l'article</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($newsList)) : ?>
                                    <tr>
                                        <td colspan="2">Aucun article à afficher !</td>
                                    </tr>
                                <?php endif; ?>

                                <!-- Affichage des fichiers -->
                                <?php foreach ($newsList as $news) : ?>
                                    <tr>
                                        <td><?= $news['news_title'] ?></td>
                                        <td>
                                            <a href="controller-dashboard-modify.php?id=<?= $news['news_id'] ?>" class="btn btn-success">Modifier</a>
                                            <a href="controller-dashboard-news.php?delete=<?= $news['news_id'] ?>" class="deleteNewsButton btn btn-danger">Supprimer</a>
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
        <!-- Fin modification ou suppression d'un article -->
        <!-- Fin du contenu du dashboard -->
    </main>







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../assets/js/script.js"></script>
</body>

</html>