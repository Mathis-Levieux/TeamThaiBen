<?php
$current_page = basename($_SERVER['PHP_SELF']);

function isCurrentPage($page)
{
    global $current_page;
    return ($current_page == $page) ? 'navbar-active-link' : '';
}
?>


<header class="header-dashboard col-lg-3 bg-dark">
    <div class="title-dashboard pt-5">
        <a class="title-link" href="controller-dashboard.php">
            <h1 class="h1-dashboard">
                TEAM THAI BEN
            </h1>
            <h2 class="h2-dashboard pt-2">
                TABLEAU DE BORD
            </h2>
        </a>
    </div>
    <nav class="navbar-dashboard mt-5 m-3">
        <ul class="nav flex-column ps-5 ms-5">
            <li class="nav-item">
                <a class="fs-5 nav-link <?= isCurrentPage('controller-dashboard-gallery.php') ?>" href="controller-dashboard-gallery.php">Galerie</a>
            </li>
            <li class="nav-item pt-3">
                <a class="fs-5 nav-link <?= isCurrentPage('controller-dashboard-events.php') ?>" href="controller-dashboard-events.php">Calendrier</a>
            </li>
            <li class="nav-item pt-3">
                <a class="fs-5 nav-link <?= isCurrentPage('controller-dashboard-news.php') ?>" href="controller-dashboard-news.php">Articles</a>
            </li>
            <li class="nav-item pt-3">
                <a class="fs-5 nav-link <?= isCurrentPage('controller-dashboard-files.php') ?>" href="controller-dashboard-files.php">Fichiers</a>
            </li>
        </ul>
    </nav>
</header>