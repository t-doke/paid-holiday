<?php
require('library.php');

$id = (string)filter_input(INPUT_GET, 'id');
if ($id === "") {
    set_message("IDが存在しません。");
    header('Location: login.php');
    exit();
}
if (filter_var($id, FILTER_VALIDATE_INT) === false) {
    set_message("IDが整数ではありません。");
    header('Location: login.php');
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
    <?php require('head.php'); ?>
</head>
<body>
    <?php require('header.php'); ?>
    <main class="custom-container">
        <?php require('message.php'); ?>
        <div class="status-box">
            <h3><?= h($list['name']) ?>さん、お疲れ様です。</h3>
            <hr>
            <p class="status-message">
                <?= h($list['name']) ?>さんの残り有給数は 
                <span class="highlight"><?= h($list['paid']) ?></span> です。<br>
                <small class="date-info">（<?= $datetime->format('Y-m-d') ?> 時点）</small>
            </p>
            <hr>
            <div class="admin-link">
                <a href="shift.php" target="_blank">シフトを見る</a>
            </div>
            <hr>
            <div class="admin-link">
                <a href="login.php">戻る</a>
            </div>
        </div>
    </main>
</body>
</html>
