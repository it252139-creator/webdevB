<?php
require_once  '../functions.php';
try {
    # connect1.php
    $user = 'phpuser';
    $password = 'tojihina0622'; // 任意のパスワード
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
    ];

    $dbh = new PDO('mysql:host=localhost;dbname=sample_db;charset=utf8', $user, $password, $opt);
    //sql文を作った
    $sql = 'SELECT title, author FROM books';
    //sql文を実行した->返り値が$statementに入った
    $statment = $dbh->query($sql);

    //while(ここがtureのとき)ずっとループする
    while ($row = $statment->fetch()) {
        echo '書籍名：' . str2html($row[0]) . '<br>';
        echo '著者名：' . str2html($row[1]) . '<br><br>';
    }

    var_dump($statment);
} catch (PDOException $e) {
    echo "エラー！:" .  str2html($e->getMessage()) . "<br>";
    exit;
}
