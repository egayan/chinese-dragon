<?php session_start(); ?>
<?php require 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="css/Top.css">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Zen+Kurenaido&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<?php require 'db_conect.php'; ?>
<div class="pat">
<div class="A">
<?php
function displayThreads($pdo) {
    $sql = $pdo->query('SELECT * FROM thread');
    $tr = 0;
    echo '<div align="center">スレッド一覧</div>';
    echo '<div style="display: flex; justify-content: center;"><table>';
    echo '<tr><td><div align="center">';
    foreach($sql as $row) {
        echo '<a href="******.php?title=', $row['title'], '">', $row['title'], '</a>';
        $tr++;
        if ($tr == 3) {
            echo '</div></td></tr><tr><td><div align="center">';
            $tr = 0;
        }
    }
    echo '</div></td></tr>';
    echo '</table></div>';
}
if (isset($_GET['gest'])) {
?>
    <table align="center">
        <tr><td><div align="center"><img src="images/logo.jpg" class="logo"></div></td></tr>
        <tr><td><div align="center">機能を利用するには<button><a href="login_input.php">ログイン画面へ戻る</a></button></div></td></tr>
    </table>
    <?php
    $pdo = new PDO($connect, USER, PASS);
    displayThreads($pdo);
    ?>
    <div align="center">
        <button><a href="Popularity.php?gest=gest">人気スレッドへ</a></button>
        <button><a href="warning.php">使い方・注意</a></button>
        <button><a href="genre.php" style="color: #fff;">スレッド一覧画面へ</a></button>
    </div>
<?php
} else {
    if (isset($_POST['password']) || isset($_POST['login'])) {
        unset($_SESSION['customer']);
        $_SESSION['login'] = ['id' => 0];
        if ($_POST['password'] != null && $_POST['login'] != null) {
            $pdo = new PDO($connect, USER, PASS);
            $sql = $pdo->prepare('SELECT * FROM client WHERE client_address=?');
            $sql->execute([$_POST['login']]);
            foreach ($sql as $row) {
                if ($_POST["password"] == $row['password']) {
                    $_SESSION['customer'] = [
                        'id' => $row['client_id'], 'name' => $row['name'],
                        'password' => $row['password'], 'address' => $row['client_address']
                    ];
                }
            }
            if (isset($_SESSION['customer'])) {
                $_SESSION['login'] = ['id' => 1];
            } else {
                echo '<div class="logerror">ログイン名またはパスワードが違います。<br><a href="login_input.php" class="button">ログインへ</a></div>';
            }
        } else {
            echo '<div class="logerror">ログイン名またはパスワードを入力してください。<br><a href="login_input.php" class="button">ログインへ</a></div>';
        }
    }
    if ($_SESSION['login']['id'] == 1) {
        $freeze_check = $pdo->prepare('SELECT * FROM client WHERE client_address=?');
        $freeze_check->execute([$_POST['login']]);
        foreach ($freeze_check as $row) {
            $check = $row['freeze'];
        }
        if ($check == 1) {
?>
            <table align="center">
                <tr><td><div align="center"><img src="images/logo.jpg" class="logo"><form action="login_input.php" method="post"><input type="submit" value="ログアウト" size="35"></form></div></td></tr>
                <tr><td><div align="center"><form action="Top_kensakukekka.php" method="post"><input type="text" placeholder="検索" name="kensaku" size="70"><input type="submit" value="検索" size="35"></form></div></td></tr>
                <tr><td><div class="line"></div></td></tr>
            </table>
            <?php
            $pdo = new PDO($connect, USER, PASS);
            displayThreads($pdo);
            ?>
            <div align="center">
                <button><a href="thread-write.php" style="color: #fff;">新規スレッド書き込み画面へ</a></button>
                <button><a href="genre.php" style="color: #fff;">スレッド一覧画面へ</a></button>
                <button><a href="Popularity.php" style="color: #fff;">人気スレッドへ</a></button>
                <button><a href="chat.php"style="color: #fff;">個人チャット</a></button>
                <button><a href="mypage.php" style="color: #fff;">マイページ</a></button>
                <button><a href="inquiry.php" style="color: #fff;">お問い合わせ</a></button>
                <button><a href="warning.php" style="color: #fff;">使い方・注意</a></button>
            </div>
<?php
        } else {
            echo '<h1>このアカウントは凍結されています</h1>';
        }
    }
}
?>
<?php require 'footer.php'; ?>
</div>
</div>
