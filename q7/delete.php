<?php
if (!isset($_GET['id'])) {
    echo "<p>IDが指定されていません。</p>";
    exit;
}

// PDOでのデータベース接続設定
$dsn = 'mysql:host=localhost;dbname=q02;charset=utf8';
$username = 'admin';
$password = 'q02';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // データの削除
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = :id");
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "<p>データの削除に失敗しました。</p>";
    }
} catch (PDOException $e) {
    echo "接続に失敗しました: " . $e->getMessage();
}
?>
