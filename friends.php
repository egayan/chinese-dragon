<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['customer']['id'])) {
    header('Location: login_input.php');
    exit;
}

$user_id = $_SESSION['customer']['id'];

// ユーザーの友達を取得
$stmt = $pdo->prepare('SELECT client.* FROM client JOIN frend ON client.client_id = frend.opponent_id WHERE frend.client_id = ?');
$stmt->execute([$user_id]);
$friends = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>友達リスト</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>友達リスト</h1>
    <ul>
        <?php foreach ($friends as $friend): ?>
            <li><?php echo htmlspecialchars($friend['name']); ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
