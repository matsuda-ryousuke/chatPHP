<?php
/*=============================================
  インデックスページ
  スレッドの一覧を表示
============================================= */

include dirname(__FILE__) . "/assets/_inc/header.php"; ?>


<?php
// セッションのユーザー情報を登録
$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];
$status = $_SESSION["status"];

$msg =
  "こんにちは " . htmlspecialchars($user_name, \ENT_QUOTES, "UTF-8") . "さん";

// GETアクセス：全表示
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // DB接続
    $dbh = database_access();

    try {
        $dbh->beginTransaction();

        // スレッドの数をカウント
        $sql = "SELECT COUNT(*) FROM threads";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        // ページネーション処理の準備
        $count = $stmt->fetchColumn(0);
        $arr = pagination_start($count, THREAD_MAX);

        // 全スレッドを取得
        $sql =
      "SELECT * FROM threads order by updated_at desc limit :start_thread, :thread_max";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(":start_thread", $arr["start"], PDO::PARAM_INT);
        $stmt->bindValue(":thread_max", THREAD_MAX, PDO::PARAM_INT);
        $stmt->execute();

        $dbh->commit();
    } catch (Exception $e) {
        $dbh->rollBack();
        echo "失敗しました。" . $e->getMessage();
    }
}
?>

<section class="hello">
    <h1 class="hello-ttl"><?php echo $msg; ?>
    </h1>

    <?php if ($status >= 1): ?>
    <p><a href="thread_create.php">スレッド作成</a></p>
    <?php else: ?>
    <p>ゲストアカウントでは、スレッド作成機能が制限されます。</p>
    <?php endif; ?>

</section>


<!-- thread一覧の表示 -->
<?php foreach ($stmt as $row): ?>
<div class="thread" data-id="<?php echo $row["thread_id"]; ?>">
    <form class="thread-form" action="thread_content.php" method="get" name="thread_form">
        <div>
            <input type="hidden" name="id" value="<?php echo $row[
              "thread_id"
            ]; ?>">
            <input type="hidden" name="page_id" value=1>

            <div class="thread-title">
                <p><?php echo $row["title"]; ?>
                    (<?php echo $row["comment_count"]; ?>)
                </p>
            </div>
            <div class="thread-user">
                <p>スレ主： <?php echo get_username_from_id(
                $row["user_id"],
                $dbh
            ); ?>
                </p>
            </div>
            <div class="thread-date">
                <p><?php echo $row["updated_at"]; ?>
                </p>
            </div>
        </div>
        <button type="submit">表示</button>
    </form>
</div>
<?php endforeach; ?>

<?php thread_pagination($arr["max_page"], $arr["now_page"]); ?>




<?php include dirname(__FILE__) . "/assets/_inc/footer.php";