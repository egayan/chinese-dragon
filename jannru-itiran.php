<?php
    try {
 
        // 接続処理
        $dsn = 'mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1517815-ch';
        $user = 'root';
        $password = '';
        $dbh = new PDO('mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1517815-ch;charset=utf8',
        'LAA1517815','chinese');
 
        // SELECT文を発行
        $sql = "select * from genre ORDER BY genre_id ASC";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(); // 全てのレコードを取得
 
        // 接続切断
        $dbh = null;
 
    } catch (PDOException $e) {
        print $e->getMessage() . "<br/>";
        die();
    }
?>
 
 
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/touroku.css" rel="stylesheet">
    <title>一覧</title>
</head>
<table>
        <tr>
            <th>ID</th>
            <th>ジャンル</th>
            <th>削除</th>
        </tr>
 
<?php
    foreach($rows as $row){
?>
        <tr>
            <td><?php print($row['genre_id']) ?></td>
            <td><?php print($row['genre_name']) ?></td>
            <td><a href="jannru-delete.php?id=<?php print($row['genre_id'])?>">削除</a></td>
        </tr>
<?php
    }
?>
    </table>
    <div class="a">
    <button onclick="location.href='Management_Top.php'" >戻る</button>
</div>
<div class="a">
    <button onclick="location.href='jannrutuika-input.php'" >追加</button>
</div>
</body>
</html>

</html>