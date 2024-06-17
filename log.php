<?php
session_start();
include('db-connect.php');
$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// ユーザーがログインしているか確認
if (!isset($_SESSION['customer']['id'])) {
    echo 'Not logged in';
    exit;
}

$user_id = $_SESSION['customer']['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['type'] == 'message') {
        $opponent_id = $_POST['friend_id'];
        $message = $_POST['message'];

        // 対応する friend_id を取得
        $stmt = $pdo->prepare('SELECT friend_id FROM friend WHERE (client_id = ? AND opponent_id = ?) OR (client_id = ? AND opponent_id = ?)');
        $stmt->execute([$user_id, $opponent_id, $opponent_id, $user_id]);
        $friend = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($friend) {
            $friend_id = $friend['friend_id'];

            // friend_id を表示
            echo 'Friend ID: ' . htmlspecialchars($friend_id) . '<br>';

            // メッセージを保存
            $stmt = $pdo->prepare('INSERT INTO individualchat (sentence_content, date, friend_id, client_id) VALUES (?, NOW(), ?, ?)');
            $stmt->execute([$message, $friend_id, $user_id]);
            echo 'Message saved';
        } else {
            echo 'Invalid friend_id: ' . htmlspecialchars($opponent_id);
        }
    } elseif ($_POST['type'] == 'log') {
        $opponent_id = $_POST['friend_id'];

        // 対応する friend_id を取得
        $stmt = $pdo->prepare('SELECT friend_id FROM friend WHERE (client_id = ? AND opponent_id = ?) OR (client_id = ? AND opponent_id = ?)');
        $stmt->execute([$user_id, $opponent_id, $opponent_id, $user_id]);
        $friend = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($friend) {
            $friend_id = $friend['friend_id'];

            // チャットログを取得
            $stmt = $pdo->prepare('SELECT ic.sentence_content AS log, ic.date AS date, c.name AS name FROM individualchat ic JOIN client c ON ic.client_id = c.client_id WHERE ic.friend_id = ? ORDER BY ic.date');
            $stmt->execute([$friend_id]);
            $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // XML形式で出力
            header('Content-Type: text/xml');
            echo '<chat>';
            foreach ($logs as $log) {
                echo '<item>';
                echo '<log>' . htmlspecialchars($log['log']) . '</log>';
                echo '<name>' . htmlspecialchars($log['name']) . '</name>';
                echo '<date>' . htmlspecialchars($log['date']) . '</date>';
                echo '</item>';
            }
            echo '</chat>';
        } else {
            echo 'Invalid friend_id: ' . htmlspecialchars($opponent_id);
        }
    }
}
?>
