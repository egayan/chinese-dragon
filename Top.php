<?php session_start(); ?>
<?php require 'header.php'; ?>
<link rel="stylesheet" type="text/css" href="css/Top.css">
<?php require 'db_conect.php'; ?>
<div class="pat">
<?php
if(isset($_GET['gest'])){
?>
    <!-- メニュー -->
    <table align="center">
    
    <tr><td><div align="center"><h1>チャイニーズドラゴン</h1></div></td></tr>
    <tr><td><div align="center">機能を利用するには<button><a href="login_input.php">ログイン画面へ戻る</a></button></div></td></tr>
    
    <?php
    $pdo = new PDO($connect,USER,PASS);
    $tr=0;
    $sql = $pdo->query('select * from thread');
    
    echo '<tr><td><div align="center">スレッド一覧</div></td></tr>';
    echo '<tr>';
    echo '<td>';
    echo '<div  align="left" >';
    foreach($sql as $row){
        
        echo '<a href="******.php?title=',$row['title'],'">',$row['title'],'</a>';
        $tr++;
        
    }
    echo '</div>';
    echo '</td>';
    echo '</tr>';
    echo '<tr><td><div align="center">';
    echo '<button><a href="Popularity.php?gest=gest">人気スレッドへ</a></button></div></td></tr>';
    
    echo '<tr><td>';
    echo '<div align="center">';
    echo '<button><a href="*">使い方・注意</a></button></div></td></tr>';
    echo '</table>';
    ?>

<?php
}else{
if(isset($_POST['passward']) || isset($_POST['login'])){
    unset($_SESSION['customer']);
    $_SESSION['login']=[
        'id'=>0
    ];
if($_POST['password'] != null && $_POST['login'] != null){
$pdo = new PDO($connect,USER,PASS);
$sql = $pdo->prepare('select * from client where client_address=?');
$sql->execute([$_POST['login']]);
foreach($sql as $row){
    if(password_verify($_POST['password'],$row['password'])){
    $_SESSION['customer']=[
        'id'=>$row['client_id'],'name'=>$row['name'],
        'password'=>$row['password'],'address'=>$row['client_address']
    ];
    }
}

if(isset($_SESSION['customer'])){
    /*echo 'ようこそ、',$_SESSION['customer']['name'],'さん。';*/
    $_SESSION['login']=[
        'id'=>1
    ];
}else{
    echo '<div class="logerror">';
    echo 'ログイン名またはパスワードが違います。';
    echo '<br>';
    echo '<a href="login_input.php" class="button">ログインへ</a>';
    echo '</div>';
}
}else{
    echo '<div class="logerror">';
    echo 'ログイン名またはパスワードを入力してください。';
    echo '<br>';
    echo '<a href="login_input.php" class="button">ログインへ</a>';
    echo '</div>';
}

}
if($_SESSION['login']['id']==1){

$freeze_check = new PDO($connect,USER,PASS);
$freeze_check = $pdo->prepare('select * from client where client_address=?');
$freeze_check ->execute([$_POST['login']]);
foreach($freeze_check as $row){
$check=$row['freeze'];
}
if($check == 1){
?>

<table align="center">
  <tr><td><div align="center"><img src="images/logo.jpg" class="logo">
  
  <a href="login_input.php">ログアウト</a></div></td></tr>
  <tr><td><div align="center">
  <form action="Top_kensakukekka.php" method="post">
    <input type="text" placeholder="検索" name="kensaku" size="70" ><input type="submit" value="検索" size="35" >
  </form>
  </div></td></tr>
  

<?php
$pdo = new PDO($connect, USER, PASS);
$tr = 0;
$sql = $pdo->query('SELECT * FROM thread');
?>

<!-- テーブルを中央寄せ -->
<div style="display: flex; justify-content: center;">

    
        <tr>
            <td><div align="center">スレッド一覧</div></td>
        </tr>
        <tr>
            <td>
                <div align="center">
                    <?php
                    foreach ($sql as $row) {
                        echo '<a href="******.php?title=', $row['title'], '">', $row['title'], '</a>';
                        $tr++;
                        if ($tr == 3) {
                            echo '</div>';
                            echo '</td>';
                            echo '</tr>';
                            $tr = 0;
                            echo '<tr>';
                            echo '<td>';
                            echo '<div align="center">';
                        }
                    }
                    ?>
                </div>
            </td>
        </tr>

    <div><tr><td><div align="center"><button><a href="*" style="color: #fff;">新規スレッド書き込み画面へ</a></button>
    <button><a href="Popularity.php" style="color: #fff;">人気スレッドへ</a></button></div></td></tr>
    
    <tr><td><div align="center"><button><a href="chat.php"style="color: #fff;">個人チャット</a></button>
    <button><a href="mypage.php" style="color: #fff;">マイページ</a></button>
    <button><a href="*" style="color: #fff;">お問い合わせ</a></button>
    <button><a href="warning.php" style="color: #fff;">使い方・注意</a></button></div></td></tr></div>
    
</table>
</div>
</div>

<?php 
    }else{
        echo '<h1>このアカウントは凍結されています</h1>';
    }
}
?>
<?php 
}
?>
<?php require 'footer.php'; ?>

