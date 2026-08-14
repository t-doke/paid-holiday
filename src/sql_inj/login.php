<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>SQL Injection</title>
</head>
<body>
    <h3>ログイン画面</h3>
    <div class="login-box">
        <hr>
        <form action="show.php" method="post">
            <div class="custom-form-group">
            <label for="name">企業ID</label>
                <input type="text" name="company_id" id="company_id" value="<?= ($input_values['company_id'] ?? '') ?>" required></br>
            </div>
            <div class="custom-form-group">
                <label for="name">社員番号</label>
                <input type="text" name="number" id="number" value="<?= ($input_values['number'] ?? '') ?>" required></br>
            </div>
                <button type="submit" class="custom-btn">ログインする</button>
        </form>
        <hr>
    </div>
</body>
</html>