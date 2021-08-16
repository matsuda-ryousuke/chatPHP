<?php
/*=============================================
  ユーザー設定表示ページ
============================================= */

include dirname(__FILE__) . "/assets/_inc/require.php"; ?>

<?php
// セッションのユーザー情報を登録
$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];
// DB接続
$dbh = database_access();

try {
  $dbh->beginTransaction();

  // user_id が一致するfavoriteを取得
  $sql = "SELECT count(*) FROM favorites where user_id = :user_id";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
  $stmt->execute();

  // ページネーション処理の準備
  $favorite_count = $stmt->fetchColumn(0);

  // いいね件数
  // 最大ページ数
  $max_page = ceil($favorite_count / FAVORITE_MAX);
  if ($max_page < 1) {
    $max_page = 1;
  }

  if (!isset($_GET["page_id"])) {
    // $_GET['page_id'] はURLに渡された現在のページ数
    $now_page = 1; // 設定されてない場合は1ページ目にする
  } else {
    $now_page = htmlspecialchars($_GET["page_id"]);
  }

  $start_favorite = ($now_page - 1) * FAVORITE_MAX;

  // 全スレッドを取得
  $sql =
    "SELECT * FROM favorites where user_id = :user_id order by updated_at desc limit :start_favorite, :favorite_max";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(":user_id", $user_id, PDO::PARAM_INT);
  $stmt->bindValue(":start_favorite", $start_favorite, PDO::PARAM_INT);
  $stmt->bindValue(":favorite_max", FAVORITE_MAX, PDO::PARAM_INT);
  $stmt->execute();

  $dbh->commit();
} catch (Exception $e) {
  $dbh->rollBack();
  echo "失敗しました。" . $e->getMessage();
}
?>

<p>
    ユーザー名
</p>
<p>
    <?php echo $user_name; ?>
</p>

<p>お気に入りリスト</p>

<?php foreach ($stmt as $row): ?>
<?php $thread = get_thread($row["thread_id"], $dbh); ?>
<div class="thread" data-id="<?php echo $thread["thread_id"]; ?>">

    <form class="thread-form" action="thread_content.php" method="get" name="thread_form">
        <div>
            <input type="hidden" name="id" value="<?php echo $thread[
              "thread_id"
            ]; ?>">
            <input type="hidden" name="page_id" value=1>

            <div class="thread-title">
                <p><?php echo $thread["title"]; ?>
                    (<?php echo $thread["comment_count"]; ?>)
                </p>
            </div>
            <div class="thread-user">
                <p>スレ主： <?php echo get_username_by_id(
                  $thread["user_id"],
                  $dbh
                ); ?>
                </p>
            </div>
            <div class="thread-date">
                <p><?php echo $thread["updated_at"]; ?>
                </p>
            </div>
        </div>
        <p><span class="comment-thread-favo <?php if (
          $favorite_flag
        ): ?>active<?php endif; ?>">
                ★</span></p>
        <button type="submit">表示</button>
    </form>
</div>
<?php endforeach;
