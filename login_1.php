<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <h1>ログイン</h1>
    <form action="login_2.php" method="post">
        <label for="admin_address">メールアドレス</label>
        <input type="text" id="admin_address" name="admin_address" required><br>
        <label for="admin_password">パスワード</label>
        <input type="text" id="admin_password" name="admin_password" required><br>
        <input type="submit" value="ログイン">
    </form>
</body>
</html>
