<?php
require_once('../library.php');

if (!is_sign_in()) {
    set_message("ログインしてください。");
    header('Location: ../login.php');
    exit();
}

$account_id = get_account_id();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdfFile'])) {
    $file = $_FILES['pdfFile'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        set_message("ファイルのアップロードに失敗しました。");
        header('Location: master_show.php');
        exit();
    }

    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    if (strtolower($fileExtension) !== 'pdf') {
        set_message("PDFファイルのみアップロードできます。");
        header('Location: master_show.php');
        exit();
    }

    $fileData = file_get_contents($file['tmp_name']);

    try {
        $sql = "update
                    accounts
                set
                    picture = :picture
                where
                    id = :id";
        $ps = $pdo->prepare($sql);
        $ps->bindValue(':picture', $fileData, PDO::PARAM_LOB);
        $ps->bindValue(':id', $account_id, PDO::PARAM_INT);
        $ps->execute();

        set_message("PDFファイルがアップロードされました。");
        header('Location: master_show.php');
    } catch (PDOException $e) {
        error_log('PDOException: ' . $e->getMessage());
        set_message("ファイルのアップロード中にエラーが発生しました。");
        header('Location: master_show.php');
    }
} else {
    set_message("ファイルが選択されていません。");
    header('Location: master_show.php');
}
?>
