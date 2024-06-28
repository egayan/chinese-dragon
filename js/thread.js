    // ポップアップを開く
    function openPopup(clientId, postId, message, actionType) {
        document.getElementById("overlay").style.display = "block";
        document.getElementById("popup").style.display = "block";
        document.getElementById("popup").setAttribute('data-client-id', clientId);
        document.getElementById("popup").setAttribute('data-post-id', postId); // 追加
        document.getElementById("popupMessage").innerText = message;
        document.getElementById("actionTypeField").value = actionType;

        if (actionType === 'report') {
            document.getElementById("reasonInput").style.display = "block";
        } else {
            document.getElementById("reasonInput").style.display = "none";
        }
    }

    // ポップアップを閉じる
    function closePopup() {
        document.getElementById("overlay").style.display = "none";
        document.getElementById("popup").style.display = "none";
    }

    // 確認ポップアップを開く
    function showConfirmation(){
        if (document.getElementById("actionTypeField").value === 'report') {
            var reason = document.getElementById("reportReason").value;
            if (!reason) {
                alert("通報理由を入力してください");
                return;
            }
            document.getElementById("reportReasonField").value = reason;
        }

        document.getElementById("popup").style.display = "none";
        document.getElementById("confirmationPopup").style.display = "block";
        document.getElementById("confirmationMessage").innerText = "この操作を実行しますか？";
    }

    // 確認ポップアップを閉じる
    function closeConfirmationPopup() {
        document.getElementById("confirmationPopup").style.display = "none";
        document.getElementById("overlay").style.display = "none";
    }

    // ポップアップアクションを実行する
    function performAction() {
        var clientId = document.getElementById("popup").getAttribute('data-client-id');
        var postId = document.getElementById("popup").getAttribute('data-post-id'); // 追加
        document.getElementById("clientIdField").value = clientId;
        document.getElementById("postIdField").value = postId; // 追加
        document.getElementById("popupForm").submit();
    }

    // ポップアップを表示するリンクをクリックしたときの処理
    var popupLinks = document.querySelectorAll('.popupLink');
    popupLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            var clientId = this.getAttribute('data-client-id');
            var postId = this.getAttribute('data-post-id'); // 追加
            openPopup(clientId, postId, '友達追加しますか？', 'add_friend');
        });
    });

    var reportLinks = document.querySelectorAll('.reportLink');
    reportLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            var clientId = this.getAttribute('data-client-id');
            var postId = this.getAttribute('data-post-id'); // 追加
            openPopup(clientId, postId, 'この投稿を通報しますか？', 'report');
        });
    });

    