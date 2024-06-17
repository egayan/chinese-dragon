<?php
session_start();
require('db-connect.php');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>新規スレッド作成</title>
        <link rel="stylesheet" href="css/thread-write.css">
</head>
<body>
    <div class="container">
        <h1>新規スレッド作成</h1>
        <form action="thread-confirm.php" method="POST">
            <label for="title">タイトル</label>
            <textarea name="title" id="title" cols="50" rows="10"></textarea>

            <label>ジャンル</label>
            <div class="radio-group">
            <?php
                  $db=new PDO($connect,USER,PASS);
                  $stmt = $db->prepare('SELECT * FROM genre');
                  $stmt->execute();
                  $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
                  $flag=0;
                  $a=[];
                  $name=[];
                  foreach($genres as $genre){
                    $a[]=$genre['genre_id'];
                    $name[]=$genre['genre_name'];
                }
                $b=count($a);
        for($i = 0; $i<$b ; $i++){
            echo '<input type="radio" name="genre_id" value="',$a[$i],'">',$name[$i],'<br>';
            echo '</div>';
        }
                ?>
            </div>
            <input type="submit" value="送信">
        </form>
        <div class="return-button"><a href="Top_kensakukekka.php">戻る</a></div>
    </div>
</body>
</html>

