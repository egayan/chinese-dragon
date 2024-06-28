<?php
require 'db-connect.php';
try {
    $conn = new PDO($connect, USER, PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 通報データを取得するSQL
    $sql = "SELECT report_reason, suspect_id FROM report ORDER BY date DESC";
    $result = $conn->query($sql);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <link rel="stylesheet" type="text/css" href="css/Report_Receive.css">
    <meta charset="UTF-8">
    <title>通報受け取り一覧</title>
</head>
<body>
    <div class="container">
        <h1>通報受け取り一覧</h1>
        <?php
        // 通報データを表示する
        if ($result->rowCount() > 0) {
            echo "<table class='report-table'>";
            echo "<tr><th>Report Reason</th><th>Suspect ID</th></tr>";
            
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td><a class='report-link' href='account_management'>" . htmlspecialchars($row["report_reason"]) . "</a></td>";
                echo "<td><a class='report-link' href='account_management?client_id=" . htmlspecialchars($row["suspect_id"]) . "'>" . htmlspecialchars($row["suspect_id"]) . "</a></td>";
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "<p>No reports found.</p>";
        }
        ?>
    <form action="Management_Top.php" method="post">
    <button type="submit">戻る</button>
</div>
</body>
</html>
</form>