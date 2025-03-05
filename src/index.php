<?php
    require_once('library.php');

    $csrf_token = generate_csrf_token();
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
        <h3>有給確認-<small>ログイン画面</small></h3>
        <hr>
        <form action="login.php" method="post">
            <input type="hidden" name="csrf_token" value="<?= h($csrf_token) ?>">
            <p>氏名<br>
            <input type="text" name="name" id="name" required></p>
            <p>パスワード<br>
            <input type="password" name="password" id="password" required></p>
            <p><button type="submit">ログインする</button></p>
        </form>
        <hr>
        <div class="master">
            <a href="signin.php">管理者用画面</a>
        </div>
    </main>
</body>
</html>