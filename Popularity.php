<?php require 'header.php'; ?>    
<?php require 'db_conect.php';?>
<?php
if(isset($_GET['gest'])){
  $ids=[5];
  $num=0;
  $pdo = new PDO($connect,USER,PASS);
  $thread_id = $pdo->query('select thread_id,count(*) as id_count from post group by thread_id order by id_count desc limit 5');
  foreach($thread_id as $id){
  $ids[$num]=$id['thread_id'];
  $num++;
  }
  $no1 = $pdo->prepare('select title from thread where thread_id=?;');
  $no1->execute([$ids[0]]);
  echo '<table id="cate" align="center">';
  echo '<tr><td><h1>人気スレッド一覧</h1></td></tr>';
  foreach($no1 as $row){
    echo '<tr>';
    echo '<td>１位：';
    echo '<a href="thread.php?title=',$row['title'],'">',$row['title'],'</a>';
    echo '</td>';
    echo '</tr>';
  }
  $no2 = $pdo->prepare('select title from thread where thread_id=?;');
  $no2->execute([$ids[1]]);
  foreach($no2 as $row2){
    echo '<tr>';
    echo '<td>２位：';
    echo '<a href="thread.php?title=',$row2['title'],'">',$row2['title'],'</a>';
    echo '</td>';
    echo '</tr>';
  }
  $no3 = $pdo->prepare('select title from thread where thread_id=?;');
  $no3->execute([$ids[2]]);
  foreach($no3 as $row3){
    echo '<tr>';
    echo '<td>３位：';
    echo '<a href="thread.php?title=',$row3['title'],'">',$row3['title'],'</a>';
    echo '</td>';
    echo '</tr>';
  }
  $no4 = $pdo->prepare('select title from thread where thread_id=?;');
  $no4->execute([$ids[3]]);
  foreach($no4 as $row4){
    echo '<tr>';
    echo '<td>４位：';
    echo '<a href="thread.php?title=',$row4['title'],'">',$row4['title'],'</a>';
    echo '</td>';
    echo '</tr>';
  }
  $no5 = $pdo->prepare('select title from thread where thread_id=?;');
  $no5->execute([$ids[4]]);
  foreach($no5 as $row5){
    echo '<tr>';
    echo '<td>５位：';
    echo '<a href="thread.php?title=',$row5['title'],'">',$row5['title'],'</a>';
    echo '</td>';
    echo '</tr>';
  }
  echo '<tr><td><div align="center"><button><a href="Top.php?gest=gest">戻る</a></button></div></td></tr>';
  echo '</table>';
}else{
$ids=[5];
$num=0;
$pdo = new PDO($connect,USER,PASS);
$thread_id = $pdo->query('select thread_id,count(*) as id_count from post group by thread_id order by id_count desc limit 5');
foreach($thread_id as $id){
$ids[$num]=$id['thread_id'];
$num++;
}
$no1 = $pdo->prepare('select title from thread where thread_id=?;');
$no1->execute([$ids[0]]);
echo '<table id="cate" align="center">';
echo '<tr><td><h1>人気スレッド一覧</h1></td></tr>';
foreach($no1 as $row){
  echo '<tr>';
  echo '<td>１位：';
  echo '<a href="thread.php?title=',$row['title'],'">',$row['title'],'</a>';
  echo '</td>';
  echo '</tr>';
}
$no2 = $pdo->prepare('select title from thread where thread_id=?;');
$no2->execute([$ids[1]]);
foreach($no2 as $row2){
  echo '<tr>';
  echo '<td>２位：';
  echo '<a href="thread.php?title=',$row2['title'],'">',$row2['title'],'</a>';
  echo '</td>';
  echo '</tr>';
}
$no3 = $pdo->prepare('select title from thread where thread_id=?;');
$no3->execute([$ids[2]]);
foreach($no3 as $row3){
  echo '<tr>';
  echo '<td>３位：';
  echo '<a href="thread.php?title=',$row3['title'],'">',$row3['title'],'</a>';
  echo '</td>';
  echo '</tr>';
}
$no4 = $pdo->prepare('select title from thread where thread_id=?;');
$no4->execute([$ids[3]]);
foreach($no4 as $row4){
  echo '<tr>';
  echo '<td>４位：';
  echo '<a href="thread.php?title=',$row4['title'],'">',$row4['title'],'</a>';
  echo '</td>';
  echo '</tr>';
}
$no5 = $pdo->prepare('select title from thread where thread_id=?;');
$no5->execute([$ids[4]]);
foreach($no5 as $row5){
  echo '<tr>';
  echo '<td>５位：';
  echo '<a href="thread.php?title=',$row5['title'],'">',$row5['title'],'</a>';
  echo '</td>';
  echo '</tr>';
}
echo '<tr><td><div align="center"><button><a href="Top_kensakukekka.php">戻る</a></button></div></td></tr>';
echo '</table>';
}
?>
