<?php include dirname(__FILE__) . "/header.php"; ?>


<section class="user">
    <div class="user-div">
        <div>
            <p class="user-ttl">ユーザー名</p>
        </div>
        <form action="./process/user_name_edit.php" method="post" name="user_name_form">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars(
              $_SESSION["token"],
              ENT_QUOTES,
              "UTF-8"
            ); ?>">
            <div>
                <input type="text" name="user_name" id="user_name" value="<?php echo $user_name; ?>" required
                    maxlength="<?php echo NAME_LENGTH; ?>">
            </div>
            <!-- モーダル表示ボタン -->
            <button type="button" class="reset submit-btn submit-btn-user js-modal-open" id="form_user_name_btn"
                data-id="form">変更</button>

            <!-- ↓モーダル↓ -->
            <div id="overlay" class="overlay"></div>
            <div class="form-window modal-window" data-id="modal-form">
                <p class="modal-secttl">ユーザー名変更</p>
                <div>
                    <label>旧ユーザー名</label>
                </div>
                <div>
                    <p class="modal-form-item" id="form_user_name_old"><?php echo $user_name; ?></p>
                </div>
                <div>
                    <label>新ユーザー名</label>
                </div>
                <div>
                    <p class="modal-form-item" id="form_user_name"></p>
                </div>
                <div class="modal-btns">
                    <div class="cancel-div">
                        <button type="button"
                            class="reset submit-btn submit-btn-cancel submit-btn-cancel-user js-modal-close" id="close">
                            キャンセル
                        </button>
                    </div>
                    <div class="submit-div">
                        <button type="submit" name="submit" class="reset submit-btn submit-btn-user js-modal-open-form"
                            id="submit-btn">名前の変更</button>
                    </div>
                </div>
            </div>
            <!-- ↑モーダル↑ -->
        </form>
    </div>


    <div class="user-div">
        <p class="user-ttl">お気に入りリスト</p>

        <ul class="thread-ul">
            <?php foreach ($stmt as $row): ?>
            <?php $thread = $dbthread->get_thread_by_id($row["thread_id"]); ?>
            <li>

                <a href="thread_content.php?id=<?php echo $thread[
                  "thread_id"
                ]; ?>&page_id=1" class="favorite-list">
                    <div class="thread-list" data-id="<?php echo $thread[
                      "thread_id"
                    ]; ?>">
                        <div>
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
                        <p><span class="comment-thread-favo active favo-icon" data-id="<?php echo $thread[
                          "thread_id"
                        ]; ?>">
                                <i class="fas fa-star favo-icon"></i></span></p>
                    </div>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>

        <?php favorite_pagination($arr["max_page"], $arr["now_page"]); ?>

    </div>

</section>

<?php include dirname(__FILE__) . "/footer.php";