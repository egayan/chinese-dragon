<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>チャットアプリ開発</title>
</head>
<body>
<?php require 'db_conect.php'; ?>
<?php
// DB接続
$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// POSTデータを取得して処理する
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if (isset($_SESSION['customer'])) {
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $id = $_SESSION['customer']['id'];
        
        // 現在の値を取得
        $sql_check = $pdo->prepare('SELECT name, password, client_address FROM client WHERE client_id = ?');
        $sql_check->execute([$id]);
        $row = $sql_check->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // 更新が必要かどうかを判断
            $update_needed = false;
            $update_values = [];

            if ($row['name'] != $_POST['name']) {
                $update_needed = true;
                $update_values[] = $_POST['name'];
            } else {
                $update_values[] = $row['name']; // 現在の名前を使う
            }
            
            if ($row['password'] != $pass) {
                $update_needed = true;
                $update_values[] = $pass;
            } else {
                $update_values[] = $row['password']; // 現在のパスワードを使う
            }

            if ($row['client_address'] != $_POST['address']) {
                $update_needed = true;
                $update_values[] = $_POST['address'];
            } else {
                $update_values[] = $row['client_address']; // 現在のクライアントアドレスを使う
            }

            if ($update_needed) {
                // データベース更新クエリを実行
                $sql_update = $pdo->prepare('UPDATE client SET name = ?, password = ?, client_address = ? WHERE client_id = ?');
                $update_values[] = $id; // WHERE 句の最後に client_id を追加
                $sql_update->execute($update_values);

                // セッション更新
                $_SESSION['customer'] = [
                    'id' => $id,
                    'name' => $update_values[0],
                    'password' => $update_values[1],
                    'address' => $update_values[2],
                ];
                echo '<div style="text-align:center"><h3>お客様情報を更新しました。</h3></div>';
            } else {
                echo "No changes to update.";
            }
        } else {
            echo "Client not found.";
        }
    }
}
?>
<div style="text-align:center"><a href="mypage.php">戻る</a></div>
<?php require 'footer.php'; ?>
</body>
</html>