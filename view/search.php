<?php include dirname(__FILE__) . "/header.php"; ?>

<h1><?php echo $msg; ?>
</h1>

<?php if ($status >= 1): ?>
<p><a href="thread_create.php">スレッド作成</a></p>
<?php else: ?>
<p>ゲストアカウントでは、スレッド作成機能が制限されます。</p>
<?php endif; ?>


<!-- thread一覧の表示 -->
<?php foreach ($stmt as $row): ?>
<div class="thread" data-id="<?php echo $row["thread_id"]; ?>">
    <form action="./thread_content.php" method="get" name="thread_form">
        <input type="hidden" name="id" value="<?php echo $row["thread_id"]; ?>">
        <p>投稿数：(<?php echo $row["comment_count"]; ?>)
        </p>
        <div class="thread_title">
            <p><?php echo $row["title"]; ?>
            </p>
        </div>
        <div class="thread_user">
            <p>スレ主： <?php echo $dbuser->get_username_by_id(
              $row["user_id"]
            ); ?>
            </p>
        </div>
        <button type="submit">表示</button>
    </form>
</div>
<?php endforeach; ?>

<?php search_pagination($arr["max_page"], $arr["now_page"], $search); ?>

<?php include dirname(__FILE__) . "/footer.php"; ?>
