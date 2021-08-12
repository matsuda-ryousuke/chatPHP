<?php include(dirname(__FILE__).'/assets/_inc/header.php'); ?>

<?php

if($_SESSION['status'] == 0){
    $_SESSION['error'] = "ゲストアカウントではこの機能はご利用いただけません。";
    header('Location: ./index.php');
}



// $thread_flag=0;登録フォーム 1;確認 2;完了
$thread_flag = 0;

// 確認ボタンを押している： 確認画面へ
if (!empty($_POST['btn_confirm'])) {
    $thread_flag = 1;
// 登録ボタンを押している： 完了画面へ
} elseif (!empty($_POST['btn_submit'])) {
    $thread_flag = 2;
}





// 確認ページでの処理
if ($thread_flag === 1) {
    $title = $_POST['title'];

// 送信完了ページの処理
} elseif ($thread_flag === 2) {
    $title = $_POST['title'];
    // セッションから、ユーザー情報を取得
    $user_id = $_SESSION['user_id'];

    // DBアクセス
    $dbh = database_access();

    // threadsテーブルにデータを登録
    $sql = "insert into threads (title, user_id) values (:title, :user_id)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();

    $_SESSION['success'] = "スレッドの作成が完了しました。";
    header('Location: index.php');
}

?>


    <?php if ($thread_flag === 1): ?>
    <form method="post" action="">
        <div class="element_wrap">
            <label>スレッドタイトル</label>
            <p><?php echo $_POST['title']; ?>
            </p>
        </div>
        <p>このスレッドを作成します。</p>
        <input type="submit" name="btn_back" value="戻る">
        <input type="submit" name="btn_submit" value="送信">
        <input type="hidden" name="title"
            value="<?php echo $_POST['title']; ?>">
    </form>


    <?php elseif ($thread_flag === 0): ?>

    <h1>スレッド作成</h1>
    <form action="" method="post">
        <div>
            <label>タイトル：<label>
                    <input type="text" name="title" required>
        </div>
        <input type="submit" name="btn_confirm" value="新規登録">
    </form>

    <?php endif; ?>

    <?php include(dirname(__FILE__).'/assets/_inc/footer.php'); ?>
