<?php
session_start();
require('db-connect.php');
$client_id = $_SESSION['customer']['id']; // セッションからclient_idを取得
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

            <div class="genre">
            <label for="genre_id">ジャンル</label>
            </div>
            <div class="radio-group">
            <?php
                  $db = new PDO($connect, USER, PASS);
                  $stmt = $db->prepare('SELECT * FROM genre');
                  $stmt->execute();
                  $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <select id="genre_id" name="genre_id">
            <?php
                  foreach($genres as $genre){
                      echo '<option value="' . $genre['genre_id'] . '">' . $genre['genre_name'] . '</option>';
                  }
            ?>
            </select>
            </div>
            <div class="decide">
            <input type="submit" value="送信">
            </div>
        </form>
        <div class="return-button"><a href="Top_kensakukekka.php">戻る</a></div>
    </div>
</body>
</html>
