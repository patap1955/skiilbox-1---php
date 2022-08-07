<?php

require $_SERVER['DOCUMENT_ROOT'] . '/db/database.php';

if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    mysqli_query(
        database\connect(),
        "DELETE FROM goods WHERE id=$id"
    );
    echo 'success';
} else {
    echo 'error';
}
