<?php

include $_SERVER['DOCUMENT_ROOT'] . '/data/const.php';
include $_SERVER['DOCUMENT_ROOT'] . '/db/database.php';

if (isset($_FILES) && !empty($_FILES)) {
    foreach ($_FILES as $file) {
        if (in_array(mime_content_type($file['tmp_name']), ALLOWED_IMAGES_TYPE)) {
            $dir = $_SERVER['DOCUMENT_ROOT'] . '/templates/img/new/';

            if (!file_exists($dir)) {
                mkdir($dir);
            }

            move_uploaded_file($file['tmp_name'], $dir . $file['name']);
            $filePath = '/templates/img/new/' . $file['name'];

            mysqli_query(
                database\connect(),
                "INSERT INTO images (link)
                VALUES ('$filePath')"
            );

            $result = mysqli_query(
                database\connect(),
                "SELECT id FROM images
                ORDER BY id DESC
                LIMIT 1"
            );
            $id = database\getResult($result);
            echo $id['id'];
        }
    }
}
