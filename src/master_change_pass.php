<?php
$id = (string)filter_input(INPUT_GET, 'id');
if ($id === "") {
    error_log("IDがありません。");
    header('Location: master_show.php?id=' . $id);
    exit();
}
if (filter_var($id, FILTER_VALIDATE_INT) === false) {
    error_log("IDが整数ではありません。");
    header('Location: master_show.php?id=' . $id);
    exit();
}

try {
    require_once('library.php');

    $sql = "select
                id, name
            from
                accounts
            where
                id = :id";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(':id', $id, PDO::PARAM_INT);
    $ps->execute();
    $account = $ps->fetch();
    if ($account === false) {
        set_message("IDが見つかりません。");
        header('Location: master_show.php');
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
    <?php require('master_head.php'); ?>
</head>
<body>
    <?php require('header.php'); ?>
    <main class="custom-container">
        <?php require('message.php'); ?>
        <h3>パスワード変更画面</h3>
        <hr>
        <form action="master_change_pass_do.php" method="post" class="custom-form">
            <input type="hidden" name="id" value="<?= h($account['id']) ?>">
            <div class="custom-form-group">
                <label>企業ID</label>
                <span><?= h($account['name']) ?></span>
            </div>
            <div class="custom-form-group">
                <label for="password">旧パスワード</label>
                <input type="password" name="password" id="password" class="custom-input" required>
            </div>
            <div class="custom-form-group">
                <label for="newpassword">新パスワード</label>
                <input type="password" name="newpassword" id="newpassword" class="custom-input" required>
            </div>
            <button type="submit" class="custom-btn">変更</button>
        </form>
        <hr>
        <div class="admin-link">
                <a href="master_show.php">戻る</a>
        </div>
    </main>
</body>
</html>
