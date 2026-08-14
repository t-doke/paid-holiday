<?php
$id = (string)filter_input(INPUT_POST, 'id');
if ($id === "") {
    error_log("IDがありません。");
    header('Location: update.php');
    exit();
}
if (filter_var($id, FILTER_VALIDATE_INT) === false) {
    error_log("IDが整数ではありません。");
    header('Location: update.php');
    exit();
}

$paid = (string)filter_input(INPUT_POST, 'paid');
if ($paid === "") {
    error_log("数が記入されていません。");
    header('Location: update.php');
    exit();
}
if (filter_var($paid, FILTER_VALIDATE_INT) === false) {
    error_log("整数ではありません。");
    header('Location: update.php');
    exit();
}

try {
    require_once('../library.php');

    $sql = "update
                lists
            set
                paid = :paid
            where
                id = :id";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(':paid', $paid, PDO::PARAM_INT);
    $ps->bindValue(':id', $id, PDO::PARAM_INT);
    $ps->execute();

    header('Location: master_show.php');
} catch (PDOException $e) {
    error_log('PDOException: ' . $e->getMessage());
    header('Location: ../error.php');
}