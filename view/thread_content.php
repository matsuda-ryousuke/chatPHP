<?php include dirname(__FILE__) . "/header.php"; ?>

<!-- threadの表示 -->
<div class="comment-thread" data-id="<?php echo $thread_id; ?>">
    <div>
        <p class="comment-thread-p"><span class="comment-thread-title"><?php echo $title; ?>

            </span><span><span class="comment-thread-favo <?php if (
              $favorite_flag
            ): ?>active<?php endif; ?>" data-id="<?php echo $thread_id; ?>">
                    ★</span>[<?php echo $user_name; ?>]
                (<?php echo $comment_count; ?>コメント)</span></p>
    </div>
</div>


<!-- comment一覧の表示 -->
<?php foreach ($stmt as $row): ?>
<div class="comment" data-id="<?php echo $comment_id; ?>">
    <div class="comment-nav">
        <div class="comment-user">
            <p><?php echo $row["comment_id"]; ?>
            </p>
            <p>
                <?php echo $row["user_name"]; ?>
            </p>
        </div>
        <p>
            <?php echo $row["created_at"]; ?>
        </p>
    </div>
    <div class="comment-content">
        <p><?php echo $row["comment"]; ?>
        </p>
    </div>

</div>
<?php endforeach; ?>

<!-- ページネーション表示 -->
<?php comment_pagination($arr["max_page"], $arr["now_page"], $thread_id); ?>


<!-- コメント作成フォーム -->
<section class="form">
    <form action="./process/comment_create.php" method="post" name="thread_form" class="comment-form">
        <?php if ($status == 1): ?>
        <div>
            <div>
            </div>
            <div><input type="text" placeholder="名前" name="user_name" id="user_name" value="<?php echo $_SESSION[
              "user_name"
            ]; ?>"></div>
        </div>
        <?php endif; ?>

        <div class="comment-textarea">
            <textarea placeholder="コメント" name="comment" id="comment" rows="8" cols="40" maxlength="255"
                required></textarea>
        </div>

        <!-- ↓モーダル↓ -->
        <div id="overlay" class="overlay"></div>
        <div class="form-window modal-window" data-id="modal-form">
            <p class="modal-secttl">コメント投稿</p>
            <div>
                <label>ユーザー名</label>
            </div>
            <div>
                <p class="modal-form-item" id="form_user_name"></p>
            </div>
            <div>
                <label>スレッドタイトル</label>
            </div>
            <div>
                <p class="modal-form-item" id="form_comment"></p>
            </div>
            <button type="button" class="js-modal-close" id="close">
                Close
            </button>
            <button type="submit" name="submit" class="js-modal-open-form" id="submit-btn">送信</button>
        </div>
        <!-- ↑モーダル↑ -->
    </form>

    <!-- モーダル表示ボタン -->
    <button type="button" class="comment-btn send js-modal-open btn btn-warning btn-lg btn-block" id="form_comment_btn"
        data-id="form">
        送信
    </button>
</section>

<?php include dirname(__FILE__) . "/footer.php"; ?>