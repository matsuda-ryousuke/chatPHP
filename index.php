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

  // 全スレッドを取得
  $sql = "SELECT * FROM threads";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();

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
        <p>投稿数：(<?php echo count_comment($row["thread_id"], $dbh); ?>)</p>
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



<?php include dirname(__FILE__) . "/assets/_inc/footer.php"; ?>