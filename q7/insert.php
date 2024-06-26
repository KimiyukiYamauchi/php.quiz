<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>追加結果</title>
</head>
<body>
    <h2>追加結果</h2>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $errors = [];
        $valid_genders = ["男性", "女性", "その他"];
        $valid_hobbies = ["読書", "スポーツ", "音楽", "旅行"];

        // 入力値の検証
        if (empty($_POST['name'])) {
            $errors[] = "名前は必須項目です。";
        }
        if (empty($_POST['email'])) {
            $errors[] = "メールアドレスは必須項目です。";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "メールアドレスの形式が正しくありません。";
        }
        if (empty($_POST['gender'])) {
            $errors[] = "性別は必須項目です。";
        } elseif (!in_array($_POST['gender'], $valid_genders)) {
            $errors[] = "性別の選択が無効です。";
        }
        if (!isset($_POST['hobbies']) || count($_POST['hobbies']) == 0) {
            $errors[] = "少なくとも一つの趣味を選択してください。";
        } else {
            foreach ($_POST['hobbies'] as $hobby) {
                if (!in_array($hobby, $valid_hobbies)) {
                    $errors[] = "趣味の選択が無効です: " . htmlspecialchars($hobby);
                    break;
                }
            }
        }
        if (empty($_POST['introduction'])) {
            $errors[] = "自己紹介は必須項目です。";
        }

        // エラーがある場合はエラーを表示
        if (!empty($errors)) {
            echo "<h3>入力エラー:</h3><ul>";
            foreach ($errors as $error) {
                echo "<li>" . htmlspecialchars($error) . "</li>";
            }
            echo "</ul>";
        } else {
            // 入力値を取得
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $gender = htmlspecialchars($_POST['gender']);
            $hobbies = isset($_POST['hobbies']) ? implode(", ", $_POST['hobbies']) : "";
            $introduction = htmlspecialchars($_POST['introduction']);

            // データベース接続
            $dsn = 'mysql:host=localhost;dbname=q02;charset=utf8';
            $username = 'admin';
            $password = 'q02';

            try {
                $pdo = new PDO($dsn, $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // データの挿入
                $stmt = $pdo->prepare("INSERT INTO students (name, email, gender, hobbies, introduction) VALUES (:name, :email, :gender, :hobbies, :introduction)");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':gender', $gender);
                $stmt->bindParam(':hobbies', $hobbies);
                $stmt->bindParam(':introduction', $introduction);

                if ($stmt->execute()) {
                    echo "<p>データが正常に追加されました。</p>";
                    header("Location: index.php");
                    exit();
                } else {
                    echo "<p>データの追加に失敗しました。</p>";
                }
            } catch (PDOException $e) {
                echo "接続に失敗しました: " . $e->getMessage();
            }
        }
    } else {
        echo "<p>フォームからデータが送信されていません。</p>";
    }
    ?>
    <p><a href="index.php">戻る</a></p>
</body>
</html>
