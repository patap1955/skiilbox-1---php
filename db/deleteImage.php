<?php

include $_SERVER['DOCUMENT_ROOT'] . '/db/database.php';
if (isset($_POST['uri']) && !stripos($_POST['uri'], '../')) {
    $uri = mysqli_real_escape_string(database\connect(), $_POST['uri']);
    mysqli_query(database\connect(), "DELETE FROM images WHERE link='$uri'");

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $uri)) {
        unlink($_SERVER['DOCUMENT_ROOT'] . $uri);
    }

    echo 'success';
}
