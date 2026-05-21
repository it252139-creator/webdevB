<?php
//htmlspecialchars1.php
echo "<s>test</s><br>" . PHP_EOL;
echo htmlspecialchars("<s>test</s><br>", ENT_QUOTES, 'UTF-8');

//htmlspecialchars2.php
echo htmlspecialchars($_POST['a'], ENT_QUOTES, 'UTF-8');
//echo $_POST['a'];
