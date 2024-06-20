<?php require './header.php'; ?>
<h2>名前検索</h2>
<?php require './header.php'; ?>
名前を入力してください。
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
<input type="text" name="keyword">
<input type="submit" value="検索">
</form>
<hr>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['keyword'])) {
    echo '<h2>検索結果</h2>' . PHP_EOL;
    // PDOでのデータベース接続設定
    $dsn = 'mysql:host=localhost;dbname=q02;charset=utf8';
    $username = 'admin';
    $password = 'q02';
    
    try {
        $pdo = new PDO($dsn, $username, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql=$pdo->prepare('select * from students where name like ?');
        if (mb_strlen($_POST['keyword']) > 0) {
            $ret = $sql->execute(['%' . $_POST['keyword']. '%']);
        } else {
            $ret = $sql->execute(['%']);
        }
    } catch (PDOException $e) {
        echo '接続に失敗しました: ' . $e->getMessage();
    }

    if ($ret) {
        if ($sql->rowCount() > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>名前</th><th>メールアドレス</th><th>性別</th><th>趣味</th><th>自己紹介</th><th>提出日時</th></tr>";
            while ($student = $sql->fetch()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($student['id']) . "</td>";
                echo "<td>" . htmlspecialchars($student['name']) . "</td>";
                echo "<td>" . htmlspecialchars($student['email']) . "</td>";
                echo "<td>" . htmlspecialchars($student['gender']) . "</td>";
                echo "<td>" . htmlspecialchars($student['hobbies']) . "</td>";
                echo "<td>" . nl2br(htmlspecialchars($student['introduction'])) . "</td>";
                echo "<td>" . htmlspecialchars($student['submitted_at']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo '<p>データは見つかりませんでした。</p>';
        }
    } else {
        echo '<p>検索に失敗しました。</p>';
    }
}
?>
<?php require './header.php'; ?>
