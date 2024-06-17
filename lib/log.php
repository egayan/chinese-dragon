<?php
session_start();
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['type']) && $_POST['type'] === 'log' && isset($_POST['friend_id'])) {
        $user_id = $_SESSION['customer']['id'];
        $friend_id = $_POST['friend_id'];

        $stmt = $pdo->prepare('SELECT * FROM chat_logs WHERE (user_id = ? AND friend_id = ?) OR (user_id = ? AND friend_id = ?)');
        $stmt->execute([$user_id, $friend_id, $friend_id, $user_id]);
        $logs = $stmt->fetchAll();

        header('Content-Type: application/xml');
        echo '<logs>';
        foreach ($logs as $log) {
            echo '<item>';
            echo '<log>' . htmlspecialchars($log['message']) . '</log>';
            echo '<name>' . htmlspecialchars($log['username']) . '</name>';
            echo '<date>' . htmlspecialchars($log['timestamp']) . '</date>';
            echo '</item>';
        }
        echo '</logs>';
    }
}
?>
