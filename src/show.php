<?php
require('library.php');

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

    $sql = "select 
                name, paid, updated
            from
                lists
            where
                id = :id";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(':id', $id, PDO::PARAM_INT);
    $ps->execute();
    $list = $ps->fetch();

    $updated = $list['updated'];
    $datetime = new DateTime($updated, new DateTimeZone('UTC'));
    $datetime->setTimezone(new DateTimeZone('Asia/Tokyo'));

} catch (PDOException $e) {
    error_log("PDOException: " . $e->getMessage());
    header('Location: error.php');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Paid-Holiday</title>
</head>
<body>
<div class="container">
    <?php require('message.php'); ?>
    <h3><?= h($list['name']) ?>さんお疲れ様です。</h3>
    <hr>
    <p><?= h($list['name']) ?>さんの残り有給数は<?= h($list['paid']) ?>です。<br>
        <small>（<?= $datetime->format('Y-m-d H:i:s') ?> 時点）</small></p>
    <hr>
    <p><a href="index.php">戻る</a></p>
</div>
</body>
</html>