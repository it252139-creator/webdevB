<?php
$users = [
    ['name' => '佐藤', 'age' => 25],
    ['name' => '田中', 'age' => 30],
];
#  1. 上記の配列をすべて表示してください。
foreach ($users as $array) {
    var_dump($array);
}
#  2. 各ユーザーの「名前は○○さん、年齢は○○歳です」と表示してください。
foreach ($users as $array) {
    echo '名前は' . $array['name'] . 'さん、年齢は' . $array['age'] . 'です。<br>';
}

$numbers = [
    [1, 2],
    [3, 4],
];
#  3. 配列内の全ての数字を合計して出力してください。
$total = 0;
foreach ($numbers as $row) {
    foreach ($row as $number) {
        $total += $number;
    }
}
echo $total;

$prefectures = [
    '東京' => ['新宿', '渋谷', '池袋'],
    '大阪' => ['梅田', '難波', '天王寺'],
];
#  4. 都道府県ごとの市区町村名をすべて出力してください。
foreach ($prefectures as $prefectures => $cities) {
    echo $prefectures . "<br>";
    foreach ($cities as $city) {
        echo $city . "<br>";
    }
}

$matrix = [
    [1, 5, 7],
    [3, 8, 2],
];
#  5. 上記の配列の中から、値が5以上のものだけ表示してください。
foreach ($matrix as $row) {
    foreach ($row as $num) {
        if ($num >= 5) {
            echo $num . "<br>";
        }
    }
}
