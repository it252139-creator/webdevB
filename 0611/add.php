<?php
require_once './functions.php';

# 空欄チェック
if (empty($_POST['title'])) {
    echo 'タイトルは必須です。';
    exit;
}

# 文字数チェック
# uは、パターン修飾子で、Unicode文字を含む正規表現にマッチすることを示す
if (!preg_match('/\A[[:^cntrl:]]{1,200}\z/u', $_POST['title'])) {
    echo 'タイトルは200文字までです。';
    exit; //通らなかったらシャットダウン
}

# ISBN（13桁)チェック
if (!preg_match('/\A\d{0,13}\z/u', $_POST['isbn'])) {
    echo 'ISBNは数字13桁までです。';
    exit;
}

# 定価（6桁）チェック
if (!preg_match('/\A\d{0,6}\z/u', $_POST['price'])) {
    echo '定価は数字6桁までです。';
    exit;
}

# 日付必須チェック
if (empty($_POST['publish'])) {
    echo '日付は必須です。';
    exit;
}

# 出版日（yyyy-mm-dd）チェック
if (!preg_match('/\A\d{4}-\d{1,2}-\d{1,2}\z/u', $_POST['publish'])) {
    echo '日付のフォーマットが違います。';
    exit;
}
# 正しい日付チェック
$date = explode('-', $_POST['publish']);
if (!checkdate($date[1], $date[2], $date[0])) {
    echo '正しい日付を入力してください。';
    exit;
}

# 著者（80文字）チェック
if (!preg_match('/\A[[:^cntrl:]]{1,80}\z/u', $_POST['author'])) {
    echo '著者名は80文字以内で入力してください。';
    exit;
}



try {
    //返り値を持ったfunctions.php内のdb_open関数
    //関数の実行
    $dbh = db_open();

    //sql文を作った
    $sql = "INSERT INTO books (id, title, isbn, price,publish, author)
            VALUES (NULL, :title, :isbn, :price, :publish, :author)";
    //sql文を実行した->返り値が$statementに入った
    $stmt = $dbh->prepare($sql);

    //整数型に変換している。なぜ？　formから取得する値は、すべて文字列型
    $price = (int) $_POST['price'];
    $stmt->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
    $stmt->bindParam(':isbn', $_POST['isbn'], PDO::PARAM_STR);
    //ここだけ変換した変数を取得しています。
    $stmt->bindParam(':price', $price, PDO::PARAM_INT);
    $stmt->bindParam(':publish', $_POST['publish'], PDO::PARAM_STR);
    $stmt->bindParam(':author', $_POST['author'], PDO::PARAM_STR);

    $stmt->execute();
    echo "データが追加されました。";
    echo "<a href='list.php'>リストへ戻る</a>";
    var_dump($stmt);
} catch (PDOException $e) {
    echo "エラー！:" .  str2html($e->getMessage()) . "<br>";
    exit;
}
