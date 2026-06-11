<?php
function str2html(string $string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

//db_open (まだローカル関数)
function db_open()
{
    $user = 'phpuser';
    $password = 'tojihina0622'; // 任意のパスワード
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
    ];

    $dbh = new PDO('mysql:host=localhost;dbname=sample_db;charset=utf8', $user, $password, $opt);
    return $dbh;
}
