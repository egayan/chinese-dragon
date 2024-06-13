<?php session_start(); ?>
<html lang="ja">    
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/toiawase.css" rel="stylesheet">
    <title>問い合わせページ</title>
</head>
<body>    
<table>
<?php
$pdo=new PDO('mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1517815-ch;charset=utf8',
    'LAA1517815','chinese');
    $sql=$pdo->prepare('select inquiry_content,inquiry_response from inquiry where client_id=?');
    $sql->execute([$_SESSION['customer']['id']]);
    foreach($sql as $row){
        echo '<tr>';
        echo '<td>',$row['inquiry_content'],'</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>',$row['inquiry_response'],'</td>';
        echo '</tr>';
        echo "\n";
    }
    ?>
    </table>
    </body>