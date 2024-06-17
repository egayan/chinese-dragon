<?php
session_start();
require('db-connect.php');

$pdo = new PDO($connect, USER, PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // ジャンル一覧を取得
    $stmt_genres = $pdo->query('SELECT genre_id, genre_name FROM genre ORDER BY genre_name ASC');
    $genres = $stmt_genres->fetchAll(PDO::FETCH_ASSOC);

    // スレッドを取得する準備
    $stmt_threads = $pdo->prepare('SELECT thread_id, title FROM thread WHERE genre_id = :genre_id');
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
    <title>ジャンル一覧とスレッド表示</title>
</head>
<body>
<div class="container">
<?php
if(isset($_SESSION['customer'])){
    ?>
    <h1>ジャンル一覧とスレッド表示</h1>
    <table>
        <thead>
            <tr>
                <th>ジャンル</th>
                <th>スレッド一覧</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($genres as $genre): ?>
                <tr>
                    <td><?php echo htmlspecialchars($genre['genre_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <?php
                        $genre_id = $genre['genre_id'];
                        $stmt_threads->bindParam(':genre_id', $genre_id, PDO::PARAM_INT);
                        $stmt_threads->execute();
                        $threads = $stmt_threads->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($threads)) {
                            echo '<ul>';
                            foreach ($threads as $thread) {
                                <div class="tab-wrap"><input id="tab1" class="tab-switch" checked="checked" name="tab" type="radio" /><label class="tab-label" for="tab1">tab1</label>
                                <input id="tab2" class="tab-switch" name="tab" type="radio" /><label class="tab-label" for="tab2">tab2</label>
                                <input id="tab3" class="tab-switch" name="tab" type="radio" /><label class="tab-label" for="tab3">tab3</label>
                                <div class="tab-body">
                                <div class="body1">コンテンツ１</div>
                                echo '<div><a href="thread.php?thread_id=' . htmlspecialchars($thread['thread_id'], ENT_QUOTES, 'UTF-8') . '">. htmlspecialchars($thread['title'], ENT_QUOTES, 'UTF-8') . '</a></div>';
                                </div>
                                </div>

                            }
                            echo '</ul>';
                        } else {
                            echo 'スレッドがありません。';
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <tr><td><div align="center"><button><a href="Top_kensakukekka.php">戻る</a></button></div></td></tr>
</div>
<?php
}else{
    ?>
    <h1>ジャンル一覧とスレッド表示</h1>
    <table>
        <thead>
            <tr>
                <th>ジャンル</th>
                <th>スレッド一覧</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($genres as $genre): ?>
                <tr>
                    <td><?php echo htmlspecialchars($genre['genre_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <?php
                        $genre_id = $genre['genre_id'];
                        $stmt_threads->bindParam(':genre_id', $genre_id, PDO::PARAM_INT);
                        $stmt_threads->execute();
                        $threads = $stmt_threads->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($threads)) {
                            echo '<ul>';
                            foreach ($threads as $thread) {
                                echo '<li><a href="thread.php?thread_id=' . htmlspecialchars($thread['thread_id'], ENT_QUOTES, 'UTF-8') . '">'
                                    . htmlspecialchars($thread['title'], ENT_QUOTES, 'UTF-8') . '</a></li>';
                            }
                            echo '</ul>';
                        } else {
                            echo 'スレッドがありません。';
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <tr><td><div align="center"><button><a href="Top.php?gest=gest">戻る</a></button></div></td></tr>
<?php
}
?>
</body>
</html>
