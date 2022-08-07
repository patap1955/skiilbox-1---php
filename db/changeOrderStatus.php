<?php
require $_SERVER['DOCUMENT_ROOT'] . '/db/database.php';
if (isset($_POST['status']) && isset($_POST['id'])) {
    $newStatus = $_POST['status'] === 'true' ? 1 : 0;
    $id = (int)$_POST['id'];
    mysqli_query(
        database\connect(),
        "UPDATE orders SET completed='$newStatus' WHERE id='$id'"
    );
}
