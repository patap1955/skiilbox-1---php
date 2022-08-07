<?php

include $_SERVER['DOCUMENT_ROOT'] . '/db/database.php';

if (
    isset($_POST['delivery']) &&
    isset($_POST['minSum']) &&
    $_POST['delivery'] !== '' &&
    $_POST['minSum'] !== ''
) {
    $delivery = (int)$_POST['delivery'];
    $min = (int)$_POST['minSum'];

    mysqli_query(
        database\connect(),
        "UPDATE config SET value='$delivery' WHERE name='cost_delivery'"
    );

    mysqli_query(
        database\connect(),
        "UPDATE config SET value='$min' WHERE name='min_dilevery'"
    );
}
