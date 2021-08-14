<?php
// require "config/access_control.php";
// // ログインしていない場合、ログインフォームへ遷移
// access_control();
?>

<?php include dirname(__FILE__) . "/assets/_inc/header.php"; ?>


<?php
// セッションのユーザー情報を登録
$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];
$status = $_SESSION["status"];

$msg =
  "こんにちは " . htmlspecialchars($user_name, \ENT_QUOTES, "UTF-8") . "さん";

// GETアクセス：全表示
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  // 検索欄を入力せずに検索した場合、GETアクセス
  if ($_GET["search"] == null) {
    header("Location: ./index.php");
  }

  $search = (string) htmlspecialchars($_GET["search"]);
  var_dump($search);

  // DB接続
  $dbh = database_access();

  try {
    $dbh->beginTransaction();

    // スレッドの数をカウント
    $sql_count = "SELECT COUNT(*) FROM threads where title like :search";
    $stmt_count = $dbh->prepare($sql_count);
    $stmt_count->bindValue(":search", "%" . $search . "%", PDO::PARAM_STR);
    $stmt_count->execute();

    // ページネーション処理の準備
    $thread_count = $stmt_count->fetchColumn(0);
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
      "SELECT * FROM threads where title like :search order by updated_at desc limit :start_thread, :thread_max";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(":search", "%" . $search . "%", PDO::PARAM_STR);
    $stmt->bindValue(":start_thread", $start_thread, PDO::PARAM_INT);
    $stmt->bindValue(":thread_max", THREAD_MAX, PDO::PARAM_INT);
    $stmt->execute();

    $dbh->commit();
  } catch (Exception $e) {
    $dbh->rollBack();
    echo "失敗しました。" . $e->getMessage();
  }
  if ($thread_count == 0) {
    $_SESSION["error"] = $search . " を含むスレッドは見つかりませんでした";
    header("Location: ./index.php");
  }
}
?>

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

<?php search_pagination($max_page, $now_page, $search); ?>




<?php include dirname(__FILE__) . "/assets/_inc/footer.php"; ?>
