<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles/touroku.css" rel="stylesheet">
    <title>ジャンル追加画面</title>
</head>
<body>
    <table>
    <?php
    $pdo=new PDO('mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1517815-ch;charset=utf8',
    'LAA1517815','chinese');
    $sql=$pdo->prepare('select * from client');    
    $sql=$pdo->prepare('select * from client where client_address=?');
    $sql->execute([$_POST['j']]);
        foreach($sql as$id){ 
            $myaddress=$id['client_address'];
    $myid=$id['client_id'];
        }
    if (empty($_POST['j'])) {
        echo "メールアドレスを入力してください";
    } else if($_POST['j']==isset($myaddress)){
        $sql=$pdo->prepare('select * from inquiry where client_id=?');
        if($sql->execute([$myid])){
            foreach($sql as $row){
                echo '<tr>';
                echo '<td>',$row['inquiry_content'],'</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>',$row['inquiry_response'],'</td>';
                echo '</tr>';
                echo "\n";
            }
    }
    } else{
        echo "メールアドレスが違います";
    }
    ?>
    </table>
    <form action="loguin-input.php" method="post">  
<p><button type="submit">戻る</button></p>
    </form>

</html>