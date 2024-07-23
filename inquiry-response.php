<?php session_start(); ?>
<html lang="ja">    
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/hensin.css" rel="stylesheet">
    <title>問い合わせページ</title>
</head>
<body>    
<table>
<tr>
            <th>問い合わせ内容</th>
            <th>問い合わせ返信</th>
        </tr>
<?php
$pdo=new PDO('mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1517815-ch;charset=utf8',
    'LAA1517815','chinese');
    $sql=$pdo->prepare('select inquiry_content,inquiry_response from inquiry where client_id=?');
    $sql->execute([$_SESSION['customer']['id']]);
    foreach($sql as $row){
        echo '<tr>';
        echo '<td>',$row['inquiry_content'],'</td>';
        if(empty($row['inquiry_response'])){
            echo '<td>',"返信待ちです",'</td>';
        }else{
            echo '<td>',$row['inquiry_response'],'</td>';

        }
        echo '</tr>';
        echo "\n";
    }
    ?>
    
    </table>
    <div class="a">
    <form action="inquiry1.php" method="post">  
<p><button type="submit">戻る</button></p>
    </form>
</div>
    </body>