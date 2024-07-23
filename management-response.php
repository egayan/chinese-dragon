<?php
    try {
 
        // 接続処理
        $dsn = 'mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1517815-ch';
        $user = 'root';
        $password = '';
        $dbh = new PDO('mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1517815-ch;charset=utf8',
        'LAA1517815','chinese');
 
        // SELECT文を発行
        $sql = "SELECT * FROM inquiry";
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
    <link href="css/manegement-response.css" rel="stylesheet">
    <title>一覧</title>
</head>
<table>
        <tr>
            <th>ID</th>
            <th>問い合わせ内容</th>
            <th>問い合わせ返信</th>
            <th>返信</th>
        </tr>
 
<?php
    foreach($rows as $row){
?>
        <tr>
            <td><?php print($row['inquiry_id']) ?></td>
            <td><?php print($row['inquiry_content']) ?></td>
            <td><?php print($row['inquiry_response']) ?></td>
            <td><a href="management-response2.php?id=<?php print($row['inquiry_id'])?>">返信</a></td>
        </tr>
<?php
    }
?>
    </table>
    <div class="a">
<<<<<<< HEAD
    <button onclick="location.href='Management_Top.php'" >戻る</button>
=======
    <button onclick="location.href='inquiry.php'" >戻る</button>
>>>>>>> 5e1ab1915062f0f93950b1ac0f78c800445274bc
</div>
</body>
</html>