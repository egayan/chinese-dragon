<?php
session_start(); // セッションの開始
require('db-connect.php');

// データベースに接続
$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// スレッドのIDを取得
$thread_id = $_GET['thread_id'] ?? null;

$thread_title = '';
if ($thread_id) {
    $stmt = $pdo->prepare('SELECT title FROM thread WHERE thread_id = ?');
    $stmt->execute([$thread_id]);
    $thread = $stmt->fetch(PDO::FETCH_ASSOC);
    $thread_title = $thread['title'];
}

// NGワードを取得
$stmt = $pdo->query('SELECT ngword_content FROM ngword');
$ngwords = $stmt->fetchAll(PDO::FETCH_COLUMN);

// アクションの処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['client_id']) && isset($_POST['action_type'])) {
    $client_id = $_POST['client_id']; // ポップアップから送信されたクライアントのIDを取得
    $user_id = $_SESSION['customer']['id'] ?? null; // ログインしているユーザーのIDを取得
    $action_type = $_POST['action_type']; // アクションのタイプを取得
    if ($user_id != null) {
        if ($action_type === 'add_friend') {
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
if (!empty($report_reason)) {
    // 選択した投稿のpost_idを取得
        $reporter_id = $_SESSION['customer']['id'] ?? null; 
        $suspect_id = $_POST['client_id']; // ポップアップから送信されたクライアントのIDを取得
        $post_id = $_POST['post_id']; // 選択した投稿のpost_idを取得
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
    // スレッドに関連する投稿を取得
    $stmt = $pdo->prepare("SELECT post.*, client.name, client.client_id FROM post LEFT JOIN client ON post.client_id = client.client_id WHERE post.thread_id = ? ORDER BY post.date ASC");
    $stmt->execute([$thread_id]);
    if(isset($_SESSION['customer'])){
    while ($post = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        名前: <a href="#" name="name" class="popupLink" data-client-id="<?php echo htmlspecialchars($post['client_id'], ENT_QUOTES, 'UTF-8'); ?>" data-post-id="<?php echo htmlspecialchars($post['post_id'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($post['name'], ENT_QUOTES, 'UTF-8'); ?></a>
        <a href="#" name="report" class="reportLink" data-client-id="<?php echo htmlspecialchars($post['client_id'], ENT_QUOTES, 'UTF-8'); ?>" data-post-id="<?php echo htmlspecialchars($post['post_id'], ENT_QUOTES, 'UTF-8'); ?>">通報する</a>
        <div class="date">
        投稿日時: <?php echo htmlspecialchars($post['date'], ENT_QUOTES, 'UTF-8'); ?><br>
        </div>
        <div class="thread">
        投稿: <?php echo nl2br(htmlspecialchars($post['post'], ENT_QUOTES, 'UTF-8')); ?><br>
        </div>
        <hr>
        <?php
    }
    ?>
    <form action="" method="POST">
        <textarea name="post" cols="50" rows="10" placeholder="ここに投稿を入力してください"></textarea><br>
        <button type="submit" name="decide">投稿する</button>
    </form>
    <?php
    echo '<tr><td><div align="center"><button><a href="Top_kensakukekka.php">戻る</a></button></div></td></tr>';
} else {
    while ($post = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        名前: <a href="#" name="name" class="popupLink" data-client-id="<?php echo htmlspecialchars($post['client_id'], ENT_QUOTES, 'UTF-8'); ?>" data-post-id="<?php echo htmlspecialchars($post['post_id'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($post['name'], ENT_QUOTES, 'UTF-8'); ?></a>
        <a href="#" name="report" class="reportLink" data-client-id="<?php echo htmlspecialchars($post['client_id'], ENT_QUOTES, 'UTF-8'); ?>" data-post-id="<?php echo htmlspecialchars($post['post_id'], ENT_QUOTES, 'UTF-8'); ?>">通報する</a>
        <div class="date">
        投稿日時: <?php echo htmlspecialchars($post['date'], ENT_QUOTES, 'UTF-8'); ?><br>
        </div>
        <div class="thread">
        投稿: <?php echo nl2br(htmlspecialchars($post['post'], ENT_QUOTES, 'UTF-8')); ?><br>
        </div>
        <hr>
        <?php
    }
    ?>
    <form action="" method="POST">
        <textarea name="post" cols="50" rows="10" placeholder="ここに投稿を入力してください"></textarea><br>
        <button type="submit" name="decide">投稿する</button>
    </form>
    <?php
    echo '<tr><td><div align="center"><button><a href="Top.php?gest=gest">戻る</a></button></div></td></tr>';
}
?>

<div class="overlay" id="overlay"></div>
<div class="popup" id="popup">
    <p id="popupMessage"></p>
    <div id="reasonInput" style="display: none;">
        <textarea id="reportReason" placeholder="通報理由を入力してください"></textarea>
    </div>
    <button id="popupActionButton" onclick="showConfirmation()">次へ</button>
    <button onclick="closePopup()">キャンセル</button>
    <!-- ポップアップフォーム -->
    <form id="popupForm" action="" method="POST">
        <input type="hidden" name="client_id" id="clientIdField">
        <input type="hidden" name="action_type" id="actionTypeField">
        <input type="hidden" name="report_reason" id="reportReasonField">
        <input type="hidden" name="post_id" id="postIdField">
    </form>
</div>

<div class="popup" id="confirmationPopup" style="display: none;">
    <p id="confirmationMessage"></p>
    <button id="confirmActionButton" onclick="performAction()">実行する</button>
    <button onclick="closeConfirmationPopup()">キャンセル</button>
</div>

<script>
    // ポップアップを開く
    function openPopup(clientId, postId, message, actionType) {
        document.getElementById("overlay").style.display = "block";
        document.getElementById("popup").style.display = "block";
        document.getElementById("popup").setAttribute('data-client-id', clientId);
        document.getElementById("popup").setAttribute('data-post-id', postId); // 追加
        document.getElementById("popupMessage").innerText = message;
        document.getElementById("actionTypeField").value = actionType;

        if (actionType === 'report') {
            document.getElementById("reasonInput").style.display = "block";
        } else {
            document.getElementById("reasonInput").style.display = "none";
        }
    }

    // ポップアップを閉じる
    function closePopup() {
        document.getElementById("overlay").style.display = "none";
        document.getElementById("popup").style.display = "none";
    }

    // 確認ポップアップを開く
    function showConfirmation(){
        if (document.getElementById("actionTypeField").value === 'report') {
            var reason = document.getElementById("reportReason").value;
            if (!reason) {
                alert("通報理由を入力してください");
                return;
            }
            document.getElementById("reportReasonField").value = reason;
        }

        document.getElementById("popup").style.display = "none";
        document.getElementById("confirmationPopup").style.display = "block";
        document.getElementById("confirmationMessage").innerText = "この操作を実行しますか？";
    }

    // 確認ポップアップを閉じる
    function closeConfirmationPopup() {
        document.getElementById("confirmationPopup").style.display = "none";
        document.getElementById("overlay").style.display = "none";
    }

    // ポップアップアクションを実行する
    function performAction() {
        var clientId = document.getElementById("popup").getAttribute('data-client-id');
        var postId = document.getElementById("popup").getAttribute('data-post-id'); // 追加
        document.getElementById("clientIdField").value = clientId;
        document.getElementById("postIdField").value = postId; // 追加
        document.getElementById("popupForm").submit();
    }

    // ポップアップを表示するリンクをクリックしたときの処理
    var popupLinks = document.querySelectorAll('.popupLink');
    popupLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            var clientId = this.getAttribute('data-client-id');
            var postId = this.getAttribute('data-post-id'); // 追加
            openPopup(clientId, postId, '友達追加しますか？', 'add_friend');
        });
    });

    var reportLinks = document.querySelectorAll('.reportLink');
    reportLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            var clientId = this.getAttribute('data-client-id');
            var postId = this.getAttribute('data-post-id'); // 追加
            openPopup(clientId, postId, 'この投稿を通報しますか？', 'report');
        });
    });
</script>
</body>
</html>