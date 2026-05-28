<?php
require_once '../functions.php';
$fp = fopen("songs.csv", "r");
if ($fp === false) {
    echo "ファイルのオープンに失敗しました。";
    exit;
}

//fromからの値取得
$keyword = $_POST['keyword'];
var_dump($keyword . "<br>");

$found = false;

while ($row = fgetcsv($fp)) {
    //var_dump($row);
    if (strpos($row[0], $keyword) !== false || strpos($row[1], $keyword) !== false) {
        $found = true;
        echo "曲名:" . $row[0] . "<br>";
        echo "アーティスト名:" . $row[1] . "<br>";
        echo "ジャンル:" . $row[2] . "<br>";
        echo "リリース年:" . $row[3] . "<br>";
        echo "メモ:" . $row[4] . "<br>";
    }
}

if (!$found) {
    echo "検索結果がありません。";
}

fclose($fp);
