<?php
    if (isset($_GET['id'])) {
        try {
 
            // 接続処理
            $dsn = 'mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1517815-ch';
            $user = 'root';
            $password = '';
            $dbh = new PDO('mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1517815-ch;charset=utf8',
            'LAA1517815','chinese');
 
            // SELECT文を発行
            $sql = "SELECT * FROM inquiry WHERE inquiry_id = :id";
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
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style/management-response2.css" rel="stylesheet">
    <title>変更画面</title>
</head>
<body>
<form action="./management-response3.php" method="post">
        <input type="hidden" name="id" value="<?php print($member->inquiry_id) ?>">
        <p>ユーザー名
        <?php
          $pdo=new PDO('mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1517815-ch;charset=utf8',
          'LAA1517815','chinese');
          $a=$member->client_id;
          $sql=$pdo->prepare('select * from client where client_id=?');
          $sql->execute([$a]);
          foreach($sql as $row){
            echo $row['name'];
          } ?> 
          </p>
        <p>問い合わせ内容
        <?php print($member->inquiry_content) ?>
        </p>
        <p>返信
        <input type="text" name="age" value="<?php print($member->inquiry_response) ?>">
        </p>
        <div class="a">
        <button type="submit">返信する</button>
        </div>
  
         
</form>
</body>
</html>