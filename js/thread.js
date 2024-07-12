    document.addEventListener('DOMContentLoaded', function() {
        const overlay = document.getElementById('overlay');
        const popup = document.getElementById('popup');
        const confirmationPopup = document.getElementById('confirmationPopup');
    
        function showPopup(clientId, postId, message, actionType) {
            document.getElementById('clientIdField').value = clientId;
            document.getElementById('postIdField').value = postId;
            document.getElementById('actionTypeField').value = actionType;
    
            if (actionType === 'report') {
                document.getElementById("reasonInput").style.display = "block";
            } else {
                document.getElementById("reasonInput").style.display = "none";
            }
    
            document.getElementById("popupMessage").innerText = message;
            overlay.style.display = "block";
            popup.style.display = "block";
        }
    
        function closePopup() {
            overlay.style.display = "none";
            popup.style.display = "none";
        }
    
        function showConfirmation() {
            if (document.getElementById("actionTypeField").value === 'report') {
                var reason = document.getElementById("reportReason").value;
                if (!reason) {
                    alert("通報理由を入力してください");
                    return;
                }
                document.getElementById("reportReasonField").value = reason;
            }
    
            popup.style.display = "none";
            confirmationPopup.style.display = "block";
            document.getElementById("confirmationMessage").innerText = "この操作を実行しますか？";
        }
    
        function closeConfirmationPopup() {
            confirmationPopup.style.display = "none";
            overlay.style.display = "none";
        }
    
        function performAction() {
            const clientId = document.getElementById("clientIdField").value;
            const postId = document.getElementById("postIdField").value;
            const actionType = document.getElementById("actionTypeField").value;
            let data = {
                clientId: clientId,
                postId: postId,
                actionType: actionType
            };
    
            if (actionType === 'addFriend') {
                fetch('thread.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("友達を追加しました！");
                    } else {
                        alert(data.message || "友達追加に失敗しました！");
                    }
                    closeConfirmationPopup();
                })
                .catch(error => console.error('Error:', error));
            } else if (actionType === 'report') {
                data.reason = document.getElementById("reportReason").value;
    
                fetch('thread.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("通報しました！");
                    } else {
                        alert(data.message || "通報に失敗しました！");
                    }
                    closeConfirmationPopup();
                })
                .catch(error => console.error('Error:', error));
            }
        }
    
        window.showPopup = showPopup;
        window.closePopup = closePopup;
        window.showConfirmation = showConfirmation;
        window.closeConfirmationPopup = closeConfirmationPopup;
        window.performAction = performAction;
    
        var popupLinks = document.querySelectorAll('.popupLink');
        popupLinks.forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                var clientId = this.getAttribute('data-client-id');
                var postId = this.getAttribute('data-post-id');
                var message = this.getAttribute('data-message');
                var actionType = this.getAttribute('data-action-type');
                showPopup(clientId, postId, message, actionType);
            });
        });
    
        var reportLinks = document.querySelectorAll('.reportLink');
        reportLinks.forEach(function(link) {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                var clientId = this.getAttribute('data-client-id');
                var postId = this.getAttribute('data-post-id');
                var message = 'この投稿を通報しますか？';
                var actionType = 'report';
                showPopup(clientId, postId, message, actionType);
            });
        });
    
        document.getElementById("popupActionButton").addEventListener("click", function() {
            showConfirmation();
        });
    
        document.getElementById("popupCancelButton").addEventListener("click", function() {
            closePopup();
        });
    
        document.getElementById("confirmActionButton").addEventListener("click", function() {
            performAction();
        });
    
        document.getElementById("confirmCancelButton").addEventListener("click", function() {
            closeConfirmationPopup();
        });
    });
    