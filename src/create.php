<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Paid-Holiday</title>
</head>
<body>
    <div class="container">
        <h3>追加画面</h3>
        <hr>
        <form action="edit.php" method="post">
            <p>社員番号<br>
            <input type="number" name="number" id="number"></p>
            <p>氏名<br>
            <input type="text" name="name" id="name"></p>
            <p>仮パスワード<br>
            <input type="text" name="password" id="password"></p>
            <p>残り有給数<br>
            <input type="number" name="paid" id="paid"></p>
            <p><button type="submit">追加</button></p>
        </form>
        <hr>
        <p><a href="master_show.php">戻る</a></p>
    </div>
</body>
</html>