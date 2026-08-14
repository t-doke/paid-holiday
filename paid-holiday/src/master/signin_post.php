<?php
try {
    require_once('../library.php');

    $csrf_token = filter_input(INPUT_POST, 'csrf_token');
    if (validate_csrf_token($csrf_token) === false) {
        error_log('不正なcsrf tokenです。');
        header('Location: ./error.php');
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

    $_SESSION['input_values'] = [
        'name' => $name,
    ];
    
    
    $sql = "select
                id, name, password
            from
                accounts
            where
                name = :name";

    $ps = $pdo->prepare($sql);
    $ps->bindValue(':name', $name, PDO::PARAM_STR);
    $ps->execute();
    $accounts = $ps->fetch();
    if ($accounts === false) {
        set_message(MESSAGE_SIGNIN_ERROR);
        header('Location: signin.php');
        exit();
    }
    if (password_verify($password, $accounts['password']) === false) {
        set_message(MESSAGE_SIGNIN_ERROR . "パスワードが正しくありません。");
        header('Location: signin.php');
        exit();
    }

    unset($_SESSION['input_values']);

    sign_in($accounts);

    set_message(MESSAGE_SIGNIN_SUCCESS);

    header('Location: master_show.php');
} catch (PDOException $e) {
    error_log('PDOException: ' . $e->getMessage());
    header('Location: ./error.php');
    exit();
}
?>