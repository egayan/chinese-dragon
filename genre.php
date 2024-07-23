<?php
session_start();
require('db-connect.php');

// データベース接続確認
try {
    $pdo = new PDO($connect, USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ジャンル一覧を取得
    $stmt_genres = $pdo->query('SELECT genre_id, genre_name FROM genre ORDER BY genre_name ASC');
    $genres = $stmt_genres->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'エラー: ' . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/genre.css">
    <title>ジャンル一覧</title>
</head>
<div class="container">
    <h1>ジャンル一覧</h1>
    <div class="Container">
        <div class="Arrow left"><</div>
        <div class="Arrow right">></div>
        <div class="Box-Container">
            <?php foreach ($genres as $index => $genre): ?>
                <input id="tab<?php echo $index; ?>" class="tab-switch" type="radio" name="tab" <?php echo $index === 0 ? 'checked' : ''; ?>>
                <label class="tab-label" for="tab<?php echo $index; ?>" data-index="<?php echo $index; ?>"><?php echo htmlspecialchars($genre['genre_name'], ENT_QUOTES, 'UTF-8'); ?></label>
            <?php endforeach; ?>
        </div>
        <div class="tab-body">
            <?php foreach ($genres as $index => $genre): ?>
                <div class="body body<?php echo $index; ?>" style="display: <?php echo $index === 0 ? 'block' : 'none'; ?>;">
                    <?php
                    $stmt_threads = $pdo->prepare('SELECT thread_id, title FROM thread WHERE genre_id = :genre_id');
                    $stmt_threads->bindParam(':genre_id', $genre['genre_id'], PDO::PARAM_INT);
                    $stmt_threads->execute();
                    $threads = $stmt_threads->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <?php if (!empty($threads)): ?>
                        <ul>
                            <?php foreach ($threads as $thread): ?>
                                <li><a href="thread.php?thread_id=<?php echo htmlspecialchars($thread['thread_id'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($thread['title'], ENT_QUOTES, 'UTF-8'); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>スレッドがありません。</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    </div>
    <?php if (isset($_SESSION['customer'])): ?>
        <div align="center"><button><a href="Top_kensakukekka.php">戻る</a></button></div>
    <?php else: ?>
        <div align="center"><button><a href="Top.php?gest=gest">戻る</a></button></div>
    <?php endif; ?>
</div>
    
<script src="js/genre.js" defer></script>
</body>
</html>
