<?php
try {
    require_once('../library.php');

    $company_id = get_account_name();

    $sql = "select
                id, number, name, paid
            from
                lists
            where
                company_id = :company_id";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(':company_id', $company_id, PDO::PARAM_STR);
    $ps->execute();
    $lists = $ps->fetchAll();
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
        <div class="admin-box">
            <h3>管理画面</h3>
            <hr>
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>社員番号</th>
                        <th>氏名</th>
                        <th>残り有給数</th>
                        <th>編集</th>
                        <th>削除</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lists as $list): ?>
                    <tr>
                        <td><?= h($list['number']) ?></td>
                        <td><?= h($list['name']) ?></td>
                        <td><?= h($list['paid']) ?></td>
                        <td><a href="update.php?id=<?= h($list['id']) ?>" class="custom-link">編集する</a></td>
                        <td><a href="delete.php?id=<?= h($list['id']) ?>" class="custom-link delete-link" onclick="return confirm('本当に削除しますか？');">削除する</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="admin-actions">
                <a href="create.php" class="custom-btn">追加する</a>
            </div>
            <hr>
            <div class="admin-box">
                <form action="upload_pdf.php" method="post" enctype="multipart/form-data">
                    <div class="custom-form-group">
                        <label for="pdfFile">シフト表(PDFファイル)をアップロード</label>
                        <input type="file" name="pdfFile" id="pdfFile" accept=".pdf" class="custom-input" required>
                    </div>
                    <button type="submit" class="custom-btn">アップロード</button>
                </form>
            </div>
                <hr>
            <div class="admin-link">
                <a href="signin.php">戻る</a>
            </div>
        </div>
    </main>
</body>
</html>
