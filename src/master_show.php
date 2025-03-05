<?php
try {
    require_once('library.php');

    $sql = "select
                id, number, name, paid
            from
                lists";
    $ps = $pdo->prepare($sql);
    $ps->execute();
    $lists = $ps->fetchAll();
} catch (PDOException $e) {
    error_log('PDOException: ' . $e->getMessage());
    header('Location: error.php');
    exit();
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
    <main class="container">
        <?php require('message.php'); ?>
        <h3>管理画面</h3>
        <hr>
        <table border="1">
            <tr>
                <th>社員番号</th>
                <th>氏名</th>
                <th>残り有給数</th>
                <th>編集する</th>
                <th>削除する</th>
            </tr>
            <?php foreach ($lists as $list): ?>
            <tr>
                <td><?= h($list['number']) ?></td>
                <td><?= h($list['name']) ?></td>
                <td><?= h($list['paid']) ?></td>
                <td><a href="update.php?id=<?= h($list['id']) ?>">編集する</a></td>
                <td><a href="delete.php?id=<?= h($list['id']) ?>">削除する</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <p><a href="create.php">追加する</a></p>
        <hr>
        <p><a href="index.php">戻る</a></p>
    </main>
</body>
</html>