<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/touroku.css" rel="stylesheet">
    <title>ジャンル追加画面</title>
</head>
<body>
    <h1>ジャンル一覧</h1>
    <table>
<?php
    $pdo=new PDO('mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1517815-ch;charset=utf8',
'LAA1517815','chinese');
if (empty($_REQUEST['j'])) {
} else {
$sql=$pdo->prepare('insert into genre(genre_id,genre_name) values(null,?)');
if($sql->execute([$_REQUEST['j']])){
}else{
}
}
foreach($pdo->query('select * from genre ORDER BY genre_id ASC')as $row){

    echo '<tr>';
    echo '<td>',$row['genre_id'],'</td>';
    echo '<td>',$row['genre_name'],'</td>';
    echo '</tr>';
    echo "\n";
    
}
    ?>
    </table>
    <form action="jannrutuika-input.php" method="post">  
<div class="a"><button type="submit">戻る</button></div>
    </form>

</html>
