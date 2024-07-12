<?php
session_start(); // セッションの開始
require('db-connect.php'); // データベース接続のファイルを読み込む（db-connect.phpに正しい接続情報が含まれている必要があります）

try {
    // データベースに接続
    $pdo = new PDO($connect, USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // スレッドのIDを取得
    $thread_id = isset($_GET['thread_id']) ? intval($_GET['thread_id']) : null;

    $thread_title = '';
    if ($thread_id) {
        $stmt = $pdo->prepare('SELECT title FROM thread WHERE thread_id = ?');
        $stmt->execute([$thread_id]);
        $thread = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($thread) {
            $thread_title = $thread['title'];
        }
    }

    // NGワードを取得
    $stmt = $pdo->query('SELECT ngword_content FROM ngword');
    $ngwords = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // アクションの処理
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['action_type'])) {
            $action_type = $_POST['action_type'];
            
            // JSONデータを取得
            $data = json_decode(file_get_contents("php://input"), true);

            if (isset($data['actionType'])) {
                $actionType = $data['actionType'];
                $clientId = $data['clientId'];
                $postId = $data['postId'];

                if ($actionType === 'addFriend') {
                    $opponentId = $postId; // postIdが相手のIDだと仮定

                    $sql = "INSERT INTO friends (client_id, friend_id) VALUES ('$clientId', '$opponentId')";
                    if ($pdo->query($sql)) {
                        echo json_encode(["success" => true]);
                    } else {
                        echo json_encode(["success" => false, "message" => "エラー: " . $sql . "<br>" . $pdo->errorInfo()]);
                    }
                } elseif ($actionType === 'report') {
                    $reason = $data['reason'];

                    $sql = "INSERT INTO reports (client_id, post_id, reason) VALUES ('$clientId', '$postId', '$reason')";
                    if ($pdo->query($sql)) {
                        echo json_encode(["success" => true]);
                    } else {
                        echo json_encode(["success" => false, "message" => "エラー: " . $sql . "<br>" . $pdo->errorInfo()]);
                    }
                }
            } else {
                echo json_encode(["success" => false, "message" => "無効なアクションタイプです"]);
            }
        }

        // 投稿の処理
        if (isset($_POST['post'])) {
            if (!empty($_POST['post']) && strlen($_POST['post']) <= 200) {
                if (isset($_SESSION['customer']['id'])) { // ログイン状態の確認
                    $contains_ngword = false;
                    foreach ($ngwords as $ngword) {
                        if (strpos($_POST['post'], $ngword) !== false) {
                            $contains_ngword = true;
                            break;
                        }
                    }
                    if (!$contains_ngword) {
                        $client_id = $_SESSION['customer']['id'];
                        $stmt = $pdo->prepare('INSERT INTO post (thread_id, post, client_id, date) VALUES (?, ?, ?, NOW())');
                        $stmt->execute([$thread_id, $_POST['post'], $client_id]);
                    } else {
                        echo '<script>alert("NGワードが含まれています")</script>';
                    }
                } else {
                    echo '<script>alert("ログインしてください")</script>';
                }
            } else if (strlen($_POST['post']) > 200) {
                echo '<script>alert("200文字以内で書いてください")</script>';
            } else {
                echo '<script>alert("入力してください")</script>';
            }
        }
    }

    // ページネーション機能の実装
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($page - 1) * 10; // 10件ずつ表示

    $stmt = $pdo->prepare('SELECT * FROM post INNER JOIN client ON post.client_id = client.client_id WHERE post.thread_id = ? LIMIT 10 OFFSET ?');
    $stmt->bindParam(1, $thread_id, PDO::PARAM_INT);
    $stmt->bindParam(2, $offset, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 総投稿数の計算
    $stmt_count = $pdo->prepare('SELECT COUNT(*) FROM post WHERE thread_id = ?');
    $stmt_count->execute([$thread_id]);
    $total_posts = $stmt_count->fetchColumn();
    $total_pages = ceil($total_posts / 10); // 10件ずつ表示

} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
    // エラー時の適切な処理を追加することが推奨されます。
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/thread.css">
    <title>スレッド: <?php echo htmlspecialchars($thread_title, ENT_QUOTES, 'UTF-8'); ?></title>
</head>
<body>
    <h1><?php echo htmlspecialchars($thread_title, ENT_QUOTES, 'UTF-8'); ?></h1>

    <?php
    // スレッドに関連する投稿を表示
    if (count($posts) > 0) {
        foreach ($posts as $post) {
            ?>
            <!-- 投稿の表示 -->
            <div>
                名前: <a href="#" name="name" class="popupLink" data-action-type="addFriend" data-client-id="<?php echo htmlspecialchars($post['client_id'], ENT_QUOTES, 'UTF-8'); ?>" data-post-id="<?php echo htmlspecialchars($post['post_id'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($post['name'], ENT_QUOTES, 'UTF-8'); ?></a>
                <a href="#" name="report" class="reportLink" data-client-id="<?php echo htmlspecialchars($post['client_id'], ENT_QUOTES, 'UTF-8'); ?>" data-post-id="<?php echo htmlspecialchars($post['post_id'], ENT_QUOTES, 'UTF-8'); ?>">通報する</a>
                <div class="date">
                    投稿日時: <?php echo htmlspecialchars($post['date'], ENT_QUOTES, 'UTF-8'); ?><br>
                </div>
                <div class="thread">
                    <?php echo nl2br(wordwrap(htmlspecialchars($post['post'], ENT_QUOTES, 'UTF-8'), 30, "\n", true)); ?>
                </div>
                <hr>
            </div>
            <?php
        }
    }
    ?>

    <form action="thread.php?thread_id=<?php echo $thread_id; ?>" method="POST">
        <textarea name="post" cols="50" rows="10" placeholder="ここに投稿を入力してください"></textarea><br>
        <button type="submit" name="decide">投稿する</button>
    </form>

    <!-- ページネーションの表示 -->
    <?php if ($page > 1): ?>
        <a href="thread.php?thread_id=<?php echo $thread_id; ?>&page=<?php echo ($page - 1); ?>">前のページ</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="thread.php?thread_id=<?php echo $thread_id; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a href="thread.php?thread_id=<?php echo $thread_id; ?>&page=<?php echo ($page + 1); ?>">次のページ</a>
    <?php endif; ?>

    <?php
    if(isset($_SESSION['customer'])){
        echo '<tr><td><div align="center"><button><a href="Top_kensakukekka.php">戻る</a></button></div></td></tr>';
    } else {
        echo '<tr><td><div align="center"><button><a href="Top.php?gest=gest">戻る</a></button></div></td></tr>';
    }
    ?>

    <!-- ポップアップ用の要素 -->
    <div id="overlay" class="overlay"></div>
    <div id="popup" class="popup">
        <input type="hidden" id="clientIdField">
        <input type="hidden" id="postIdField">
        <input type="hidden" id="actionTypeField">
        <input type="hidden" id="reportReasonField">
        <div id="popupMessage"></div>
        <textarea id="reportReason" placeholder="通報理由を入力してください" style="display:none;"></textarea>
        <button id="popupActionButton">実行</button>
        <button id="popupCancelButton">キャンセル</button>
    </div>

    <!-- 確認用ポップアップ -->
    <div id="confirmationPopup" class="popup">
        <div id="confirmationMessage"></div>
        <button id="confirmActionButton">確認</button>
        <button id="confirmCancelButton">キャンセル</button>
    </div>

    <script src="js/thread.js"></script>
</body>
</html>
