<?php include dirname(__FILE__) . "/header.php"; ?>

<section class="hello">
    <h1 class="hello-ttl"><?php echo $msg; ?>
    </h1>

    <?php if ($status >= 1): ?>
    <a href="./thread_form.php" class="a-btn"><span class="a-btn-icon"><i class="far fa-comments"></i></span><span
            class="a-btn-text">スレッド作成</span></a>
    <?php else: ?>
    <p>ゲストアカウントでは、スレッド作成機能が制限されます。</p>
    <?php endif; ?>

</section>

<section class="thread">

    <ul class="thread-ul">

        <!-- thread一覧の表示 -->
        <?php foreach ($stmt as $row): ?>
        <li>
            <a href="thread_content.php?id=<?php echo $row[
              "thread_id"
            ]; ?>&page_id=1">
                <div class="thread-list" data-id="<?php echo $row["thread_id"]; ?>">
                    <!-- <form class="thread-form" action="thread_content.php" method="get" name="thread_form"> -->
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
            </a>
        </li>

        <?php endforeach; ?>
    </ul>

    <?php if (!isset($search)) {
  thread_pagination($arr["max_page"], $arr["now_page"]);
} else {
  search_pagination($arr["max_page"], $arr["now_page"], $search);
} ?>

</section>


<?php include dirname(__FILE__) . "/footer.php"; ?>