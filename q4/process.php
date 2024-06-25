<?php require './header.php'; ?>
<h2>入力されたデータ</h2>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $errors = [];
  $valid_genders = ['男性', '女性', 'その他'];
  $valid_hobbies = ['読書', 'スポーツ', '音楽', '旅行'];

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
        $errors[] = "値が不正です（趣味）";
        break;
      }
    }
  }
  // if (empty($_POST['introduction'])) {
  //     $errors[] = "自己紹介は必須項目です。";
  // }

  // エラーがある場合はエラーを表示
  if (!empty($errors)) {
      echo "<h3>入力エラー:</h3><ul>";
      foreach ($errors as $error) {
          echo "<li>" . htmlspecialchars($error) . "</li>";
      }
      echo "</ul>";
  } else {
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
        $stmt = $pdo->prepare("INSERT INTO students (id, name, email, gender, hobbies, introduction, submitted_at) VALUES (null, :name, :email, :gender, :hobbies, :introduction, now())");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindParam(':hobbies', $hobbies, PDO::PARAM_STR);
        $stmt->bindParam(':introduction', $introduction, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "<p>データが正常に保存されました。</p>";
        } else {
            echo "<p>データの保存に失敗しました。</p>";
        }
    } catch (PDOException $e) {
        echo "接続に失敗しました: " . $e->getMessage();
    }

    // 入力データの表示
    echo "<p>名前: " . $name . "</p>";
    echo "<p>メールアドレス: " . $email . "</p>";
    echo "<p>性別: " . $gender . "</p>";
    echo "<p>趣味: " . $hobbies . "</p>";
    echo "<p>自己紹介: " . nl2br($introduction) . "</p>";
  }
} else {
    echo "<p>フォームからデータが送信されていません。</p>";
}
?>
<?php require './footer.php'; ?>
