<?php
$str = "12345678";
$rtn = preg_match('/\d{7}/u', $str, $match);
$str2 = "1234567あ";
$rtn2 = preg_match('/\d{7}/u', $str2, $match2);
$str3 = "111-1234567";
$rtn3 = preg_match('/\d{7}/u', $str3, $match3);

echo "結果1:<br>";
var_dump($rtn);
echo "<br>";
echo "結果2:<br>";
var_dump($rtn2);
echo "<br>";
echo "結果3:<br>";
var_dump($rtn3);
echo "<br>";
