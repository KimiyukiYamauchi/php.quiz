<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>学生データ一覧</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>学生データ一覧</h2>
    <p><a href="add.php">新規追加</a></p>
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
            echo "<tr><th>ID</th><th>名前</th><th>メールアドレス</th><th>性別</th><th>趣味</th><th>自己紹介</th><th>提出日時</th><th>操作</th></tr>";
            foreach ($students as $student) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($student['id']) . "</td>";
                echo "<td>" . htmlspecialchars($student['name']) . "</td>";
                echo "<td>" . htmlspecialchars($student['email']) . "</td>";
                echo "<td>" . htmlspecialchars($student['gender']) . "</td>";
                echo "<td>" . htmlspecialchars($student['hobbies']) . "</td>";
                echo "<td>" . nl2br(htmlspecialchars($student['introduction'])) . "</td>";
                echo "<td>" . htmlspecialchars($student['submitted_at']) . "</td>";
                echo "<td>
                        <a href='edit.php?id=" . htmlspecialchars($student['id']) . "'>編集</a> |
                        <a href='delete.php?id=" . htmlspecialchars($student['id']) . "' onclick=\"return confirm('本当に削除しますか？');\">削除</a>
                      </td>";
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
</body>
</html>
