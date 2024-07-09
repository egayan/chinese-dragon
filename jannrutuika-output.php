<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/tuika.css" rel="stylesheet">
    <title>ジャンル追加画面</title>
</head>
<body>
    <table>
<?php
    $pdo=new PDO('mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1517815-ch;charset=utf8',
'LAA1517815','chinese');
if (empty($_REQUEST['j'])) {
    echo "<div class='b'>";
    echo 'ジャンルを入力してください';
    echo "</div>";
} else  {
$j=$_REQUEST['j'];
$mail = "SELECT genre_name FROM genre WHERE genre_name ='$j'";
 
$stmtMail = $pdo->prepare($mail);
$stmtMail->execute();
$cnt = 0;
foreach ($stmtMail as $keyMail => $valMail) {
    $cnt = $cnt + 1;
}
if ($cnt > 0) {
    echo "<div class='b'>";
    echo  "既に存在します";
    echo "</div>";

} else {
    echo "<div class='b'>";
    echo "追加しました";
    echo "<div>";
}
$sql=$pdo->prepare('INSERT IGNORE into genre(genre_id,genre_name) values(null,?) ');
if($sql->execute([$_REQUEST['j']])){
}else  {
}

}

    ?>
    </table>
    <form action="jannru-itiran.php" method="post">  
<div class="a"><button type="submit">戻る</button></div>
    </form>

</html>
