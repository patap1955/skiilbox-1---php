<?php

include $_SERVER['DOCUMENT_ROOT'] . '/db/database.php';

if (isset($_POST)) {
    $name = $_POST['name'];
    $price = (int)$_POST['price'];
    $sale = isset($_POST['sale']) && $_POST['sale'] === 'on' ? 1 : 0;
    $new = isset($_POST['new']) && $_POST['new'] === 'on' ? 1 : 0;

    if (
        isset($_POST['type']) &&
        $_POST['type'] === 'add' &&
        isset($_POST['name']) &&
        $_POST['name'] !== '' &&
        isset($_POST['price']) &&
        $_POST['price'] !== ''
    ) {
        $result = mysqli_query(
            database\connect(),
            "INSERT INTO goods (name, price, sale, new)
        VALUES ('$name', '$price', '$sale', '$new')"
        );

        $result = mysqli_query(
            database\connect(),
            "SELECT id FROM goods
                ORDER BY id DESC
                LIMIT 1"
        );
        $id = database\getResult($result)['id'];

        setCategories($id);

        setImage($id);

        echo 'success';
    } elseif (
        isset($_POST['name']) &&
        $_POST['name'] !== '' &&
        isset($_POST['price']) &&
        $_POST['price'] !== '' &&
        isset($_POST['item']) &&
        $_POST['item'] !== ''
    ) {
        $id = (int)$_POST['item'];

        mysqli_query(
            database\connect(),
            "UPDATE goods SET name='$name', price='$price', sale='$sale', new='$new' WHERE id='$id'"
        );

        mysqli_query(
            database\connect(),
            "DELETE FROM good_category WHERE good_id='$id'"
        );

        setImage($id);

        setCategories($id);

        echo 'success';
    } else {
        echo 'error';
    }
}

function setImage($id)
{
    if (isset($_POST['image']) && (int)($_POST['image']) !== 0) {
        $imageId = (int)($_POST['image']);
        mysqli_query(
            database\connect(),
            "INSERT INTO good_image (good_id, image_id)
                VALUES ($id, $imageId)"
        );
    }
}

function setCategories($id)
{
    if (isset($_POST['categories'])) {
        $queryCat = "INSERT INTO good_category (good_id, category_id) VALUES ";
        $categories = explode(',', $_POST['categories']);
        $values = [];
        foreach ($categories as $category) {
            $values[] = '(' . $id . ', ' . $category . ')';
        }
        $queryCat .= implode(', ', $values);

        mysqli_query(database\connect(), $queryCat);
    }
}
