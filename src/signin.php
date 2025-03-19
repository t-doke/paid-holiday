<?php
require_once('library.php');

$csrf_token = generate_csrf_token();

$input_values = $_SESSION['input_values'] ?? [];
unset($_SESSION['input_values']);
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
        <div class="signin-box">
            <h3>管理者-サインイン画面</h3>
            <hr>
            <form action="signin_post.php" method="post" class="custom-form">
                <input type="hidden" name="csrf_token" value="<?= h($csrf_token) ?>">
                <div class="custom-form-group">
                    <label for="name">企業ID</label>
                    <input type="text" name="name" id="name" class="custom-input" value="<?= h($input_values['name'] ?? '') ?>" required>
                </div>
                <div class="custom-form-group">
                    <label for="password">パスワード</label>
                    <input type="password" name="password" id="password" class="custom-input" required>
                </div>
                <button type="submit" class="custom-btn">サインインする</button>
            </form>
            <hr>
            <div class="account-link">
                <a href="signup.php">新規アカウント作成</a> 
            </div>
            <hr>
            <div class="admin-link">
                <a href="login.php">戻る</a>
            </div>
        </div>
    </main>
    <footer></footer>
</body>
</html>
