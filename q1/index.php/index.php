<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>数値計算フォーム</title>
</head>
<body>
    <?php
    if (isset($_POST['num1']) && isset($_POST['num2'])) {
        if (!is_numeric($_POST['num1']) || !is_numeric($_POST['num2'])) {
            $error = true;
        } else {
            $error = false;
        }
    } else {
        $error = false;
    }
    ?>
    <h1>数値計算フォーム</h1>
    <form method="post">
        <label for="num1">数値1:</label>
        <input type="text" id="num1" name="num1" value="<?php echo $error ?  htmlspecialchars($_POST['num1']) : '' ?>"><br><br>
        <label for="num2">数値2:</label>
        <input type="text" id="num2" name="num2" value="<?php echo $error ? htmlspecialchars($_POST['num2']) : '' ?>"><br><br>
        <input type="submit" value="計算">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $num1 = $_POST['num1'];
        $num2 = $_POST['num2'];

        if (!is_numeric($num1) || !is_numeric($num2)) {
            echo "<h2>入力が数値でないため、計算ができません</h2>";
        } else {

          // 数値に変換
          $num1 = (float)$num1;
          $num2 = (float)$num2;
  
          echo "<h2>計算結果</h2>";
  
          // 合計を計算
          $sum = $num1 + $num2;
          echo "和: $num1 + $num2 = $sum<br>";
  
          // 差を計算
          $diff = $num1 - $num2;
          echo "差: $num1 - $num2 = $diff<br>";
  
          // 積を計算
          $product = $num1 * $num2;
          echo "積: $num1 * $num2 = $product<br>";
  
          // 商を計算
          if ($num2 != 0) {
              $quotient = $num1 / $num2;
              echo "商: $num1 / $num2 = $quotient<br>";
          } else {
              echo "エラー: 0で割ることはできません<br>";
          }
        }
    }
    ?>
</body>
</html>
