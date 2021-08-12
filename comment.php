<?php include(dirname(__FILE__).'/assets/_inc/header.php'); ?>


<?php

// $comment_flag=0;登録フォーム 1;確認 2;完了
$comment_flag = 0;
if (!empty($_POST['btn_confirm'])) {
    $comment_flag = 1;
} elseif (!empty($_POST['btn_submit'])) {
    $comment_flag = 2;
}



// 確認ページでの処理
if ($comment_flag === 1) {
    $title = $_POST['title'];
    $mail = $_POST['mail'];
    //$pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $pass = $_POST['pass'];

    // DB接続
    $dbh = database_access();

    // ログインユーザーのメールアドレスと、入力メールアドレスをチェック
    if ($mail === $_SESSION['mail']) {
        //フォームに入力されたmailがすでに登録されていないかチェック
        $sql = "SELECT * FROM users WHERE mail = :mail";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':mail', $mail);
        $stmt->execute();
        $member = $stmt->fetch();
    } else {
        $msg = 'メールアドレスが間違っています。';
        $link = '<a href="index.php">戻る</a>';
    }

    //指定したハッシュがパスワードにマッチしているかチェック
    if (password_verify($pass, $member['pass'])) {
        echo $title;
        $msg = 'このスレッドを作成します';
        $link = '<a href="thread_create.php">登録</a><a href="index.php">キャンセル</a>';
    } else {
        $msg = 'メールアドレスもしくはパスワードが間違っています。';
        $link = '<a href="index.php">戻る</a>';
    }


    // 送信完了ページの処理
} elseif ($comment_flag === 2) {
    $title = $_POST['title'];
    // セッションから、ユーザー情報を取得
    $user_id = $_SESSION['user_id'];

    // DBアクセス
    $dbh = database_access();

    $sql = "insert into threads (title, user_id) values (:title, :user_id)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();

    $_SESSION['success'] = "スレッドの作成が完了しました。";
    header('Location: index.php');
}

?>




    <?php if ($comment_flag === 1): ?>
    <form method="post" action="">
        <div class="element_wrap">
            <label>スレッドタイトル</label>
            <p><?php echo $_POST['title']; ?>
            </p>
        </div>
        <div class="element_wrap">
            <label>メールアドレス</label>
            <p><?php echo $_POST['mail']; ?>
            </p>
        </div>
        <input type="submit" name="btn_back" value="戻る">
        <input type="submit" name="btn_submit" value="送信">
        <input type="hidden" name="title"
            value="<?php echo $_POST['title']; ?>">
    </form>


    <?php elseif ($comment_flag === 0): ?>

    <h1>スレッド作成</h1>
    <form action="" method="post">
        <div>
            <label>タイトル：<label>
                    <input type="text" name="title" required>
        </div>
        <div>
            <label>メールアドレス：<label>
                    <input type="text" name="mail" required>
        </div>
        <div>
            <label>パスワード：<label>
                    <input type="password" name="pass" required>
        </div>
        <input type="submit" name="btn_confirm" value="新規登録">
    </form>

    <?php endif; ?>
    <?php include(dirname(__FILE__).'/assets/_inc/footer.php'); ?>
