<?php

if (isset($_POST['authorization'])) {
    $login = mysqli_real_escape_string(database\connect(), $_POST['login']);
    $user = mysqli_query(database\connect(), "SELECT password, groups FROM users WHERE email='$login'");

    if (mysqli_num_rows($user) > 0) {
        $user = mysqli_fetch_assoc($user);
        //$isAuth = false;
        $isAuth = password_verify($_POST['password'], $user['password']);
        !$isAuth ?: $_SESSION['isAuth'] = true;
        $_SESSION['isAdmin'] = (int)$user['groups'] === 1 && $isAuth;
    }
}

