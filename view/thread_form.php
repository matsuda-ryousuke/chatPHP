<?php include dirname(__FILE__) . "/header.php"; ?>


<h1>スレッド作成</h1>
<form action="process/thread_create.php" method="post">
    <div>
        <input type="text" placeholder="名前" name="user_name" id="user_name">
    </div>
    <div>
        <input type="text" placeholder="タイトル" name="title" id="title" required>
    </div>

    <!-- ↓モーダル↓ -->
    <div id="overlay" class="overlay"></div>
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

        <button type="button" class="js-modal-close" id="close">
            Close
        </button>
        <button type="submit" class="js-modal-open-form" id="submit-btn">送信</button>
    </div>
    <!-- ↑モーダル↑ -->
</form>

<!-- モーダル表示用ボタン -->
<button type="button" class="send js-modal-open btn btn-warning btn-lg btn-block" id="form_thread_btn" data-id="form">
    送信
</button>


<?php include dirname(__FILE__) . "/footer.php"; ?>
