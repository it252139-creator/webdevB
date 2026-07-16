<?php
// index.php
session_start();
require_once __DIR__ . '/inc/functions.php';
include __DIR__ . '/inc/header.php';
?>
<article class="movie">
    <video src="videos/sample.mp4" controls poster="videos/sample.jpg"></video>
    <h2 class="movie__title">あんなこんなを撮ってみた パート1</h2>
    <p class="movie__channel">annakona.TV</p>
</article>

<section class="comments">
    <h2 class="comments__count">0件のコメント</h2>
    <!-- ステップ②でここに投稿フォームと一覧を追加 -->
    <?php $dbh = db_open();

    // 投稿一覧を、投稿者のユーザー情報と一緒に取得
    $sql = '
  SELECT posts.*, users.username, users.icon_path, users.color,
    (SELECT COUNT(*) FROM replies WHERE replies.post_id = posts.id) AS reply_count,
    (SELECT COUNT(*) FROM likes   WHERE likes.post_id   = posts.id AND type = "good") AS good_count
  FROM posts
  JOIN users ON posts.user_id = users.id
  ORDER BY posts.created_at DESC
';
    $posts = $dbh->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    $total = count($posts);
    $replySql = '
  SELECT replies.*, users.username, users.icon_path, users.color
  FROM replies
  JOIN users ON replies.user_id = users.id
  WHERE replies.post_id = :p
  ORDER BY replies.created_at ASC
';
    $replyStmt = $dbh->prepare($replySql);

    foreach ($posts as &$post) {
        $replyStmt->execute([':p' => $post['id']]);
        $post['replies'] = $replyStmt->fetchAll(PDO::FETCH_ASSOC);
    }
    unset($post);



    // CSRFトークン（投稿フォーム用）
    $token = bin2hex(random_bytes(20));
    $_SESSION['token'] = $token;
    ?>
    <h2 class="comments__count"><?= $total ?>件のコメント</h2>

    <?php if (!empty($_SESSION['login'])): ?>
        <form method="post" action="post_add.php" class="comment-form">
            <input type="hidden" name="token" value="<?= str2html($token) ?>">
            <textarea name="content" required placeholder="コメントを入力"></textarea>
            <button type="submit">投稿する</button>
        </form>
    <?php else: ?>
        <p><a href="login.php">ログイン</a>するとコメントできます。</p>
    <?php endif; ?>

    <ul class="comment-list">
        <?php foreach ($posts as $post): ?>
            <li class="comment">
                <?= render_icon($post) ?>
                <div class="comment__body">
                    <p class="comment__meta">
                        <strong>@<?= str2html($post['username']) ?></strong>
                        <time><?= str2html($post['created_at']) ?></time>
                    </p>
                    <p class="comment__text"><?= nl2br(str2html($post['content'])) ?></p>

                    <p class="comment__actions">
                        <?php if (!empty($_SESSION['login'])): ?>
                    <form method="post" action="reaction.php" class="inline">
                        <input type="hidden" name="token" value="<?= str2html($token) ?>">
                        <input type="hidden" name="post_id" value="<?= (int)$post['id'] ?>">
                        <input type="hidden" name="type" value="good">
                        <button type="submit">👍 <?= (int)$post['good_count'] ?></button>
                    </form>
                    <form method="post" action="reaction.php" class="inline">
                        <input type="hidden" name="token" value="<?= str2html($token) ?>">
                        <input type="hidden" name="post_id" value="<?= (int)$post['id'] ?>">
                        <input type="hidden" name="type" value="bad">
                        <button type="submit">👎</button>
                    </form>
                <?php else: ?>
                    <span>👍 <?= (int)$post['good_count'] ?></span>
                    <span>👎</span>
                <?php endif; ?>

                <?php if ((int)$post['reply_count'] > 0): ?>
                    <button type="button" class="reply-toggle"
                        data-target="replies-<?= (int)$post['id'] ?>">
                        <?= (int)$post['reply_count'] ?>件の返信を表示
                    </button>
                <?php endif; ?>

                <?php if (!empty($_SESSION['login']) && (int)$_SESSION['user_id'] === (int)$post['user_id']): ?>
                    <form method="post" action="post_delete.php" class="inline"
                        onsubmit="return confirm('削除しますか？');">
                        <input type="hidden" name="token" value="<?= str2html($token) ?>">
                        <input type="hidden" name="post_id" value="<?= (int)$post['id'] ?>">
                        <button type="submit">削除</button>
                    </form>
                <?php endif; ?>
                </p>

                <div id="replies-<?= (int)$post['id'] ?>" class="replies hidden">
                    <ul class="reply-list">
                        <?php foreach ($post['replies'] as $r): ?>
                            <li class="reply">
                                <?= render_icon($r) ?>
                                <div>
                                    <p class="comment__meta">
                                        <strong>@<?= str2html($r['username']) ?></strong>
                                        <time><?= str2html($r['created_at']) ?></time>
                                    </p>
                                    <p class="comment__text"><?= nl2br(str2html($r['content'])) ?></p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <?php if (!empty($_SESSION['login'])): ?>
                        <form method="post" action="reply_add.php" class="reply-form">
                            <input type="hidden" name="token" value="<?= str2html($token) ?>">
                            <input type="hidden" name="post_id" value="<?= (int)$post['id'] ?>">
                            <textarea name="content" required placeholder="返信を入力"></textarea>
                            <button type="submit">返信する</button>
                        </form>
                    <?php endif; ?>
                </div>
                </div>
            </li>

        <?php endforeach; ?>
    </ul>
</section>
<?php include __DIR__ . '/inc/footer.php'; ?>