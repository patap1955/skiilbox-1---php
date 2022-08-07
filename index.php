<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/data/const.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db/database.php';
require $_SERVER['DOCUMENT_ROOT'] . '/render/render.php';
include $_SERVER['DOCUMENT_ROOT'] . '/templates/html/header.php';

if ($_SERVER['REQUEST_URI'] === '/delivery/') {
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/html/delivery/delivery.php';
} else {
    include $_SERVER['DOCUMENT_ROOT'] . '/templates/html/main/index.php';
}

include $_SERVER['DOCUMENT_ROOT'] . '/templates/html/footer.php';
