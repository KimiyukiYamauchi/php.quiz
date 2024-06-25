<?php require './header.php'; ?>
<h2>データの削除</h2>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // データベース接続
    $dsn = 'mysql:host=localhost;dbname=q02;charset=utf8';
    $username = 'admin';
    $password = 'q02';

    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 以下にデータ削除の処理を記述

    } catch (PDOException $e) {
        echo "接続に失敗しました: " . $e->getMessage();
    }

} else {
    echo "<p>フォームからデータが送信されていません。</p>";
}
?>
<?php require './footer.php'; ?>
