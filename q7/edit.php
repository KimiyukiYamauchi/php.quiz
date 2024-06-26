<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>学生データ編集</title>
</head>
<body>
    <h2>学生データ編集</h2>
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

        // データの取得
        $stmt = $pdo->prepare("SELECT * FROM students WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$student) {
            echo "<p>データが見つかりませんでした。</p>";
            exit;
        }
    } catch (PDOException $e) {
        echo "接続に失敗しました: " . $e->getMessage();
        exit;
    }
    ?>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($student['id']); ?>">

        <label for="name">名前:</label><br>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required><br><br>

        <label for="email">メールアドレス:</label><br>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required><br><br>

        <label>性別:</label><br>
        <input type="radio" id="male" name="gender" value="男性" <?php if ($student['gender'] == '男性') echo 'checked'; ?> required>
        <label for="male">男性</label><br>
        <input type="radio" id="female" name="gender" value="女性" <?php if ($student['gender'] == '女性') echo 'checked'; ?>>
        <label for="female">女性</label><br>
        <input type="radio" id="other" name="gender" value="その他" <?php if ($student['gender'] == 'その他') echo 'checked'; ?>>
        <label for="other">その他</label><br><br>

        <label>趣味:</label><br>
        <?php
        $hobbies = explode(", ", $student['hobbies']);
        $hobby_options = ["読書", "スポーツ", "音楽", "旅行"];
        foreach ($hobby_options as $hobby) {
            $checked = in_array($hobby, $hobbies) ? 'checked' : '';
            echo "<input type='checkbox' id='$hobby' name='hobbies[]' value='$hobby' $checked>";
            echo "<label for='$hobby'>$hobby</label><br>";
        }
        ?><br>

        <label for="introduction">自己紹介:</label><br>
        <textarea id="introduction" name="introduction" rows="4" cols="50"><?php echo htmlspecialchars($student['introduction']); ?></textarea><br><br>

        <input type="submit" value="更新">
    </form>
</body>
</html>
