<?php session_start(); ?>
<?php require 'header.php'; ?>
      
<?php require 'db_conect.php';?>
<?php
     $pdo=new PDO($connect,USER,PASS);
     $name=$address=$password='';
     if($_SERVER["REQUEST_METHOD"]=='POST'){
        if(isset($_SESSION['customer'])){
            $id=$_SESSION['customer']['id'];
            $sql=$pdo->prepare('update client set name=?, password=?,client_address=? where client_id=?');
            $sql->execute([
                $_POST['name'],$_POST['password'],
                $_POST['address'],$id
            ]);
            $_SESSION['customer']=[
                'id'=>$id,'name'=>$_POST['name'],
                'password'=>$_POST['password'],'address'=>$_POST['address'],
            ];
            echo 'お客様情報を更新しました。';    
        }
    }
     if (isset($_SESSION['customer'])){
        $id=$_SESSION['customer']['id'];
         $name=$_SESSION['customer']['name'];
         $address=$_SESSION['customer']['address'];
         $password=$_SESSION['customer']['password'];
     }
         
         $pdo = new PDO($connect,USER,PASS);
         //登録に必要な情報はまだ決めていないので仮入力
         $sql = $pdo->prepare('select * from client where client_id = ?');
         $sql ->execute([
             $_SESSION['customer']['id']
         ]);
         echo '<table id="cate" align="center">';
         echo '<tr><td><div align="center"><h1>マイページ</h1></div></td></tr>'; 
         foreach($sql as $row){
         echo'<form action="mypage.php" method="post">';
         echo'<table align="center">';
         echo'<tr><td><div align="center"><h2>ユーザープロフィール</h2></div></td></tr>';
         
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
         
         echo '<tr><td><div align="center"><button><a href="*">投稿</a></button></div></td></tr>';
         echo '<tr><td><div align="center"><button><a href="login_input.php">ログアウト</a></button></div></td></tr>';
         echo '<tr><td><div align="center"><button><a href="account_delete_check.php?id=',$row['client_id'],'">アカウント削除</a></button></div></td></tr>';
         echo '</table>';
         }
    
    $id = $pdo->prepare('select client_id from client where name=?');
    $id->execute([$name]);
    $sql = $pdo->prepare('select * from thread where client_id=?');
    foreach($id as $myid){
    $sql->execute([$myid['client_id']]);
    }
    $tr=0;
    echo '<table align="center">';
    echo '<tr><td>Myスレッド一覧</td></tr>';
    echo '<tr>';
    foreach($sql as $row){
    echo '<td>';
    echo '<a href="partner.php?genre=',$row['title'],'">',$row['title'],'</a>';
    echo '</td>';
        $tr++;
        if($tr==3){
        echo '</tr>';
        $tr=0;
        echo '<tr>';
        }
    }
          
    echo '<tr><td><div align="center"><button><a href="Top_kensakukekka.php">戻る</a></button></div></td></tr>';
    echo '</table>';
    ?> 
            <?php require 'footer.php'; ?> 