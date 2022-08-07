<?php

// Данный код выполняется вызывается через js при изменении GET параметров
// Отвечает за изменение отображаемых данных без перезагрузки

include $_SERVER['DOCUMENT_ROOT'] . '/data/const.php';
include $_SERVER['DOCUMENT_ROOT'] . '/db/database.php';
include $_SERVER['DOCUMENT_ROOT'] . '/render/render.php';

$price = ['min' => $_GET['min'], 'max' => $_GET['max']];
$goods = database\getGoods(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH), $price);
$response = [];
$response['goods'] = render\renderGoodsList($goods);
$response['count'] = database\getCount(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH), $price);
$response['pages'] = render\renderPagination($response['count']);

echo json_encode($response, JSON_PRETTY_PRINT);
