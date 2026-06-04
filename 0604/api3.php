<?php
if (!isset($_GET['zip'])) {
    echo "郵便番号がセットされていません。";
    exit;
}

$rtn = preg_match('/\A\d{7}\z/u', $_GET["zip"]);
if (!$rtn) {
    echo "郵便番号は数字7桁で入力してください。";
    exit;
}


$url = "https://zipcloud.ibsnet.co.jp/api/search?zipcode=" . $_GET["zip"];
$response = file_get_contents($url);
$response = json_decode($response, true);

if (empty($response["results"])) {
    echo "住所が見つかりませんでした。";
    exit;
}
echo "<ul>";
echo "<li>" . "入力された郵便番号: " . $_GET["zip"] . "</li>";
echo "<li>" . $response["results"][0]["address1"] . "</li>";
echo "<li>" . $response["results"][0]["address2"] . "</li>";
echo "<li>" . $response["results"][0]["address3"] . "</li>";
echo "</ul>";
echo "の住所です。" . "<br>";
var_dump($response);
