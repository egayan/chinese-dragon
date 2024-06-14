<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録画面</title>
    <link rel="stylesheet" href="css/admintoroku.css">
</head>

<body>
   <h1>新規登録画面</h1>
   <form action="admintorokuOK.php" method="post">
   <p>ユーザーID<input type="text" name="admin_id"></p>
   <p>メールアドレス<input type="text" name="admin_address"></p>
   <p>パスワード<input type="text" name="admin_password"></p>
   <input type="submit" value="登録">
</form>
</body>
</html>