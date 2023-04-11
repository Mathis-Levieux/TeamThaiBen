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
    <title>Administration - Modifier un article</title>
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
                        <li id="addNews" class="dashboard-tabs active-tab d-flex align-items-center">MODIFIER UN ARTICLE</li>
                        <!-- retour à la page d'administration -->
                        <li id="addNews" class="dashboard-tabs bg bg-danger d-flex align-items-center"><a class="dashboard-return" href="controller-dashboard-news.php">RETOUR</a></li>
                    </ul>
                </div>
            </div>
            <!-- Fin du top dashboard -->

            <!-- Début du contenu du dashboard -->
            <div class="container">
                <div class="row h-100">
                    <div class="col-12 justify-content-center">


                        <!-- Formulaire d'article -->
                        <!-- Affichage des erreurs -->
                        <?php if (!empty($_POST) && isset($modifyNews) && !empty($modifyNews->getErrorsMessages())) : ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <?php foreach ($modifyNews->getErrorsMessages() as $error) : ?>
                                    <?= $error . ' <br> ' ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <!-- Fin affichage des erreurs -->

                        <!-- Affichage des messages de succès -->
                        <?php if (!empty($_POST) && isset($modifyNews) && !empty($modifyNews->getSuccessMessage())) : ?>
                            <div class="alert alert-success mt-3"><?php echo $modifyNews->getSuccessMessage(); ?></div>
                        <?php endif; ?>
                        <!-- Fin affichage des messages de succès -->
                        <form method="post">
                            <h3 class="mt-3">Type de news</h3>

                            <!-- Affichage du select -->
                            <select class="col-lg-6" name="newsType" id="newsType">
                                <option selected disabled>Choisissez un type de news</option>
                                <?php foreach ($newsTypes as $newsType) : ?>
                                    <option value="<?= $newsType['news_type_id'] ?>" <?= $newsType['news_type_id'] == $news['news_type_id'] ? 'selected' : '' ?>>
                                        <?= $newsType['news_type'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <!-- Fin affichage du select -->

                            <h3 class="mt-3">Titre</h3>
                            <input class="col-lg-6" type="text" name="newsTitle" id="newsTitle" value="<?= $news['news_title'] ?>"></input>
                            <h3 class="mt-3">Contenu</h3>
                            <textarea name="newsContent" id="newsContent"><?= $news['news_content'] ?></textarea>
                            <input type="submit" name="submitModifyNews" class="mt-3 mb-3 btn btn-outline-dark rounded-pill border-2 fw-bold" value="Envoyer">
                        </form>

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