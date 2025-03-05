<?php
require_once('library.php');

$csrf_token = filter_input(INPUT_POST, 'csrf_token');
if (validate_csrf_token($csrf_token) === false) {
    error_log('不正なcsrf tokenです。');
    header('Location: error.php');
    exit();
}

$name = (string)filter_input(INPUT_POST, 'name');
if ($name === "") {
    set_message(MESSAGE_SIGNIN_ERROR);
    header('Location: signin.php');
    exit();
}
if (mb_strlen($name) > 20) {
    set_message(MESSAGE_SIGNIN_ERROR);
    header('Location: signin.php');
    exit();
}

$password = (string)filter_input(INPUT_POST, 'password');
if ($password === "") {
    set_message(MESSAGE_SIGNIN_ERROR);
    header('Location: signin.php');
    exit();
}
if (mb_strlen($password) > 20) {
    set_message(MESSAGE_SIGNIN_ERROR);
    header('Location: signin.php');
    exit();
}

try {
    $sql = "select
                id, name, password
            from
                master
            where
                name = :name";

    $ps = $pdo->prepare($sql);
    $ps->bindValue(':name', $name, PDO::PARAM_STR);
    $ps->execute();
    $master = $ps->fetch();
    if ($master === false) {
        set_message(MESSAGE_SIGNIN_ERROR);
        header('Location: signin.php');
        exit();
    }
    if (password_verify($password, $master['password']) === false) {
        set_message(MESSAGE_SIGNIN_ERROR);
        header('Location: sigin.php');
        exit();
    }

    sign_in($master);

    set_message(MESSAGE_SIGNIN_SUCCESS);

    header('Location: master_show.php');
} catch (PDOException $e) {
    error_log('PDOException: ' . $e->getMessage());
    header('Location: error.php');
    exit();
}
?>