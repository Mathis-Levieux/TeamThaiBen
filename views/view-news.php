<?php
$title = 'Actualités - Team Thai Ben';
include('templates/head.php');
include('templates/header.php');
?>

<body class="bg bg-dark">
  <main class="mb-5">

    <div class="container">
      <h1 class="my-5 text-center text-light">Actualités</h1>
    </div>

    <!-- container pour intégrer les news -->
    <div class="col-lg-12">
      <?php
      if (empty($news)) {
        echo '<div class="container">';
        echo '<h2 class="my-5 text-center text-light">Aucune actualité pour le moment</h2>';
        echo '</div>';
      }
      $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
      foreach ($news as $new) {
        echo '<div class="container news-container mt-4">
                <div class="card p-4 bg bg-dark">
                  <div class="card-body">
                    <h2 class="card-title title-container">' . $new['news_title'] . '</h2>
                    <p class="card-subtitle text-light my-3">Publié le ' . $formatter->format(new DateTime($new['news_date'])) . '</p>
                    <div class="card-text content-container">' . $new['news_content'] . '</div>
                  </div>
                </div>
              </div>
              ';
      }
      ?>
    </div>
  </main>
  <?php include('templates/footer.php'); ?>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <script src="../assets/js/script.js"></script>
</body>





</html>