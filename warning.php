<<<<<<< HEAD
<?php
session_start(); // セッションの開始
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <title>ご利用上の注意</title>
</head>
<body>
    <form action="Top_kensakukekka.php"method="post">
    <?php
    if(isset($_SESSION['customer'])){
        ?>
            <form action="Top_kensakukekka.php"method="post">
    <div class="container">
        <h1>当サイトのご利用上の注意</h1>
        <p>このサイトの利用には、以下の利用規約が適用されます。サイトを利用することで、これらの規約に同意したものとみなされます。</p>
        <p>当サイトは、ユーザーのプライバシー保護を重視しています。個人情報の収集、使用、保護に関するポリシーについて保護を重視しています。</p>
        <p>当サイトのコミュニティは、尊重、礼儀、公正な振る舞いを重んじます。差別、暴力的な言動、違法な行為は禁止されています。</p>
        <p>当サイトの提供する情報やサービスの正確性や完全性を保証するものではありません。当サイトの利用によって生じたいかなる損失や損害についても、当サイトは責任を負いません。</p>
        <p>サポートやお問い合わせについては、<a href="inquiry1.php">お問い合わせページ</a>からご連絡ください。</p>
        <button type="submit">戻る</button>
    </div>
    </form>
    <?php
    }else{
    ?>
    <form action="Top.php?gest=gest"method="post">
    <div class="container">
        <h1>当サイトのご利用上の注意</h1>
        <p>このサイトの利用には、以下の利用規約が適用されます。サイトを利用することで、これらの規約に同意したものとみなされます。
        <p>当サイトは、ユーザーのプライバシー保護を重視しています。個人情報の収集、使用、保護に関するポリシーについて保護を重視しています。</p>
        <p>当サイトのコミュニティは、尊重、礼儀、公正な振る舞いを重んじます。差別、暴力的な言動、違法な行為は禁止されています。</p>
        <p>当サイトの提供する情報やサービスの正確性や完全性を保証するものではありません。当サイトの利用によって生じたいかなる損失や損害についても、当サイトは責任を負いません。</p>
        <p>サポートやお問い合わせについては、<a href="inquiry1.php">お問い合わせページ</a>からご連絡ください。</p>
        <button type="submit">戻る</button>
    </div>
    </form>
<?php    
}
?>
</body>
</html>
=======
<?php
session_start(); // セッションの開始
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/warning.css">
    <title>ご利用上の注意</title>
</head>
<body>
    <?php
    if(isset($_SESSION['customer'])){
        ?>
            <form action="Top_kensakukekka.php"method="post">
    <div class="container">
        <h1>当サイトのご利用上の注意</h1>
        <p>このサイトの利用には、以下の利用規約が適用されます。サイトを利用することで、これらの規約に同意したものとみなされます。</p>
        <p>当サイトは、ユーザーのプライバシー保護を重視しています。個人情報の収集、使用、保護に関するポリシーについて保護を重視しています。</p>
        <p>当サイトのコミュニティは、尊重、礼儀、公正な振る舞いを重んじます。差別、暴力的な言動、違法な行為は禁止されています。</p>
        <p>当サイトの提供する情報やサービスの正確性や完全性を保証するものではありません。当サイトの利用によって生じたいかなる損失や損害についても、当サイトは責任を負いません。</p>
        <p>サポートやお問い合わせについては、<a href="inquiry.php">お問い合わせページ</a>からご連絡ください。</p>
        <button type="submit">戻る</button>
    </div>
    </form>
    <?php
    }else{
    ?>
    <form action="Top.php?gest=gest"method="post">
    <div class="container">
        <h1>当サイトのご利用上の注意</h1>
        <p>このサイトの利用には、以下の利用規約が適用されます。サイトを利用することで、これらの規約に同意したものとみなされます。
        <p>当サイトは、ユーザーのプライバシー保護を重視しています。個人情報の収集、使用、保護に関するポリシーについて保護を重視しています。</p>
        <p>当サイトのコミュニティは、尊重、礼儀、公正な振る舞いを重んじます。差別、暴力的な言動、違法な行為は禁止されています。</p>
        <p>当サイトの提供する情報やサービスの正確性や完全性を保証するものではありません。当サイトの利用によって生じたいかなる損失や損害についても、当サイトは責任を負いません。</p>
        <p>サポートやお問い合わせについては、<a href="inquiry.php">お問い合わせページ</a>からご連絡ください。</p>
        <button type="submit">戻る</button>
    </div>
    </form>
<?php    
}
?>
</body>
</html>
>>>>>>> 5e1ab1915062f0f93950b1ac0f78c800445274bc
