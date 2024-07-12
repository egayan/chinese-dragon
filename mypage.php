<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" name="viewport" content="width=device-width,initial-scale=1.0">
<title>チャットアプリ開発</title>
</head>
<body>
<?php require 'db_conect.php';?>
<?php
     $pdo=new PDO($connect,USER,PASS);
     $name = $_SESSION['customer']['name'];
    $address = $_SESSION['customer']['address'];
    $password = $_SESSION['customer']['password'];
     //$name=$address=$password='';
     /*if($_SERVER["REQUEST_METHOD"]=='POST'){
        if(isset($_SESSION['customer'])){
            $id=$_SESSION['customer']['id'];
            $sql=$pdo->prepare('update client set client_id=?, name=?, password=?,client_address=? where client_id=?');
            $pass=password_hash($_POST['password'],PASSWORD_DEFAULT);//ハッシュ化 
            $sql->execute([
                $id,
                $_POST['name'],$pass,
                $_POST['address'],$id
            ]);
            $_SESSION['customer']=[
                'id'=>$id,'name'=>$_POST['name'],
                'password'=>$pass,'address'=>$_POST['address'],
            ];
            echo 'お客様情報を更新しました。';    
        }
    }*/
    // 現在の値を取得
    if($_SERVER["REQUEST_METHOD"]=='POST'){
        if(isset($_SESSION['customer'])){
            $pass=password_hash($_POST['password'],PASSWORD_DEFAULT);
            $id=$_SESSION['customer']['id'];
            $sql_check = $pdo->prepare('SELECT name, password, client_address FROM client WHERE client_id = ?');
            $sql_check->execute([$id]);
            $row = $sql_check->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                // 現在の値と新しい値を比較して、異なる場合のみ更新する
                $update_needed = false;
                $update_values = [];

                if ($row['name'] != $name) {
                    $update_needed = true;
                    $update_values[] = $name;
                } else {
                    $update_values[] = $row['name']; // 現在の名前を使う
                }
                
                if ($row['password'] != $pass) {
                    $update_needed = true;
                    $update_values[] = $pass;
                } else {
                    $update_values[] = $row['password']; // 現在のパスワードを使う
                }

                if ($row['client_address'] != $_POST['address']) {
                    $update_needed = true;
                    $update_values[] = $_POST['address'];
                } else {
                    $update_values[] = $row['client_address']; // 現在のクライアントアドレスを使う
                }

                if ($update_needed) {
                    // 更新クエリを実行
                    $sql_update = $pdo->prepare('UPDATE client SET name = ?, password = ?, client_address = ? WHERE client_id = ?');
                    $update_values[] = $id; // WHERE 句の最後に client_id を追加
                    $sql_update->execute($update_values);
                    $_SESSION['customer']=[
                        'id'=>$update_values[0],'name'=>$update_values[1],
                        'password'=>$update_values[2],'address'=>$update_values[3],
                    ];
                } else {
                    // 何も更新しない場合の処理
                    echo "No changes to update.";
                }
            } else {
                // クライアントIDに対応する行が見つからない場合の処理
                echo "Client not found.";
            }

        }
    }
    

     if (isset($_SESSION['customer'])){
        $id=$_SESSION['customer']['id'];
         $name=$_SESSION['customer']['name'];
         $address=$_SESSION['customer']['address'];
         $password=$_SESSION['customer']['password'];
     }
         
         $pdo = new PDO($connect,USER,PASS);
         $sql = $pdo->prepare('select * from client where client_id = ?');
         $sql ->execute([
             $id
         ]);
         
         echo '<div align="center"><h1>マイページ</h1></div>'; 
         
         foreach($sql as $row){
         
         echo'<div align="center"><h2>ユーザープロフィール</h2><br></div>';
         echo'<form action="mypage_update.php" method="post" class="hidden">';

         echo  '<div class="D">プロフィール更新する</div>';
         echo'<p >ユーザーネーム</p>';
         echo '<div class="E">';
         echo '<input type="text" name="name" value="',$row['name'],'" placeholder="必須項目です" required> ';
         echo '</div>';       
         
         echo'<p>メールアドレス</p>';
         echo '<div class="E">';
         echo'<input type="text" name="address"value="',$row['client_address'],'" placeholder="必須項目です" required>';
         echo '</div>';

         echo'<p>パスワード　　</p>';
         echo '<div class="E">';
         echo'<input type="text" name="password" placeholder="必須項目です" required>';
         echo '</div>';

         echo '<input type="hidden" name="id" value="',$row['client_id'],'">';

         
         echo '<div class="E">';
         echo '<input type="submit" value="更新">';
         echo '</div>';

         echo'</form>';
         echo '<div align="center"><a href="thread-write.php">新規スレッド書き込み</a></div>';
         echo '<div align="center"><a href="login_input.php">ログアウト</a></div>';
         echo '<div align="center"><a href="account_delete_check.php?id=',$row['client_id'],'">アカウント削除</a></div>';
         
         }
         

    $client_id_thread = $pdo->prepare('select client_id from client where name=?');
    $client_id_thread->execute([$name]);
    $sql_thread = $pdo->prepare('select * from thread where client_id=?');
    foreach($client_id_thread as $myid){
    $sql_thread->execute([$myid['client_id']]);
    }
    $tr=0;
    echo '<div align="center">Myスレッド一覧</div>';
    echo '<table id="example" border="1">';
    
    echo '<tr>';
    foreach($sql_thread as $thread){
    echo '<td>';
    echo '<a href="thread.php?thread_id=',$thread['title'],'">',$thread['title'],'</a>';
    echo '</td>';
        $tr++;
        if($tr==3){
        echo '</tr>';
        $tr=0;
        echo '<tr>';
        }
    }
          
    echo '</tr><tr><td><div align="center"><a href="Top_kensakukekka.php">戻る</a></div></td></tr>';
    echo '</table>';
    ?> 
<script src="https://code.jquery.com/jquery.min.js"></script>
<script>
$(function() {
    $(".D").click(function() {
        $(".E").slideToggle("");
    });
});
</script>
<style>
.D{
    background: #b6beff;
    cursor: pointer;
    text-align:center;
    width: 200px;
    margin-right:auto;
    margin-left:auto;
}
.E{
    background: #ffaf74;
    height: 50px;
    display:none;
    text-align:center;
    width: 200px;
    margin-right:auto;
    margin-left:auto;
}
p{
  text-align:center;
}
#example{
    margin:auto;
}
</style>
            <?php require 'footer.php'; ?> 