<?php session_start(); ?>
<?php require 'header.php'; ?>
<table id="cate" align="center">
<?php 
session_destroy();
    ?>
<form action="Top.php" method="post">
    <tr><td><h1>チャイニーズドラゴン</h1></td></tr>
    <tr><td>メールアドレス　　　<input type="text" name="login"></td></tr>
    <tr><td>_____________________________________</td></tr>
    <tr><td>パスワード　　　　　<input type="password" name="password"></td></tr>
    <tr><td>_____________________________________</td></tr>
    <tr><td><div align="center"><button type ="submit">ログイン</button></div></td></tr>
</form>
<tr><td><div align="center"><button><a href="customer_input.php">新規登録</a></button></dev></td></tr>
<tr><td><div align="center"><button><a href="Top.php?gest=gest">ゲストログイン</a></button></div></td></tr>
<<<<<<< HEAD
<tr><td><div align="center"><button><a href="inquiry4.php">お問い合わせ</a></button></div></td></tr>
=======
<tr><td><div align="center"><button><a href="inquiry.php">お問い合わせ</a></button></div></td></tr>
>>>>>>> 5e1ab1915062f0f93950b1ac0f78c800445274bc
<tr><td><div align="center"><button><a href="login.php">管理者ログイン画面</a></button></div></td></tr>
</table>
<?php require 'footer.php'; ?>    