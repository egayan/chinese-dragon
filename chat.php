<?php
session_start();
include('db_connect.php');

// ユーザーがログインしているか確認
if (!isset($_SESSION['customer']['id'])) {
    echo 'Not logged in';
    exit;
}

$user_id = $_SESSION['customer']['id'];

// 友達リストを取得
$friends = [];
$stmt = $pdo->prepare('SELECT c.client_id, c.name FROM friend f JOIN client c ON f.opponent_id = c.client_id WHERE f.client_id = ?');
$stmt->execute([$user_id]);
$friends = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>チャット</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
</head>
<body>
    <h1>チャット</h1>
    <div id="chatwrap" class="hidden">
        <div id="Log">
            <ul></ul>
        </div>
        <input type="text" id="str">
        <button id="button1">送信</button>
        <!-- 戻るボタンを追加 -->
        <button onclick="goBack()">戻る</button>
    </div>
    <div id="f3">
        <h2>友達を選択</h2>
        <button onclick="location.href='Top_kensakukekka.php'">Topに戻る</button>
        <ul>
            <?php foreach ($friends as $friend): ?>
                <li>
                    <a href="javascript:void(0);" class="select_friend" data-friend-id="<?php echo $friend['client_id']; ?>">
                        <?php echo htmlspecialchars($friend['name']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script>
        function goBack() {
            window.history.back();
        }

        $(document).ready(function(){
            $("#chatwrap").hide(); // 初回ロード時はチャット枠を非表示

            // 友達選択ボタンのクリックイベントを設定
            $(".select_friend").click(function(){
                var friendId = $(this).data('friend-id');
                $.cookie("CHAT_FRIEND", friendId, { expires: 7 });
                logAll(); // 選択された友達のログをロード
                $("#chatwrap").show(); // チャット枠を表示
                $("#f3").hide(); // 友達選択枠を非表示
            });

            $("#button1").click(function(){
                var message = $("#str").val();
                if(message.trim() !== ""){
                    $.ajax({
                        type: "POST",
                        url: "log.php",
                        data: {
                            type: "message",
                            friend_id: $.cookie("CHAT_FRIEND"),
                            message: message
                        },
                        success: function(response){
                            console.log("Message sent:", response);
                            $("#str").val(""); // テキストボックスをクリア
                            loadLog(); // ログを再読み込み
                        },
                        error: function(xhr, status, error){
                            console.error("Error occurred while sending message:", status, error);
                        }
                    });
                }
            });

            function logAll(){
                loadLog();
                setTimeout(function(){
                    logAll();
                }, 10000); // リロード時間はここで調整
            }

            function loadLog(){
                console.log("Loading log...");
                $('#Log ul').empty(); // 一旦空にする
                $.ajax({
                    async: false,
                    type: "POST",
                    url: "log.php",
                    data: {
                        type: "log",
                        friend_id: $.cookie("CHAT_FRIEND")
                    },
                    success: function(xml){
                        console.log("Log loaded:", xml);
                        $(xml).find("item").each(function(){
                            var chat = $(this).find("log").text();
                            var name = $(this).find("name").text();
                            var date = $(this).find("date").text();
                            console.log("Parsed log item:", name, chat, date);
                            $("<li></li>").html('<span style="color: #000;">' + name + '</span> <div class="log">' + chat + '</div> <div class="date">' + date + '</div>').appendTo("#Log ul");
                        });
                    },
                    error: function(xhr, status, error){
                        console.error("Error occurred while loading log:", status, error);
                    }
                });
            }
        });
    </script>
</body>
</html>
