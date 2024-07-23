document.addEventListener("DOMContentLoaded", function () {
    const popupLinks = document.querySelectorAll(".popupLink");
    const reportLinks = document.querySelectorAll(".reportLink");
    const overlay = document.getElementById("overlay");
    const popup = document.getElementById("popup");
    const clientIdField = document.getElementById("clientIdField");
    const postIdField = document.getElementById("postIdField");
    const actionTypeField = document.getElementById("actionTypeField");
    const reportReasonField = document.getElementById("reportReasonField");
    const popupMessage = document.getElementById("popupMessage");
    const reportReason = document.getElementById("reportReason");
    const popupActionButton = document.getElementById("popupActionButton");
    const popupCancelButton = document.getElementById("popupCancelButton");

    popupLinks.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            const clientId = this.getAttribute("data-client-id");
            const actionType = "add_friend";

            clientIdField.value = clientId;
            actionTypeField.value = actionType;
            popupMessage.innerText = "友達を追加しますか？";
            reportReason.style.display = "none";
            popup.style.display = "block";
            overlay.style.display = "block";
        });
    });

    reportLinks.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            const clientId = this.getAttribute("data-client-id");
            const postId = this.getAttribute("data-post-id");
            const actionType = "report";

            clientIdField.value = clientId;
            postIdField.value = postId;
            actionTypeField.value = actionType;
            popupMessage.innerText = "通報理由を入力してください：";
            reportReason.style.display = "block";
            popup.style.display = "block";
            overlay.style.display = "block";
        });
    });

    popupActionButton.addEventListener("click", function () {
        const clientId = clientIdField.value;
        const postId = postIdField.value;
        const actionType = actionTypeField.value;
        const reportReasonValue = reportReason.value;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "thread.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText); // JSONレスポンスをパース
                alert(response); // ここでレスポンスメッセージをアラートとして表示
                popup.style.display = "none";
                overlay.style.display = "none";
            }
        };

        let params = `client_id=${clientId}&action_type=${actionType}`;
        if (actionType === "report") {
            params += `&post_id=${postId}&report_reason=${encodeURIComponent(reportReasonValue)}`;
        }

        xhr.send(params);
    });

    popupCancelButton.addEventListener("click", function () {
        popup.style.display = "none";
        overlay.style.display = "none";
    });

    overlay.addEventListener("click", function () {
        popup.style.display = "none";
        overlay.style.display = "none";
    });
});
