<?php
require_once('library.php');

$csrf_token = filter_input(INPUT_POST, 'csrf_token');
if (validate_csrf_token($csrf_token) === false) {
    error_log('不正なcsrf tokenです。');
    header('Location: error.php');
    exit();
}

$company_id = (string)filter_input(INPUT_POST, 'company_id');
if ($company_id === "") {
    set_message(MESSAGE_LOGIN_ERROR . "企業IDを入力してください。");
    header('Location: login.php');
    exit();
}
if (mb_strlen($company_id) > 20) {
    set_message(MESSAGE_LOGIN_ERROR);
    header('Location: login.php');
    exit();
}

$number = (string)filter_input(INPUT_POST, 'number', FILTER_SANITIZE_SPECIAL_CHARS);
if ($number === "") {
    set_message(MESSAGE_LOGIN_ERROR . "社員番号を入力してください。");
    header('Location: login.php');
    exit();
}
if (!preg_match('/^\d+$/', $number)) {
    set_message(MESSAGE_LOGIN_ERROR . "社員番号を整数で入力してください。");
    header('Location: login.php');
    exit();
}

$password = (string)filter_input(INPUT_POST, 'password');
if ($password === "") {
    set_message(MESSAGE_LOGIN_ERROR . "パスワードを入力してください。");
    header('Location: login.php');
    exit();
}
if (mb_strlen($password) > 20) {
    set_message(MESSAGE_LOGIN_ERROR);
    header('Location: login.php');
    exit();
}

$_SESSION['input_values'] = [
    'company_id' => $company_id,
    'number' => $number
];

try {
    $sql = "select
                id, name, password
            from
                lists
            where
                company_id = :company_id
            and
                number = :number";

    $ps = $pdo->prepare($sql);
    $ps->bindValue(':company_id', $company_id, PDO::PARAM_STR);
    $ps->bindValue(':number', $number, PDO::PARAM_STR);
    $ps->execute();
    $list = $ps->fetch();
    if ($list === false) {
        set_message(MESSAGE_LOGIN_ERROR);
        header('Location: login.php');
        exit();
    }
    if (password_verify($password, $list['password']) === false) {
        set_message(MESSAGE_LOGIN_ERROR . "パスワードが正しくありません。");
        header('Location: login.php');
        exit();
    }

    unset($_SESSION['input_values']);
    
    sign_in($list);

    set_message(MESSAGE_LOGIN_SUCCESS);

    header('Location: show.php?id=' . $list['id']);
} catch (PDOException $e) {
    error_log('PDOException: ' . $e->getMessage());
    header('Location: error.php');
    exit();
}
?>