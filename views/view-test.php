<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../node_modules/photoswipe/dist/photoswipe.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/bootstrap-5.3/css/bootstrap.min.css">
    <title>Document</title>
</head>

<body>

    <div id="lastPhotos" class="row">
        <?php
        echo '<h3 class="my-3 text-light">Les dernières photos ajoutées</h3>';
        foreach ($somePhotos as $photo) {
            echo '<span class="col-md-2 col-6 my-2">
                        <a href="' . $photo['photos_path'] . '" data-pswp-width="2048" data-pswp-height="1684" target="_blank">
                        <img src="' . $photo['photos_path'] . '" alt="Photo Team Thai Ben ' . $photo['photos_name'] . '" class="img-fluid">
                        </a>
                        </span>';
        }
        ?>
    </div>




    <div class="pswp-gallery pswp-gallery--single-column" id="my-gallery">
        <a href="https://cdn.photoswipe.com/photoswipe-demo-images/photos/2/img-2500.jpg" data-pswp-width="2048" data-pswp-height="1684" target="_blank">
            <img src="https://cdn.photoswipe.com/photoswipe-demo-images/photos/2/img-200.jpg" alt="" />
        </a>
    </div>

    <script type="module">
        import PhotoSwipeLightbox from '../node_modules/photoswipe/dist/photoswipe-lightbox.esm.js';
        const lightbox = new PhotoSwipeLightbox({
            gallery: '#my-gallery',
            children: 'a',
            pswpModule: () => import('../node_modules/photoswipe/dist/photoswipe.esm.js')
        });
        const lightbox2 = new PhotoSwipeLightbox({
            gallery: '#lastPhotos',
            children: 'a',
            pswpModule: () => import('../node_modules/photoswipe/dist/photoswipe.esm.js')
        });
        lightbox.init();
        lightbox2.init();
    </script>
</body>

</html>