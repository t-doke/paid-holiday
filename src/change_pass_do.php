<?php
try {
    require_once('library.php');
    
    $id = (string)filter_input(INPUT_POST, 'id');
    if ($id === "") {
        error_log("IDがありません。");
        header('Location: change_pass.php');
        exit();
    }
    if (filter_var($id, FILTER_VALIDATE_INT) === false) {
        error_log("IDが整数ではありません。");
        header('Location: change_pass.php');
        exit();
    }

    $old_password = (string)filter_input(INPUT_POST, 'password');
    if ($old_password === "") {
        error_log("古いパスワードがありません。");
        header('Location: change_pass.php');
        exit();
    }

    $new_password = (string)filter_input(INPUT_POST, 'newpassword');
    if ($new_password === "") {
        error_log("新しいパスワードがありません。");
        header('Location: change_pass.php');
        exit();
    }
    if (mb_strlen($new_password) > 25) {
        error_log("パスワードが長すぎます。");
        header('Location: change_pass.php');
        exit();
    }
    $h_password = password_hash($new_password, PASSWORD_DEFAULT);

    $sql = "select
                password
            from
                lists
            where
                id = :id";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(':id', $id, PDO::PARAM_INT);
    $ps->execute();
    $db_password = $ps->fetchColumn();
    if (password_verify($old_password, $db_password) === false) {
        set_message(MESSAGE_WRONG_PASSWORD);
        header('Location: change_pass.php?id=' . $id);
        exit();
    } else {
        $sql = "update
                    lists
                set
                    password = :password
                where
                    id = :id";
        $ps = $pdo->prepare($sql);
        $ps->bindValue(':password', $h_password, PDO::PARAM_STR);
        $ps->bindValue(':id', $id, PDO::PARAM_INT);
        $ps->execute();

        header('Location: show.php?id=' . $id);
        set_message(MESSAGE_CHANGE_PASSWORD_SUCCESS);
    }
} catch (PDOException $e) {
    error_log($e->getMessage());
    header('Location: error.php');
}