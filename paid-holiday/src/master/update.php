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
    require_once('../library.php');

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
    header('Location: ../error.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <?php require('master_head.php'); ?>
</head>
<body>
    <?php require('../header.php'); ?>
    <main class="custom-container">
        <?php require('../message.php'); ?>
        <h3>編集画面</h3>
        <hr>
        <form action="update_do.php" method="post" class="custom-form">
            <input type="hidden" name="id" value="<?= h($list['id']) ?>">
            <div class="custom-form-group">
                <label>社員番号</label>
                <span><?= h($list['number']) ?></span>
            </div>
            <div class="custom-form-group">
                <label>氏名</label>
                <span><?= h($list['name']) ?></span>
            </div>
            <div class="custom-form-group">
                <label for="paid">残り有給数</label>
                <input type="number" name="paid" id="paid" class="custom-input" value="<?= h($list['paid']) ?>" required>
            </div>
            <button type="submit" class="custom-btn">更新</button>
        </form>
        <hr>
        <p class="back-link"><a href="master_show.php">戻る</a></p>
    </main>
</body>
</html>
