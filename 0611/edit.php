<?php
require_once './functions.php';
//idをバリデーションして、通過したものだけ
if (empty($_GET['id'])) {
    echo 'idを指定してください。';
    exit;
}
if (!preg_match('/\A\d{1,11}+\z/u', $_GET['id'])) {
    echo 'idが正しくありません。';
    exit;
}

//整数型に変換
$id = (int)$_GET['id'];

$dbh = db_open();

//sql文を作った
$sql = "SELECT id, title, isbn, price, publish, author FROM books WHERE id = :id";
//sql文を実行した->返り値が$statementに入った
$stmt = $dbh->prepare($sql);

$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$result) {
    echo "指定されたデータはありません。";
    exit;
}

var_dump($result);

//取得したデータをフォームに配置
$title = str2html($result['title']);
$isbn = str2html($result['isbn']);
$price = str2html($result['price']);
$publish = str2html($result['publish']);
$author = str2html($result['author']);
$id = str2html($result['id']);

$html_form = <<<EOD
<form action="update.php" method="post">
  <p>
    <label for="title">書籍名</label>
    <input type="text" id="title" name="title" value="$title" required>
  </p>
  <p>
    <label for="isbn">ISBN</label>
    <input type="text" id="isbn" name="isbn" value="$isbn">
  </p>
  <p>
    <label for="price">価格</label>
    <input type="number" id="price" name="price" value="$price">
  </p>
  <p>
    <label for="publish">出版日</label>
    <input type="date" id="publish" name="publish" value="$publish">
  </p>
  <p>
    <label for="author">著者名</label>
    <input type="text" id="author" name="author" value="$author">
  </p>
  <p>
    <input type="hidden" name="id" value="$id">
  </p>
  <button type="submit">送信する</button>
</form>
EOD;
echo $html_form;
