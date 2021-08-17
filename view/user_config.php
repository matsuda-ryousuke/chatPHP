<?php include dirname(__FILE__) . "/header.php"; ?>


<p>
    ユーザー名
</p>
<p>
    <?php echo $user_name; ?>
</p>

<p>お気に入りリスト</p>

<?php foreach ($stmt as $row): ?>
<?php $thread = $dbthread->get_thread_by_id($row["thread_id"]); ?>
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
                <p>スレ主： <?php echo $dbuser->get_username_by_id(
                  $thread["user_id"]
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
<?php endforeach; ?>

<?php include dirname(__FILE__) . "/footer.php";
