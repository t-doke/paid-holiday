<?php
require_once('../library.php');

$csrf_token = generate_csrf_token();
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
        <div class="login-box">
            <h3>追加画面</h3>
            <hr>
            <form action="edit.php" method="post">
                <div class="custom-form-group">
                    <label for="number">社員番号</label>
                    <input type="number" name="number" id="number" class="custom-input" required>
                </div>
                <div class="custom-form-group">
                    <label for="name">氏名</label>
                    <input type="text" name="name" id="name" class="custom-input" required>
                </div>
                <div class="custom-form-group">
                    <label for="password">仮パスワード</label>
                    <input type="text" name="password" id="password" class="custom-input" required>
                </div>
                <div class="custom-form-group">
                    <label for="paid">残り有給数</label>
                    <input type="number" name="paid" id="paid" class="custom-input" required>
                </div>
                <button type="submit" class="custom-btn">追加</button>
            </form>
            <hr>
            <div class="admin-link">
                <a href="master_show.php">戻る</a>
            </div>
        </div>
    </main>
</body>
</html>
