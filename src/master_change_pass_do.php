<?php
try {
    require_once('library.php');

    $id = (string)filter_input(INPUT_POST, 'id');
    if ($id === "") {
        set_message("IDがありません。");
        header('Location: master_change_pass.php');
        exit();
    }
    if (filter_var($id, FILTER_VALIDATE_INT) === false) {
        set_message("IDが整数ではありません。");
        header('Location: master_change_pass.php');
        exit();
    }

    $old_password = (string)filter_input(INPUT_POST, 'password');
    if ($old_password === "") {
        set_message("旧パスワードを記入してください。");
        header('Location: master_change_pass.php');
        exit();
    }

    $new_password = (string)filter_input(INPUT_POST, 'newpassword');
    if ($new_password === "") {
        set_message("新パスワードを記入してください。");
        header('Location: master_change_pass.php');
        exit();
    }
    if (mb_strlen($new_password) > 25) {
        set_message("パスワードが長すぎます。");
        header('Location: master_change_pass.php');
        exit();
    }
    $h_password = password_hash($new_password, PASSWORD_DEFAULT);

    $sql = "select
                password
            from
                accounts
            where
                id = :id";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(':id', $id, PDO::PARAM_INT);
    $ps->execute();
    $db_password = $ps->fetchColumn();
    if (password_verify($old_password, $db_password) === false) {
        set_message(MESSAGE_WRONG_PASSWORD);
        header('Location: master_change_pass.php?id=' . $id);
        exit();
    } else {
        $sql = "update
                    accounts
                set
                    password = :password
                where
                    id = :id";
        $ps = $pdo->prepare($sql);
        $ps->bindValue(':password', $h_password, PDO::PARAM_STR);
        $ps->bindValue(':id', $id, PDO::PARAM_INT);
        $ps->execute();

        header('Location: master_show.php');
        set_message(MESSAGE_CHANGE_PASSWORD_SUCCESS);
    }
} catch (PDOException $e) {
    error_log($e->getMessage());
    header('Location: error.php');
}