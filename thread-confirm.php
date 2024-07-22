<?php
session_start();
require('db-connect.php');
$pdo = new PDO($connect, USER, PASS);

// 出力バッファリングを開始
ob_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm'])) {
        $title = $_POST['title'];
        $genre_id = $_POST['genre_id'];

        // NGワードを取得
        $stmt = $pdo->query('SELECT ngword_content FROM ngword');
        $ngwords = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // NGワードの確認
        $contains_ngword = false;
        foreach ($ngwords as $ngword) {
            if (strpos($title, $ngword) !== false) {
                $contains_ngword = true;
                break;
            }
        }

        if (isset($_SESSION['login']['id'])) {
            $client_id = $_SESSION['customer']['id']; // セッションからclient_idを取得

            // バリデーション
            if (strlen($title) >= 1 && strlen($title) <= 30 && !empty($genre_id)) {
                if (!$contains_ngword) {
                    $statement = $pdo->prepare('INSERT INTO thread(title, genre_id, client_id) VALUES(?, ?, ?)');
                    $statement->execute([$title, $genre_id, $client_id]);

                    // スレッドが正常に作成された場合、thread.php にリダイレクトする
                    header('Location: thread.php?thread_id=' . $pdo->lastInsertId());
                    exit(); // リダイレクト後にスクリプトの実行を停止する
                } else {
                    echo '<script>alert("NGワードがタイトルに含まれています")</script>';
                    echo '<script>window.location.href = "thread-write.php"</script>';
                }
            } else {
                echo '<script>alert("タイトルを1文字以上30文字以内で入力し、ジャンルを選択してください。")</script>';
                echo '<script>window.location.href = "thread-write.php"</script>';
            }
        } else {
            echo '<script>alert("ログインしてください。")</script>';
            echo '<script>window.location.href = "login.php"</script>';
        }
    } elseif (isset($_POST['cancel'])) {
        // 確認画面での「キャンセル」ボタンが押された場合
        echo '<script>alert("キャンセルされました。")</script>';
        echo "<script>window.location.href = 'thread-write.php';</script>";
    }
}

// ジャンル名の取得
$genre_id = $_POST['genre_id']; // スレッド作成画面からgenre_idを取得
$genre_query = $pdo->prepare('SELECT genre_name FROM genre WHERE genre_id = ?');
$genre_query->execute([$genre_id]);
$genre_result = $genre_query->fetch(PDO::FETCH_ASSOC);


// 出力バッファリングを終了し、内容を出力
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Zen+Kurenaido&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>新規スレッド確認画面</title>
    <link rel="stylesheet" href="css/thread-confirm.css">
</head>
<body>
<tr><td><div align="center"><img src="images/logo.jpg" class="logo"></div></td></tr>
    <div class="container">
        <p>以下の内容でスレッドを作成しますか？</p>
        <form action="" method="post">
            <label for="title">タイトル：</label>
            <p><?php echo nl2br(wordwrap(htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8'), 30, "\n", true)); ?></p>

            <label for="genre_id">ジャンル：</label>
            <p><?php echo htmlspecialchars($genre_result['genre_name'], ENT_QUOTES, 'UTF-8'); ?></p>
            
            <input type="hidden" name="title" value="<?php echo htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="genre_id" value="<?php echo htmlspecialchars($_POST['genre_id'], ENT_QUOTES, 'UTF-8'); ?>">
            <input type="submit" name="confirm" value="確認">
            <input type="submit" name="cancel" value="キャンセル">
        </form>
    </div>
</body>
</html>
