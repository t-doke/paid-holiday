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
        <div class="error-box">
            <h3>エラー</h3>
            <hr>
            <p>エラーです。</p>
            <hr>
            <div class="admin-link">
                <a href="login.php">戻る</a>
            </div>
        </div>
    </main>
</body>
</html>
