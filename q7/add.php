<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>学生データ追加</title>
</head>
<body>
    <h2>学生データ追加</h2>
    <form action="insert.php" method="post">
        <label for="name">名前:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">メールアドレス:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label>性別:</label><br>
        <input type="radio" id="male" name="gender" value="男性" required>
        <label for="male">男性</label><br>
        <input type="radio" id="female" name="gender" value="女性">
        <label for="female">女性</label><br>
        <input type="radio" id="other" name="gender" value="その他">
        <label for="other">その他</label><br><br>

        <label>趣味:</label><br>
        <input type="checkbox" id="reading" name="hobbies[]" value="読書">
        <label for="reading">読書</label><br>
        <input type="checkbox" id="sports" name="hobbies[]" value="スポーツ">
        <label for="sports">スポーツ</label><br>
        <input type="checkbox" id="music" name="hobbies[]" value="音楽">
        <label for="music">音楽</label><br>
        <input type="checkbox" id="travel" name="hobbies[]" value="旅行">
        <label for="travel">旅行</label><br><br>

        <label for="introduction">自己紹介:</label><br>
        <textarea id="introduction" name="introduction" rows="4" cols="50"></textarea><br><br>

        <input type="submit" value="追加">
    </form>
</body>
</html>
