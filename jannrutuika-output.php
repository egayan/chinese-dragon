<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/touroku.css" rel="stylesheet">
    <title>ジャンル追加画面</title>
</head>
<body>
    <h1>ジャンル一覧</h1>
    <table>
<?php
    $pdo=new PDO('mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1517815-ch;charset=utf8',
'LAA1517815','chinese');
if (empty($_REQUEST['j'])) {
    echo 'ジャンルを入力してください';
} else  {
$sql=$pdo->prepare('INSERT IGNORE into genre(genre_id,genre_name) values(null,?) ');
if($sql->execute([$_REQUEST['j']])){
}else  {
}

echo 'ジャンルを追加しました';
}

    ?>
    </table>
    <form action="jannru-itiran.php" method="post">  
<div class="a"><button type="submit">戻る</button></div>
    </form>

</html>
