<?php require 'header.php'; ?>
<?php require 'db_conect.php'; ?>
<?php
$pdo = new PDO($connect,USER,PASS);
if(isset($_GET['freeze_out'])){
    $freeze=$pdo->prepare('update client set freeze = 1 where client_id=?');
    $freeze->execute([
        $_GET['freeze_out']
    ]);
    $sql = $pdo->prepare('select * from client where client_id = ?');
    $sql ->execute([
    $_GET['freeze_out']
    ]);
    echo '<div align="center"><h1>凍結を解除しました</h1></div>';
    echo '<table id="cate" align="center">';
    foreach($sql as $row){

    echo '<tr><td><h3>',$row['name'],'</h3></td></tr>';
    echo '<form action="account_management.php" method="post">';
    echo '<table align="center">';
    echo '<tr><td><h2>ユーザープロフィール</h2></td></tr>';
        
    echo '<tr><td>ユーザー名　　';
    echo '<input type="text" align="center" name="name" value="',$row['name'],'">';
    echo '</td></tr>';
       
    echo '<tr><td>メールアドレス';
    echo '<input type="text" name="address" value="',$row['client_address'],'">';
    echo '</td></tr>';
        
    echo '<tr><td>パスワード　　';
    echo '<input type="text" name="password" value="',$row['password'],'">';
    echo '</td></tr>';
        
    echo '<tr><td>';
    echo '<input type="hidden" name="id" value="',$row['client_id'],'">','</p>';
    echo '</td></tr>';
        
    echo '<tr><td><div align="center">';
    echo '<input type="submit" value="更新">';
    echo'</form></div>';
    echo '</td></tr>';
    echo '<tr><td><div align="center"><button><a href="account_management.php?freeze_id=',$row['client_id'],'"><h2>凍結</h2></div></button></p></td></tr>';
    echo '<tr><td><div align="center"><button><a href="account.php">戻る</a></button></div></td></tr>';
    }
    echo '</table>';
}else{
if(isset($_GET['client_id'])){
    $f_check = $pdo->prepare('select * from client where client_id = ?');
    $f_check ->execute([
        $_GET['client_id']
    ]);
    foreach($f_check as $f_c){
        $fcid = $f_c['freeze'];
    }
}else if(isset($_GET['freeze_id'])){
    $f_check = $pdo->prepare('select * from client where client_id = ?');
    $f_check ->execute([
        $_GET['freeze_id']
    ]);
    foreach($f_check as $f_c){
        $fcid = $f_c['freeze'];
    } 
}else{
    $f_check = $pdo->prepare('select * from client where client_id = ?');
    $f_check ->execute([
    $_POST['id']
    ]);
    foreach($f_check as $f_c){
    $fcid = $f_c['freeze'];
    }
}
if($fcid == 2){
    if($_SERVER["REQUEST_METHOD"]=='POST'){
        $update=$pdo->prepare('update client set name=?, password=?,client_address=? where client_id=?');
        $update->execute([
            $_POST['name'],$_POST['password'],
            $_POST['address'],$_POST['id']
        ]);
        $sql = $pdo->prepare('select * from client where client_id = ?');
        $sql ->execute([
        $_POST['id']
        ]);
    echo '<div align="center"><h1>更新しました</h1></div>';
    echo '<div align="center"><h1>このアカウントは凍結されています</h1></div>';
    echo '<table id="cate" align="center">';
    foreach($sql as $row){
    echo '<tr><td><h3>',$row['name'],'</h3></td></tr>';
    echo '<form action="account_management.php" method="post">';
    echo '<table align="center">';
    echo '<tr><td><h2>ユーザープロフィール</h2></td></tr>';
        
    echo '<tr><td>ユーザー名　　';
    echo '<input type="text" align="center" name="name" value="',$row['name'],'">';
    echo '</td></tr>';
       
    echo '<tr><td>メールアドレス';
    echo'<input type="text" name="address" value="',$row['client_address'],'">';
    echo'</td></tr>';
        
    echo'<tr><td>パスワード　　';
    echo'<input type="text" name="password" value="',$row['password'],'">';
    echo'</td></tr>';
        
    echo '<tr><td>';
    echo '<input type="hidden" name="id" value="',$row['client_id'],'">','</p>';
    echo '</td></tr>';
        
    echo '<tr><td><div align="center">';
    echo '<input type="submit" value="更新">';
    echo'</form></div>';
    echo '</td></tr>';
    echo '<tr><td><div align="center"><button><a href="account_management.php?freeze_out=',$row['client_id'],'"><h2>凍結解除</h2></div></button></p></td></tr>';
    echo '<tr><td><div align="center"><button><a href="account.php">戻る</a></button></div></td></tr>';
    }
    echo '</table>';
    }else{
    echo '<div align="center"><h1>このアカウントは凍結されています</h1></div>';
    echo '<table id="cate" align="center">';
    if(isset($_GET['client_id'])){
    $sql = $pdo->prepare('select * from client where client_id = ?');
    $sql ->execute([
    $_GET['client_id']
    ]);
    }else if(isset($_GET['freeze_id'])){
    $sql = $pdo->prepare('select * from client where client_id = ?');
    $sql ->execute([
    $_GET['freeze_id']
    ]);
    }else{
    $sql = $pdo->prepare('select * from client where client_id = ?');
    $sql ->execute([
    $_POST['id']
    ]);  
    }      

    foreach($sql as $row){

    echo '<tr><td><h3>',$row['name'],'</h3></td></tr>';
    echo '<form action="account_management.php" method="post">';
    echo '<table align="center">';
    echo '<tr><td><h2>ユーザープロフィール</h2></td></tr>';
        
    echo '<tr><td>ユーザー名　　';
    echo '<input type="text" align="center" name="name" value="',$row['name'],'">';
    echo '</td></tr>';
       
    echo '<tr><td>メールアドレス';
    echo '<input type="text" name="address" value="',$row['client_address'],'">';
    echo '</td></tr>';
        
    echo '<tr><td>パスワード　　';
    echo '<input type="text" name="password" value="',$row['password'],'">';
    echo '</td></tr>';
        
    echo '<tr><td>';
    echo '<input type="hidden" name="id" value="',$row['client_id'],'">','</p>';
    echo '</td></tr>';
        
    echo '<tr><td><div align="center">';
    echo '<input type="submit" value="更新">';
    echo'</form></div>';
    echo '</td></tr>';
    echo '<tr><td><div align="center"><button><a href="account_management.php?freeze_out=',$row['client_id'],'"><h2>凍結解除</h2></div></button></p></td></tr>';
    echo '<tr><td><div align="center"><button><a href="account.php">戻る</a></button></div></td></tr>';
    }
    echo '</table>';
    }

}else{
if(isset($_GET['freeze_id'])){
    $freeze=$pdo->prepare('update client set freeze = 2 where client_id=?');
    $freeze->execute([
        $_GET['freeze_id']
    ]);
    $sql = $pdo->prepare('select * from client where client_id = ?');
    $sql ->execute([
    $_GET['freeze_id']
    ]);
    echo '<div align="center"><h1>このアカウントは凍結されています</h1></div>';
    echo '<table id="cate" align="center">';
    foreach($sql as $row){

    echo '<tr><td><h3>',$row['name'],'</h3></td></tr>';
    echo '<form action="account_management.php" method="post">';
    echo '<table align="center">';
    echo '<tr><td><h2>ユーザープロフィール</h2></td></tr>';
        
    echo '<tr><td>ユーザー名　　';
    echo '<input type="text" align="center" name="name" value="',$row['name'],'">';
    echo '</td></tr>';
       
    echo '<tr><td>メールアドレス';
    echo '<input type="text" name="address" value="',$row['client_address'],'">';
    echo '</td></tr>';
        
    echo '<tr><td>パスワード　　';
    echo '<input type="text" name="password" value="',$row['password'],'">';
    echo '</td></tr>';
        
    echo '<tr><td>';
    echo '<input type="hidden" name="id" value="',$row['client_id'],'">','</p>';
    echo '</td></tr>';
        
    echo '<tr><td><div align="center">';
    echo '<input type="submit" value="更新">';
    echo'</form></div>';
    echo '</td></tr>';
    echo '<tr><td><div align="center"><button><a href="account_management.php?freeze_out=',$row['client_id'],'"><h2>凍結解除</h2></div></button></p></td></tr>';
    echo '<tr><td><div align="center"><button><a href="account.php">戻る</a></button></div></td></tr>';
    }
    echo '</table>';
}else if($_SERVER["REQUEST_METHOD"]=='POST'){
    $update=$pdo->prepare('update client set name=?, password=?,client_address=? where client_id=?');
    $update->execute([
        $_POST['name'],$_POST['password'],
        $_POST['address'],$_POST['id']
    ]);
    $sql = $pdo->prepare('select * from client where client_id = ?');
    $sql ->execute([
    $_POST['id']
    ]);
    echo '<div align="center"><h1>更新しました</h1></div>';
echo '<table id="cate" align="center">';
foreach($sql as $row){
echo '<tr><td><h3>',$row['name'],'</h3></td></tr>';
echo '<form action="account_management.php" method="post">';
echo '<table align="center">';
echo '<tr><td><h2>ユーザープロフィール</h2></td></tr>';
    
echo '<tr><td>ユーザー名　　';
echo '<input type="text" align="center" name="name" value="',$row['name'],'">';
echo '</td></tr>';
   
echo '<tr><td>メールアドレス';
echo'<input type="text" name="address" value="',$row['client_address'],'">';
echo'</td></tr>';
    
echo'<tr><td>パスワード　　';
echo'<input type="text" name="password" value="',$row['password'],'">';
echo'</td></tr>';
    
echo '<tr><td>';
echo '<input type="hidden" name="id" value="',$row['client_id'],'">','</p>';
echo '</td></tr>';
    
echo '<tr><td><div align="center">';
echo '<input type="submit" value="更新">';
echo'</form></div>';
echo '</td></tr>';
echo '<tr><td><div align="center"><button><a href="account_management.php?freeze_id=',$row['client_id'],'"><h2>凍結</h2></div></button></p></td></tr>';
echo '<tr><td><div align="center"><button><a href="account.php">戻る</a></button></div></td></tr>';
}
echo '</table>';
}else{
$sql = $pdo->prepare('select * from client where client_id = ?');
$sql ->execute([
    $_GET['client_id']
]);
echo '<table id="cate" align="center">';
foreach($sql as $row){
echo '<tr><td><h3>',$row['name'],'</h3></td></tr>';
echo'<form action="account_management.php" method="post">';
echo'<table align="center">';
echo'<tr><td><h2>ユーザープロフィール</h2></td></tr>';

echo'<tr><td>ユーザー名　　';
echo'<input type="text" align="center" name="name" value="',$row['name'],'">';
echo'</td></tr>';

echo'<tr><td>メールアドレス';
echo'<input type="text" name="address" value="',$row['client_address'],'">';
echo'</td></tr>';

echo'<tr><td>パスワード　　';
echo'<input type="text" name="password" value="',$row['password'],'">';
echo'</td></tr>';

echo '<tr><td>';
echo '<input type="hidden" name="id" value="',$row['client_id'],'">','</p>';
echo '</td></tr>';

echo '<tr><td><div align="center">';
echo '<input type="submit" value="更新">';
echo'</form></div>';
echo '</td></tr>';
echo '<tr><td><div align="center"><button><a href="account_management.php?freeze_id=',$row['client_id'],'"><h2>凍結</h2></div></button></p></td></tr>';
echo '<tr><td><div align="center"><button><a href="account.php">戻る</a></button></div></td></tr>';
}
echo '</table>';
}
}
}
?>
<?php require 'footer.php'; ?> 