<?php
session_start(); // セッションの開始
require('db-connect.php');

// データベースに接続
try {
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
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['client_id']) && isset($_POST['action_type'])) {
        $client_id = $_POST['client_id'];
        $user_id = $_SESSION['customer']['id'] ?? null;
        $action_type = $_POST['action_type'];
    
        if ($user_id != null) {
            if ($action_type === 'name') {
                // 友達追加の処理
                $stmt = $pdo->prepare('SELECT * FROM friend WHERE (client_id = ? AND opponent_id = ?) OR (client_id = ? AND opponent_id = ?)');
                $stmt->execute([$user_id, $client_id, $client_id, $user_id]);
                if ($stmt->fetch()) {
                    echo '<script>alert("既に友達です。");</script>';
                } else {
                    $stmt = $pdo->prepare('SELECT client_id FROM client WHERE client_id = ?');
                    $stmt->execute([$user_id]);
                    if ($stmt->fetch()) {
                        $stmt = $pdo->prepare('SELECT client_id FROM client WHERE client_id = ?');
                        $stmt->execute([$client_id]);
                        if ($stmt->fetch()) {
                            $stmt = $pdo->prepare('INSERT INTO friend (friend_id, client_id, opponent_id) VALUES (null, ?, ?)');
                            $stmt->execute([$user_id, $client_id]);
                            $stm = $pdo->prepare('INSERT INTO friend (friend_id, client_id, opponent_id) VALUES (null, ?, ?)');
                            $stm->execute([$client_id, $user_id]);
                            echo '<script>alert("友達を追加しました！");</script>';
                        } else {
                            echo '<script>alert("相手のIDが存在しません。");</script>';
                        }
                    } else {
                        echo '<script>alert("ユーザーIDが存在しません。");</script>';
                    }
                }
            } elseif ($action_type === 'report') {
                // 通報の処理
                $report_reason = $_POST['report_reason'] ?? '';
                $post_id = $_POST['post_id'] ?? null; // post_idを取得
                if (empty($post_id)) {
                    echo '<script>alert("投稿IDが指定されていません。");</script>';
                } elseif (!empty($report_reason)) {
                    $reporter_id = $_SESSION['customer']['id'] ?? null;
                    $suspect_id = $_POST['client_id'];
                    $stmt = $pdo->prepare('INSERT INTO report(report_reason, date, reporter_id, post_id, suspect_id) VALUES (?, NOW(), ?, ?, ?)');
                    $stmt->execute([$report_reason, $reporter_id, $post_id, $suspect_id]);
                    echo '<script>alert("通報しました。");</script>';
                } else {
                    echo '<script>alert("通報理由を入力してください。");</script>';
                }
            }
        } else {
            echo '<script>alert("ログインしていません。");</script>';
        }
    }
    // 投稿の処理
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post'])) {
        if (!empty($_POST['post']) && strlen($_POST['post']) <= 200) {
            if (isset($_SESSION['login']['id'])) {
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

    // ページネーション機能の実装
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * 10; // 10件ずつ表示

$stmt = $pdo->prepare('SELECT * FROM post INNER JOIN client ON post.client_id = client.client_id WHERE post.thread_id = ? LIMIT 10 OFFSET ?');
$stmt->bindParam(1, $thread_id, PDO::PARAM_INT);
$stmt->bindParam(2, $offset, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 総レビュー数の計算
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
<lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/thread.css">
    <title>スレッド: <?php echo htmlspecialchars($thread_title, ENT_QUOTES, 'UTF-8'); ?></title>
</head>
    <h1><?php echo htmlspecialchars($thread_title, ENT_QUOTES, 'UTF-8'); ?></h1>
    <?php
    // スレッドに関連する投稿を取得
    $stmt = $pdo->prepare("SELECT post.*, client.name, client.client_id FROM post LEFT JOIN client ON post.client_id = client.client_id WHERE post.thread_id = ? ORDER BY post.date DESC");
    $stmt->execute([$thread_id]);
    if(count($posts) > 0):
        foreach ($posts as $post) {
    ?>
            <!-- 投稿の表示 -->
            <div>
            名前: <a href="#" name="name" class="popupLink" data-client-id="<?php $post['client_id']?>" data-post-id="<?php $post['post_id']?>"><?php echo htmlspecialchars($post['name'], ENT_QUOTES, 'UTF-8'); ?></a>
                <a href="#" name="report" class="reportLink" data-client-id="<?php echo htmlspecialchars($post['client_id'], ENT_QUOTES, 'UTF-8'); ?>" data-post-id="<?php echo htmlspecialchars($post['post_id'], ENT_QUOTES, 'UTF-8'); ?>">通報する</a>
                <div class="date">
                    投稿日時: <?php echo htmlspecialchars($post['date'], ENT_QUOTES, 'UTF-8'); ?><br>
                </div>
                <div class="thread">
                <?php echo nl2br(wordwrap(htmlspecialchars($post['post'], ENT_QUOTES, 'UTF-8'), 30, "\n", true)); ?>
                </div>
            <hr>
    <?php
        }
    endif;
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
    <a href="thread.php?thread_id=<?php echo $thread_id; ?>&page=<?php echo $i; ?>"><?php echo $i;?></a>
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
  <div id="overlay" class="overlay" style="display: none;"></div>
    <div id="popup" class="popup" style="display: none;">
        <p id="popupMessage"></p>
        <div id="reasonInput" style="display: none;">
            <textarea id="reportReason" placeholder="通報理由を入力してください"></textarea>
        </div>
        <button id="popupActionButton" onclick="showConfirmation()">次へ</button>
        <button onclick="closePopup()">キャンセル</button>
        <form id="popupForm" action="" method="POST">
            <input type="hidden" name="client_id" id="clientIdField">
            <input type="hidden" name="action_type" id="actionTypeField">
            <input type="hidden" name="report_reason" id="reportReasonField">
            <input type="hidden" name="post_id" id="postIdField">
        </form>
    </div>
    <div id="confirmationPopup" class="popup" style="display: none;">
        <p id="confirmationMessage"></p>
        <button onclick="performAction()">実行</button>
        <button onclick="closeConfirmationPopup()">キャンセル</button>
    </div>

<script src="js/thread.js"></script>
</body>
</html>
