<?php
session_start();
require('db-connect.php');

try {
    $pdo = new PDO($connect, USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ジャンル一覧を取得
    $stmt_genres = $pdo->query('SELECT genre_id, genre_name FROM genre ORDER BY genre_name ASC');
    $genres = $stmt_genres->fetchAll(PDO::FETCH_ASSOC);

    // スレッドを取得する準備
    $stmt_threads = $pdo->prepare('SELECT thread_id, title FROM thread WHERE genre_id = :genre_id');
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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/genre.css">
    <title>ジャンル一覧</title>
</head>
<body>
<div class="container">
<?php if(isset($_SESSION['customer'])): ?>
    <h1>ジャンル一覧</h1>
    <div class="Container">
        <div class="Arrow left"><</div>
        <div class="Box-Container">
            <?php foreach ($genres as $index => $genre): ?>
                <input id="tab<?php echo $index; ?>" class="tab-switch" type="radio" name="tab" <?php echo $index === 0 ? 'checked' : ''; ?>>
                <label class="tab-label" for="tab<?php echo $index; ?>" data-index="<?php echo $index; ?>"><?php echo htmlspecialchars($genre['genre_name'], ENT_QUOTES, 'UTF-8'); ?></label>
            <?php endforeach; ?>
        </div>
        <div class="Arrow right">></div>
    </div>

    <div class="tab-body">
        <?php foreach ($genres as $index => $genre): ?>
            <div class="body body<?php echo $index; ?>" style="display: <?php echo $index === 0 ? 'block' : 'none'; ?>;">
                <?php
                $stmt_threads->bindParam(':genre_id', $genre['genre_id'], PDO::PARAM_INT);
                $stmt_threads->execute();
                $threads = $stmt_threads->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($threads)) {
                    echo '<ul>';
                    foreach ($threads as $thread) {
                        echo '<li><a href="thread.php?thread_id=' . htmlspecialchars($thread['thread_id'], ENT_QUOTES, 'UTF-8') . '">'. htmlspecialchars($thread['title'], ENT_QUOTES, 'UTF-8') .'</a></li>';
                    }
                    echo '</ul>';
                } else {
                    echo 'スレッドがありません。';
                }
                ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div align="center"><button><a href="Top_kensakukekka.php">戻る</a></button></div>
<?php else: ?>
    <h1>ジャンル一覧</h1>
    <div class="Container">
        <div class="Arrow left"><</div>
        <div class="Box-Container">
            <?php foreach ($genres as $index => $genre): ?>
                <input id="tab<?php echo $index; ?>" class="tab-switch" type="radio" name="tab" <?php echo $index === 0 ? 'checked' : ''; ?>>
                <label class="tab-label" for="tab<?php echo $index; ?>" data-index="<?php echo $index; ?>"><?php echo htmlspecialchars($genre['genre_name'], ENT_QUOTES, 'UTF-8'); ?></label>
            <?php endforeach; ?>
        </div>
        <div class="Arrow right">></div>
    </div>

    <div class="tab-body">
        <?php foreach ($genres as $index => $genre): ?>
            <div class="body body<?php echo $index; ?>" style="display: <?php echo $index === 0 ? 'block' : 'none'; ?>;">
                <?php
                $stmt_threads->bindParam(':genre_id', $genre['genre_id'], PDO::PARAM_INT);
                $stmt_threads->execute();
                $threads = $stmt_threads->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($threads)) {
                    echo '<ul>';
                    foreach ($threads as $thread) {
                        echo '<li><a href="thread.php?thread_id=' . htmlspecialchars($thread['thread_id'], ENT_QUOTES, 'UTF-8') . '">'. htmlspecialchars($thread['title'], ENT_QUOTES, 'UTF-8') .'</a></li>';
                    }
                    echo '</ul>';
                } else {
                    echo 'スレッドがありません。';
                }
                ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div align="center"><button><a href="Top.php?gest=gest">戻る</a></button></div>
<?php endif; ?>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const containers = document.querySelectorAll('.Container');

    containers.forEach(container => {
        const boxContainer = container.querySelector('.Box-Container');
        const leftArrow = container.querySelector('.Arrow.left');
        const rightArrow = container.querySelector('.Arrow.right');
        const scrollAmount = 1400;

        leftArrow.addEventListener('click', function () {
            scroll(boxContainer, -1);
        });

        rightArrow.addEventListener('click', function () {
            scroll(boxContainer, 1);
        });

        function scroll(boxContainer, direction) {
            const containerWidth = container.offsetWidth;
            const maxScrollAmount = boxContainer.scrollWidth - containerWidth;
            const currentScrollAmount = Math.abs(parseInt(boxContainer.style.transform.split('(')[1])) || 0;
            const newScrollAmount = direction === -1 ? Math.max(currentScrollAmount - scrollAmount, 0) :
                Math.min(currentScrollAmount + scrollAmount, maxScrollAmount);
            boxContainer.style.transform = 'translateX(-' + newScrollAmount + 'px)';
            updateArrowVisibility(newScrollAmount, maxScrollAmount, leftArrow, rightArrow);
        }

        function updateArrowVisibility(scrollAmount, maxScrollAmount, leftArrow, rightArrow) {
            if (scrollAmount === 0) {
                leftArrow.classList.add('Hide');
            } else {
                leftArrow.classList.remove('Hide');
            }

            if (scrollAmount === maxScrollAmount) {
                rightArrow.classList.add('Hide');
            } else {
                rightArrow.classList.remove('Hide');
            }
        }

        // 初期状態の矢印表示を設定
        updateArrowVisibility(0, boxContainer.scrollWidth - container.offsetWidth, leftArrow, rightArrow);
    });

    const tabLabels = document.querySelectorAll('.tab-label');
    tabLabels.forEach(label => {
        label.addEventListener('click', function () {
            const index = this.getAttribute('data-index');
            const bodies = document.querySelectorAll('.tab-body .body');
            bodies.forEach(body => body.style.display = 'none');
            document.querySelector('.body' + index).style.display = 'block';
        });
    });
});
</script>

</body>
</html>
