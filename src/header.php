<?php

try {
    require_once('library.php');

    $name = get_account_name();

    $sql = "select
                id, name, password
            from
                accounts
            where
                name = :name";
    $ps = $pdo->prepare($sql);
    $ps->bindValue(':name', $name, PDO::PARAM_STR);
    $ps->execute();
    $account = $ps->fetch();
} catch (PDOException $e) {
    error_log($e->getMessage());
    header('Location: error.php');
    exit();
}
?>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="/login.php" class="navbar-brand"><strong>有給確認</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?php if (is_sign_in()) { ?>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= h(get_account_name()) ?>
                            </a>
                            <?php if ($account === false): ?>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="show.php?id=<?= h(get_account_id()) ?>">マイページへ</a></li>
                                <li><a class="dropdown-item" href="shift.php" target="_blank">シフトを見る</a></li>
                                <li><a class="dropdown-item" href="change_pass.php?id=<?= h(get_account_id()) ?>">パスワードの変更</a></li>                                
                                <li><a class="dropdown-item" href="logout.php">ログアウト</a></li>
                            </ul>
                            <?php else: ?>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="/master/master_show.php?id=<?= h(get_account_id()) ?>">管理画面へ</a></li>
                                <li><a class="dropdown-item" href="/master/master_change_pass.php?id=<?= h(get_account_id()) ?>">パスワードの変更</a></li>                                
                                <li><a class="dropdown-item" href="/master/signout.php">サインアウト</a></li>
                            </ul>
                            <?php endif; ?>
                        </li>
                    </ul>
                <?php } else { ?>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a href="/login.php" class="btn btn-outline-light">ログイン</a>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </nav>
</header>

