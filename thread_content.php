<?php include dirname(__FILE__) . "/assets/_inc/header.php"; ?>

<?php if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET["id"])) {
        // thread_id 取得
        $thread_id = htmlspecialchars($_GET["id"]);
        $_SESSION["thread_id"] = $thread_id;
    } else {
        $_SESSION["error"] = "エラーが発生しました。";
        header("Location: ./index.php");
    }

    // DB接続
    $dbh = database_access();

    try {
        $dbh->beginTransaction();

        // 該当スレッドを取得
        $sql_thread = "SELECT * FROM threads where thread_id = :thread_id";
        $stmt_thread = $dbh->prepare($sql_thread);
        $stmt_thread->bindValue(":thread_id", $thread_id, PDO::PARAM_INT);
        $stmt_thread->execute();

        // ページネーション処理の準備
        $thread = $stmt_thread->fetch();
        // comment件数
        $comment_count = $thread["comment_count"];
        $title = $thread["title"];
        $user_name = user_from_comment($thread["user_id"], $dbh);

        // 最大ページ数
        $max_page = ceil($comment_count / COMMENT_MAX);
        if ($max_page < 1) {
            $max_page = 1;
        }


        if (!isset($_GET["page_id"])) {
            // $_GET['page_id'] はURLに渡された現在のページ数
            $now_page = $max_page; // 設定されてない場合は最新ページにする
        } else {
            // page_id が1以下なら1に、max以上ならmaxに合わせる

            $page_id = (int) $_GET["page_id"];
            $_SESSION["page_id"] = $page_id;
            if ($page_id < 1 || $page_id > $max_page) {
                $_SESSION["error"] = "無効な値が入力されました。";
                header("Location: index.php");
            }
            $now_page = $page_id;
        }

        $start_comment = ($now_page - 1) * COMMENT_MAX;

        // スレッドのコメントを取得
        $sql_comment =
      "SELECT * FROM comments where thread_id = :thread_id limit :start_comment, :comment_max";
        // $sql_comment = "SELECT * FROM comments where thread_id = :thread_id";

        $stmt_comment = $dbh->prepare($sql_comment);
        $stmt_comment->bindValue(":thread_id", $thread_id);
        $stmt_comment->bindValue(":start_comment", $start_comment, PDO::PARAM_INT);
        $stmt_comment->bindValue(":comment_max", COMMENT_MAX, PDO::PARAM_INT);
        $stmt_comment->execute();

        $dbh->commit();
    } catch (Exception $e) {
        $dbh->rollBack();
        echo "失敗しました。" . $e->getMessage();
    }

    $status = $_SESSION["status"];
} ?>

<!-- threadの表示 -->
<div class="comment-thread" data-id="<?php echo $thread_id; ?>">
    <div>
        <p class="comment-thread-p"><span
                class="comment-thread-title"><?php echo $title; ?></span><span>[<?php echo $user_name; ?>]
                (<?php echo $comment_count; ?>コメント)</span></p>
    </div>
    <div class="comment-thread-user">

    </div>
</div>


<!-- comment一覧の表示 -->
<?php foreach ($stmt_comment as $row): ?>
<div class="comment" data-id="<?php echo $comment_id; ?>">
    <div class="comment-nav">
        <div class="comment-user">
            <p><?php echo $row["comment_id"]; ?>
            </p>
            <p>
                <?php echo $row["user_name"]; ?>
            </p>
        </div>
        <p>
            <?php echo $row["created_at"]; ?>
        </p>
    </div>
    <div class="comment-content">
        <p><?php echo $row["comment"]; ?>
        </p>
    </div>

</div>
<?php endforeach; ?>

<?php comment_pagination($max_page, $now_page, $thread_id); ?>


<section class="form">
    <form action="comment_create.php" method="post" name="thread_form" class="comment-form">
        <?php if ($status == 1): ?>
        <div>
            <div>
            </div>
            <div><input type="text" placeholder="名前" name="user_name" id="user_name" value="<?php echo $_SESSION[
              "user_name"
            ]; ?>"></div>
        </div>
        <?php endif; ?>

        <div class="comment-textarea">
            <textarea placeholder="コメント" name="comment" id="comment" rows="8" cols="40" required></textarea>
        </div>

        <div id="overlay" class="overlay"></div>
        <div class="form-window modal-window" data-id="modal-form">
            <p class="modal-secttl">コメント投稿</p>
            <div>
                <label>ユーザー名</label>
            </div>
            <div>
                <p class="modal-form-item" id="form_user_name"></p>
            </div>
            <div>
                <label>スレッドタイトル</label>
            </div>
            <div>
                <p class="modal-form-item" id="form_comment"></p>
            </div>
            <button type="button" class="js-modal-close" id="close">
                Close
            </button>
            <button type="submit" name="submit" class="js-modal-open-form" id="submit-btn">送信</button>
        </div>

    </form>


    <button type="button" class="comment-btn send js-modal-open btn btn-warning btn-lg btn-block" id="form_comment_btn"
        data-id="form">
        送信
    </button>
</section>

<?php include dirname(__FILE__) . "/assets/_inc/footer.php";