<?php
$title = 'Nous rejoindre - Team Thai Ben';
include('templates/head.php');
include('templates/header.php');
?>

<body class="bg-dark text-light">
  <main class="mb-5">
    <div class="container">
      <h1 class="my-5 text-center text-light">REJOINDRE LA TEAM THAI BEN</h1>
      <div class="row">
        <div class="col-md-12">
          <p class="text-center text-light">Vous souhaitez vous inscrire à la Team Thai Ben ? Vous trouverez ci-dessous les informations nécessaires à votre inscription.</p>
          <p class="text-center text-light mb-5">Nous proposons également un cours d'essai gratuit pour vous permettre de découvrir notre club et nos activités. N'hésitez pas à nous contacter via Facebook, téléphone ou de venir directement sur place lors de nos entrainements.</p>
        </div>
        <div class="col-md-6">
          <h3>Téléchargez les formulaires d'inscription :</h3>
          <ul>
            <?php if (empty($files)) : ?>
              <li>Aucun fichier disponible pour l'instant</li>
            <?php endif; ?>
            <?php $nb = 1;
            foreach ($files as $file) {
              echo '<li><a class="text-light" href="../uploads/files/' . $file['files_name'] . '" download>Formulaire d\'inscription ' . $nb . '</a></li>';
              $nb++;
            }
            ?>
          </ul>
        </div>
        <div class="col-md-6">
          <h3>Horaires d'entraînement :</h3>
          <table class="table table-striped text-light">
            <tbody>
              <tr>
                <td class="text-light">Lundi</td>
                <td class="text-light">19h - 21h</td>
              </tr>
              <tr>
                <td class="text-light">Mardi</td>
                <td class="text-light">18h30 - 20h30</td>
              </tr>
              <tr>
                <td class="text-light">Jeudi</td>
                <td class="text-light">19h - 21h</td>
              </tr>
            </tbody>
          </table>
          <h3 class="mt-5">Tarifs :</h3>
          <ul>
            <li>Abonnement annuel adulte : 200 €</li>
            <li>Abonnement annuel étudiant : 170 €</li>
          </ul>
        </div>
      </div>
    </div>





  </main>



  <?php include('templates/footer.php'); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <script src="../assets/js/script.js"></script>
</body>



</html>