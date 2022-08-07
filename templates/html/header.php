<?php
if (isset($_GET['logout']) && $_GET['logout'] === 'yes') {
    session_destroy();
    header('location: /');
}
if (
    isset($_SESSION['isAuth']) &&
    isset($_SESSION['isAdmin']) &&
    $_SESSION['isAuth'] &&
    $_SESSION['isAdmin']
) {
    $adminMenu = database\getAdminMenu();
}
$menu = database\getMainMenu();
$config = database\getConfig();
?>

<!DOCTYPE html>
<html lang="<?= $config['charset'] ?>">
<head>
    <meta charset="utf-8">
    <title><?= $config['title'] ?></title>

    <meta name="description" content="<?= $config['description'] ?>">
    <meta name="keywords" content="<?= $config['keywords'] ?>">

    <meta name="theme-color" content="<?= $config['theme-color'] ?>">

    <link rel="preload" href="/templates/img/intro/coats-2018.jpg" as="image">

    <link rel="icon" href="<?= $config['favicon'] ?>">
    <link rel="stylesheet" href="/templates/css/style.css">

    <script src="/templates/js/lib/jquery.min.js"></script>
    <script src="/templates/js/lib/jquery-ui.js"></script>
    <script src="/templates/js/scripts.js" defer=""></script>
</head>
<body>
<header class="page-header container">
    <a class="page-header__logo" href="/">
        <img src="<?= $config['logo'] ?>" alt="Fashion">
    </a>
    <nav class="page-header__menu">
        <?php if (isset($adminMenu)) {
            render\renderMenu($adminMenu, 'main-menu main-menu--header', 'main-menu__item', 'active');
        } else {
            render\renderMenu($menu, 'main-menu main-menu--header', 'main-menu__item', 'active');
        } ?>
    </nav>
</header>
