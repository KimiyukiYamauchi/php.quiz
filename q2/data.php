<?php
// PDOでのデータベース接続設定
$dsn = 'mysql:host=localhost;dbname=q02;charset=utf8';
$username = 'admin';
$password = 'q02';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // サンプルデータの生成
    $names = ["佐藤 太郎", "鈴木 次郎", "高橋 三郎", "田中 四郎", "伊藤 五郎", 
              "渡辺 六郎", "山本 七郎", "中村 八郎", "小林 九郎", "加藤 十郎", 
              "吉田 十一郎", "山田 十二郎", "佐々木 十三郎", "松本 十四郎", 
              "井上 十五郎", "木村 十六郎", "林 十七郎", "斉藤 十八郎", 
              "清水 十九郎", "坂本 二十郎"];
    $emails = ["taro@example.com", "jiro@example.com", "saburo@example.com", 
               "shiro@example.com", "goro@example.com", "rokuro@example.com", 
               "shichiro@example.com", "hachiro@example.com", "kuro@example.com", 
               "juro@example.com", "juichiro@example.com", "juniro@example.com", 
               "jusaburo@example.com", "jushiro@example.com", "jugoro@example.com", 
               "jurkuro@example.com", "jushichiro@example.com", "juhachiro@example.com", 
               "jukuro@example.com", "nijuro@example.com"];
    $genders = ["男性", "女性", "その他"];
    $hobbies_options = ["読書", "スポーツ", "音楽", "旅行"];
    $introductions = ["私は学生です。", "趣味は読書です。", "スポーツが好きです。", 
                      "音楽が好きです。", "旅行が好きです。", "映画鑑賞が好きです。", 
                      "ゲームが好きです。", "プログラミングが好きです。", 
                      "料理が好きです。", "写真が好きです。", "散歩が好きです。", 
                      "ランニングが好きです。", "サイクリングが好きです。", 
                      "登山が好きです。", "水泳が好きです。", "釣りが好きです。", 
                      "キャンプが好きです。", "ダンスが好きです。", "ボードゲームが好きです。", 
                      "旅行が好きです。"];

    // データの挿入
    $stmt = $pdo->prepare("INSERT INTO students (name, email, gender, hobbies, introduction) VALUES (:name, :email, :gender, :hobbies, :introduction)");

    for ($i = 0; $i < 20; $i++) {
        $name = $names[$i];
        $email = $emails[$i];
        $gender = $genders[array_rand($genders)];
        $arr = array_rand( array_flip($hobbies_options), rand(2, 4));
        $hobbies = implode(", ", $arr);
        // var_dump($hobbies);
        $introduction = $introductions[array_rand($introductions)];

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':hobbies', $hobbies);
        $stmt->bindParam(':introduction', $introduction);

        $stmt->execute();
    }

    echo "サンプルデータが正常に追加されました。";
} catch (PDOException $e) {
    echo "接続に失敗しました: " . $e->getMessage();
}
?>
