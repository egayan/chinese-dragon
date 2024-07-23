<?php session_start(); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && ! isset($_GET['complete'])) {
    // GET で初期アクセスされた時は送信用フォームを表示
    echo <<<HTML
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/toiawase.css" rel="stylesheet">
    <title>問い合わせページ</title>
</head>
<body>
    <div class='wrap'>
    <div class="contact">
<form action="" method="post">
   <label> <div class='a'>問い合わせ内容</div><div class='b'><input type="text" name="name0" ></div></label>
    <button type="submit" class='g'>送信</button>
</form>
<button onclick="location.href='inquiry-response.php'" class='e'>返信受け取り</button>
<<<<<<< HEAD
<button onclick="location.href='Top_kensakukekka.php'"class='f'>戻る</button>
=======
<button onclick="location.href='Top-kensakukekka.php'"class='f'>戻る</button>
>>>>>>> 5e1ab1915062f0f93950b1ac0f78c800445274bc
</div>
</div>
</body>
</html>
HTML;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // フォームで送られてきたデータを保存など何かしら処理
    $pdo=new PDO('mysql:host=mysql301.phy.lolipop.lan;dbname=LAA1517815-ch;charset=utf8',
    'LAA1517815','chinese');
    $sql=$pdo->prepare('select * from client where client_address=?');
    $sql->execute([$_SESSION['customer']['address']]);
    foreach($sql as $id){
    $myid=$id['client_id'];
    }
    if (empty($_POST['name0'])) {
    }else if(empty($_SESSION['customer']['address'])){
    } else {
    $sql=$pdo->prepare('insert into inquiry(inquiry_content,client_id) values(?,?)');
    if($sql->execute([$_POST['name0'],$myid])){
    }else{
    }
    }
    // POST でアクセスされた時はリダイレクトレスポンスを返す
<<<<<<< HEAD
    header('Location: Top_kensakukekka.php?complete', true, 301);
=======
    header('Location: /php2/kaihatu/Top-kensakukekka.php?complete', true, 301);
>>>>>>> 5e1ab1915062f0f93950b1ac0f78c800445274bc
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['complete'])) {
    // POST でアクセスされた後のリダイレクト先。
    // リダイレクト先の画面で完了ページを表示する
    echo <<<HTML
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>完了ページ</title>
</head>
<body>
データが保存されました。
</body>
</html>
HTML;
}