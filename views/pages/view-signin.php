<?php require_once('../../controllers/controller-signin.php') ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../assets/bootstrap-5.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <title>Inscription - Team Thai Ben</title>
</head>

<body>
    <?php include('../templates/header.php'); ?>


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
                            <input value='<?php rewriteForm('lastname') ?>' type="text" class="form-control rounded" placeholder="Nom" aria-label="Lastname" aria-describedby="basic-addon1" name="lastname">
                            <?= $signInErrors['lastname'] ?? '' ?>

                        </div>
                        <div class="input-group mx-auto mb-5">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                            <input value='<?php rewriteForm('firstname') ?>' type="text" class="form-control rounded" placeholder="Prénom" aria-label="Firstname" aria-describedby="basic-addon1" name="firstname">
                            <?= $signInErrors['firstname'] ?? '' ?>
                        </div>
                        <div class="input-group mx-auto mb-5">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-key"></i></span>
                            <input value='<?php rewriteForm('password') ?>' type="password" class="form-control rounded" placeholder="Mot de passe" aria-label="Password" aria-describedby="basic-addon1" name="password">
                            <?= $signInErrors['password'] ?? '' ?>
                        </div>
                        <div class="input-group mx-auto mb-5">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-key"></i></span>
                            <input value='<?php rewriteForm('verifypassword') ?>' type="password" class="form-control rounded" placeholder="Confirmez le mot de passe" aria-label="Password" aria-describedby="basic-addon1" name="verifypassword">
                            <?= $signInErrors['verifypassword'] ?? '' ?>

                        </div>
                        <div class="input-group mx-auto mb-5">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input value='<?php rewriteForm('email') ?>' type="text" class="form-control rounded" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" name="email">
                            <?= $signInErrors['email'] ?? '' ?>
                        </div>
                        <div class="input-group mx-auto mb-5">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-person"></i></span>
                            <select class="form-select" aria-label="Default select example" name="gender">
                                <option selected>Vous êtes... </option>
                                <option <?php rewriteGenderForm('Homme') ?> value="Homme">Un homme</option>
                                <option <?php rewriteGenderForm('Femme') ?> value="Femme">Une femme</option>
                            </select>
                            <?= $signInErrors['gender'] ?? '' ?>
                        </div>
                    </div>
                    <div>
                        <button id="submit" type="submit" class="btn btn-primary btn-outline-light m-3">S'inscrire</button>
                    </div>
                </form>
            </div>
        </div>
    </main>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="../../assets/js/script.js"></script>
</body>

</html>