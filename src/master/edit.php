<?php
try {
    require_once('../library.php');

    $number = (string)filter_input(INPUT_POST, 'number', FILTER_SANITIZE_SPECIAL_CHARS);
    if ($number === "") {
        error_log("社員番号がありません。");
        header('Location: create.php');
        exit();
    }
    if (!preg_match('/^\d+$/', $number)) {
        error_log("整数で入力してください。");
        header('Location: create.php');
        exit();
    }

    $name = (string)filter_input(INPUT_POST, 'name');
    if ($name === "") {
        error_log("氏名がありません。");
        header('Location: create.php');
        exit();
    }
    if (mb_strlen($name) > 25) {
        error_log("氏名が長すぎます。");
        header('Location: create.php');
        exit();
    }

    $password = (string)filter_input(INPUT_POST, 'password');
    if ($password === "") {
        error_log("パスワードがありません。");
        header('Location: create.php');
        exit();
    }
    if (mb_strlen($password) > 25) {
        error_log("パスワードが長すぎます。");
        header('Location: create.php');
        exit();
    }
    $h_password = password_hash($password, PASSWORD_DEFAULT);

    $paid = (string)filter_input(INPUT_POST, 'paid');
    if ($paid === "") {
        error_log("有給数がありません。");
        header('Location: create.php');
        exit();
    }
    if (filter_var($paid, FILTER_VALIDATE_INT) === false) {
        error_log("整数で入力してください。");
        header('Location: create.php');
        exit();
    }

    $company_id = get_account_name();

    $sql = "select
                count(*)
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
    $count = $ps->fetchColumn();
    if ($count > 0) {
        set_message(MESSAGE_ALREADY_USED_NUMBER);
        header('Location: create.php');
        exit();
    }

    $sql = "insert into lists
                (number, name, password, paid, company_id)
            values
                (:number, :name, :password, :paid, :company_id)";

    $ps = $pdo->prepare($sql);
    $ps->bindValue(':number', $number, PDO::PARAM_STR);
    $ps->bindValue(':name', $name, PDO::PARAM_STR);
    $ps->bindValue(':password', $h_password, PDO::PARAM_STR);
    $ps->bindValue(':paid', $paid, PDO::PARAM_INT);
    $ps->bindValue(':company_id', $company_id, PDO::PARAM_STR);
    $ps->execute();

    header('Location: master_show.php');
} catch (PDOException $e) {
    error_log("PDOException: " . $e->getMessage());
    header('Location: ../error.php');
}