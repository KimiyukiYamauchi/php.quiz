<?php require './header.php'; ?>
<h2>データの削除</h2>
<?php
// データベース接続
$dsn = 'mysql:host=localhost;dbname=q02;charset=utf8';
$username = 'admin';
$password = 'q02';
$ret = false;

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql=$pdo->prepare('delete from students where id= :id');
    $sql->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $ret = $sql->execute();
    
} catch (PDOException $e) {
    echo "接続に失敗しました: " . $e->getMessage();
}
if ($ret) {
    echo '削除に成功しました。';
} else {
    echo '削除に失敗しました。';
}
?>
<?php require './footer.php'; ?>
