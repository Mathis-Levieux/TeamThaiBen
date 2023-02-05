<?php require_once('../../controllers/controller-login.php') ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../assets/bootstrap-5.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <title>Connexion - Team Thai Ben</title>
</head>

<body>
    <?php include('../templates/header.php'); ?>
<h2><a href="logout.php">Déconnexion</a></h2>
    <main class="main-login">
        <div class="login-container card text-center">
            <div class="text-light h3 m-3">
                Connexion
            </div>
            <div class="card-body text-light">
                <form action="" method="POST">
                    <div>
                        <div class="input-group mx-auto mb-5">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                            <input value='<?php rewriteForm('email') ?>' type="text" class="form-control rounded" placeholder="Email" aria-label="Lastname" aria-describedby="basic-addon1" name="email">
                            <?= $loginErrors['lastname'] ?? '' ?>

                        </div>
                        <div class="input-group mx-auto mb-5">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                            <input value='<?php rewriteForm('password') ?>' type="password" class="form-control rounded" placeholder="Mot de passe" aria-label="Firstname" aria-describedby="basic-addon1" name="password">
                            <?= $loginErrors['firstname'] ?? '' ?>
                        </div>
                    </div>
                    <div>
                        <button id="submit" type="submit" class="btn btn-primary btn-outline-light m-3">Connexion</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../../assets/js/script.js"></script>
</body>

</html>