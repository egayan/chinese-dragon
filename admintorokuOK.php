<?php require 'db-connect.php';?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>登録完了</title>
    <link rel="stylesheet" href="css/admintorokuOK.css">
</head>
<body>
    <?php
    $pass=password_hash($_REQUEST['admin_password'],PASSWORD_DEFAULT);
    $pdo=new PDO($connect, USER, PASS);
    $sql=$pdo->prepare('insert into admin(admin_address,admin_password) values (?, ?)');
    if($sql->execute([$_POST['admin_address'],$pass])) {
        echo '<font color="red">アカウント登録完了です！</font>';
    }else{
        echo '<font color="red">アカウントの登録に失敗しました</font>';
    }
    ?>
    <br><hr><br>
    <form action="login_1.php" method="post">
    <input type="submit" value="ログイン画面">
</form>    
</body>
</html>

