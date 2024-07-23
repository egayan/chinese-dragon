<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['complete'])) {
    // GETリクエストで初期アクセスされた場合のフォーム表示
    echo <<<HTML
    <html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/toiawase1.css" rel="stylesheet">
        <title>問い合わせページ</title>
    </head>
    <body>
        <div class='warp'>
            <form action="" method="post">
                <label><div class='a'>問い合わせ内容</div><div class='b'><input type="text" name="name0"></div></label>
                <label><div class='c'>メールアドレス入力</div><div class='d'><input type="text" name="mail"></div></label>
                <button type="submit" class='g'>送信</button>
            </form>
            <button onclick="location.href='inquiry-response2.php'" class='e'>返信受け取り</button>
            <button onclick="location.href='login_input.php'"class='f'>戻る</button>
        </div>
    </body>
    </html>
HTML;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POSTリクエストでデータ処理
    if (empty($_POST['name0']) || empty($_POST['mail'])) {
        // 必要なデータが入力されていない場合のエラーハンドリング
        echo "<center>";
        echo "名前とメールアドレスを入力してください。";
        echo "</center>";

    } else {
        try {
            // データベース接続
            $pdo = new PDO('mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1517815-ch;charset=utf8', 'LAA1517815', 'chinese');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // エラーモードを例外モードに設定

            // メールアドレスの存在チェック
            $sql = $pdo->prepare('SELECT * FROM client WHERE client_address = ?');
            $sql->execute([$_POST['mail']]);
            $client = $sql->fetch(PDO::FETCH_ASSOC);

            if (!$client) {
                // メールアドレスが存在しない場合のエラーメッセージ
                echo "<center>";
                echo "指定されたメールアドレスは登録されていません。";
                echo'</br>';
              echo '<a href="'. "login_input.php" .'">'. "戻る" .'</a>';
                echo "</center>";
                

            } else {
                // クライアントIDを取得
                $client_id = $client['client_id'];

                // 問い合わせ内容を保存
                $sql = $pdo->prepare('INSERT INTO inquiry (inquiry_content, client_id) VALUES (?, ?)');
                $result = $sql->execute([$_POST['name0'], $client_id]);

                if ($result) {
                    // 保存成功時の処理
                    header('Location: login_input.php?complete', true, 301);
                    exit;
                } else {
                    // 保存失敗時のエラーハンドリング
                    echo "問い合わせ内容の保存に失敗しました。";
                }
            }
        } catch (PDOException $e) {
            // データベースエラー時の処理
            echo "データベースエラー：" . $e->getMessage();
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['complete'])) {
    // 完了ページの表示
    echo <<<HTML
    <html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>完了ページ</title>
    </head>
    <body>
        データが保存されました。
    </body>
    </html>
HTML;
}
?>
