<?php
require_once('library.php');

if (!is_sign_in()) {
    set_message("ログインしてください。");
    header('Location: login.php');
    exit();
}

$id = get_account_id();

try {
    $sql = "select
                a.picture, l.id
            from
                accounts a
            left join
                lists l
            on
                a.name = l.company_id
            where
                l.id = :id";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(':id', $id, PDO::PARAM_INT);
    $ps->execute();
    $account = $ps->fetch();
    
    if ($account['picture']) {
        header('Content-Type: application/pdf');
        exit();
    } else {
        set_message("PDFファイルがアップロードされていません。");
        header('Location: show.php?id=' . $id);
        exit();
    }
} catch (PDOException $e) {
    error_log('PDOException: ' . $e->getMessage());
    set_message("PDFの表示中にエラーが発生しました。");
    header('Location: show.php?id=' . $id);
    exit();
}
?>