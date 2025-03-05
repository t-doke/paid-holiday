<?php
$number = (string)filter_input(INPUT_POST, 'number');
if ($number === "") {
    error_log("社員番号がありません。");
    header('Location: create.php');
    exit();
}
if (filter_var($number, FILTER_VALIDATE_INT) === false) {
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
if (mb_strlen($name) > 25) {
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

try {
    require_once('library.php');

    $sql = "insert into lists
                (number, name, password, paid)
            values
                (:number, :name, :password, :paid)";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(':number', $number, PDO::PARAM_INT);
    $ps->bindValue(':name', $name, PDO::PARAM_STR);
    $ps->bindValue(':password', $h_password, PDO::PARAM_STR);
    $ps->bindValue(':paid', $paid, PDO::PARAM_INT);
    $ps->execute();

    header('Location: master_show.php');
} catch (PDOException $e) {
    error_log("PDOException: " . $e->getMessage());
    header('Location: error.php');
}