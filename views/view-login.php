<?php include('templates/head.php'); ?>


<body class="body-login">
    <?php include('templates/header.php'); ?>

    <main>

        <!-- Formulaire de connexion -->

        <!-- <form method="POST">
            <label for="login">Login</label>
            <input type="text" name="login" id="login" placeholder="Login">
            <span class="error"><?= $errors['login'] ?? '' ?></span>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" placeholder="Mot de passe">
            <span class="error"><?= $errors['password'] ?? '' ?></span>
            <input type="submit" value="Se connecter">
        </form> -->

        <!-- Affichage des erreurs -->
        <?php if (!empty($_POST) && isset($login) && !empty($login->getErrorsMessages())) : ?>
            <div class="alert alert-danger" role="alert">
                <?php foreach ($login->getErrorsMessages() as $error) : ?>
                    <?= $error . ' <br> ' ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class=" mt-5 w-25 m-auto">
            <div class="mb-3">
                <label for="login" class="form-label col-lg-6">Login</label>
                <input name="login" type="login" class="form-control" id="login" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword1">
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </main>



</body>

</html>