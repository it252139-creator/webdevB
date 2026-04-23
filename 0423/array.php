<?php
$a = [" 田中", "井上"];
echo $a[0]; // 田中

$name = [
    'satou' => '佐藤',
    'suzuki' => '鈴木',
    'takahashi' => '高橋'
];
echo $name['takahashi']; // 高橋
//var_dumpは値を全部表示する
//var_dump($name);

//自動的に要素の数だけループします。
//ループすると、配列の要素がそれぞれasのあとの変数に代入されます
//処理がループの数だけ実行される
foreach ($name as $value) {
    echo '名前は' . $value . "<br>";
}

//キーを扱う場合の書き方
foreach ($name as $key => $value) {
    echo 'キーは' . $key . '、名前は' . $value . "<br>";
}

$people[0] = '亀頭';
$people[1] = '森';
$people[2] = '棚橋';

foreach ($people as $key => $value) {
    echo 'キーは' . $key . '、名前は' . $value . '<br>';
}

$a = ['A', 'B', 'C'];
var_dump($a);

$b[] = 'C';
$b[] = 'D';
$b[] = 'E';
var_dump($b);

$c = array('E', 'F', 'G');
//近年では[]を使った配列の書き方が一般的
