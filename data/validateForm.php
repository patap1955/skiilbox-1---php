<?php
include $_SERVER['DOCUMENT_ROOT'] . '/db/database.php';

if (isset($_POST['delivery'])) {
    $surname = mysqli_real_escape_string(database\connect(), $_POST['surname']);
    $name = mysqli_real_escape_string(database\connect(), $_POST['name']);
    $patronymic = mysqli_real_escape_string(database\connect(), $_POST['thirdName']);
    $phone = mysqli_real_escape_string(database\connect(), $_POST['phone']);
    $email = mysqli_real_escape_string(database\connect(), $_POST['email']);
    switch ($_POST['pay']) {
        case 'card':
        default:
            $payment_id = 1;
            break;
        case 'cash':
            $payment_id = 2;
            break;
    }
    $comment = mysqli_real_escape_string(database\connect(), $_POST['comment']);
    $goods = (int)mysqli_real_escape_string(database\connect(), $_POST['id']);
    $sum = (int)mysqli_real_escape_string(database\connect(), $_POST['sum']);
    $date = date('Y-m-d H:i:s');

    if ($_POST['delivery'] === 'dev-no') {
        if (
            isset($_POST['surname']) && $_POST['surname'] !== '' &&
            isset($_POST['name']) && $_POST['name'] !== '' &&
            isset($_POST['phone']) && $_POST['phone'] !== '' &&
            isset($_POST['email']) && $_POST['email'] !== ''
        ) {
            $delivery_id = 1;

            mysqli_query(
                database\connect(),
                "INSERT INTO orders (surname, name, patronymic, phone, mail, delivery_id, payment_id, comment, goods, sum, date)
                  VALUES ('$surname', '$name', '$patronymic', '$phone', '$email', '$delivery_id', '$payment_id', '$comment', '$goods', '$sum', '$date')"
            );
            database\closeConnect(database\connect());
            echo '<p class="order__success">Заказ успешно оформлен!</p><a href="/">Вернуться в магазин</a>';
        } else {
            echo 'error';
        }
    } else {
        if (
            isset($_POST['surname']) && $_POST['surname'] !== '' &&
            isset($_POST['name']) && $_POST['name'] !== '' &&
            isset($_POST['phone']) && $_POST['phone'] !== '' &&
            isset($_POST['email']) && $_POST['email'] !== '' &&
            isset($_POST['city']) && $_POST['city'] !== '' &&
            isset($_POST['street']) && $_POST['street'] !== '' &&
            isset($_POST['home']) && $_POST['home'] !== '' &&
            isset($_POST['aprt']) && $_POST['aprt'] !== ''
        ) {
            $delivery_id = 2;


            $city = $_POST['city'];
            $street = $_POST['street'];
            $home = $_POST['home'];
            $app = $_POST['aprt'];

            mysqli_query(
                database\connect(),
                "INSERT INTO orders (surname, name, patronymic, phone, mail, delivery_id, city, street, home, 
                    app, payment_id, comment, goods, sum, date)
                    VALUES ('$surname', '$name', '$patronymic', '$phone', '$email', '$delivery_id', '$city', '$street', '$home',
                            '$app', '$payment_id', '$comment', '$goods', '$sum', '$date')"
            );
            echo '<p class="order__success">Заказ успешно оформлен!</p><a href="/">Вернуться в магазин</a>';
        } else {
            echo 'error';
        }
    }
}
