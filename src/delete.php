<?php
$id = (string)filter_input(INPUT_GET, 'id');
if ($id === "") {
    error_log("IDがありません。");
    header('Location: create.php');
    exit();
}
if (filter_var($id, FILTER_VALIDATE_INT) === false) {
    error_log("IDが整数ではありません。");
    header('Location: create.php');
    exit();
}

try {
    require_once('library.php');
    
    $sql = "delete from lists where id = :id";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(':id', $id, PDO::PARAM_INT);
    $ps->execute();

    header('Location: master_show.php');
} catch (PDOException $e) {
    error_log('PDOException: ' . $e->getMessage());
    header('Location: error.php');
    exit();
}