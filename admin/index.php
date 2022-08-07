<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/data/const.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db/database.php';
require $_SERVER['DOCUMENT_ROOT'] . '/render/render.php';

require $_SERVER['DOCUMENT_ROOT'] . '/data/authorization.php';

if ($_SERVER['REQUEST_URI'] === '/admin/') {
    if (
        isset($_SESSION['isAuth']) &&
        isset($_SESSION['isAdmin']) &&
        $_SESSION['isAuth'] &&
        (int)$_SESSION['isAdmin'] === 1
    ) {
        header('location: /admin/orders/');
        exit();
    }
} elseif (
    $_SERVER['REQUEST_URI'] !== '/admin/' && !isset($_SESSION['isAdmin']) ||
    $_SERVER['REQUEST_URI'] !== '/admin/' && !$_SESSION['isAdmin']
) {
    header('location: /admin/');
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/templates/html/header.php';
if (stripos($_SERVER['REQUEST_URI'], '/orders')) {
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/html/admin/orders/orders.php';
} elseif (stripos($_SERVER['REQUEST_URI'], '/products/add')) {
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/html/admin/add/add.php';
} elseif (stripos($_SERVER['REQUEST_URI'], '/products')) {
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/html/admin/products/products.php';
} else {
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/html/admin/authorization.php';
}
include $_SERVER['DOCUMENT_ROOT'] . '/templates/html/footer.php';
