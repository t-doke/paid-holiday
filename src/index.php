<?php
require_once('library.php');

$csrf_token = generate_csrf_token();
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
        <div class="welcome-box">
            <h3>ようこそ</h3>
            <hr>
            <p>有給管理・確認システムです。</p>
            <hr>
            <div class="admin-link">
                <a href="login.php" target="_blank">早速使う</a>
            </div>
        </div>
    </main> 
</body>
</html>
