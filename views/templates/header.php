<?php
$current_page = basename($_SERVER['PHP_SELF']);
function isCurrentPage($page)
{
    global $current_page;
    return ($current_page == $page) ? 'nav-active-link' : '';
}
?>


<header>

    <!-- Navbar -->
    <nav class="navbar navbar-dark navbar-expand-lg bg-black py-4 border-bottom">
        <div class="container-fluid">
            <a class="header-title-link" href="/accueil.php">
                <h2 class="mb-0 navbar-brand text-light header-title">TEAM THAI BEN</h2>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Navigation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body me-0 pe-0 pe-xl-5 me-xl-5">
                    <ul class="gap-lg-5 navbar-nav justify-content-center flex-grow-1 me-0 pe-0 pe-xl-5 me-xl-5 ul-text-light">
                        <li class="nav-item">
                            <a class="nav-link text-uppercase <?= isCurrentPage('view-home.php') ?>" href="/accueil.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase <?= isCurrentPage('view-aboutus.php') ?>" href="/notre-histoire.php">À propos du club</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase <?= isCurrentPage('controller-gallery.php') ?>" href="/galerie.php">Galerie</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase <?= isCurrentPage('view-calendar.php') ?>" href="/calendrier.php">Calendrier</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase <?= isCurrentPage('controller-news.php') ?>" href="/actualites.php">Actualités</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-uppercase <?= isCurrentPage('controller-joinus.php') ?>" href="/nous-rejoindre.php">Adhérer au club</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>