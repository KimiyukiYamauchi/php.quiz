<?php require './header.php'; ?>
<h2>学生データ一覧</h2>
<?php
// PDOでのデータベース接続設定
$dsn = 'mysql:host=localhost;dbname=q02;charset=utf8';
$username = 'admin';
$password = 'q02';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // データの取得
    $stmt = $pdo->query("SELECT * FROM students");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($students) {
        echo "<table>";
        echo "<tr><th>ID</th><th>名前</th><th>メールアドレス</th><th>性別</th><th>趣味</th><th>自己紹介</th><th>提出日時</th></tr>";
        foreach ($students as $student) {
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
        echo "<p>データが見つかりませんでした。</p>";
    }
} catch (PDOException $e) {
    echo "接続に失敗しました: " . $e->getMessage();
}
?>
<?php require './header.php'; ?>
