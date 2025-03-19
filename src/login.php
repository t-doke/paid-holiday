<?php
require_once('library.php');

$csrf_token = generate_csrf_token();

$input_values = $_SESSION['input_values'] ?? [];
unset($_SESSION['input_values']);
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
        <div class="login-box">
            <h3>従業員-ログイン画面</h3>
            <hr>
            <form action="login_post.php" method="post">
                <input type="hidden" name="csrf_token" value="<?= h($csrf_token) ?>">
                <div class="custom-form-group">
                    <label for="name">企業ID</label>
                    <input type="text" name="company_id" id="company_id" class="custom-input" value="<?= ($input_values['company_id'] ?? '') ?>" required>
                </div>
                <div class="custom-form-group">
                    <label for="name">社員番号</label>
                    <input type="text" name="number" id="number" class="custom-input"  value="<?= ($input_values['number'] ?? '') ?>" required>
                </div>
                <div class="custom-form-group">
                    <label for="password">パスワード</label>
                    <input type="password" name="password" id="password" class="custom-input" required>
                </div>
                <button type="submit" class="custom-btn">ログインする</button>
            </form>
            <hr>
            <div class="admin-link">
                <a href="signin.php">管理者サインイン画面</a>
            </div>
        </div>
    </main>
</body>
</html>
