<?php require 'header.php'; ?>
<?php require 'db_conect.php'; ?>
<div align="center">アカウントを削除しました</div>
<?php
$pdo=new PDO($connect,USER,PASS);
$sql = $pdo->prepare('delete from client where client_id=?');//user_name ユーザー名をメアドに変更
$sql->execute([$_GET['delete_id']]);
echo '<div align="center"><button><a href="login_input.php">ログイン画面へ戻る</a></button></div>';
?>
<?php require 'footer.php'; ?> 