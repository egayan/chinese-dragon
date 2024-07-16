<?php
session_start();
require 'db-connect.php';

unset($_SESSION['admin']);
$pdo = new PDO($connect, USER, PASS);
$sql = $pdo->prepare('SELECT * FROM admin WHERE admin_address = ?');
$sql->execute([$_POST['admin_address']]);

$admin = $sql->fetch(PDO::FETCH_ASSOC);

$matsufuji = password_verify($_POST['admin_password'],$admin['admin_password']);

if ($matsufuji) {
    $_SESSION['admin'] = [
        'admin_address' => $admin['admin_address'],
        'admin_password' => $admin['admin_password']
    ];
    header("Location: Management_Top.php");
    exit(); // リダイレクト後にスクリプトの実行を停止
} else {
    echo 'ログイン名またはパスワードが違います。';
}
require 'footer.php';
?>
