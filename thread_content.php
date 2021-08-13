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
    $stmt_thread->bindValue(":thread_id", $thread_id);
    $stmt_thread->execute();

    // ページネーション処理の準備
    $thread = $stmt_thread->fetch();
    // comment件数
    $comment_count = $thread["comment_count"];
    // 最大ページ数
    $max_page = ceil($comment_count / COMMENT_MAX);

    if (!isset($_GET["page_id"])) {
      // $_GET['page_id'] はURLに渡された現在のページ数
      $now_page = 1; // 設定されてない場合は1ページ目にする
    } else {
      $now_page = $_GET["page_id"];
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

<!-- thread一覧の表示 -->
<?php foreach ($stmt_thread as $row): ?>
<div class="thread" data-id="<?php echo $row["thread_id"]; ?>">
    <div class="thread_title">
        <?php echo $row["title"]; ?>
    </div>
    <div class="thread_user">
        <?php echo $row["user_id"]; ?>
    </div>
</div>
<?php endforeach; ?>


<!-- comment一覧の表示 -->
<?php foreach ($stmt_comment as $row): ?>
<div class="thread" data-id="<?php echo $thread_id; ?>">
    <p><?php echo $row["comment_id"]; ?></p>
    <div class="comment">
        <?php echo $row["comment"]; ?>
    </div>
    <div class="thread_user">
        <?php echo $row["user_name"]; ?>
    </div>
    <?php echo $row["created_at"]; ?>
</div>
<?php endforeach; ?>

<?php comment_pagination($max_page, $now_page, $thread_id); ?>


<form action="comment_create.php" method="post" name="thread_form">
    <?php if ($status == 1): ?>
    <div>
        <label>名前：<label>
                <input type="text" name="user_name" id="user_name" value="<?php echo $_SESSION[
                  "user_name"
                ]; ?>">
    </div>
    <?php endif; ?>

    <div>
        <label>コメント：<label>
                <input type="text" name="comment" id="comment" required>
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

<button type="button" class="send js-modal-open btn btn-warning btn-lg btn-block" id="form_comment_btn" data-id="form">
    送信
</button>





<?php include dirname(__FILE__) . "/assets/_inc/footer.php"; ?>