<?php
require_once __DIR__ . '/login_check.php'; // ログインチェック※既に設置済み
//session_start(); //いらないかも。
$token = bin2hex(random_bytes(20));
$_SESSION['token'] = $token;
?>

<?php require_once __DIR__ . '/login_check.php'; ?>

<?php include __DIR__ . '/inc/header.php'; ?>
<form action="add.php" method="post">
    <p>
        <label for="title">タイトル（必須：200文字まで）：</label>
        <input type="text" id="title" name="title" required value="テスト書籍名">
    </p>
    <p>
        <label for="isbn">ISBN（13桁までの数字）：</label>
        <input type="text" id="isbn" name="isbn" value="0123456789012" />
    </p>
    <p>
        <label for="price">定価（6桁までの数字）：</label>
        <input type="number" id="price" name="price" value="2600" />
    </p>
    <p>
        <label for="publish">出版日：</label>
        <input type="date" id="publish" name="publish" value="2024-02-28" />
    </p>
    <p>
        <label for="author">著者（80文字まで）：</label>
        <input type="text" id="author" name="author" value="柏岡" />
    </p>
    <input type="hidden" name="token" value="<?php //echo $token; 
                                                ?>" />
    <!-- buttonの前に置きます。 -->
    <button type="submit">送信する</button>
</form>
<p style="text-align: center; margin-top: 20px;">
    <a href="index.php">リストに戻る</a>
</p>

<?php include __DIR__ . '/inc/footer.php'; ?>