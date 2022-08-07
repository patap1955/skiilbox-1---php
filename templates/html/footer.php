<footer class="page-footer">
    <div class="container">
        <a class="page-footer__logo" href="/">
            <img src="<?= $config['logo-footer'] ?>" alt="Fashion">
        </a>
        <nav class="page-footer__menu">
            <?php render\renderMenu($menu, 'main-menu main-menu--footer', 'main-menu__item'); ?>
        </nav>
        <address class="page-footer__copyright">
            © Все права защищены
        </address>
    </div>
</footer>
</body>
</html>
<?php database\closeConnect(database\connect());
