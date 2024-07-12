// スレッドページでのポップアップ表示処理
document.addEventListener('DOMContentLoaded', function() {
    // 名前をクリックしたときの処理
    var nameLinks = document.querySelectorAll('.popupLink');
    nameLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            var clientId = link.getAttribute('data-client-id');
            var postId = link.getAttribute('data-post-id');
            var actionType = link.getAttribute('data-action-type');

            // ポップアップに情報をセット
            var overlay = document.getElementById('overlay');
            var popup = document.getElementById('popup');
            if (overlay && popup) {
                document.getElementById('clientIdField').value = clientId;
                document.getElementById('postIdField').value = postId;
                document.getElementById('actionTypeField').value = actionType;

                overlay.style.display = 'block';
                popup.style.display = 'block';
            } else {
                console.error('OverlayまたはPopupが見つかりません。');
            }
        });
    });

    // 通報するをクリックしたときの処理
    var reportLinks = document.querySelectorAll('.reportLink');
    reportLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            var clientId = link.getAttribute('data-client-id');
            var postId = link.getAttribute('data-post-id');

            // ポップアップに情報をセット
            var popup = document.getElementById('popup');
            var reportReason = document.getElementById('reportReason');
            if (popup && reportReason) {
                document.getElementById('clientIdField').value = clientId;
                document.getElementById('postIdField').value = postId;
                document.getElementById('actionTypeField').value = 'report';

                reportReason.style.display = 'block';
                popup.style.display = 'block';
                document.getElementById('popupActionButton').innerText = '通報する'; // ボタンのテキストを変更
            } else {
                console.error('PopupまたはReportReasonが見つかりません。');
            }
        });
    });

    // キャンセルボタンをクリックしたときの処理
    var popupCancelButton = document.getElementById('popupCancelButton');
    if (popupCancelButton) {
        popupCancelButton.addEventListener('click', function(event) {
            event.preventDefault();
            // ポップアップを非表示にする
            var overlay = document.getElementById('overlay');
            var popup = document.getElementById('popup');
            var reportReason = document.getElementById('reportReason');
            if (overlay) overlay.style.display = 'none';
            if (popup) popup.style.display = 'none';
            if (reportReason) reportReason.style.display = 'none'; // 通報理由入力欄も非表示にする
        });
    }

    // 実行ボタンをクリックしたときの処理
    var popupActionButton = document.getElementById('popupActionButton');
    if (popupActionButton) {
        popupActionButton.addEventListener('click', function(event) {
            event.preventDefault();
            var actionType = document.getElementById('actionTypeField').value;
            if (actionType === 'report') {
                var reason = document.getElementById('reportReasonField').value;
                // 通報する処理を実装する（Ajaxなどでサーバーに送信）
                // この部分はサーバー側の処理に依存します
                console.log('通報理由:', reason);
            } else {
                // 友達追加などの処理を実装する（Ajaxなどでサーバーに送信）
                // この部分はサーバー側の処理に依存します
            }

            function showPopup(clientId, postId, actionType) {
                var overlay = document.getElementById('overlay');
                var popup = document.getElementById('popup');
                var reportReason = document.getElementById('reportReason');
            
                // 要素の存在を確認
                if (overlay && popup && reportReason) {
                    document.getElementById('clientIdField').value = clientId;
                    document.getElementById('postIdField').value = postId;
                    document.getElementById('actionTypeField').value = actionType;
            
                    overlay.style.display = 'block';
                    popup.style.display = 'block';
            
                    // 通報する場合の処理
                    if (actionType === 'report') {
                        reportReason.style.display = 'block';
                        document.getElementById('popupActionButton').innerText = '通報する';
                    } else {
                        reportReason.style.display = 'none';
                        document.getElementById('popupActionButton').innerText = '実行';
                    }
                } else {
                    console.error('Overlay、Popup、またはReportReasonが見つかりません。');
                }
            }
            
            // 例: 名前をクリックした場合の処理
document.querySelectorAll('a[name="name"]').forEach(function(link) {
    link.addEventListener('click', function(event) {
        event.preventDefault();
        var clientId = this.getAttribute('data-client-id');
        var postId = this.getAttribute('data-post-id');
        showPopup(clientId, postId, 'addFriend');
    });
});

// 例: 通報するをクリックした場合の処理
document.querySelectorAll('a[name="report"]').forEach(function(link) {
    link.addEventListener('click', function(event) {
        event.preventDefault();
        var clientId = this.getAttribute('data-client-id');
        var postId = this.getAttribute('data-post-id');
        showPopup(clientId, postId, 'report');
    });
});

            
            // ポップアップを非表示にする
            var overlay = document.getElementById('overlay');
            var popup = document.getElementById('popup');
            var reportReason = document.getElementById('reportReason');
            if (overlay) overlay.style.display = 'none';
            if (popup) popup.style.display = 'none';
            if (reportReason) reportReason.style.display = 'none'; // 通報理由入力欄も非表示にする
        });
    }
});
