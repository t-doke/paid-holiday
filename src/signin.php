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
    <header><?php require('message.php'); ?></header>
    <main class="container">
        <h3>管理者-サインイン画面</h3>
        <hr>
        <form action="signin_post.php" method="post">
            <input type="hidden" name="csrf_token" value="<?= h($csrf_token) ?>">
            <p>企業名<br>
            <input type="text" name="name" id="name" required></p>
            <p>パスワード<br>
            <input type="password" name="password" id="password" required></p>
            <p><button type="submit">サインインする</button></p>
        </form>
        <hr>
        <p><a href="signup.php">新規アカウント作成</a><a href="index.php">戻る</a></p>
    </main>
    <footer></footer>
</body>
</html>