<?php session_start(); ?>
<?php require 'header.php'; ?>
<?php require 'db_conect.php'; ?>
<?php
$pdo = new PDO($connect,USER,PASS);
$sql = $pdo->query('select * from ngword');
echo '<table align="center">';
echo '<tr><td><div align="center"><h2 id="sample">チャイニーズドラゴン</h2></div></td></tr>';
echo '<tr><td><div align="center">禁止ワード一覧</div></td></tr>';
    foreach($sql as $row){
        echo '<tr>';
        echo '<td>';
        echo '<div align="center">';
        echo '・',$row['ngword_content'];
        echo '</div>';
        echo '</td>';
        echo '</tr>';
    }
    echo '<tr><td><div align="center"><button><a href="Forbidden_word_input.php">禁止ワード追加画面へ</a></button>';
    echo '<button><a href="*">戻る</a></button></div></td></tr>';
?>
<?php require 'footer.php'; ?> 