<?php
try {
    require_once('library.php');

    $csrf_token = filter_input(INPUT_POST, 'csrf_token');
    if (validate_csrf_token($csrf_token) === false) {
        error_log('不正なcsrf tokenです。');
        header('Location: error.php');
        exit();
    }

    $name = (string)filter_input(INPUT_POST, 'name');
    if ($name === "") {
        set_message(MESSAGE_SIGNUP_ERROR);
        header('Location: signup.php');
        exit();
    }
    if (mb_strlen($name) > 20) {
        set_message(MESSAGE_SIGNUP_ERROR);
        header('Location: signup.php');
        exit();
    }

    $password = (string)filter_input(INPUT_POST, 'password');
    if ($password === "") {
        set_message(MESSAGE_SIGNUP_ERROR);
        header('Location: signup.php');
        exit();
    }
    if (mb_strlen($password) > 20) {
        set_message(MESSAGE_SIGNUP_ERROR);
        header('Location: signup.php');
        exit();
    }
    $h_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "select
                count(*)
            from
                accounts
            where
                name = :name";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(':name', $name, PDO::PARAM_STR);
    $ps->execute();
    $count = $ps->fetchColumn();
    if ($count > 0) {
        set_message(MESSAGE_ALREADY_USED_NAME);
        header('Location: signup.php');
        exit();
    }

    $sql = "insert into accounts
                (name, password)
            values
                (:name, :password)";

    $ps = $pdo->prepare($sql);
    $ps->bindValue(':name', $name, PDO::PARAM_STR);
    $ps->bindValue(':password', $h_password, PDO::PARAM_STR);
    $ps->execute();

    set_message(MESSAGE_SIGNUP_SUCCESS);

    header('Location: signin.php');
} catch (PDOException $e) {
    if ($e->getCode() === 23000) {
        set_message(MESSAGE_SIGNUP_ERROR_NOT_AVAILABLE_NAME);
        header('Location: signup.php');
        exit();
    }
    error_log($e->getMessage());
    header('Location: error.php');
}
?>