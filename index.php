<?php

require "config/access_control.php";
require "config/database.php";

session_start();

// エラー、登録完了ステートメントがあるならば、変数に登録
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION["error"]);
}
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION["success"]);
}

// セッションのユーザー情報を登録
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$mail = $_SESSION['mail'];

// ログインしていない場合、ログインフォームへ遷移
access_control();


if ($_SERVER["REQUEST_METHOD"] == "GET") {
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

    $msg = 'こんにちは ' . htmlspecialchars($user_name, \ENT_QUOTES, 'UTF-8') . 'さん';
    $link = '<a href="logout.php">ログアウト</a>';
}


?>


<?php include(dirname(__FILE__).'/assets/_inc/header.php'); ?>
    <?php if (isset($success)) {
    echo $success;
}
    ?>
    <?php if (isset($error)) {
        echo $error;
    }
    ?>

    <?php foreach ($stmt as $row) : ?>
    <div class="thread" data-id="<?php echo $row['thread_id']; ?>">
        <div class="thread_title">
            <?php echo $row['title']; ?>
        </div>
        <div class="thread_user">
            <?php echo $row['user_id']; ?>
        </div>

    </div>
    <?php endforeach; ?>


    <h1><?php echo $msg; ?>
    </h1>
    <?php echo $link; ?>
    <p><a href="thread_create.php">スレッド作成</a></p>

    <?php include(dirname(__FILE__).'/assets/_inc/footer.php'); ?>
