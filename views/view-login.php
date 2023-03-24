<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/bootstrap-5.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title><?= $title ?></title>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        function onSubmit(token) {
            document.getElementById("my-form").submit();
        }
    </script>
</head>

<body class="body-login">
    <?php include('templates/header.php'); ?>


    <main>

        <!-- Affichage des erreurs -->

        <?php if (!empty($_POST) && isset($login) && !empty($login->getErrorsMessages())) : ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php foreach ($login->getErrorsMessages() as $error) : ?>
                    <?= $error . ' <br> ' ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['message'])) :  ?>
            <div class="alert alert-success text-center" role="alert">
                <?= $_SESSION['message'] ?>
            </div>
            <?php unset($_SESSION['message']) ?>
        <?php endif; ?>
        <!-- Formulaire de connexion -->

        <form action="controller-login.php" id="my-form" method="POST" class="mt-5 w-25 m-auto">
            <div class="mb-3">
                <label for="login" class="form-label col-lg-6">Login</label>
                <input name="login" type="login" class="form-control" id="login" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword1">
            </div>

            <button data-callback='onSubmit' data-action='submit' data-sitekey="6Ld8vxglAAAAAK6vmsqMrz4RDQnuIQi4CefZLoYb" class="g-recaptcha btn btn-primary">Se connecter</button>
        </form>
    </main>



</body>

</html>