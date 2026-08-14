<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../master/css/master_style.css">
    <title>SQL Injection</title>
</head>
<body>
    <?php
        $dsn = "mysql:host=mysql-container;dbname=my_database;charset=utf8mb4";
        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        $pdo = new PDO($dsn, "user", "userpassword", $options);

        $company_id = $_POST['company_id'];
        $number = $_POST['number'];
        $sql = "select
                number, name, paid, company_id, created, updated
            from
                lists
            where
                company_id = '$company_id'
            and
                number = $number";
        $stmt = $pdo->query($sql);
        $lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <h3>有給</h3>
            <hr>
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>社員番号</th>
                        <th>氏名</th>
                        <th>残り有給数</th>
                        <th>会社ID</th>
                        <th>登録日時</th>
                        <th>更新日時</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lists as $list): ?>
                    <tr>
                        <td><?php echo $list['number']; ?></td>
                        <td><?php echo $list['name']; ?></td>
                        <td><?php echo $list['paid']; ?></td>
                        <td><?php echo $list['company_id']; ?></td>
                        <td><?php echo $list['created']; ?></td>
                        <td><?php echo $list['updated']; ?></td>
                     </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
</body>
</html>