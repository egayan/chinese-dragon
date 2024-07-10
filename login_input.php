<?php require 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="css/login_input.css">
<?php unset($_SESSION['customer']); ?>
<div class="pat">
<table id="cate" align="center">
<form action="Top.php" method="post">
    <img src="images/logo.jpg" class="logo">
    <tr><td>メールアドレス<input type="text" name="login"></td></tr>
    <tr><td>_____________________________________</td></tr>
    <tr><td>パスワード<input type="password" name="password"></td></tr>
    <tr><td>_____________________________________</td></tr>
    <tr><td><div align="center"><button type="submit">ログイン</button></div></td></tr>
</form>
<tr><td><div align="center"><button><a href="customer_input.php">新規登録</a></button></div></td></tr>
<tr><td><div align="center"><button><a href="Top.php?gest=gest">ゲストログイン</a></button></div></td></tr>
<tr><td><div align="center"><button><a href="*">お問い合わせ</a></button></div></td></tr>
</table>
</div>
<?php require 'footer.php'; ?> 
