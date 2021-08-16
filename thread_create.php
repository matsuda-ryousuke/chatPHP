<?php include dirname(__FILE__) . "/assets/_inc/header.php"; ?>

<?php
require "config/access_control.php";
// ログインしていない場合、ログインフォームへ遷移
access_control();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // GETアクセス、ゲストユーザーの場合はインデックスにリダイレクト
    if ($_SESSION["status"] == 0) {
        $_SESSION["error"] = "ゲストアカウントではこの機能はご利用いただけません。";
        header("Location: ./index.php");
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // POSTアクセス時、スレッド作成
    $title = $_POST["title"];
    $comment = $_POST["comment"];

    // セッションから、ユーザー情報を取得
    $user_id = $_SESSION["user_id"];

    // user_name がPOSTされている かつ ログインユーザーならばその値、なければゲスト
    if (isset($_POST["user_name"]) && $status == 1) {
        $user_name = $_POST["user_name"];
    } else {
        $user_name = "ゲスト";
    }


    // DBアクセス
    $dbh = database_access();

    try {
        $dbh->beginTransaction();

        // threadsテーブルにデータを登録
        $sql = "insert into threads (title, user_id, user_name) values (:title, :user_id, :user_name)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(":title", $title);
        $stmt->bindValue(":user_id", $user_id);
        $stmt->bindValue(":user_name", $user_name);

        $stmt->execute();

       
        $dbh->commit();
    } catch (Exception $e) {
        $dbh->rollBack();
        echo "失敗しました。" . $e->getMessage();
    }

    $_SESSION["success"] = "スレッドの作成が完了しました。";
    header("Location: index.php");
}
?>

<h1>スレッド作成</h1>
<form action="" method="post">
    <div>
        <input type="text" placeholder="名前" name="user_name" id="user_name">
    </div>
    <div>
        <input type="text" placeholder="タイトル" name="title" id="title" required>
    </div>

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
</form>


<button type="button" class="send js-modal-open btn btn-warning btn-lg btn-block" id="form_thread_btn" data-id="form">
    送信
</button>


<?php include dirname(__FILE__) . "/assets/_inc/footer.php";