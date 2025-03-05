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

    $sql = "select
                id, number, name, paid
            from
                lists
            where
                id = :id";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(':id', $id, PDO::PARAM_INT);
    $ps->execute();
    $list = $ps->fetch();
    if ($list === false) {
        error_log("IDが見つかりません。");
        header('Location: create.php');
        exit();
    }
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
<div class="container">
    <h3>編集画面</h3>
    <hr>
    <form action="update_do.php" method="post">
        <input type="hidden" name="id" value="<?= h($list['id']) ?>">
        社員番号: <?= h($list['number']) ?><br>
        氏名: <?= h($list['name']) ?><br>
        残り有給数: <input type="number" name="paid" id="paid"><br>
        <button type="submit">更新</button>
    </form>
    <hr>
    <p><a href="master_show.php">戻る</a></p>
</div>
</body>
</html>