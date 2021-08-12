<?php include(dirname(__FILE__).'/assets/_inc/header.php'); ?>

<?php

if($_POST['submit']){
    $comment = $_POST['comment'];
    $thread_id = $_SESSION['thread_id'];

    // セッションから、ユーザー情報を取得
    $user_id = $_SESSION['user_id'];

    // DBアクセス
    $dbh = database_access();

    // 
    $sql = "select comment_id from comments where thread_id = :thread_id order by comment_id desc limit 1";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':thread_id', $thread_id);
    $stmt->execute();
    $comment_id = $stmt->fetch();

    // array型なのでintに変換、新規コメントは現在の最新コメントのID +1
    $comment_id = (int)$comment_id["comment_id"] + 1;

    // commentsテーブルにデータを登録
    $sql = "insert into comments (comment_id, thread_id, user_id, comment) values (:comment_id, :thread_id, :user_id, :comment)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':comment_id', $comment_id);
    $stmt->bindValue(':thread_id', $thread_id);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->bindValue(':comment', $comment);
    $stmt->execute();

    $_SESSION['success'] = "コメントの投稿が完了しました。";

    $uri = $_SERVER['HTTP_REFERER'];
    header("Location: ".$uri);
}else{
    $_SESSION['error'] = "エラーが発生しました。";
    header("Location: ./thread_list.php");
}



?>


    <?php if ($comment_flag === 1): ?>
    <form method="post" action="">
        <div class="element_wrap">
            <label>コメント</label>
            <p><?php echo $_POST['comment']; ?>
            </p>
        </div>
        <p>このコメントを投稿します。</p>
        <input type="submit" name="btn_back" value="戻る">
        <input type="submit" name="btn_submit" value="送信">
        <input type="hidden" name="comment"
            value="<?php echo $_POST['comment']; ?>">
    </form>


    <?php elseif ($comment_flag === 0): ?>

    <h1>コメント作成</h1>
    <form action="" method="post">
        <div>
            <label>コメント：<label>
                    <input type="text" name="comment" required>
        </div>
        <input type="submit" name="btn_confirm" value="新規登録">
    </form>

    <?php endif; ?>

    <?php include(dirname(__FILE__).'/assets/_inc/footer.php'); ?>
