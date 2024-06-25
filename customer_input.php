<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php
echo'<form action="customer_output.php" method="post">';
echo'<table align="center">';
echo'<tr><td><div align="center"><h3>新規登録</h3></div></td></tr>';

echo'<tr><td>ユーザー名　　　';
echo'<input type="text" placeholder="必須項目です" name="name" required>';
echo'</td></tr>';

echo'<tr><td>メールアドレス　';
echo'<input type="email" placeholder="必須項目です" name="address" required>';
echo'</td></tr>';

echo'<tr><td>パスワード　　　';
echo'<input type="password" placeholder="必須項目です" name="password" required>';
echo'</td></tr>';

echo '<tr><td><div align="center">';
echo '<input type="submit" value="登録">';
echo'</form></div>';
echo '</td></tr>';

echo '<tr><td><div align="center"><button><a href="login_input.php">戻る</a></button></div></td></tr>';
echo '</table>';
?>
<?php require 'footer.php'; ?>