<link href="css/management-response3.css" rel="stylesheet">
<?php
    if (isset($_POST['id'])) {
        try {
 
            $dsn = 'mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1517815-ch';
            $user = 'root';
            $password = '';
            $dbh = new PDO('mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1517815-ch;charset=utf8',
            'LAA1517815','chinese');
 
            // UPDATE文を発行
            $id = $_POST['id']; // UPDATEするレコードのID
 
            $age = isset($_POST['age']) ? $_POST['age'] : 0;
 
            $sql = "UPDATE inquiry SET  inquiry_response = :age WHERE inquiry_id = :id";
            $stmt = $dbh->prepare($sql);
 
            $stmt->execute([":age" => $age,":id" => $id ]); // 連想配列でバインド
            echo "<div class=a>";
            print("返信しました<br>");
            print('<a href="management-response.php">一覧表示へ</a>');
            echo "</div>";
            // 接続切断
            $dbh = null;
 
 
        } catch (PDOException $e) {
            print $e->getMessage() . "<br/>";
            die();
        }
    }
?>  