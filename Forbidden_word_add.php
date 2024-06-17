<?php require 'header.php'; ?>
<?php require 'db_conect.php'; ?>
<?php
$pdo=new PDO($connect,USER,PASS);
if($_POST['word1'] == null && $_POST['word2'] == null && $_POST['word3'] == null){
echo '<div align="center">禁止ワードを入力してください</div>';
}else{   
if(isset($_POST['word1']) && $_POST['word1'] != null){
$word1check=$pdo->prepare('select * from ngword where ngword_content=?');
$word1check->execute([$_POST['word1']]);
if(empty($word1check->fetchAll())){
    $word1=$pdo->prepare('insert into ngword values(null,?)');
    $word1->execute([
        $_POST['word1']
    ]);
    echo '<div align="center">',$_POST['word1'],'を追加しました</div><br>';
}else{
    echo '<div align="center">',$_POST['word1'],'は既に存在します</div>';
}
}

if(isset($_POST['word2']) && $_POST['word2'] != null){
$word2check=$pdo->prepare('select * from ngword where ngword_content=?');
$word2check->execute([$_POST['word2']]);
if(empty($word2check->fetchAll())){
    $word2=$pdo->prepare('insert into ngword values(null,?)');
    $word2->execute([
        $_POST['word2']
    ]);
    echo '<div align="center">',$_POST['word2'],'を追加しました</div><br>';
}else{
    echo '<div align="center">',$_POST['word2'],'は既に存在します</div>';
}
}

if(isset($_POST['word3']) && $_POST['word3'] != null){
$word3check=$pdo->prepare('select * from ngword where ngword_content=?');
$word3check->execute([$_POST['word3']]);
if(empty($word3check->fetchAll())){   
$word3=$pdo->prepare('insert into ngword values(null,?)');
$word3->execute([
    $_POST['word3']
]);
    echo '<div align="center">',$_POST['word3'],'を追加しました</div><br>';
}else{
    echo '<div align="center">',$_POST['word3'],'は既に存在します</div>'; 
}
}

}
?>
<div align="center"><button><a href="Forbidden_word_input.php">戻る</a></button></div>
<?php require 'footer.php'; ?> 