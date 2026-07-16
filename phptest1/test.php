<?php
//1
$a = 5;
$b = 3;
echo $a + $b . "<br>";

//2
$name = "通事";
$name .= "さん、元気？";
echo $name . "<br>";

//3
$total = 1000;
echo $total * 0.1 + $total . "<br>";

//4
$score = rand(0, 100);
echo "スコア:" . $score;

if ($score >= 80) {
    echo "優" . "<br>";
} elseif ($score >= 60) {
    echo "良" . "<br>";
} else {
    echo "可" . "<br>";
}

//5
for ($i = 1; $i <= 100; $i++) {
    if ($i % 3 == 0) {
        echo $i . "<br>";
    }
}

//6
$person = ['name' => 'Taro', 'age' => 20];
foreach ($person as $key => $value) {
    echo $key . ':' . $value . '<br>';
}

//7
$users = [
    ['name' => 'Ken', 'age' => 20, 'score' => 85],
    ['name' => 'Yui', 'age' => 22, 'score' => 78],
    ['name' => 'Taro', 'age' => 19, 'score' => 55]
];
foreach ($users as $user) {
    if ($user['score'] >= 80) {
        $point = '優';
    } elseif ($user['score'] >= 60) {
        $point = '良';
    } else {
        $point = '可';
    }
    echo "名前:" . $user['name'] . "年齢" . $user['age'] . "歳" . "、" . "スコア:" . $user['score'] . "," . "判定:" . $point . "<br>";
}
?>


<?php
$score = rand(0, 100);
?>
スコア:<?= $score ?>

<?php if ($score >= 80) : ?>
    優
<?php elseif ($score >= 60) : ?>
    良
<?php else : ?>
    可
<?php endif; ?>



<?php
$name = $_POST['name'];
$comment = $_POST['comment'];

echo $name . "さんのコメント：" . $comment
?>