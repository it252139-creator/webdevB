<?php
session_start();
$_SESSION['a']++; //インクリメント1ずつ増える
echo $_SESSION['a'];
