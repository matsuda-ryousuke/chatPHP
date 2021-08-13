<?php include dirname(__FILE__) . "/assets/_inc/header.php"; ?>

<?php if ($_SERVER["REQUEST_METHOD"] == "GET") {
  // DB接続
  $dbh = database_access();

  // 全スレッドを取得
  $sql = "SELECT * FROM threads";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  // foreach($stmt as $row){
  //     var_dump($row);
  // }
  // $threads = $stmt->fetch();
} ?>

<!-- thread一覧の表示 -->
<?php foreach ($stmt as $row): ?>
<div class="thread" data-id="<?php echo $row["thread_id"]; ?>">
    <form action="thread_content.php" method="get" name="thread_form">
        <input type="hidden" name="id" value="<?php echo $row[
              "thread_id"
            ]; ?>">
        <div class="thread_title">
            <?php echo $row["title"]; ?>
        </div>
        <div class="thread_user">
            <?php echo $row["user_id"]; ?>
        </div>
        <button type="submit">表示</button>
    </form>
</div>
<?php endforeach; ?>

<?php include dirname(__FILE__) . "/assets/_inc/footer.php"; ?>