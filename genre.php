<?php
session_start(); // セッションの開始

require('db-connect.php');

// データベースに接続
$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // ジャンルを取得
    $stmt = $pdo->query('SELECT genre_id, genre_name FROM genre ORDER BY genre_name ASC');
    $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'エラー: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>ジャンル一覧</title>
</head>
<body>
<h1>ジャンル一覧</h1>
<?php
if(isset($_SESSION['customer'])){
if (!empty($genres)): ?>
    <ul>
        <?php foreach ($genres as $genre): ?>
            <li>
                <a href="thread.php?thread_id=<?php echo htmlspecialchars($genre['genre_id'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo htmlspecialchars($genre['genre_name'], ENT_QUOTES, 'UTF-8'); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>ジャンルが見つかりませんでした。</p>
    <?php endif; ?>
<button><a href="Top_kensakukekka.php">トップページに戻る</a></button>
<?php
}else{
    if (!empty($genres)): ?>
        <ul>
            <?php foreach ($genres as $genre): ?>
                <li>
                    <a href="thread.php?thread_id=<?php echo htmlspecialchars($genre['genre_id'], ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($genre['genre_name'], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>ジャンルが見つかりませんでした。</p>
        <?php endif; ?>
        <tr><td><div align="center"><button><a href="Top.php?gest=gest">トップページに戻る</a></button></div></td></tr>
<?php
}
?>
</body>
</html>
