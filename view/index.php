<?php include dirname(__FILE__) . "/header.php"; ?>

<section class="hello">
    <h1 class="hello-ttl"><?php echo $msg; ?>
    </h1>

    <?php if ($status >= 1): ?>
    <p><a href="thread_form.php"><img class="header-icon" src="image/user_config.png" alt=""></a></p>
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
                <p>スレ主： <?php echo $dbuser->get_username_by_id(
                  $row["user_id"]
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

<?php if (!isset($search)) {
  thread_pagination($arr["max_page"], $arr["now_page"]);
} else {
  search_pagination($arr["max_page"], $arr["now_page"], $search);
} ?>


<?php include dirname(__FILE__) . "/footer.php"; ?>
