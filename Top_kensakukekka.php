<?php require 'header.php'; ?>
<?php require 'db_conect.php'; ?>
<link rel="stylesheet" type="text/css" href="css/Top_kensakukekka.css">
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Zen+Kurenaido&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<!DOCTYPE html>
<html lang="ja">

<div class="pat">

<table align="center">

    <tr><td><div align="center"><img src="images/logo.jpg" class="logo">
    <form action="login_input.php" method="post">
        <input type="submit" value="ログアウト" size="35" >
    </form>
    
    <tr><td><div align="center">
    <form action="Top_kensakukekka.php" method="post">
    <input type="text" placeholder="検索" name="kensaku" size="70" ><input type="submit" value="検索" size="35" >
    </form>
    <tr><td><div class="line"></div></td></tr>
    </div></td></tr>

    <tr>
            <td><div align="center">スレッド一覧</div></td>
    </tr>
    <?php
    $pdo = new PDO($connect,USER,PASS);
    if(isset($_POST['kensaku'])){
    $sql = $pdo->prepare('select * from thread where title like ?');
    $sql->execute(['%'.$_POST['kensaku'].'%']);
    $tr=0;
    echo '<tr>';
    echo '<td>';
    echo '<div align="center">';
    foreach($sql as $row){
    echo '<a href="partner.php?genre=',$row['title'],'">',$row['title'],'</a>　　';
        $tr++;
        if($tr==3){
        echo '</div>';
        echo '</td>';
        echo '</tr>';
        $tr=0;
        echo '<tr>';
        echo '<td>';
        echo '<div align="center">';
        }
    }
}else{
$sql = $pdo->query('select * from thread ');//一覧
$tr=0;


echo '<tr>';
echo '<td>';
echo '<div align="center">';

foreach($sql as $row){
    echo '<a href="partner.php?genre=',$row['title'],'">',$row['title'],'</a>　　';
    $tr++;
        if($tr==3){
        echo '</div>';
        echo '</td>';
        echo '</tr>';
        $tr=0;
        echo '<tr>';
        echo '<td>';
        echo '<div align="center">';
        }
    }


}
echo '</div>';
echo '</td>';
echo '</tr>';
echo '</div>';

?>

  </div>


  
</td>
        </tr>
</div>

<tr><td><div class="line"></div></td></tr>

<div class="menu">
    <tr><td><div align="center">
    <button><a href="thread-write.php" style="color: #fff;">新規スレッド書き込み画面へ</a></button>
    <button><a href="genre.php" style="color: #fff;">スレッド一覧画面へ</a></button>
    <button><a href="Popularity.php" style="color: #fff;">人気スレッドへ</a></button>
    <button><a href="chat.php" style="color: #fff;">個人チャット</a></button>
    <button><a href="mypage.php" style="color: #fff;">マイページ</a></button>
    <button><a href="inquiry.php" style="color: #fff;">お問い合わせ</a></button>
    <button><a href="warning.php" style="color: #fff;">使い方・注意</a></button></div></td></tr>
</div> 
</table>

<?php require 'footer.php'; ?> 
</div>