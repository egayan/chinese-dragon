<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['customer']['id'])) {
    header('Location: login_input.php');
    exit;
}

$user_id = $_SESSION['customer']['id'];

// ユーザーの友達を取得
$stmt = $pdo->prepare('SELECT client.* FROM client JOIN friend ON client.client_id = friend.opponent_id WHERE friend.client_id = ?');
$stmt->execute([$user_id]);
$friends = $stmt->fetchAll();
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
    </div>
    <div id="f3">
        <h2>友達を選択</h2>
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
