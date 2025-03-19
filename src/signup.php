<?php
require_once('library.php');

$csrf_token = generate_csrf_token();
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
        <div class="signup-box">
            <h3>管理者-新規アカウント作成画面</h3>
            <hr>
            <form action="signup_post.php" method="post" class="custom-form">
                <input type="hidden" name="csrf_token" value="<?= h($csrf_token) ?>">
                <div class="custom-form-group">
                    <label for="name">企業ID</label>
                    <input type="text" name="name" id="name" class="custom-input" required>
                </div>
                <div class="custom-form-group">
                    <label for="password">パスワード</label>
                    <input type="password" name="password" id="password" class="custom-input" required>
                </div>
                <button type="submit" class="custom-btn">アカウント作成</button>
            </form>
            <hr>
            <div class="account-link">
                <a href="signin.php">戻る</a>
            </div>
        </div>
    </main>
    <footer></footer>
</body>
</html>
