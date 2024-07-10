<?php session_start(); ?>
<?php require 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="css/customer_input.css">
<div class="pat">
<img src="images/logo.jpg" class="logo">

<?php
echo'<tr><td><div align="center"><h1>新規登録</h1></div></td></tr>';
echo'<form action="customer_output.php" method="post">';
echo'<table align="center">';

echo'<tr><td>ユーザー名　　　';
echo'<input type="text" placeholder="必須項目です" name="name" required>';
echo'</td></tr>';

echo'<tr><td>メールアドレス　';
echo'<input type="text" placeholder="必須項目です" name="address" required>';
echo'</td></tr>';

echo'<tr><td>パスワード　　　';
echo'<input type="password" placeholder="必須項目です" name="password" required>';
echo'</td></tr>';

echo '<tr><td><div align="center">';
echo '<button><a href="customer_output.php">登録</a></button>';
echo'</form></div>';
echo '</td></tr>';

echo '<tr><td><div align="center"><button><a href="login_input.php">戻る</a></button></div></td></tr>';
echo '</table>';
?>

<?php require 'footer.php'; ?>
</div>