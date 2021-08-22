<?php include dirname(__FILE__) . "/header.php"; ?>

<section class="login">

    <h1>スレッド作成</h1>
    <form action="process/thread_create.php" method="post">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars(
          $_SESSION["token"],
          ENT_QUOTES,
          "UTF-8"
        ); ?>">
        <div>
            <input type="text" placeholder="名前" name="user_name" id="user_name" maxlength="<?php echo NAME_LENGTH; ?>">
        </div>
        <div>
            <input type="text" placeholder="タイトル" name="title" id="title" required
                maxlength="<?php echo THREAD_TITLE_LENGTH; ?>">
        </div>

        <!-- モーダル表示用ボタン -->
        <button type="button" class="js-modal-open reset submit-btn submit-btn-thread" id="form_thread_btn"
            data-id="form">
            送信
        </button>

        <!-- ↓モーダル↓ -->
        <div class="form-window modal-window" data-id="modal-form">
            <p class="modal-secttl">スレッド作成</p>
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
                <p class="modal-form-item" id="form_title"></p>
            </div>

            <div class="modal-btns">
                <div class="cancel-div">
                    <button type="button" class="reset submit-btn submit-btn-cancel js-modal-close" id="close">
                        キャンセル
                    </button>
                </div>
                <div class="submit-div">
                    <button type="submit" name="submit" class="reset submit-btn submit-btn-comment js-modal-open-form"
                        id="submit-btn">スレッド作成</button>
                </div>
            </div>
        </div>
        <!-- ↑モーダル↑ -->
    </form>




    <?php include dirname(__FILE__) . "/footer.php"; ?>