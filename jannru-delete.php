<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/touroku.css" rel="stylesheet">
    <title>ジャンル追加画面</title>
</head>
<body>
    <h1>ジャンル削除</h1>
    <table>
<?php
  if (isset($_GET['id'])) {
    try {
        $dsn = 'mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1517815-ch';
        $user = 'root';
        $password = '';
        $dbh = new PDO('mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1517815-ch;charset=utf8',
        'LAA1517815','chinese');

$sql = "DELETE FROM genre WHERE genre_id = :id";
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
            $stmt->execute();
            $member = $stmt->fetch(PDO::FETCH_OBJ); // 1件のレコードを取得
        } catch (PDOException $e) {
            print $e->getMessage() . "<br/>";
            die();
        }
  }
    ?>
    <h3>削除しました</h3>
    </table>
    <form action="jannru-itiran.php" method="post">  
<div class="a"><button type="submit">戻る</button></div>
    </form>

</html>
