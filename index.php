<?php
// require "config/access_control.php";
// // ログインしていない場合、ログインフォームへ遷移
// access_control();
?>

<?php include dirname(__FILE__) . "/assets/_inc/header.php"; ?>


<?php if ($_SERVER["REQUEST_METHOD"] == "GET") {
  // GETアクセス：全表示

  // セッションのユーザー情報を登録
  $user_id = $_SESSION["user_id"];
  $user_name = $_SESSION["user_name"];
  $status = $_SESSION["status"];

  $msg =
    "こんにちは " . htmlspecialchars($user_name, \ENT_QUOTES, "UTF-8") . "さん";

  // DB接続
  $dbh = database_access();

  try {
    $dbh->beginTransaction();

    // スレッドの数をカウント
    $sql = "SELECT COUNT(*) FROM threads";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    // ページネーション処理の準備
    $thread_count = $stmt->fetchColumn(0);
    // thread件数
    // 最大ページ数
    $max_page = ceil($thread_count / THREAD_MAX);

    if (!isset($_GET["page_id"])) {
      // $_GET['page_id'] はURLに渡された現在のページ数
      $now_page = 1; // 設定されてない場合は1ページ目にする
    } else {
      $now_page = $_GET["page_id"];
    }

    $start_thread = ($now_page - 1) * THREAD_MAX;

    // 全スレッドを取得
    $sql =
      "SELECT * FROM threads order by updated_at desc limit :start_thread, :thread_max";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(":start_thread", $start_thread, PDO::PARAM_INT);
    $stmt->bindValue(":thread_max", THREAD_MAX, PDO::PARAM_INT);
    $stmt->execute();

    $dbh->commit();
  } catch (Exception $e) {
    $dbh->rollBack();
    echo "失敗しました。" . $e->getMessage();
  }

  // POSTアクセス：検索機能
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
  }
} ?>

<h1><?php echo $msg; ?>
</h1>
<?php echo $link; ?>

<?php if ($status >= 1): ?>
<p><a href="thread_create.php">スレッド作成</a></p>
<?php else: ?>
<p>ゲストアカウントでは、スレッド作成機能が制限されます。</p>
<?php endif; ?>


<!-- thread一覧の表示 -->
<?php foreach ($stmt as $row): ?>
<div class="thread" data-id="<?php echo $row["thread_id"]; ?>">
    <form action="thread_content.php" method="get" name="thread_form">
        <input type="hidden" name="id" value="<?php echo $row["thread_id"]; ?>">
        <p>投稿数：(<?php echo $row["comment_count"]; ?>)</p>
        <div class="thread_title">
            <p><?php echo $row["title"]; ?></p>
        </div>
        <div class="thread_user">
            <p>スレ主： <?php echo user_from_comment(
              $row["user_id"],
              $dbh
            ); ?></p>
        </div>
        <button type="submit">表示</button>
    </form>
</div>
<?php endforeach; ?>

<?php thread_pagination($max_page, $now_page); ?>




<?php include dirname(__FILE__) . "/assets/_inc/footer.php"; ?>