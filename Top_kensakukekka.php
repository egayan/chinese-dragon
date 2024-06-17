<?php require 'header.php'; ?>
<?php require 'db_conect.php'; ?>
<link rel="stylesheet" type="text/css" href="css/Top.css">
<table align="center">

    <tr><td><div align="center">チャイニーズドラゴン
    <a href="login_input.php">ログアウト</a></div></td></tr>
    
    <tr><td><div align="center">
    <form action="Top_kensakukekka.php" method="post">
    <input type="text" placeholder="検索" name="kensaku" size="70" ><input type="submit" value="検索" size="35" >
    </form>
    </div></td></tr>

<?php
$pdo = new PDO($connect,USER,PASS);


if(isset($_POST['kensaku'])){
    $sql = $pdo->prepare('select * from thread where title like ?');
    $sql->execute(['%'.$_POST['kensaku'].'%']);
    $tr=0;
    echo '<tr><td>スレッド一覧</td></tr>';
    echo '<tr>';
    echo '<td>';
    echo '<div align="left">';
    foreach($sql as $row){
        echo '<a href="thread.php?thread_id=',$row['thread_id'],'">',$row['title'],'</a>';
        $tr++;
        if($tr==3){
        echo '</div>';
        echo '</td>';
        echo '</tr>';
        $tr=0;
        echo '<tr>';
        echo '<td>';
        echo '<div align="left">';
        }
    }
}else{
$sql = $pdo->query('select * from thread ');//一覧
$tr=0;

echo '<tr><td>スレッド一覧</td></tr>';
echo '<tr>';
echo '<td>';
echo '<div align="left">';
foreach($sql as $row){
    echo '<a href="thread.php?thread_id=',$row['thread_id'],'">',$row['title'],'</a>';
    $tr++;
        if($tr==3){
        echo '</div>';
        echo '</td>';
        echo '</tr>';
        $tr=0;
        echo '<tr>';
        echo '<td>';
        echo '<div align="left">';
        }
    }


}
echo '</div>';
echo '</td>';
echo '</tr>';
?>
    <tr><td><div align="center"><button><a href="thread-write.php" style="color: #fff;">新規スレッド書き込み画面へ</a></button>
    <button><a href="Popularity.php" style="color: #fff;">人気スレッドへ</a></button></div></td></tr>
    
    <tr><td><div align="center"><button><a href="chat.php" style="color: #fff;">個人チャット</a></button>
    <button><a href="mypage.php" style="color: #fff;">マイページ</a></button>
    <button><a href="inquiry.php" style="color: #fff;">お問い合わせ</a></button>
    <button><a href="warning.php" style="color: #fff;">使い方・注意</a></button></div></td></tr>
</table>
<?php require 'footer.php'; ?> 