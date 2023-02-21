<?php include('templates/head.php'); ?>


<body class="body-login">
    <?php include('templates/header.php'); ?>


    <main>
        <form method="POST">
            <label for="login">Login</label>
            <input type="text" name="login" id="login" placeholder="Login">
            <span class="error"><?= $errors['login'] ?? '' ?></span>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" placeholder="Mot de passe">
            <span class="error"><?= $errors['password'] ?? '' ?></span>
            <input type="submit" value="Se connecter">
            <span class="error"><?= $errors['empty'] ?? '' ?></span>
        </form>
    </main>
    

    

</body>